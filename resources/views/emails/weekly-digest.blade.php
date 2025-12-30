<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Weekly Digest</title>
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
            background: linear-gradient(135deg, #0891b2 0%, #0e7490 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }
        .email-body {
            padding: 40px 30px;
        }
        .summary-section {
            background: #f9fafb;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
        }
        .stat-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
            margin: 20px 0;
        }
        .stat-card {
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 15px;
            text-align: center;
        }
        .stat-value {
            font-size: 28px;
            font-weight: bold;
            color: #0891b2;
            margin: 5px 0;
        }
        .stat-label {
            font-size: 12px;
            color: #6b7280;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .activity-item {
            padding: 15px;
            border-bottom: 1px solid #e5e7eb;
            display: flex;
            align-items: start;
            gap: 15px;
        }
        .activity-item:last-child {
            border-bottom: none;
        }
        .activity-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            flex-shrink: 0;
        }
        .activity-content {
            flex: 1;
        }
        .activity-title {
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 5px;
        }
        .activity-description {
            font-size: 14px;
            color: #6b7280;
        }
        .cta-button {
            display: inline-block;
            padding: 12px 30px;
            background: #0891b2;
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
    </style>
</head>
<body>
    <div class="email-container">
        <div class="email-header">
            <div style="font-size: 36px; margin-bottom: 10px;">📊</div>
            <h1 style="margin: 0; font-size: 28px;">Weekly Account Summary</h1>
            <p style="margin: 10px 0 0 0; opacity: 0.9;">{{ now()->subWeek()->format('M d') }} - {{ now()->format('M d, Y') }}</p>
        </div>

        <div class="email-body">
            <p style="font-size: 16px; line-height: 1.6; margin-bottom: 20px;">
                Hello {{ $user->name }},
            </p>

            <p style="font-size: 16px; line-height: 1.6; margin-bottom: 20px;">
                Here's a summary of your account activity over the past week.
            </p>

            <!-- Summary Stats -->
            <div class="stat-grid">
                <div class="stat-card">
                    <div class="stat-label">New Messages</div>
                    <div class="stat-value">{{ $digestData['new_messages_count'] }}</div>
                </div>
                <div class="stat-card">
                    <div class="stat-label">New Invoices</div>
                    <div class="stat-value">{{ $digestData['new_invoices_count'] }}</div>
                </div>
                <div class="stat-card">
                    <div class="stat-label">Pending Payment</div>
                    <div class="stat-value">${{ number_format($digestData['pending_amount'], 2) }}</div>
                </div>
                <div class="stat-card">
                    <div class="stat-label">Overdue Invoices</div>
                    <div class="stat-value" style="color: {{ $digestData['overdue_count'] > 0 ? '#ef4444' : '#10b981' }};">
                        {{ $digestData['overdue_count'] }}
                    </div>
                </div>
            </div>

            <!-- Recent Activity -->
            @if(count($digestData['new_messages']) > 0 || count($digestData['new_invoices']) > 0)
                <div class="summary-section">
                    <h2 style="margin: 0 0 20px 0; font-size: 18px; color: #1f2937;">Recent Activity</h2>

                    @foreach($digestData['new_messages'] as $message)
                        <div class="activity-item">
                            <div class="activity-icon" style="background: #eff6ff; color: #0891b2;">
                                ✉️
                            </div>
                            <div class="activity-content">
                                <div class="activity-title">New Message</div>
                                <div class="activity-description">
                                    From: {{ $message->sender->name }}<br>
                                    {{ Str::limit($message->message, 80) }}
                                </div>
                                <div style="font-size: 12px; color: #9ca3af; margin-top: 5px;">
                                    {{ $message->created_at->diffForHumans() }}
                                </div>
                            </div>
                        </div>
                    @endforeach

                    @foreach($digestData['new_invoices'] as $invoice)
                        <div class="activity-item">
                            <div class="activity-icon" style="background: #f0fdf4; color: #10b981;">
                                📄
                            </div>
                            <div class="activity-content">
                                <div class="activity-title">New Invoice {{ $invoice->invoice_number }}</div>
                                <div class="activity-description">
                                    Amount: ${{ number_format($invoice->total, 2) }}<br>
                                    Due: {{ $invoice->due_date->format('M d, Y') }}
                                </div>
                                <div style="font-size: 12px; color: #9ca3af; margin-top: 5px;">
                                    Status: <span style="color: {{ $invoice->status === 'paid' ? '#10b981' : ($invoice->status === 'overdue' ? '#ef4444' : '#6b7280') }};">{{ ucfirst($invoice->status) }}</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

            <!-- Action Items -->
            @if($digestData['overdue_count'] > 0 || count($digestData['unread_messages']) > 0)
                <div class="summary-section" style="background: #fef2f2; border-color: #fecaca;">
                    <h2 style="margin: 0 0 15px 0; font-size: 18px; color: #991b1b;">Action Required</h2>

                    @if($digestData['overdue_count'] > 0)
                        <p style="margin: 0 0 10px 0; color: #b91c1c;">
                            ⚠️ You have {{ $digestData['overdue_count'] }} overdue invoice{{ $digestData['overdue_count'] > 1 ? 's' : '' }} totaling ${{ number_format($digestData['overdue_amount'], 2) }}
                        </p>
                    @endif

                    @if(count($digestData['unread_messages']) > 0)
                        <p style="margin: 0; color: #b91c1c;">
                            📩 You have {{ count($digestData['unread_messages']) }} unread message{{ count($digestData['unread_messages']) > 1 ? 's' : '' }}
                        </p>
                    @endif
                </div>
            @endif

            <div style="text-align: center; margin-top: 30px;">
                <a href="{{ url('/login') }}" class="cta-button">View Your Dashboard</a>
            </div>

            <p style="font-size: 14px; color: #6b7280; line-height: 1.6; margin-top: 30px;">
                This is your weekly summary email. If you have any questions or concerns,
                feel free to contact us at billing@realwebdevelopment.com.
            </p>
        </div>

        <div class="footer">
            <strong style="color: #0891b2;">RealWebDevelopment</strong><br>
            Professional Web Development Services<br>
            billing@realwebdevelopment.com<br><br>
            <small style="color: #9ca3af;">
                You're receiving this because you have an account with us.<br>
                To manage your email preferences, please log in to your account.
            </small>
        </div>
    </div>
</body>
</html>
