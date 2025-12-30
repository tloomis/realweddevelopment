<x-app-layout>
    <x-slot name="header">
        <h2 style="font-size: 1.875rem; font-weight: 800; color: #1f2937;">
            Payment - Invoice {{ $invoice->invoice_number }}
        </h2>
    </x-slot>

    <div style="padding: 3rem 0;">
        <div style="max-width: 42rem; margin: 0 auto; padding: 0 1.5rem;">

            <!-- Payment Summary -->
            <div style="background: white; padding: 2rem; border-radius: 0.75rem; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1); margin-bottom: 1.5rem;">
                <h3 style="font-size: 1.5rem; font-weight: 700; color: #1f2937; margin-bottom: 1.5rem;">
                    Invoice Summary
                </h3>

                <div style="border-top: 1px solid #e5e7eb; padding-top: 1.5rem;">
                    <div style="display: flex; justify-content: space-between; padding: 0.75rem 0; border-bottom: 1px solid #f3f4f6;">
                        <span style="color: #6b7280;">Invoice Number:</span>
                        <span style="font-weight: 600; color: #1f2937;">{{ $invoice->invoice_number }}</span>
                    </div>

                    <div style="display: flex; justify-content: space-between; padding: 0.75rem 0; border-bottom: 1px solid #f3f4f6;">
                        <span style="color: #6b7280;">Issue Date:</span>
                        <span style="font-weight: 600; color: #1f2937;">{{ $invoice->issue_date->format('M d, Y') }}</span>
                    </div>

                    <div style="display: flex; justify-content: space-between; padding: 0.75rem 0; border-bottom: 1px solid #f3f4f6;">
                        <span style="color: #6b7280;">Due Date:</span>
                        <span style="font-weight: 600; color: #1f2937;">{{ $invoice->due_date->format('M d, Y') }}</span>
                    </div>

                    <div style="display: flex; justify-content: space-between; padding: 0.75rem 0; border-bottom: 1px solid #f3f4f6;">
                        <span style="color: #6b7280;">Status:</span>
                        <span style="display: inline-flex; align-items: center; padding: 0.25rem 0.75rem; border-radius: 0.5rem; font-size: 0.875rem; font-weight: 600; background-color: {{ $invoice->status_badge['color'] }}22; color: {{ $invoice->status_badge['color'] }};">
                            {{ $invoice->status_badge['text'] }}
                        </span>
                    </div>

                    <div style="display: flex; justify-content: space-between; padding: 1.5rem 0 0 0; margin-top: 1rem; border-top: 2px solid #e5e7eb;">
                        <span style="font-size: 1.25rem; font-weight: 700; color: #1f2937;">Total Amount:</span>
                        <span style="font-size: 1.875rem; font-weight: 800; color: #0891b2;">${{ number_format($invoice->total, 2) }}</span>
                    </div>
                </div>
            </div>

            <!-- Invoice Items -->
            <div style="background: white; padding: 2rem; border-radius: 0.75rem; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1); margin-bottom: 1.5rem;">
                <h3 style="font-size: 1.125rem; font-weight: 700; color: #1f2937; margin-bottom: 1rem;">
                    Items
                </h3>

                <div style="overflow-x: auto;">
                    <table style="width: 100%; border-collapse: collapse;">
                        <thead style="background: #f9fafb; border-bottom: 1px solid #e5e7eb;">
                            <tr>
                                <th style="padding: 0.75rem; text-align: left; font-weight: 600; color: #6b7280; font-size: 0.875rem;">Description</th>
                                <th style="padding: 0.75rem; text-align: right; font-weight: 600; color: #6b7280; font-size: 0.875rem;">Qty</th>
                                <th style="padding: 0.75rem; text-align: right; font-weight: 600; color: #6b7280; font-size: 0.875rem;">Rate</th>
                                <th style="padding: 0.75rem; text-align: right; font-weight: 600; color: #6b7280; font-size: 0.875rem;">Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($invoice->items as $item)
                                <tr style="border-bottom: 1px solid #f3f4f6;">
                                    <td style="padding: 0.75rem; color: #1f2937;">{{ $item->description }}</td>
                                    <td style="padding: 0.75rem; text-align: right; color: #1f2937;">{{ $item->quantity }}</td>
                                    <td style="padding: 0.75rem; text-align: right; color: #1f2937;">${{ number_format($item->rate, 2) }}</td>
                                    <td style="padding: 0.75rem; text-align: right; font-weight: 600; color: #1f2937;">${{ number_format($item->amount, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Payment Method -->
            <div style="background: linear-gradient(135deg, #0891b2 0%, #0e7490 100%); color: white; padding: 2rem; border-radius: 0.75rem; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); margin-bottom: 1.5rem;">
                <h3 style="font-size: 1.25rem; font-weight: 700; margin-bottom: 1rem;">
                    💳 Secure Payment with Stripe
                </h3>
                <p style="opacity: 0.9; margin-bottom: 1.5rem; line-height: 1.6;">
                    Pay securely using your credit or debit card. Your payment information is encrypted and processed through Stripe's secure payment gateway.
                </p>

                <form method="POST" action="{{ route('client.payment.checkout', $invoice) }}">
                    @csrf
                    <button type="submit" style="width: 100%; background: white; color: #0891b2; padding: 1rem 2rem; border-radius: 0.5rem; font-weight: 700; font-size: 1.125rem; border: none; cursor: pointer; transition: all 0.2s ease; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 8px rgba(0, 0, 0, 0.15)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 4px rgba(0, 0, 0, 0.1)';">
                        Pay ${{ number_format($invoice->total, 2) }} Now
                    </button>
                </form>
            </div>

            <!-- Security Notice -->
            <div style="background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 0.5rem; padding: 1rem; text-align: center; margin-bottom: 1.5rem;">
                <div style="display: flex; align-items: center; justify-content: center; gap: 0.5rem; color: #166534;">
                    <svg style="width: 1.25rem; height: 1.25rem;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                    <span style="font-weight: 600; font-size: 0.875rem;">Secure 256-bit SSL encrypted payment</span>
                </div>
            </div>

            <!-- Back Link -->
            <div style="text-align: center;">
                <a href="{{ route('client.invoices.show', $invoice) }}" style="color: #6b7280; text-decoration: none; font-size: 0.875rem;">
                    ← Back to Invoice Details
                </a>
            </div>

        </div>
    </div>
</x-app-layout>
