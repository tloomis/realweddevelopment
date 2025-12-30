<x-app-layout>
    <!-- Dashboard Header -->
    <div class="dashboard-header" style="display: flex; justify-content: space-between; align-items: center;">
        <div>
            <h1 class="dashboard-title">Detailed Reports</h1>
            <p class="dashboard-subtitle">Generate and analyze custom reports for your business.</p>
        </div>
        <a href="{{ route('admin.analytics') }}" class="btn-dashboard" style="background: white; color: #0891b2; border: 2px solid white; font-size: 0.9375rem; padding: 0.75rem 1.5rem; text-decoration: none;">
            ← Back to Analytics
        </a>
    </div>

    <!-- Report Type Selector -->
    <div class="content-card" style="margin-bottom: 2rem;">
        <div class="content-card-header">
            <h3 class="content-card-title">Select Report Type</h3>
        </div>
        <div class="content-card-body">
            <form method="GET" action="{{ route('admin.analytics.reports') }}" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; align-items: end;">
                <div>
                    <label style="display: block; font-size: 0.875rem; font-weight: 600; color: #374151; margin-bottom: 0.5rem;">Report Type</label>
                    <select name="type" style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 0.375rem; font-size: 0.9375rem;">
                        <option value="revenue" {{ $reportType === 'revenue' ? 'selected' : '' }}>Revenue Report</option>
                        <option value="overdue" {{ $reportType === 'overdue' ? 'selected' : '' }}>Overdue Invoices</option>
                        <option value="payment-history" {{ $reportType === 'payment-history' ? 'selected' : '' }}>Payment History</option>
                    </select>
                </div>

                <div id="startDateField">
                    <label style="display: block; font-size: 0.875rem; font-weight: 600; color: #374151; margin-bottom: 0.5rem;">Start Date</label>
                    <input type="date" name="start_date" value="{{ $startDate }}" style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 0.375rem; font-size: 0.9375rem;">
                </div>

                <div id="endDateField">
                    <label style="display: block; font-size: 0.875rem; font-weight: 600; color: #374151; margin-bottom: 0.5rem;">End Date</label>
                    <input type="date" name="end_date" value="{{ $endDate }}" style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 0.375rem; font-size: 0.9375rem;">
                </div>

                <div>
                    <button type="submit" class="btn-dashboard" style="width: 100%; padding: 0.5rem 1rem; font-size: 0.9375rem; border: none; cursor: pointer;">
                        Generate Report
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Report Results -->
    <div class="content-card">
        @if($reportType === 'revenue')
            <div class="content-card-header">
                <h3 class="content-card-title">Revenue Report ({{ $startDate }} to {{ $endDate }})</h3>
            </div>
            <div class="content-card-body">
                @if($data->isEmpty())
                    <p style="color: #6b7280; padding: 2rem; text-align: center;">No paid invoices found in this date range.</p>
                @else
                    <div style="margin-bottom: 1rem; padding: 1rem; background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 0.5rem;">
                        <strong>Total Revenue: </strong>${{ number_format($data->sum('total'), 2) }}
                        <span style="margin-left: 1rem; color: #6b7280;">
                            ({{ $data->count() }} invoices)
                        </span>
                    </div>

                    <div style="overflow-x: auto;">
                        <table style="width: 100%; border-collapse: collapse;">
                            <thead style="background: #f9fafb; border-bottom: 2px solid #e5e7eb;">
                                <tr>
                                    <th style="padding: 0.75rem; text-align: left; font-weight: 600; color: #374151;">Invoice #</th>
                                    <th style="padding: 0.75rem; text-align: left; font-weight: 600; color: #374151;">Client</th>
                                    <th style="padding: 0.75rem; text-align: left; font-weight: 600; color: #374151;">Paid Date</th>
                                    <th style="padding: 0.75rem; text-align: left; font-weight: 600; color: #374151;">Payment Method</th>
                                    <th style="padding: 0.75rem; text-align: right; font-weight: 600; color: #374151;">Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data as $invoice)
                                    <tr style="border-bottom: 1px solid #e5e7eb;">
                                        <td style="padding: 0.75rem;">{{ $invoice->invoice_number }}</td>
                                        <td style="padding: 0.75rem;">{{ $invoice->user->name }}</td>
                                        <td style="padding: 0.75rem;">{{ $invoice->paid_date?->format('M d, Y') ?? 'N/A' }}</td>
                                        <td style="padding: 0.75rem;">{{ $invoice->payment_method ?? 'N/A' }}</td>
                                        <td style="padding: 0.75rem; text-align: right; font-weight: 600;">${{ number_format($invoice->total, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>

        @elseif($reportType === 'overdue')
            <div class="content-card-header">
                <h3 class="content-card-title">Overdue Invoices Report</h3>
            </div>
            <div class="content-card-body">
                @if($data->isEmpty())
                    <p style="color: #6b7280; padding: 2rem; text-align: center;">No overdue invoices found.</p>
                @else
                    <div style="margin-bottom: 1rem; padding: 1rem; background: #fef2f2; border: 1px solid #fecaca; border-radius: 0.5rem;">
                        <strong>Total Overdue: </strong>${{ number_format($data->sum('total'), 2) }}
                        <span style="margin-left: 1rem; color: #6b7280;">
                            ({{ $data->count() }} invoices)
                        </span>
                    </div>

                    <div style="overflow-x: auto;">
                        <table style="width: 100%; border-collapse: collapse;">
                            <thead style="background: #f9fafb; border-bottom: 2px solid #e5e7eb;">
                                <tr>
                                    <th style="padding: 0.75rem; text-align: left; font-weight: 600; color: #374151;">Invoice #</th>
                                    <th style="padding: 0.75rem; text-align: left; font-weight: 600; color: #374151;">Client</th>
                                    <th style="padding: 0.75rem; text-align: left; font-weight: 600; color: #374151;">Due Date</th>
                                    <th style="padding: 0.75rem; text-align: left; font-weight: 600; color: #374151;">Days Overdue</th>
                                    <th style="padding: 0.75rem; text-align: right; font-weight: 600; color: #374151;">Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data as $invoice)
                                    <tr style="border-bottom: 1px solid #e5e7eb;">
                                        <td style="padding: 0.75rem;">{{ $invoice->invoice_number }}</td>
                                        <td style="padding: 0.75rem;">{{ $invoice->user->name }}</td>
                                        <td style="padding: 0.75rem;">{{ $invoice->due_date->format('M d, Y') }}</td>
                                        <td style="padding: 0.75rem; color: #ef4444; font-weight: 600;">
                                            {{ abs($invoice->due_date->diffInDays(now())) }} days
                                        </td>
                                        <td style="padding: 0.75rem; text-align: right; font-weight: 600;">${{ number_format($invoice->total, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>

        @elseif($reportType === 'payment-history')
            <div class="content-card-header">
                <h3 class="content-card-title">Payment History Report ({{ $startDate }} to {{ $endDate }})</h3>
            </div>
            <div class="content-card-body">
                @if($data->isEmpty())
                    <p style="color: #6b7280; padding: 2rem; text-align: center;">No payment data found in this date range.</p>
                @else
                    <div style="margin-bottom: 1rem; padding: 1rem; background: #eff6ff; border: 1px solid #bfdbfe; border-radius: 0.5rem;">
                        <strong>Total Collected: </strong>${{ number_format($data->sum('total'), 2) }}
                    </div>

                    <div style="overflow-x: auto;">
                        <table style="width: 100%; border-collapse: collapse;">
                            <thead style="background: #f9fafb; border-bottom: 2px solid #e5e7eb;">
                                <tr>
                                    <th style="padding: 0.75rem; text-align: left; font-weight: 600; color: #374151;">Payment Method</th>
                                    <th style="padding: 0.75rem; text-align: center; font-weight: 600; color: #374151;">Count</th>
                                    <th style="padding: 0.75rem; text-align: right; font-weight: 600; color: #374151;">Total Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data as $payment)
                                    <tr style="border-bottom: 1px solid #e5e7eb;">
                                        <td style="padding: 0.75rem;">{{ $payment->payment_method ?? 'Not Specified' }}</td>
                                        <td style="padding: 0.75rem; text-align: center;">{{ $payment->count }}</td>
                                        <td style="padding: 0.75rem; text-align: right; font-weight: 600;">${{ number_format($payment->total, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        @endif
    </div>

    <script>
        // Hide date fields for overdue report
        const typeSelect = document.querySelector('select[name="type"]');
        const startDateField = document.getElementById('startDateField');
        const endDateField = document.getElementById('endDateField');

        function toggleDateFields() {
            if (typeSelect.value === 'overdue') {
                startDateField.style.display = 'none';
                endDateField.style.display = 'none';
            } else {
                startDateField.style.display = 'block';
                endDateField.style.display = 'block';
            }
        }

        typeSelect.addEventListener('change', toggleDateFields);
        toggleDateFields(); // Run on page load
    </script>
</x-app-layout>
