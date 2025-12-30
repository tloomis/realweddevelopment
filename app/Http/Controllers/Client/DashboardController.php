<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\InvoiceInquiry;
use App\Models\FileUpload;
use App\Mail\InquirySubmittedMail;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DashboardController extends Controller
{
    /**
     * Display the client dashboard.
     */
    public function index()
    {
        $user = auth()->user();

        // Load messages and invoices for the client
        $user->load(['messages.sender', 'invoices.items']);

        // Get recent unread messages
        $recentMessages = $user->messages()
            ->with('sender')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Get recent invoices
        $recentInvoices = $user->invoices()
            ->with('items')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Calculate financial summary
        $totalBilled = $user->invoices()->sum('total');
        $totalPaid = $user->invoices()->where('status', 'paid')->sum('total');
        $totalOutstanding = $user->invoices()->whereNotIn('status', ['paid', 'cancelled'])->sum('total');
        $unreadMessages = $user->messages()->where('read', false)->count();

        // Additional statistics
        $totalInvoices = $user->invoices()->count();
        $paidInvoices = $user->invoices()->where('status', 'paid')->count();
        $overdueInvoices = $user->invoices()->where('status', 'overdue')->count();
        $avgInvoiceAmount = $totalInvoices > 0 ? $totalBilled / $totalInvoices : 0;
        $paymentRate = $totalInvoices > 0 ? ($paidInvoices / $totalInvoices) * 100 : 0;

        // Next payment due
        $nextDueInvoice = $user->invoices()
            ->whereIn('status', ['sent', 'overdue'])
            ->orderBy('due_date', 'asc')
            ->first();

        return view('client.dashboard', compact(
            'user',
            'recentMessages',
            'recentInvoices',
            'totalBilled',
            'totalPaid',
            'totalOutstanding',
            'unreadMessages',
            'totalInvoices',
            'paidInvoices',
            'overdueInvoices',
            'avgInvoiceAmount',
            'paymentRate',
            'nextDueInvoice'
        ));
    }

    /**
     * Display a specific invoice.
     */
    public function showInvoice(Invoice $invoice)
    {
        // Ensure the invoice belongs to the authenticated client
        if ($invoice->user_id !== auth()->id()) {
            abort(403, 'Unauthorized access to invoice.');
        }

        $invoice->load('items');

        return view('client.invoice', compact('invoice'));
    }

    /**
     * Download invoice as PDF.
     */
    public function downloadInvoicePdf(Invoice $invoice)
    {
        // Ensure the invoice belongs to the authenticated client
        if ($invoice->user_id !== auth()->id()) {
            abort(403, 'Unauthorized access to invoice.');
        }

        // Load relationships
        $invoice->load(['user', 'items']);

        // Generate PDF
        $pdf = Pdf::loadView('pdfs.invoice', compact('invoice'));

        // Download with filename
        return $pdf->download($invoice->invoice_number . '.pdf');
    }

    /**
     * Store a new invoice inquiry.
     */
    public function storeInquiry(Request $request, Invoice $invoice)
    {
        // Ensure the invoice belongs to the authenticated client
        if ($invoice->user_id !== auth()->id()) {
            abort(403, 'Unauthorized access to invoice.');
        }

        $validated = $request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:5000',
        ]);

        $inquiry = InvoiceInquiry::create([
            'invoice_id' => $invoice->id,
            'user_id' => auth()->id(),
            'subject' => $validated['subject'],
            'message' => $validated['message'],
            'status' => 'open',
        ]);

        // Send email notification to admin
        $adminUsers = \App\Models\User::where('role', 'admin')->get();
        foreach ($adminUsers as $admin) {
            Mail::to($admin->email)->send(new InquirySubmittedMail($inquiry));
        }

        return back()->with('success', 'Your inquiry has been submitted successfully. We will respond as soon as possible.');
    }

    /**
     * Upload a file.
     */
    public function uploadFile(Request $request)
    {
        $validated = $request->validate([
            'file' => 'required|file|max:10240|mimes:pdf,doc,docx,xls,xlsx,png,jpg,jpeg,zip,rar',
            'description' => 'nullable|string|max:1000',
            'invoice_id' => 'nullable|exists:invoices,id',
        ]);

        // Validate that the invoice belongs to the user if provided
        if ($request->invoice_id) {
            $invoice = Invoice::find($request->invoice_id);
            if ($invoice->user_id !== auth()->id()) {
                return back()->withErrors(['file' => 'Invalid invoice selected.']);
            }
        }

        $file = $request->file('file');
        $originalFilename = $file->getClientOriginalName();
        $storedFilename = Str::uuid() . '_' . $originalFilename;
        $filePath = $file->storeAs('uploads', $storedFilename);

        FileUpload::create([
            'user_id' => auth()->id(),
            'uploaded_by' => auth()->id(),
            'invoice_id' => $request->invoice_id,
            'filename' => $originalFilename,
            'stored_filename' => $storedFilename,
            'file_path' => $filePath,
            'file_size' => $file->getSize(),
            'mime_type' => $file->getMimeType(),
            'description' => $request->description,
            'is_visible_to_client' => true,
        ]);

        return back()->with('file_success', 'File uploaded successfully!');
    }

    /**
     * Download a file.
     */
    public function downloadFile(FileUpload $file)
    {
        // Ensure the file belongs to the authenticated client
        if ($file->user_id !== auth()->id()) {
            abort(403, 'Unauthorized access to file.');
        }

        if (!Storage::exists($file->file_path)) {
            abort(404, 'File not found.');
        }

        return Storage::download($file->file_path, $file->filename);
    }

    /**
     * Delete a file.
     */
    public function deleteFile(FileUpload $file)
    {
        // Ensure the file belongs to the authenticated client
        if ($file->user_id !== auth()->id()) {
            abort(403, 'Unauthorized access to file.');
        }

        $file->delete();

        return back()->with('file_success', 'File deleted successfully!');
    }
}
