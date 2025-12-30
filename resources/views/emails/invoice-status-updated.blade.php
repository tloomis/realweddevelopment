<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice Status Updated: {{ $invoice->invoice_number }}</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background-color: #f8fafc;
            color: #334155;
        }
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
        }
        .email-header {
            background: linear-gradient(135deg, #0891b2 0%, #0e7490 100%);
            padding: 40px 30px;
            text-align: center;
        }
        .email-logo {
            font-size: 28px;
            font-weight: 700;
            color: #ffffff;
            margin: 0;
        }
        .email-body {
            padding: 40px 30px;
        }
        .invoice-title {
            font-size: 24px;
            font-weight: 700;
            color: #1e293b;
            margin: 0 0 10px 0;
        }
        .invoice-number {
            font-size: 18px;
            color: #0891b2;
            font-weight: 600;
            margin-bottom: 30px;
        }
        .status-badge {
            display: inline-block;
            padding: 12px 24px;
            border-radius: 8px;
            font-size: 18px;
            font-weight: 700;
            margin: 20px 0;
        }
        .info-grid {
            display: table;
            width: 100%;
            margin: 30px 0;
        }
        .info-row {
            display: table-row;
        }
        .info-label {
            display: table-cell;
            padding: 8px 0;
            font-weight: 600;
            color: #64748b;
        }
        .info-value {
            display: table-cell;
            padding: 8px 0;
            text-align: right;
            color: #1e293b;
        }
        .highlight-box {
            background-color: #f0f9ff;
            border: 2px solid #0891b2;
            border-radius: 8px;
            padding: 20px;
            text-align: center;
            margin: 30px 0;
        }
        .highlight-box .amount {
            font-size: 32px;
            font-weight: 700;
            color: #0891b2;
            margin: 10px 0;
        }
        .cta-button {
            display: inline-block;
            padding: 14px 28px;
            background: linear-gradient(135deg, #0891b2 0%, #0e7490 100%);
            color: #ffffff;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 600;
            font-size: 16px;
        }
        .email-footer {
            background-color: #f8fafc;
            padding: 30px;
            text-align: center;
            font-size: 14px;
            color: #64748b;
            border-top: 1px solid #e2e8f0;
        }
        .divider {
            height: 1px;
            background-color: #e2e8f0;
            margin: 30px 0;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="email-header">
            <h1 class="email-logo">RealWebDevelopment</h1>
        </div>

        <div class="email-body">
            <h2 class="invoice-title">Invoice Status Updated</h2>
            <div class="invoice-number">{{ $invoice->invoice_number }}</div>

            <p style="font-size: 16px; color: #64748b; margin-bottom: 20px;">
                The status of your invoice has been updated:
            </p>

            <div style="text-align: center;">
                <span class="status-badge" style="background-color: {{ $invoice->status_badge['color'] }}22; color: {{ $invoice->status_badge['color'] }};">
                    {{ $invoice->status_badge['text'] }}
                </span>
            </div>

            @if($invoice->status === 'paid')
                <div class="highlight-box" style="background-color: #ecfdf5; border-color: #10b981;">
                    <p style="margin: 0; font-size: 18px; font-weight: 600; color: #065f46;">
                        Thank you for your payment!
                    </p>
                    @if($invoice->paid_date)
                        <p style="margin: 10px 0 0 0; color: #059669;">
                            Paid on {{ $invoice->paid_date->format('F d, Y') }}
                        </p>
                    @endif
                </div>
            @elseif($invoice->status === 'sent')
                <div class="highlight-box">
                    <p style="margin: 0 0 10px 0; font-size: 16px; color: #0891b2;">Total Amount Due</p>
                    <div class="amount">${{ number_format($invoice->total, 2) }}</div>
                    <p style="margin: 10px 0 0 0; color: #64748b;">
                        Due: {{ $invoice->due_date->format('F d, Y') }}
                    </p>
                </div>
            @elseif($invoice->status === 'overdue')
                <div class="highlight-box" style="background-color: #fef2f2; border-color: #ef4444;">
                    <p style="margin: 0 0 10px 0; font-size: 18px; font-weight: 600; color: #991b1b;">
                        Payment Overdue
                    </p>
                    <div class="amount" style="color: #dc2626;">${{ number_format($invoice->total, 2) }}</div>
                    <p style="margin: 10px 0 0 0; color: #b91c1c;">
                        Was due: {{ $invoice->due_date->format('F d, Y') }}
                    </p>
                </div>
            @endif

            <div class="info-grid">
                <div class="info-row">
                    <div class="info-label">Invoice Number:</div>
                    <div class="info-value">{{ $invoice->invoice_number }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Issue Date:</div>
                    <div class="info-value">{{ $invoice->issue_date->format('F d, Y') }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Due Date:</div>
                    <div class="info-value">{{ $invoice->due_date->format('F d, Y') }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Amount:</div>
                    <div class="info-value" style="font-weight: 700; font-size: 18px;">${{ number_format($invoice->total, 2) }}</div>
                </div>
            </div>

            <div class="divider"></div>

            <p style="text-align: center; margin: 0;">
                <a href="{{ url('/login') }}" class="cta-button">View Invoice Details</a>
            </p>
        </div>

        <div class="email-footer">
            <p style="margin: 0 0 10px 0;">This notification was sent to {{ $invoice->user->email }}</p>
            <p style="margin: 0; color: #94a3b8;">
                &copy; {{ date('Y') }} RealWebDevelopment. All rights reserved.
            </p>
        </div>
    </div>
</body>
</html>
