<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Invoice: {{ $invoice->invoice_number }}</title>
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
        .info-grid {
            display: table;
            width: 100%;
            margin-bottom: 30px;
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
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin: 30px 0;
        }
        .items-table th {
            background-color: #f8fafc;
            padding: 12px;
            text-align: left;
            font-size: 14px;
            font-weight: 600;
            color: #64748b;
            border-bottom: 2px solid #e2e8f0;
        }
        .items-table td {
            padding: 12px;
            border-bottom: 1px solid #e2e8f0;
            color: #334155;
        }
        .items-table th:last-child,
        .items-table td:last-child {
            text-align: right;
        }
        .total-section {
            background-color: #f8fafc;
            padding: 20px;
            border-radius: 8px;
            margin-top: 20px;
        }
        .total-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            font-size: 16px;
        }
        .total-row.grand-total {
            border-top: 2px solid #e2e8f0;
            margin-top: 8px;
            padding-top: 16px;
            font-size: 20px;
            font-weight: 700;
            color: #0891b2;
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
        .notes-box {
            background-color: #fffbeb;
            border-left: 4px solid #f59e0b;
            padding: 16px;
            margin: 20px 0;
            border-radius: 4px;
        }
        .notes-box strong {
            color: #92400e;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="email-header">
            <h1 class="email-logo">RealWebDevelopment</h1>
        </div>

        <div class="email-body">
            <h2 class="invoice-title">New Invoice</h2>
            <div class="invoice-number">{{ $invoice->invoice_number }}</div>

            <div class="info-grid">
                <div class="info-row">
                    <div class="info-label">Issue Date:</div>
                    <div class="info-value">{{ $invoice->issue_date->format('F d, Y') }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Due Date:</div>
                    <div class="info-value">{{ $invoice->due_date->format('F d, Y') }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Status:</div>
                    <div class="info-value" style="color: {{ $invoice->status_badge['color'] }}; font-weight: 600;">
                        {{ $invoice->status_badge['text'] }}
                    </div>
                </div>
            </div>

            @if($invoice->items->count() > 0)
                <table class="items-table">
                    <thead>
                        <tr>
                            <th>Description</th>
                            <th style="text-align: center;">Qty</th>
                            <th>Price</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($invoice->items as $item)
                            <tr>
                                <td>{{ $item->description }}</td>
                                <td style="text-align: center;">{{ $item->quantity }}</td>
                                <td>${{ number_format($item->unit_price, 2) }}</td>
                                <td style="text-align: right;">${{ number_format($item->total, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif

            <div class="total-section">
                <div class="total-row">
                    <span>Subtotal:</span>
                    <span>${{ number_format($invoice->subtotal, 2) }}</span>
                </div>
                <div class="total-row">
                    <span>Tax ({{ $invoice->tax_rate }}%):</span>
                    <span>${{ number_format($invoice->tax_amount, 2) }}</span>
                </div>
                <div class="total-row grand-total">
                    <span>Total Amount Due:</span>
                    <span>${{ number_format($invoice->total, 2) }}</span>
                </div>
            </div>

            @if($invoice->notes)
                <div class="notes-box">
                    <strong>Notes:</strong><br>
                    {{ $invoice->notes }}
                </div>
            @endif

            <div class="divider"></div>

            <p style="text-align: center; margin: 0;">
                <a href="{{ url('/login') }}" class="cta-button">View Invoice in Dashboard</a>
            </p>
        </div>

        <div class="email-footer">
            <p style="margin: 0 0 10px 0;">This invoice was sent to {{ $invoice->user->email }}</p>
            <p style="margin: 0; color: #94a3b8;">
                &copy; {{ date('Y') }} RealWebDevelopment. All rights reserved.
            </p>
        </div>
    </div>
</body>
</html>
