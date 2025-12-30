<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\ClientNote;
use App\Models\ClientMessage;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\InvoiceInquiry;
use App\Models\FileUpload;
use App\Mail\ClientMessageMail;
use App\Mail\InvoiceCreatedMail;
use App\Mail\InvoiceStatusUpdatedMail;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;

class ClientController extends Controller
{
    /**
     * Show the form for creating a new client.
     */
    public function create()
    {
        return view('admin.clients.create');
    }

    /**
     * Store a newly created client in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'client',
        ]);

        return redirect()->route('admin.dashboard')
            ->with('success', 'Client created successfully!');
    }

    /**
     * Impersonate a client user.
     */
    public function impersonate(User $user)
    {
        // Only allow admins to impersonate
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        // Only allow impersonating client users
        if ($user->role !== 'client') {
            abort(403, 'Can only impersonate client users.');
        }

        // Store the original admin user ID in session
        session(['impersonate_admin_id' => Auth::id()]);

        // Log in as the client
        Auth::login($user);

        return redirect()->route('dashboard')
            ->with('success', "Now viewing as {$user->name}");
    }

    /**
     * Stop impersonating and return to admin account.
     */
    public function stopImpersonating()
    {
        $adminId = session('impersonate_admin_id');

        if (!$adminId) {
            return redirect()->route('dashboard');
        }

        $admin = User::find($adminId);

        if (!$admin) {
            session()->forget('impersonate_admin_id');
            return redirect()->route('login');
        }

        // Clear the impersonation session
        session()->forget('impersonate_admin_id');

        // Log back in as admin
        Auth::login($admin);

        return redirect()->route('admin.dashboard')
            ->with('success', 'Returned to admin account');
    }

    /**
     * Display the specified client with all details.
     */
    public function show(User $user)
    {
        // Only allow viewing client users
        if ($user->role !== 'client') {
            abort(403, 'Can only view client users.');
        }

        $user->load(['notes.creator', 'messages.sender', 'invoices.items']);

        return view('admin.clients.show', compact('user'));
    }

    /**
     * Store a new note for a client.
     */
    public function storeNote(Request $request, User $user)
    {
        $request->validate([
            'note' => ['required', 'string'],
        ]);

        ClientNote::create([
            'user_id' => $user->id,
            'created_by' => Auth::id(),
            'note' => $request->note,
        ]);

        return redirect()->route('admin.clients.show', $user)
            ->with('success', 'Note added successfully!');
    }

    /**
     * Delete a note.
     */
    public function deleteNote(ClientNote $note)
    {
        $userId = $note->user_id;
        $note->delete();

        return redirect()->route('admin.clients.show', $userId)
            ->with('success', 'Note deleted successfully!');
    }

    /**
     * Store a new message for a client.
     */
    public function storeMessage(Request $request, User $user)
    {
        $request->validate([
            'subject' => ['required', 'string', 'max:255'],
            'message' => ['required', 'string'],
        ]);

        $clientMessage = ClientMessage::create([
            'user_id' => $user->id,
            'sent_by' => Auth::id(),
            'subject' => $request->subject,
            'message' => $request->message,
            'read' => false,
        ]);

        // Load relationships for email
        $clientMessage->load(['user', 'sender']);

        // Send email notification to client
        Mail::to($user->email)->send(new ClientMessageMail($clientMessage));

        return redirect()->route('admin.clients.show', $user)
            ->with('success', 'Message sent successfully and email notification delivered!');
    }

    /**
     * Mark a message as read.
     */
    public function markMessageAsRead(ClientMessage $message)
    {
        $message->update(['read' => true]);

        return back()->with('success', 'Message marked as read!');
    }

    /**
     * Store a new invoice for a client.
     */
    public function storeInvoice(Request $request, User $user)
    {
        $request->validate([
            'issue_date' => ['required', 'date'],
            'due_date' => ['required', 'date', 'after_or_equal:issue_date'],
            'notes' => ['nullable', 'string'],
            'tax_rate' => ['required', 'numeric', 'min:0', 'max:100'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.description' => ['required', 'string'],
            'items.*.quantity' => ['required', 'integer', 'min:1'],
            'items.*.unit_price' => ['required', 'numeric', 'min:0'],
        ]);

        // Calculate totals
        $subtotal = 0;
        foreach ($request->items as $item) {
            $subtotal += $item['quantity'] * $item['unit_price'];
        }

        $taxAmount = $subtotal * ($request->tax_rate / 100);
        $total = $subtotal + $taxAmount;

        // Generate invoice number
        $lastInvoice = Invoice::orderBy('id', 'desc')->first();
        $invoiceNumber = 'INV-' . date('Y') . '-' . str_pad(($lastInvoice ? $lastInvoice->id + 1 : 1), 5, '0', STR_PAD_LEFT);

        // Create invoice
        $invoice = Invoice::create([
            'invoice_number' => $invoiceNumber,
            'user_id' => $user->id,
            'created_by' => Auth::id(),
            'status' => 'draft',
            'issue_date' => $request->issue_date,
            'due_date' => $request->due_date,
            'notes' => $request->notes,
            'subtotal' => $subtotal,
            'tax_rate' => $request->tax_rate,
            'tax_amount' => $taxAmount,
            'total' => $total,
        ]);

        // Create invoice items
        foreach ($request->items as $item) {
            InvoiceItem::create([
                'invoice_id' => $invoice->id,
                'description' => $item['description'],
                'quantity' => $item['quantity'],
                'unit_price' => $item['unit_price'],
                'total' => $item['quantity'] * $item['unit_price'],
            ]);
        }

        // Load relationships for email
        $invoice->load(['user', 'items']);

        // Send email notification to client
        Mail::to($user->email)->send(new InvoiceCreatedMail($invoice));

        return redirect()->route('admin.clients.show', $user)
            ->with('success', 'Invoice created successfully and email notification sent!');
    }

    /**
     * Update invoice status.
     */
    public function updateInvoiceStatus(Request $request, Invoice $invoice)
    {
        $request->validate([
            'status' => ['required', 'in:draft,sent,paid,overdue,cancelled'],
            'paid_date' => ['nullable', 'date'],
            'payment_method' => ['nullable', 'string', 'max:255'],
            'payment_reference' => ['nullable', 'string', 'max:255'],
            'payment_notes' => ['nullable', 'string'],
        ]);

        $oldStatus = $invoice->status;
        $data = ['status' => $request->status];

        // If marking as paid, set the paid date and payment tracking fields
        if ($request->status === 'paid') {
            if ($request->paid_date) {
                $data['paid_date'] = $request->paid_date;
            }
            if ($request->payment_method) {
                $data['payment_method'] = $request->payment_method;
            }
            if ($request->payment_reference) {
                $data['payment_reference'] = $request->payment_reference;
            }
            if ($request->payment_notes) {
                $data['payment_notes'] = $request->payment_notes;
            }
        }

        $invoice->update($data);

        // Send email notification if status changed and is not draft
        if ($oldStatus !== $request->status && $request->status !== 'draft') {
            $invoice->load(['user', 'items']);
            Mail::to($invoice->user->email)->send(new InvoiceStatusUpdatedMail($invoice));
        }

        return redirect()->route('admin.clients.show', $invoice->user_id)
            ->with('success', 'Invoice status updated successfully and notification sent!');
    }

    /**
     * Delete an invoice.
     */
    public function deleteInvoice(Invoice $invoice)
    {
        $userId = $invoice->user_id;
        $invoice->delete();

        return redirect()->route('admin.clients.show', $userId)
            ->with('success', 'Invoice deleted successfully!');
    }

    /**
     * Download invoice as PDF.
     */
    public function downloadInvoicePdf(Invoice $invoice)
    {
        // Load relationships
        $invoice->load(['user', 'items']);

        // Generate PDF
        $pdf = Pdf::loadView('pdfs.invoice', compact('invoice'));

        // Download with filename
        return $pdf->download($invoice->invoice_number . '.pdf');
    }

    /**
     * Respond to an invoice inquiry.
     */
    public function respondToInquiry(Request $request, InvoiceInquiry $inquiry)
    {
        $validated = $request->validate([
            'status' => 'required|in:open,in_progress,resolved',
            'response' => 'required|string|max:5000',
        ]);

        $inquiry->update([
            'status' => $validated['status'],
            'admin_response' => $validated['response'],
            'responded_by' => auth()->id(),
            'responded_at' => now(),
        ]);

        // Send email notification to client
        Mail::to($inquiry->user->email)->send(new \App\Mail\InquiryRespondedMail($inquiry));

        return back()->with('success', 'Response sent successfully to ' . $inquiry->user->name);
    }

    /**
     * Upload a file for a client.
     */
    public function uploadFileForClient(Request $request, User $user)
    {
        $validated = $request->validate([
            'file' => 'required|file|max:10240|mimes:pdf,doc,docx,xls,xlsx,png,jpg,jpeg,zip,rar',
            'description' => 'nullable|string|max:1000',
            'invoice_id' => 'nullable|exists:invoices,id',
            'is_visible_to_client' => 'nullable|boolean',
        ]);

        // Validate that the invoice belongs to the user if provided
        if ($request->invoice_id) {
            $invoice = Invoice::find($request->invoice_id);
            if ($invoice->user_id !== $user->id) {
                return back()->withErrors(['file' => 'Invalid invoice selected.']);
            }
        }

        $file = $request->file('file');
        $originalFilename = $file->getClientOriginalName();
        $storedFilename = Str::uuid() . '_' . $originalFilename;
        $filePath = $file->storeAs('uploads', $storedFilename);

        FileUpload::create([
            'user_id' => $user->id,
            'uploaded_by' => auth()->id(),
            'invoice_id' => $request->invoice_id,
            'filename' => $originalFilename,
            'stored_filename' => $storedFilename,
            'file_path' => $filePath,
            'file_size' => $file->getSize(),
            'mime_type' => $file->getMimeType(),
            'description' => $request->description,
            'is_visible_to_client' => $request->has('is_visible_to_client') ? true : false,
        ]);

        return back()->with('file_admin_success', 'File uploaded successfully for ' . $user->name . '!');
    }

    /**
     * Download a file (admin access).
     */
    public function downloadFileAdmin(FileUpload $file)
    {
        if (!Storage::exists($file->file_path)) {
            abort(404, 'File not found.');
        }

        return Storage::download($file->file_path, $file->filename);
    }

    /**
     * Delete a file (admin access).
     */
    public function deleteFileAdmin(FileUpload $file)
    {
        $userName = $file->user->name;
        $file->delete();

        return back()->with('file_admin_success', 'File deleted successfully for ' . $userName . '!');
    }

    /**
     * Toggle file visibility to client.
     */
    public function toggleFileVisibility(FileUpload $file)
    {
        $file->update([
            'is_visible_to_client' => !$file->is_visible_to_client,
        ]);

        $status = $file->is_visible_to_client ? 'visible' : 'hidden';
        return back()->with('file_admin_success', 'File visibility updated to ' . $status . '!');
    }
}
