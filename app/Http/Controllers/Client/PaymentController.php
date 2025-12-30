<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Checkout\Session;

class PaymentController extends Controller
{
    public function __construct()
    {
        // Set Stripe API key
        Stripe::setApiKey(config('services.stripe.secret'));
    }

    /**
     * Show payment page for an invoice
     */
    public function show(Invoice $invoice)
    {
        // Verify this invoice belongs to the authenticated user
        if ($invoice->user_id !== auth()->id()) {
            abort(403, 'Unauthorized access to this invoice.');
        }

        // Check if invoice can be paid
        if ($invoice->status === 'paid') {
            return redirect()->route('client.invoices.show', $invoice)
                ->with('error', 'This invoice has already been paid.');
        }

        return view('client.payment.show', compact('invoice'));
    }

    /**
     * Create a Stripe Checkout session
     */
    public function createCheckoutSession(Invoice $invoice)
    {
        // Verify this invoice belongs to the authenticated user
        if ($invoice->user_id !== auth()->id()) {
            abort(403, 'Unauthorized access to this invoice.');
        }

        // Check if invoice can be paid
        if ($invoice->status === 'paid') {
            return redirect()->route('client.invoices.show', $invoice)
                ->with('error', 'This invoice has already been paid.');
        }

        try {
            $checkoutSession = Session::create([
                'payment_method_types' => ['card'],
                'line_items' => [[
                    'price_data' => [
                        'currency' => 'usd',
                        'product_data' => [
                            'name' => 'Invoice ' . $invoice->invoice_number,
                            'description' => 'Payment for invoice ' . $invoice->invoice_number,
                        ],
                        'unit_amount' => (int)($invoice->total * 100), // Convert to cents
                    ],
                    'quantity' => 1,
                ]],
                'mode' => 'payment',
                'success_url' => route('client.payment.success', ['invoice' => $invoice->id]) . '?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => route('client.payment.show', $invoice),
                'customer_email' => auth()->user()->email,
                'metadata' => [
                    'invoice_id' => $invoice->id,
                    'invoice_number' => $invoice->invoice_number,
                ],
            ]);

            return redirect($checkoutSession->url);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Unable to create payment session: ' . $e->getMessage());
        }
    }

    /**
     * Handle successful payment
     */
    public function success(Invoice $invoice, Request $request)
    {
        // Verify this invoice belongs to the authenticated user
        if ($invoice->user_id !== auth()->id()) {
            abort(403, 'Unauthorized access to this invoice.');
        }

        $sessionId = $request->get('session_id');

        if (!$sessionId) {
            return redirect()->route('client.invoices.show', $invoice)
                ->with('error', 'Invalid payment session.');
        }

        try {
            // Retrieve the session from Stripe
            $session = Session::retrieve($sessionId);

            // Verify the session is complete
            if ($session->payment_status === 'paid') {
                // Update invoice status
                $invoice->update([
                    'status' => 'paid',
                    'paid_date' => now(),
                    'payment_method' => 'Credit Card (Stripe)',
                    'payment_reference' => $session->payment_intent,
                ]);

                return view('client.payment.success', compact('invoice', 'session'));
            } else {
                return redirect()->route('client.invoices.show', $invoice)
                    ->with('error', 'Payment not completed.');
            }
        } catch (\Exception $e) {
            return redirect()->route('client.invoices.show', $invoice)
                ->with('error', 'Unable to verify payment: ' . $e->getMessage());
        }
    }

    /**
     * Handle cancelled payment
     */
    public function cancel(Invoice $invoice)
    {
        return redirect()->route('client.invoices.show', $invoice)
            ->with('warning', 'Payment cancelled. You can try again whenever you\'re ready.');
    }
}
