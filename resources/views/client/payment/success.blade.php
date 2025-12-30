<x-app-layout>
    <x-slot name="header">
        <h2 style="font-size: 1.875rem; font-weight: 800; color: #1f2937;">
            Payment Successful
        </h2>
    </x-slot>

    <div style="padding: 3rem 0;">
        <div style="max-width: 42rem; margin: 0 auto; padding: 0 1.5rem;">

            <!-- Success Message -->
            <div style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: white; padding: 3rem 2rem; border-radius: 0.75rem; box-shadow: 0 10px 25px rgba(16, 185, 129, 0.3); margin-bottom: 2rem; text-align: center;">
                <div style="font-size: 4rem; margin-bottom: 1rem;">✓</div>
                <h3 style="font-size: 2rem; font-weight: 800; margin-bottom: 0.5rem;">Payment Successful!</h3>
                <p style="font-size: 1.125rem; opacity: 0.9;">
                    Your payment has been processed successfully.
                </p>
            </div>

            <!-- Payment Details -->
            <div style="background: white; padding: 2rem; border-radius: 0.75rem; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1); margin-bottom: 1.5rem;">
                <h4 style="font-size: 1.25rem; font-weight: 700; color: #1f2937; margin-bottom: 1.5rem;">
                    Payment Details
                </h4>

                <div style="border-top: 1px solid #e5e7eb; padding-top: 1.5rem;">
                    <div style="display: flex; justify-content: space-between; padding: 0.75rem 0; border-bottom: 1px solid #f3f4f6;">
                        <span style="color: #6b7280;">Invoice Number:</span>
                        <span style="font-weight: 600; color: #1f2937;">{{ $invoice->invoice_number }}</span>
                    </div>

                    <div style="display: flex; justify-content: space-between; padding: 0.75rem 0; border-bottom: 1px solid #f3f4f6;">
                        <span style="color: #6b7280;">Payment Date:</span>
                        <span style="font-weight: 600; color: #1f2937;">{{ $invoice->paid_date->format('M d, Y') }}</span>
                    </div>

                    <div style="display: flex; justify-content: space-between; padding: 0.75rem 0; border-bottom: 1px solid #f3f4f6;">
                        <span style="color: #6b7280;">Payment Method:</span>
                        <span style="font-weight: 600; color: #1f2937;">{{ $invoice->payment_method }}</span>
                    </div>

                    <div style="display: flex; justify-content: space-between; padding: 0.75rem 0; border-bottom: 1px solid #f3f4f6;">
                        <span style="color: #6b7280;">Transaction ID:</span>
                        <span style="font-weight: 600; color: #1f2937; font-family: monospace; font-size: 0.875rem;">{{ $invoice->payment_reference }}</span>
                    </div>

                    <div style="display: flex; justify-content: space-between; padding: 1.5rem 0 0 0; margin-top: 1rem; border-top: 2px solid #e5e7eb;">
                        <span style="font-size: 1.25rem; font-weight: 700; color: #1f2937;">Amount Paid:</span>
                        <span style="font-size: 1.875rem; font-weight: 800; color: #10b981;">${{ number_format($invoice->total, 2) }}</span>
                    </div>
                </div>
            </div>

            <!-- Next Steps -->
            <div style="background: #eff6ff; border: 1px solid #bfdbfe; border-radius: 0.75rem; padding: 1.5rem; margin-bottom: 2rem;">
                <h4 style="font-size: 1.125rem; font-weight: 700; color: #1e40af; margin-bottom: 1rem;">
                    📧 What's Next?
                </h4>
                <ul style="margin: 0; padding-left: 1.5rem; color: #1e3a8a; line-height: 1.8;">
                    <li>A confirmation email has been sent to your email address</li>
                    <li>You can download a PDF receipt from your invoice page</li>
                    <li>The invoice status has been updated to "Paid"</li>
                </ul>
            </div>

            <!-- Action Buttons -->
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem;">
                <a href="{{ route('client.invoices.show', $invoice) }}" style="background: #0891b2; color: white; padding: 0.875rem 1.5rem; border-radius: 0.5rem; text-decoration: none; font-weight: 600; text-align: center; transition: all 0.2s ease;" onmouseover="this.style.background='#0e7490'" onmouseout="this.style.background='#0891b2'">
                    View Invoice
                </a>

                <a href="{{ route('client.invoices.pdf', $invoice) }}" style="background: #10b981; color: white; padding: 0.875rem 1.5rem; border-radius: 0.5rem; text-decoration: none; font-weight: 600; text-align: center; transition: all 0.2s ease;" onmouseover="this.style.background='#059669'" onmouseout="this.style.background='#10b981'">
                    Download Receipt
                </a>

                <a href="{{ route('client.dashboard') }}" style="background: #6b7280; color: white; padding: 0.875rem 1.5rem; border-radius: 0.5rem; text-decoration: none; font-weight: 600; text-align: center; transition: all 0.2s ease;" onmouseover="this.style.background='#4b5563'" onmouseout="this.style.background='#6b7280'">
                    Back to Dashboard
                </a>
            </div>

        </div>
    </div>
</x-app-layout>
