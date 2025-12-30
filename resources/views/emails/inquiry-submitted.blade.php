<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Invoice Inquiry</title>
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
        .inquiry-title {
            font-size: 24px;
            font-weight: 700;
            color: #1e293b;
            margin: 0 0 10px 0;
        }
        .inquiry-meta {
            font-size: 14px;
            color: #64748b;
            margin-bottom: 30px;
        }
        .info-box {
            background-color: #eff6ff;
            border-left: 4px solid #0891b2;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 4px;
        }
        .info-label {
            font-size: 12px;
            font-weight: 600;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 5px;
        }
        .info-value {
            font-size: 16px;
            font-weight: 600;
            color: #1e293b;
        }
        .message-content {
            font-size: 16px;
            line-height: 1.6;
            color: #334155;
            margin-bottom: 30px;
            white-space: pre-wrap;
            background-color: #f8fafc;
            padding: 20px;
            border-radius: 8px;
            border: 1px solid #e2e8f0;
        }
        .cta-button {
            display: inline-block;
            background: linear-gradient(135deg, #0891b2 0%, #0e7490 100%);
            color: #ffffff;
            text-decoration: none;
            padding: 14px 30px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 16px;
            margin-top: 10px;
        }
        .email-footer {
            background-color: #f1f5f9;
            padding: 30px;
            text-align: center;
            font-size: 14px;
            color: #64748b;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <!-- Header -->
        <div class="email-header">
            <h1 class="email-logo">RealWebDevelopment</h1>
        </div>

        <!-- Body -->
        <div class="email-body">
            <h2 class="inquiry-title">New Invoice Inquiry</h2>
            <p class="inquiry-meta">
                Submitted by {{ $inquiry->user->name }} on {{ $inquiry->created_at->format('F d, Y \a\t g:i A') }}
            </p>

            <div class="info-box" style="margin-bottom: 10px;">
                <div class="info-label">Invoice Number</div>
                <div class="info-value">{{ $inquiry->invoice->invoice_number }}</div>
            </div>

            <div class="info-box" style="margin-bottom: 10px;">
                <div class="info-label">Invoice Amount</div>
                <div class="info-value">${{ number_format($inquiry->invoice->total, 2) }}</div>
            </div>

            <div class="info-box">
                <div class="info-label">Subject</div>
                <div class="info-value">{{ $inquiry->subject }}</div>
            </div>

            <h3 style="font-size: 18px; font-weight: 600; color: #1e293b; margin: 30px 0 15px 0;">Client Message:</h3>
            <div class="message-content">{{ $inquiry->message }}</div>

            <p style="color: #64748b; font-size: 14px; margin-bottom: 20px;">
                Please review this inquiry and respond to the client as soon as possible through the admin panel.
            </p>

            <a href="{{ route('admin.clients.show', $inquiry->user_id) }}" class="cta-button">
                View Client & Respond
            </a>
        </div>

        <!-- Footer -->
        <div class="email-footer">
            <p style="margin: 0 0 10px 0;">
                <strong>RealWebDevelopment</strong><br>
                Professional Web Development Services
            </p>
            <p style="margin: 0; font-size: 12px;">
                This is an automated notification. Please do not reply to this email.
            </p>
        </div>
    </div>
</body>
</html>
