<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Reminder</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background-color: #f3f4f6;
            color: #1f2937;
        }
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background: white;
        }
        .email-header {
            background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }
        .email-body {
            padding: 40px 30px;
        }
        .invoice-details {
            background: #fef2f2;
            border: 2px solid #fecaca;
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
        }
        .invoice-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px solid #fee2e2;
        }
        .invoice-row:last-child {
            border-bottom: none;
        }
        .label {
            font-weight: 600;
            color: #991b1b;
        }
        .value {
            color: #b91c1c;
        }
        .total-row {
            padding: 15px 0 0 0;
            border-top: 2px solid #dc2626;
            margin-top: 10px;
        }
        .total-row .label {
            font-size: 18px;
            font-weight: bold;
        }
        .total-row .value {
            font-size: 22px;
            font-weight: bold;
        }
        .cta-button {
            display: inline-block;
            padding: 15px 30px;
            background: #dc2626;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            font-weight: bold;
            margin: 20px 0;
        }
        .footer {
            background: #f9fafb;
            padding: 30px;
            text-align: center;
            font-size: 14px;
            color: #6b7280;
            border-top: 1px solid #e5e7eb;
        }
        .warning-icon {
            font-size: 48px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="email-header">
            <div class="warning-icon">⚠️</div>
            <h1 style="margin: 0; font-size: 28px;">Payment Reminder</h1>
            <p style="margin: 10px 0 0 0; opacity: 0.9;">Invoice {{ $invoice->invoice_number }}</p>
        </div>

        <div class="email-body">
            <p style="font-size: 16px; line-height: 1.6; margin-bottom: 20px;">
                Hello {{ $invoice->user->name }},
            </p>

            <p style="font-size: 16px; line-height: 1.6; margin-bottom: 20px;">
                This is a friendly reminder that invoice <strong>{{ $invoice->invoice_number }}</strong> is now overdue.
                The payment was due on <strong>{{ $invoice->due_date->format('F d, Y') }}</strong>
                ({{ $invoice->due_date->diffForHumans() }}).
            </p>

            <div class="invoice-details">
                <div class="invoice-row">
                    <span class="label">Invoice Number:</span>
                    <span class="value">{{ $invoice->invoice_number }}</span>
                </div>
                <div class="invoice-row">
                    <span class="label">Issue Date:</span>
                    <span class="value">{{ $invoice->issue_date->format('M d, Y') }}</span>
                </div>
                <div class="invoice-row">
                    <span class="label">Due Date:</span>
                    <span class="value">{{ $invoice->due_date->format('M d, Y') }}</span>
                </div>
                <div class="invoice-row">
                    <span class="label">Days Overdue:</span>
                    <span class="value">{{ abs($invoice->due_date->diffInDays(now())) }} days</span>
                </div>
                <div class="invoice-row total-row">
                    <span class="label">Amount Due:</span>
                    <span class="value">${{ number_format($invoice->total, 2) }}</span>
                </div>
            </div>

            <p style="font-size: 16px; line-height: 1.6; margin-bottom: 20px;">
                Please arrange payment at your earliest convenience to avoid any late fees or service interruptions.
                The invoice PDF is attached to this email for your reference.
            </p>

            <p style="font-size: 16px; line-height: 1.6; margin-bottom: 20px;">
                <strong>Payment Methods:</strong>
            </p>

            <ul style="font-size: 16px; line-height: 1.8; margin-bottom: 30px;">
                <li>Contact us at <a href="mailto:billing@realwebdevelopment.com" style="color: #dc2626; text-decoration: none;">billing@realwebdevelopment.com</a></li>
                <li>Reference invoice number: <strong>{{ $invoice->invoice_number }}</strong></li>
            </ul>

            <div style="text-align: center;">
                <a href="{{ url('/login') }}" class="cta-button">View Invoice Online</a>
            </div>

            <p style="font-size: 14px; color: #6b7280; line-height: 1.6; margin-top: 30px;">
                If you have already made this payment, please disregard this reminder. If you have any questions or concerns,
                feel free to contact us at billing@realwebdevelopment.com.
            </p>
        </div>

        <div class="footer">
            <strong style="color: #0891b2;">RealWebDevelopment</strong><br>
            Professional Web Development Services<br>
            billing@realwebdevelopment.com
        </div>
    </div>
</body>
</html>
