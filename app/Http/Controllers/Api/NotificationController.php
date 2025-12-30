<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Check for new notifications
     */
    public function check(Request $request)
    {
        $user = Auth::user();
        $lastCheck = $request->get('last_check');

        // Get unread messages since last check
        $messagesQuery = Message::where('recipient_id', $user->id)
            ->where('read_at', null);

        if ($lastCheck) {
            $messagesQuery->where('created_at', '>', $lastCheck);
        }

        $newMessages = $messagesQuery->with('sender')->get();

        // Get new invoices since last check
        $invoicesQuery = Invoice::where('user_id', $user->id);

        if ($lastCheck) {
            $invoicesQuery->where('created_at', '>', $lastCheck);
        }

        $newInvoices = $invoicesQuery->get();

        return response()->json([
            'messages' => $newMessages->map(function($message) {
                return [
                    'id' => $message->id,
                    'sender' => $message->sender->name,
                    'preview' => substr($message->message, 0, 100),
                    'created_at' => $message->created_at->toIso8601String(),
                ];
            }),
            'invoices' => $newInvoices->map(function($invoice) {
                return [
                    'id' => $invoice->id,
                    'invoice_number' => $invoice->invoice_number,
                    'total' => $invoice->total,
                    'status' => $invoice->status,
                    'created_at' => $invoice->created_at->toIso8601String(),
                ];
            }),
            'checked_at' => now()->toIso8601String(),
        ]);
    }

    /**
     * Get unread message count
     */
    public function unreadCount()
    {
        $user = Auth::user();

        return response()->json([
            'count' => Message::where('recipient_id', $user->id)
                ->where('read_at', null)
                ->count()
        ]);
    }
}
