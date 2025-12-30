<?php

namespace App\Console\Commands;

use App\Mail\WeeklyDigestMail;
use App\Models\Invoice;
use App\Models\Message;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendWeeklyDigests extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'digests:send-weekly';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send weekly account summary emails to all clients';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Preparing weekly digest emails...');

        $clients = User::where('is_admin', false)->get();

        if ($clients->isEmpty()) {
            $this->info('No clients found.');
            return 0;
        }

        $this->info("Found {$clients->count()} client(s) to send digests to.");

        $sent = 0;
        $failed = 0;

        foreach ($clients as $client) {
            try {
                // Gather digest data for the past week
                $digestData = $this->gatherDigestData($client);

                // Skip if there's no activity
                if ($this->shouldSkipClient($digestData)) {
                    $this->line("↓ Skipped {$client->email} (no activity)");
                    continue;
                }

                // Send digest email
                Mail::to($client->email)->send(new WeeklyDigestMail($client, $digestData));

                $this->line("✓ Sent digest to {$client->email}");
                $sent++;
            } catch (\Exception $e) {
                $this->error("✗ Failed to send digest to {$client->email}: {$e->getMessage()}");
                $failed++;
            }
        }

        $this->newLine();
        $this->info("Summary:");
        $this->info("- Digests sent: {$sent}");
        if ($failed > 0) {
            $this->error("- Failed: {$failed}");
        }

        return 0;
    }

    /**
     * Gather digest data for a client
     */
    private function gatherDigestData(User $client): array
    {
        $weekAgo = now()->subWeek();

        // New messages in the past week
        $newMessages = Message::where('recipient_id', $client->id)
            ->where('created_at', '>=', $weekAgo)
            ->with('sender')
            ->get();

        // Unread messages
        $unreadMessages = Message::where('recipient_id', $client->id)
            ->whereNull('read_at')
            ->get();

        // New invoices in the past week
        $newInvoices = Invoice::where('user_id', $client->id)
            ->where('created_at', '>=', $weekAgo)
            ->get();

        // Pending invoices
        $pendingInvoices = Invoice::where('user_id', $client->id)
            ->whereIn('status', ['sent', 'overdue'])
            ->get();

        // Overdue invoices
        $overdueInvoices = Invoice::where('user_id', $client->id)
            ->where('status', 'overdue')
            ->get();

        return [
            'new_messages' => $newMessages,
            'new_messages_count' => $newMessages->count(),
            'unread_messages' => $unreadMessages,
            'new_invoices' => $newInvoices,
            'new_invoices_count' => $newInvoices->count(),
            'pending_amount' => $pendingInvoices->sum('total'),
            'overdue_count' => $overdueInvoices->count(),
            'overdue_amount' => $overdueInvoices->sum('total'),
        ];
    }

    /**
     * Determine if we should skip sending digest to this client
     */
    private function shouldSkipClient(array $digestData): bool
    {
        // Skip if no new activity and no action items
        return $digestData['new_messages_count'] === 0
            && $digestData['new_invoices_count'] === 0
            && $digestData['overdue_count'] === 0
            && count($digestData['unread_messages']) === 0;
    }
}
