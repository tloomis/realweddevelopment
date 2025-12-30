<x-app-layout>
    <!-- Success Message -->
    @if(session('success'))
        <div style="background: #ecfdf5; border: 2px solid #a7f3d0; color: #065f46; padding: 1rem 1.5rem; border-radius: 0.75rem; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 1rem;">
            <svg style="width: 1.5rem; height: 1.5rem; color: #10b981;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span style="font-weight: 600;">{{ session('success') }}</span>
        </div>
    @endif

    <!-- Back Button -->
    <div style="margin-bottom: 1rem;">
        <a href="{{ route('client.dashboard') }}" style="color: #0891b2; text-decoration: none; font-weight: 600; font-size: 0.9375rem; display: inline-flex; align-items: center; gap: 0.5rem;" onmouseover="this.style.color='#0e7490'" onmouseout="this.style.color='#0891b2'">
            <svg style="width: 1.25rem; height: 1.25rem;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            Back to Dashboard
        </a>
    </div>

    <!-- Invoice Header -->
    <div style="background: linear-gradient(135deg, #0891b2 0%, #0e7490 100%); color: white; padding: 2rem; border-radius: 1rem; margin-bottom: 1.5rem;">
        <div style="display: flex; justify-content: space-between; align-items: start; flex-wrap: wrap; gap: 1rem;">
            <div>
                <h1 style="font-size: 2rem; font-weight: 700; margin-bottom: 0.5rem;">Invoice Details</h1>
                <p style="font-size: 1.5rem; opacity: 0.9;">{{ $invoice->invoice_number }}</p>
            </div>
            <div style="text-align: right; display: flex; gap: 0.75rem; align-items: center; flex-wrap: wrap;">
                @if($invoice->status !== 'paid')
                    <a href="{{ route('client.payment.show', $invoice) }}" style="background: #10b981; color: white; border: none; padding: 0.625rem 1.25rem; border-radius: 0.75rem; font-size: 0.9375rem; font-weight: 700; cursor: pointer; text-decoration: none; display: inline-flex; align-items: center; gap: 0.5rem; transition: all 0.2s ease; box-shadow: 0 2px 4px rgba(16, 185, 129, 0.3);" onmouseover="this.style.background='#059669'; this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 8px rgba(16, 185, 129, 0.4)';" onmouseout="this.style.background='#10b981'; this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 4px rgba(16, 185, 129, 0.3)';">
                        <svg style="width: 1.25rem; height: 1.25rem;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                        </svg>
                        Pay Now
                    </a>
                @endif
                <a href="{{ route('client.invoices.pdf', $invoice) }}" style="background: white; color: #0891b2; border: none; padding: 0.625rem 1.25rem; border-radius: 0.75rem; font-size: 0.9375rem; font-weight: 700; cursor: pointer; text-decoration: none; display: inline-flex; align-items: center; gap: 0.5rem; transition: all 0.2s ease;" onmouseover="this.style.background='#f0f9ff';" onmouseout="this.style.background='white';">
                    <svg style="width: 1.25rem; height: 1.25rem;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    Download PDF
                </a>
                <span style="display: inline-flex; align-items: center; padding: 0.625rem 1.25rem; border-radius: 0.75rem; font-size: 1rem; font-weight: 700; background-color: {{ $invoice->status_badge['color'] }}22; color: {{ $invoice->status_badge['color'] }}; border: 2px solid {{ $invoice->status_badge['color'] }};">
                    {{ $invoice->status_badge['text'] }}
                </span>
            </div>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.5rem; margin-top: 1.5rem;">
            <div>
                <div style="font-size: 0.875rem; opacity: 0.9; margin-bottom: 0.25rem;">Issue Date</div>
                <div style="font-size: 1.125rem; font-weight: 600;">{{ $invoice->issue_date->format('M d, Y') }}</div>
            </div>
            <div>
                <div style="font-size: 0.875rem; opacity: 0.9; margin-bottom: 0.25rem;">Due Date</div>
                <div style="font-size: 1.125rem; font-weight: 600;">{{ $invoice->due_date->format('M d, Y') }}</div>
            </div>
            @if($invoice->paid_date)
                <div>
                    <div style="font-size: 0.875rem; opacity: 0.9; margin-bottom: 0.25rem;">Paid Date</div>
                    <div style="font-size: 1.125rem; font-weight: 600;">{{ $invoice->paid_date->format('M d, Y') }}</div>
                </div>
            @endif
            <div>
                <div style="font-size: 0.875rem; opacity: 0.9; margin-bottom: 0.25rem;">Total Amount</div>
                <div style="font-size: 1.5rem; font-weight: 700;">${{ number_format($invoice->total, 2) }}</div>
            </div>
        </div>
    </div>

    <!-- Invoice Details -->
    <div class="content-card" style="margin-bottom: 2rem;">
        <div class="content-card-header">
            <h2 class="content-card-title">Line Items</h2>
        </div>
        <div class="content-card-body">
            @if($invoice->items->count() > 0)
                <div class="table-responsive">
                    <table class="dashboard-table">
                        <thead>
                            <tr>
                                <th>Description</th>
                                <th style="text-align: center;">Quantity</th>
                                <th style="text-align: right;">Unit Price</th>
                                <th style="text-align: right;">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($invoice->items as $item)
                                <tr>
                                    <td>{{ $item->description }}</td>
                                    <td style="text-align: center;">{{ $item->quantity }}</td>
                                    <td style="text-align: right;">${{ number_format($item->unit_price, 2) }}</td>
                                    <td style="text-align: right; font-weight: 600;">${{ number_format($item->total, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Totals Section -->
                <div style="margin-top: 2rem; padding: 1.5rem; background: #f8fafc; border-radius: 0.75rem; max-width: 400px; margin-left: auto;">
                    <div style="display: flex; justify-content: space-between; padding: 0.5rem 0; font-size: 1rem;">
                        <span style="color: #64748b;">Subtotal:</span>
                        <span style="font-weight: 600; color: #1e293b;">${{ number_format($invoice->subtotal, 2) }}</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; padding: 0.5rem 0; font-size: 1rem;">
                        <span style="color: #64748b;">Tax ({{ $invoice->tax_rate }}%):</span>
                        <span style="font-weight: 600; color: #1e293b;">${{ number_format($invoice->tax_amount, 2) }}</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; padding: 1rem 0 0 0; margin-top: 0.5rem; border-top: 2px solid #e2e8f0; font-size: 1.25rem;">
                        <span style="font-weight: 700; color: #0891b2;">Total:</span>
                        <span style="font-weight: 700; color: #0891b2;">${{ number_format($invoice->total, 2) }}</span>
                    </div>
                </div>
            @endif
        </div>
    </div>

    @if($invoice->notes)
        <!-- Invoice Notes -->
        <div class="content-card" style="margin-bottom: 2rem;">
            <div class="content-card-header">
                <h2 class="content-card-title">Notes</h2>
            </div>
            <div class="content-card-body">
                <div style="padding: 1rem; background: #fffbeb; border-left: 4px solid #f59e0b; border-radius: 0.5rem;">
                    <p style="color: #78350f; line-height: 1.6; margin: 0;">{{ $invoice->notes }}</p>
                </div>
            </div>
        </div>
    @endif

    @if($invoice->status === 'sent' || $invoice->status === 'overdue')
        <!-- Payment Information -->
        <div class="content-card">
            <div class="content-card-header">
                <h2 class="content-card-title">Payment Information</h2>
            </div>
            <div class="content-card-body">
                <div style="padding: 1.5rem; background: {{ $invoice->status === 'overdue' ? '#fef2f2' : '#eff6ff' }}; border: 2px solid {{ $invoice->status === 'overdue' ? '#fecaca' : '#93c5fd' }}; border-radius: 0.75rem;">
                    @if($invoice->status === 'overdue')
                        <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1rem;">
                            <svg style="width: 3rem; height: 3rem; color: #dc2626;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                            <div>
                                <div style="font-size: 1.25rem; font-weight: 700; color: #991b1b;">Payment Overdue</div>
                                <div style="font-size: 0.9375rem; color: #b91c1c; margin-top: 0.25rem;">This invoice was due on {{ $invoice->due_date->format('F d, Y') }}</div>
                            </div>
                        </div>
                    @else
                        <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1rem;">
                            <svg style="width: 3rem; height: 3rem; color: #2563eb;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <div>
                                <div style="font-size: 1.25rem; font-weight: 700; color: #1e40af;">Payment Pending</div>
                                <div style="font-size: 0.9375rem; color: #1e3a8a; margin-top: 0.25rem;">Due by {{ $invoice->due_date->format('F d, Y') }}</div>
                            </div>
                        </div>
                    @endif

                    <div style="padding: 1rem; background: white; border-radius: 0.5rem; margin-top: 1rem;">
                        <p style="color: #475569; margin: 0; line-height: 1.6;">
                            To make a payment, please contact us at <a href="mailto:billing@realwebdevelopment.com" style="color: #0891b2; text-decoration: none; font-weight: 600;">billing@realwebdevelopment.com</a> or reference invoice number <strong>{{ $invoice->invoice_number }}</strong> when submitting payment.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    @elseif($invoice->status === 'paid')
        <!-- Payment Confirmation -->
        <div class="content-card">
            <div class="content-card-header">
                <h2 class="content-card-title">Payment Confirmation</h2>
            </div>
            <div class="content-card-body">
                <div style="padding: 1.5rem; background: #ecfdf5; border: 2px solid #a7f3d0; border-radius: 0.75rem;">
                    <div style="display: flex; align-items: center; gap: 1rem;">
                        <svg style="width: 3rem; height: 3rem; color: #10b981;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <div>
                            <div style="font-size: 1.25rem; font-weight: 700; color: #065f46;">Payment Received</div>
                            <div style="font-size: 0.9375rem; color: #047857; margin-top: 0.25rem;">
                                Thank you! This invoice was paid on {{ $invoice->paid_date->format('F d, Y') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Invoice Inquiries -->
    <div class="content-card" style="margin-top: 2rem;">
        <div class="content-card-header">
            <h2 class="content-card-title">Questions or Disputes</h2>
        </div>
        <div class="content-card-body">
            <!-- Existing Inquiries -->
            @if($invoice->inquiries()->count() > 0)
                <div style="margin-bottom: 2rem;">
                    <h3 style="font-size: 1.125rem; font-weight: 600; color: #1f2937; margin-bottom: 1rem;">Previous Inquiries</h3>
                    @foreach($invoice->inquiries()->with(['user', 'responder'])->latest()->get() as $inquiry)
                        <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 0.75rem; padding: 1.5rem; margin-bottom: 1rem;">
                            <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 1rem;">
                                <div>
                                    <h4 style="font-size: 1rem; font-weight: 600; color: #1f2937; margin-bottom: 0.25rem;">{{ $inquiry->subject }}</h4>
                                    <div style="font-size: 0.875rem; color: #6b7280;">
                                        Submitted {{ $inquiry->created_at->format('M d, Y \a\t g:i A') }}
                                    </div>
                                </div>
                                <span style="display: inline-flex; align-items: center; padding: 0.375rem 0.75rem; border-radius: 0.5rem; font-size: 0.875rem; font-weight: 600; background-color: {{ $inquiry->status_badge['color'] }}22; color: {{ $inquiry->status_badge['color'] }}; border: 1px solid {{ $inquiry->status_badge['color'] }};">
                                    {{ $inquiry->status_badge['text'] }}
                                </span>
                            </div>
                            <div style="padding: 1rem; background: white; border-radius: 0.5rem; margin-bottom: 1rem;">
                                <div style="font-size: 0.875rem; color: #64748b; margin-bottom: 0.5rem; font-weight: 600;">Your Message:</div>
                                <p style="color: #334155; line-height: 1.6; margin: 0;">{{ $inquiry->message }}</p>
                            </div>
                            @if($inquiry->admin_response)
                                <div style="padding: 1rem; background: #eff6ff; border-left: 4px solid #0891b2; border-radius: 0.5rem;">
                                    <div style="font-size: 0.875rem; color: #0891b2; margin-bottom: 0.5rem; font-weight: 600;">
                                        Response from {{ $inquiry->responder->name ?? 'Admin' }}:
                                    </div>
                                    <p style="color: #1e3a8a; line-height: 1.6; margin: 0;">{{ $inquiry->admin_response }}</p>
                                    <div style="font-size: 0.875rem; color: #64748b; margin-top: 0.5rem;">
                                        {{ $inquiry->responded_at->format('M d, Y \a\t g:i A') }}
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            @endif

            <!-- New Inquiry Form -->
            <div>
                <h3 style="font-size: 1.125rem; font-weight: 600; color: #1f2937; margin-bottom: 1rem;">Submit a New Inquiry</h3>
                <form method="POST" action="{{ route('client.invoices.inquiries.store', $invoice) }}" style="display: grid; gap: 1rem;">
                    @csrf
                    <div>
                        <label style="display: block; font-size: 0.875rem; font-weight: 600; color: #374151; margin-bottom: 0.5rem;">Subject</label>
                        <input type="text" name="subject" required style="width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 0.5rem; font-size: 0.9375rem;" placeholder="Brief description of your question or concern">
                        @error('subject')
                            <span style="color: #ef4444; font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <label style="display: block; font-size: 0.875rem; font-weight: 600; color: #374151; margin-bottom: 0.5rem;">Message</label>
                        <textarea name="message" required rows="5" style="width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 0.5rem; font-size: 0.9375rem; font-family: inherit;" placeholder="Please provide details about your question or dispute..."></textarea>
                        @error('message')
                            <span style="color: #ef4444; font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <button type="submit" class="btn-dashboard" style="padding: 0.75rem 1.5rem; font-size: 0.9375rem; border: none; cursor: pointer;">
                            Submit Inquiry
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
