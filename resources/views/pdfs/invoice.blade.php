<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice {{ $invoice->invoice_number }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 10pt;
            color: #334155;
            line-height: 1.5;
        }
        .page {
            padding: 35px;
        }

        /* Header Styles */
        .header {
            margin-bottom: 30px;
            border-bottom: 3px solid #0891b2;
            padding-bottom: 20px;
        }
        .header-content {
            width: 100%;
            border-collapse: collapse;
        }
        .logo-cell {
            width: 90px;
            vertical-align: top;
            padding-right: 15px;
        }
        .logo-box {
            width: 80px;
            height: 80px;
            background: #0891b2;
            border-radius: 10px;
            text-align: center;
            padding-top: 16px;
            border: 3px solid #0e7490;
        }
        .logo-text {
            font-size: 36pt;
            font-weight: bold;
            color: white;
            line-height: 1;
        }
        .company-info {
            vertical-align: top;
            padding-top: 5px;
        }
        .company-name {
            font-size: 24pt;
            font-weight: bold;
            color: #0f172a;
            margin-bottom: 6px;
            line-height: 1;
        }
        .company-tagline {
            font-size: 10pt;
            color: #64748b;
            margin-bottom: 10px;
        }
        .company-contact {
            font-size: 9pt;
            color: #64748b;
            margin-top: 6px;
        }

        /* Invoice Title Section */
        .invoice-header {
            margin-bottom: 30px;
            background: #f8fafc;
            padding: 20px;
            border-radius: 6px;
            border-left: 4px solid #0891b2;
        }
        .invoice-header-table {
            width: 100%;
            border-collapse: collapse;
        }
        .invoice-title-cell {
            width: 60%;
            vertical-align: top;
        }
        .invoice-title {
            font-size: 32pt;
            font-weight: bold;
            color: #0891b2;
            line-height: 1;
            margin-bottom: 6px;
        }
        .invoice-number {
            font-size: 16pt;
            color: #0f172a;
            font-weight: 600;
            margin-top: 4px;
        }
        .invoice-status-cell {
            width: 40%;
            vertical-align: top;
            text-align: right;
        }
        .status-badge {
            display: inline-block;
            padding: 8px 16px;
            border-radius: 6px;
            font-weight: bold;
            font-size: 11pt;
            color: {{ $invoice->status_badge['color'] }};
            background-color: {{ $invoice->status_badge['color'] }}22;
            border: 2px solid {{ $invoice->status_badge['color'] }};
            margin-bottom: 12px;
        }

        /* Info Section */
        .info-section {
            margin-bottom: 30px;
        }
        .info-grid {
            width: 100%;
            border-collapse: collapse;
        }
        .info-cell {
            width: 50%;
            padding: 12px;
            vertical-align: top;
        }
        .info-cell-left {
            background: #f1f5f9;
            border-radius: 6px;
        }
        .info-cell-right {
            background: #f8fafc;
            border-radius: 6px;
        }
        .info-label {
            font-weight: bold;
            color: #0891b2;
            font-size: 9pt;
            text-transform: uppercase;
            margin-bottom: 6px;
        }
        .info-value {
            color: #0f172a;
            font-size: 10pt;
            line-height: 1.6;
        }
        .info-value-large {
            font-size: 13pt;
            font-weight: bold;
            color: #0f172a;
        }

        /* Table Styles */
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
        }
        .items-table thead {
            background: #0891b2;
            color: white;
        }
        .items-table th {
            text-align: left;
            padding: 12px 10px;
            font-weight: bold;
            font-size: 10pt;
            text-transform: uppercase;
        }
        .items-table th.right {
            text-align: right;
        }
        .items-table th.center {
            text-align: center;
        }
        .items-table tbody tr {
            border-bottom: 1px solid #e2e8f0;
        }
        .items-table tbody tr:last-child {
            border-bottom: 2px solid #0891b2;
        }
        .items-table td {
            padding: 12px 10px;
            font-size: 10pt;
            color: #334155;
        }
        .items-table td.right {
            text-align: right;
        }
        .items-table td.center {
            text-align: center;
        }
        .items-table tbody tr:nth-child(even) {
            background: #f8fafc;
        }

        /* Totals Section */
        .totals-section {
            width: 320px;
            margin-left: auto;
            margin-bottom: 30px;
            border: 2px solid #e2e8f0;
            border-radius: 6px;
            padding: 16px;
        }
        .total-row {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }
        .total-row td {
            padding: 6px 0;
        }
        .total-label {
            color: #64748b;
            font-size: 10pt;
            font-weight: 500;
        }
        .total-value {
            text-align: right;
            font-weight: 600;
            color: #0f172a;
            font-size: 10pt;
        }
        .grand-total-row {
            border-top: 3px solid #0891b2;
            margin-top: 10px;
        }
        .grand-total-row td {
            padding-top: 12px;
        }
        .grand-total-label {
            color: #0891b2;
            font-size: 13pt;
            font-weight: bold;
            text-transform: uppercase;
        }
        .grand-total-value {
            text-align: right;
            color: #0891b2;
            font-size: 15pt;
            font-weight: bold;
        }

        /* Notes Section */
        .notes-section {
            padding: 16px;
            background: #fffbeb;
            border-left: 4px solid #f59e0b;
            margin-bottom: 25px;
            border-radius: 6px;
        }
        .notes-title {
            font-weight: bold;
            color: #92400e;
            margin-bottom: 8px;
            font-size: 10pt;
            text-transform: uppercase;
        }
        .notes-content {
            color: #78350f;
            font-size: 10pt;
            line-height: 1.6;
        }

        /* Payment Info */
        .payment-info {
            padding: 20px;
            background: #eff6ff;
            border: 2px solid #93c5fd;
            border-radius: 6px;
            margin-bottom: 25px;
        }
        .payment-title {
            font-weight: bold;
            color: #1e40af;
            margin-bottom: 10px;
            font-size: 12pt;
            text-transform: uppercase;
        }
        .payment-content {
            color: #1e3a8a;
            font-size: 10pt;
            line-height: 1.6;
        }

        /* Paid Stamp */
        .paid-stamp {
            padding: 20px;
            background: #ecfdf5;
            border: 3px solid #10b981;
            border-radius: 8px;
            text-align: center;
            margin-bottom: 25px;
        }
        .paid-stamp-text {
            font-size: 26pt;
            font-weight: bold;
            color: #065f46;
            margin-bottom: 6px;
        }
        .paid-date {
            font-size: 11pt;
            color: #047857;
            font-weight: 500;
        }

        /* Footer */
        .footer {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 2px solid #e2e8f0;
            text-align: center;
        }
        .footer-company {
            font-size: 10pt;
            font-weight: bold;
            color: #0891b2;
            margin-bottom: 4px;
        }
        .footer-tagline {
            font-size: 9pt;
            color: #64748b;
            margin-bottom: 8px;
        }
        .footer-contact {
            font-size: 9pt;
            color: #64748b;
            margin-bottom: 12px;
        }
        .footer-thanks {
            font-size: 8pt;
            color: #94a3b8;
            font-style: italic;
            margin-top: 12px;
        }
    </style>
</head>
<body>
    <div class="page">
        <!-- Header -->
        <div class="header">
            <table class="header-content">
                <tr>
                    <td class="logo-cell">
                        <div class="logo-box">
                            <div class="logo-text">RW</div>
                        </div>
                    </td>
                    <td class="company-info">
                        <div class="company-name">RealWebDevelopment</div>
                        <div class="company-tagline">Professional Web Development Services</div>
                        <div class="company-contact">
                            Email: billing@realwebdevelopment.com
                        </div>
                    </td>
                </tr>
            </table>
        </div>

        <!-- Invoice Header -->
        <div class="invoice-header">
            <table class="invoice-header-table">
                <tr>
                    <td class="invoice-title-cell">
                        <div class="invoice-title">INVOICE</div>
                        <div class="invoice-number">{{ $invoice->invoice_number }}</div>
                    </td>
                    <td class="invoice-status-cell">
                        <div class="status-badge">{{ $invoice->status_badge['text'] }}</div>
                        <div style="font-size: 10pt; color: #64748b; margin-top: 5px;">
                            <strong>Total Amount:</strong><br>
                            <span style="font-size: 18pt; color: #0891b2; font-weight: bold;">${{ number_format($invoice->total, 2) }}</span>
                        </div>
                    </td>
                </tr>
            </table>
        </div>

        <!-- Invoice Information -->
        <div class="info-section">
            <table class="info-grid">
                <tr>
                    <td class="info-cell info-cell-left" style="padding-right: 10px;">
                        <div class="info-label">BILL TO</div>
                        <div class="info-value-large">{{ $invoice->user->name }}</div>
                        <div class="info-value">{{ $invoice->user->email }}</div>
                    </td>
                    <td class="info-cell info-cell-right" style="padding-left: 10px;">
                        <div class="info-label">INVOICE DETAILS</div>
                        <div class="info-value">
                            <strong>Issue Date:</strong> {{ $invoice->issue_date->format('F d, Y') }}<br>
                            <strong>Due Date:</strong> {{ $invoice->due_date->format('F d, Y') }}
                            @if($invoice->paid_date)
                            <br><strong>Paid Date:</strong> {{ $invoice->paid_date->format('F d, Y') }}
                            @endif
                        </div>
                    </td>
                </tr>
            </table>
        </div>

        <!-- Line Items -->
        <table class="items-table">
            <thead>
                <tr>
                    <th style="width: 50%;">DESCRIPTION</th>
                    <th class="center" style="width: 15%;">QTY</th>
                    <th class="right" style="width: 17.5%;">UNIT PRICE</th>
                    <th class="right" style="width: 17.5%;">TOTAL</th>
                </tr>
            </thead>
            <tbody>
                @foreach($invoice->items as $item)
                <tr>
                    <td style="font-weight: 500;">{{ $item->description }}</td>
                    <td class="center">{{ $item->quantity }}</td>
                    <td class="right">${{ number_format($item->unit_price, 2) }}</td>
                    <td class="right" style="font-weight: bold; color: #0f172a;">${{ number_format($item->total, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Totals -->
        <div class="totals-section">
            <table class="total-row">
                <tr>
                    <td class="total-label">Subtotal</td>
                    <td class="total-value">${{ number_format($invoice->subtotal, 2) }}</td>
                </tr>
            </table>
            <table class="total-row">
                <tr>
                    <td class="total-label">Tax ({{ $invoice->tax_rate }}%)</td>
                    <td class="total-value">${{ number_format($invoice->tax_amount, 2) }}</td>
                </tr>
            </table>
            <table class="total-row grand-total-row">
                <tr>
                    <td class="grand-total-label">TOTAL</td>
                    <td class="grand-total-value">${{ number_format($invoice->total, 2) }}</td>
                </tr>
            </table>
        </div>

        <!-- Notes -->
        @if($invoice->notes)
        <div class="notes-section">
            <div class="notes-title">Notes</div>
            <div class="notes-content">{{ $invoice->notes }}</div>
        </div>
        @endif

        <!-- Payment Status -->
        @if($invoice->status === 'paid')
        <div class="paid-stamp">
            <div class="paid-stamp-text">✓ PAID</div>
            <div class="paid-date">Payment received on {{ $invoice->paid_date->format('F d, Y') }}</div>
        </div>
        @elseif($invoice->status === 'sent' || $invoice->status === 'overdue')
        <div class="payment-info">
            <div class="payment-title">Payment Information</div>
            <div class="payment-content">
                To make a payment, please contact us at <strong>billing@realwebdevelopment.com</strong> or reference invoice number <strong>{{ $invoice->invoice_number }}</strong> when submitting payment.
                @if($invoice->status === 'overdue')
                <br><br><strong style="color: #dc2626;">⚠ NOTICE: This invoice is overdue. Payment was due on {{ $invoice->due_date->format('F d, Y') }}.</strong>
                @endif
            </div>
        </div>
        @endif

        <!-- Footer -->
        <div class="footer">
            <div class="footer-company">RealWebDevelopment</div>
            <div class="footer-tagline">Professional Web Development Services</div>
            <div class="footer-contact">billing@realwebdevelopment.com</div>
            <div class="footer-thanks">Thank you for your business!</div>
        </div>
    </div>
</body>
</html>
