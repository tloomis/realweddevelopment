<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $clientMessage->subject }}</title>
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
        .message-title {
            font-size: 24px;
            font-weight: 700;
            color: #1e293b;
            margin: 0 0 10px 0;
        }
        .message-meta {
            font-size: 14px;
            color: #64748b;
            margin-bottom: 30px;
        }
        .message-content {
            font-size: 16px;
            line-height: 1.6;
            color: #334155;
            margin-bottom: 30px;
            white-space: pre-wrap;
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
            <h2 class="message-title">{{ $clientMessage->subject }}</h2>
            <p class="message-meta">
                From: {{ $clientMessage->sender->name }}<br>
                Sent: {{ $clientMessage->created_at->format('F d, Y \a\t g:i A') }}
            </p>

            <div class="message-content">{{ $clientMessage->message }}</div>

            <div class="divider"></div>

            <p style="text-align: center; margin: 0;">
                <a href="{{ url('/login') }}" class="cta-button">Login to Your Dashboard</a>
            </p>
        </div>

        <div class="email-footer">
            <p style="margin: 0 0 10px 0;">This message was sent to {{ $clientMessage->user->email }}</p>
            <p style="margin: 0; color: #94a3b8;">
                &copy; {{ date('Y') }} RealWebDevelopment. All rights reserved.
            </p>
        </div>
    </div>
</body>
</html>
