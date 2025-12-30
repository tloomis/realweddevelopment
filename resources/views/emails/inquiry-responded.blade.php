<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Response to Your Inquiry</title>
</head>
<body style="margin: 0; padding: 0; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif; background-color: #f3f4f6; color: #1f2937;">
    <table role="presentation" style="width: 100%; border-collapse: collapse; background-color: #f3f4f6;">
        <tr>
            <td align="center" style="padding: 40px 20px;">
                <table role="presentation" style="max-width: 600px; width: 100%; border-collapse: collapse; background-color: #ffffff; border-radius: 12px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
                    <!-- Header -->
                    <tr>
                        <td style="background: linear-gradient(135deg, #0891b2 0%, #06b6d4 100%); padding: 40px 30px; border-radius: 12px 12px 0 0; text-align: center;">
                            <h1 style="margin: 0; color: #ffffff; font-size: 28px; font-weight: 700; letter-spacing: -0.5px;">
                                Response to Your Inquiry
                            </h1>
                            <p style="margin: 10px 0 0 0; color: rgba(255, 255, 255, 0.9); font-size: 16px;">
                                We've responded to your question
                            </p>
                        </td>
                    </tr>

                    <!-- Body -->
                    <tr>
                        <td style="padding: 40px 30px;">
                            <p style="margin: 0 0 20px 0; font-size: 16px; line-height: 1.6; color: #4b5563;">
                                Hello {{ $inquiry->user->name }},
                            </p>

                            <p style="margin: 0 0 30px 0; font-size: 16px; line-height: 1.6; color: #4b5563;">
                                We've responded to your inquiry regarding <strong>Invoice {{ $inquiry->invoice->invoice_number }}</strong>.
                            </p>

                            <!-- Inquiry Details -->
                            <div style="background-color: #f9fafb; border-left: 4px solid #0891b2; padding: 20px; margin: 0 0 30px 0; border-radius: 6px;">
                                <h3 style="margin: 0 0 15px 0; font-size: 18px; font-weight: 600; color: #0891b2;">
                                    Your Original Question
                                </h3>
                                <p style="margin: 0 0 10px 0; font-size: 14px; font-weight: 600; color: #6b7280;">
                                    Subject: {{ $inquiry->subject }}
                                </p>
                                <p style="margin: 0; font-size: 14px; line-height: 1.6; color: #4b5563;">
                                    {{ $inquiry->message }}
                                </p>
                            </div>

                            <!-- Admin Response -->
                            <div style="background-color: #ecfdf5; border-left: 4px solid #10b981; padding: 20px; margin: 0 0 30px 0; border-radius: 6px;">
                                <h3 style="margin: 0 0 15px 0; font-size: 18px; font-weight: 600; color: #10b981;">
                                    Our Response
                                </h3>
                                <p style="margin: 0 0 15px 0; font-size: 14px; line-height: 1.6; color: #4b5563; white-space: pre-line;">{{ $inquiry->admin_response }}</p>
                                <div style="display: flex; justify-content: space-between; align-items: center; padding-top: 15px; border-top: 1px solid #d1fae5;">
                                    <p style="margin: 0; font-size: 13px; color: #6b7280;">
                                        Responded by: <strong>{{ $inquiry->responder->name }}</strong>
                                    </p>
                                    <span style="display: inline-block; padding: 6px 12px; background-color: {{ $inquiry->statusBadge['color'] }}; color: #ffffff; border-radius: 6px; font-size: 12px; font-weight: 600;">
                                        {{ $inquiry->statusBadge['text'] }}
                                    </span>
                                </div>
                            </div>

                            <!-- Invoice Details -->
                            <div style="background-color: #eff6ff; padding: 20px; border-radius: 8px; margin: 0 0 30px 0;">
                                <h4 style="margin: 0 0 15px 0; font-size: 16px; font-weight: 600; color: #1e40af;">
                                    Invoice Information
                                </h4>
                                <table style="width: 100%; border-collapse: collapse;">
                                    <tr>
                                        <td style="padding: 8px 0; font-size: 14px; color: #6b7280;">Invoice Number:</td>
                                        <td style="padding: 8px 0; font-size: 14px; font-weight: 600; color: #1f2937; text-align: right;">{{ $inquiry->invoice->invoice_number }}</td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 8px 0; font-size: 14px; color: #6b7280;">Amount:</td>
                                        <td style="padding: 8px 0; font-size: 14px; font-weight: 600; color: #1f2937; text-align: right;">${{ number_format($inquiry->invoice->total, 2) }}</td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 8px 0; font-size: 14px; color: #6b7280;">Status:</td>
                                        <td style="padding: 8px 0; font-size: 14px; font-weight: 600; color: #1f2937; text-align: right;">
                                            <span style="display: inline-block; padding: 4px 10px; background-color: {{ $inquiry->invoice->statusBadge['color'] }}; color: #ffffff; border-radius: 4px; font-size: 12px;">
                                                {{ $inquiry->invoice->statusBadge['text'] }}
                                            </span>
                                        </td>
                                    </tr>
                                </table>
                            </div>

                            <!-- CTA Button -->
                            <div style="text-align: center; margin: 0 0 30px 0;">
                                <a href="{{ url('/client/invoices/' . $inquiry->invoice->id) }}" style="display: inline-block; padding: 14px 32px; background: linear-gradient(135deg, #0891b2 0%, #06b6d4 100%); color: #ffffff; text-decoration: none; border-radius: 8px; font-weight: 600; font-size: 16px; box-shadow: 0 4px 6px rgba(8, 145, 178, 0.3);">
                                    View Invoice & Inquiry
                                </a>
                            </div>

                            <p style="margin: 0 0 15px 0; font-size: 14px; line-height: 1.6; color: #6b7280;">
                                If you have any additional questions or concerns, please feel free to submit another inquiry on the invoice page.
                            </p>

                            <p style="margin: 0; font-size: 14px; line-height: 1.6; color: #6b7280;">
                                Thank you,<br>
                                <strong style="color: #1f2937;">The RealWebDevelopment Team</strong>
                            </p>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="background-color: #f9fafb; padding: 30px; border-radius: 0 0 12px 12px; text-align: center; border-top: 1px solid #e5e7eb;">
                            <p style="margin: 0 0 10px 0; font-size: 13px; color: #6b7280;">
                                This email was sent regarding Invoice {{ $inquiry->invoice->invoice_number }}
                            </p>
                            <p style="margin: 0; font-size: 12px; color: #9ca3af;">
                                &copy; {{ date('Y') }} RealWebDevelopment. All rights reserved.
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
