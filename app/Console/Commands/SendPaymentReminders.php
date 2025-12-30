<?php

namespace App\Console\Commands;

use App\Mail\PaymentReminderMail;
use App\Models\Invoice;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendPaymentReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'invoices:send-reminders {--days=7 : Send reminders for invoices overdue by this many days}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send payment reminder emails for overdue invoices';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Checking for overdue invoices...');

        $daysOverdue = (int) $this->option('days');
        $targetDate = now()->subDays($daysOverdue);

        // Find invoices that are:
        // 1. Status is 'overdue'
        // 2. Due date is before the target date
        // 3. No reminder sent, or last reminder was sent more than 7 days ago
        $overdueInvoices = Invoice::with(['user', 'items'])
            ->where('status', 'overdue')
            ->where('due_date', '<=', $targetDate)
            ->where(function($query) {
                $query->whereNull('payment_reminder_sent_at')
                      ->orWhere('payment_reminder_sent_at', '<=', now()->subDays(7));
            })
            ->get();

        if ($overdueInvoices->isEmpty()) {
            $this->info('No overdue invoices found that need reminders.');
            return 0;
        }

        $this->info("Found {$overdueInvoices->count()} overdue invoice(s) to send reminders for.");

        $sent = 0;
        $failed = 0;

        foreach ($overdueInvoices as $invoice) {
            try {
                Mail::to($invoice->user->email)->send(new PaymentReminderMail($invoice));

                // Update the payment_reminder_sent_at timestamp
                $invoice->update(['payment_reminder_sent_at' => now()]);

                $this->line("✓ Sent reminder for invoice {$invoice->invoice_number} to {$invoice->user->email}");
                $sent++;
            } catch (\Exception $e) {
                $this->error("✗ Failed to send reminder for invoice {$invoice->invoice_number}: {$e->getMessage()}");
                $failed++;
            }
        }

        $this->newLine();
        $this->info("Summary:");
        $this->info("- Reminders sent: {$sent}");
        if ($failed > 0) {
            $this->error("- Failed: {$failed}");
        }

        return 0;
    }
}
