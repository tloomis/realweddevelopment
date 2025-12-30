<x-app-layout>
    <!-- Dashboard Header -->
    <div class="dashboard-header">
        <h1 class="dashboard-title">Welcome back, {{ $user->name }}!</h1>
        <p class="dashboard-subtitle">Manage your account, view messages, and track invoices.</p>
    </div>

    <!-- Next Payment Alert -->
    @if($nextDueInvoice)
        <div style="background: {{ $nextDueInvoice->status === 'overdue' ? '#fef2f2' : '#eff6ff' }}; border: 2px solid {{ $nextDueInvoice->status === 'overdue' ? '#fecaca' : '#93c5fd' }}; border-radius: 0.75rem; padding: 1.25rem; margin-bottom: 1.5rem;">
            <div style="display: flex; align-items: center; gap: 1rem;">
                <svg style="width: 2.5rem; height: 2.5rem; color: {{ $nextDueInvoice->status === 'overdue' ? '#dc2626' : '#2563eb' }};" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <div style="flex: 1;">
                    <div style="font-weight: 700; font-size: 1.125rem; color: {{ $nextDueInvoice->status === 'overdue' ? '#991b1b' : '#1e40af' }}; margin-bottom: 0.25rem;">
                        {{ $nextDueInvoice->status === 'overdue' ? 'Payment Overdue' : 'Payment Due Soon' }}
                    </div>
                    <div style="color: {{ $nextDueInvoice->status === 'overdue' ? '#b91c1c' : '#1e3a8a' }};">
                        Invoice {{ $nextDueInvoice->invoice_number }} • ${{ number_format($nextDueInvoice->total, 2) }} • Due {{ $nextDueInvoice->due_date->format('M d, Y') }}
                        @if($nextDueInvoice->status === 'overdue')
                            ({{ $nextDueInvoice->due_date->diffForHumans() }})
                        @endif
                    </div>
                </div>
                <a href="{{ route('client.invoices.show', $nextDueInvoice) }}" style="background: {{ $nextDueInvoice->status === 'overdue' ? '#dc2626' : '#2563eb' }}; color: white; padding: 0.625rem 1.25rem; border-radius: 0.5rem; font-weight: 600; text-decoration: none; white-space: nowrap;">
                    View Invoice
                </a>
            </div>
        </div>
    @endif

    <!-- Financial Summary -->
    <div class="stats-grid" style="margin-bottom: 2rem; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem;">
        <div class="stat-card" style="background: linear-gradient(135deg, #0891b2 0%, #0e7490 100%); color: white; border: none;">
            <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 0.75rem;">
                <div class="stat-label" style="color: rgba(255,255,255,0.9);">Total Billed</div>
                <svg style="width: 2rem; height: 2rem; opacity: 0.5;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                </svg>
            </div>
            <div class="stat-value" style="color: white;">${{ number_format($totalBilled, 2) }}</div>
            <div style="font-size: 0.875rem; opacity: 0.8; margin-top: 0.5rem;">{{ $totalInvoices }} invoice{{ $totalInvoices !== 1 ? 's' : '' }}</div>
        </div>

        <div class="stat-card" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: white; border: none;">
            <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 0.75rem;">
                <div class="stat-label" style="color: rgba(255,255,255,0.9);">Total Paid</div>
                <svg style="width: 2rem; height: 2rem; opacity: 0.5;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div class="stat-value" style="color: white;">${{ number_format($totalPaid, 2) }}</div>
            <div style="font-size: 0.875rem; opacity: 0.8; margin-top: 0.5rem;">{{ $paidInvoices }} paid invoice{{ $paidInvoices !== 1 ? 's' : '' }}</div>
        </div>

        <div class="stat-card" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); color: white; border: none;">
            <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 0.75rem;">
                <div class="stat-label" style="color: rgba(255,255,255,0.9);">Outstanding</div>
                <svg style="width: 2rem; height: 2rem; opacity: 0.5;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div class="stat-value" style="color: white;">${{ number_format($totalOutstanding, 2) }}</div>
            <div style="font-size: 0.875rem; opacity: 0.8; margin-top: 0.5rem;">
                @if($overdueInvoices > 0)
                    {{ $overdueInvoices }} overdue
                @else
                    All up to date
                @endif
            </div>
        </div>

        <div class="stat-card">
            <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 0.75rem;">
                <div class="stat-label">Unread Messages</div>
                <svg style="width: 2rem; height: 2rem; color: #cbd5e1;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
            </div>
            <div class="stat-value" style="color: {{ $unreadMessages > 0 ? '#0891b2' : '#64748b' }};">{{ $unreadMessages }}</div>
        </div>
    </div>

    <!-- Payment Statistics -->
    @if($totalInvoices > 0)
        <div class="content-card" style="margin-bottom: 2rem;">
            <div class="content-card-header">
                <h2 class="content-card-title">Payment Statistics</h2>
            </div>
            <div class="content-card-body">
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 2rem;">
                    <div>
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.75rem;">
                            <span style="font-weight: 600; color: #64748b;">Payment Rate</span>
                            <span style="font-weight: 700; color: #0891b2; font-size: 1.25rem;">{{ number_format($paymentRate, 1) }}%</span>
                        </div>
                        <div style="width: 100%; height: 1.5rem; background: #e2e8f0; border-radius: 9999px; overflow: hidden;">
                            <div style="height: 100%; background: linear-gradient(90deg, #10b981, #059669); width: {{ $paymentRate }}%; transition: width 0.5s ease;"></div>
                        </div>
                        <div style="margin-top: 0.5rem; font-size: 0.875rem; color: #64748b;">
                            {{ $paidInvoices }} of {{ $totalInvoices }} invoices paid
                        </div>
                    </div>

                    <div>
                        <div style="font-weight: 600; color: #64748b; margin-bottom: 0.75rem;">Average Invoice</div>
                        <div style="font-size: 2rem; font-weight: 700; color: #0891b2;">${{ number_format($avgInvoiceAmount, 2) }}</div>
                        <div style="margin-top: 0.5rem; font-size: 0.875rem; color: #64748b;">
                            Based on {{ $totalInvoices }} invoice{{ $totalInvoices !== 1 ? 's' : '' }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Recent Messages -->
    <div class="content-card" style="margin-bottom: 2rem;">
        <div class="content-card-header">
            <h2 class="content-card-title">Recent Messages</h2>
        </div>
        <div class="content-card-body">
            @if($recentMessages->count() > 0)
                <div style="space-y: 1rem;">
                    @foreach($recentMessages as $message)
                        <div style="padding: 1rem; background: {{ $message->read ? '#f8fafc' : '#eff6ff' }}; border: 1px solid {{ $message->read ? '#e2e8f0' : '#93c5fd' }}; border-radius: 0.75rem; margin-bottom: 1rem;">
                            <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 0.5rem;">
                                <div>
                                    <div style="font-weight: 700; color: #1e293b; margin-bottom: 0.25rem;">{{ $message->subject }}</div>
                                    <div style="font-size: 0.8125rem; color: #64748b;">
                                        From: {{ $message->sender->name }} • {{ $message->created_at->diffForHumans() }}
                                    </div>
                                </div>
                                @if(!$message->read)
                                    <span style="background: #0891b2; color: white; padding: 0.25rem 0.75rem; border-radius: 9999px; font-size: 0.75rem; font-weight: 600;">New</span>
                                @endif
                            </div>
                            <div style="color: #475569; font-size: 0.9375rem; margin-top: 0.75rem; line-height: 1.6;">
                                {{ Str::limit($message->message, 150) }}
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div style="text-align: center; padding: 3rem; color: #64748b;">
                    <svg style="width: 4rem; height: 4rem; margin: 0 auto 1rem; color: #cbd5e1;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                    <p>No messages yet</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Recent Invoices -->
    <div class="content-card" style="margin-bottom: 2rem;">
        <div class="content-card-header">
            <h2 class="content-card-title">Recent Invoices</h2>
        </div>
        <div class="content-card-body">
            @if($recentInvoices->count() > 0)
                <div class="table-responsive">
                    <table class="dashboard-table">
                        <thead>
                            <tr>
                                <th>Invoice #</th>
                                <th>Date</th>
                                <th>Due Date</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th style="text-align: right;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentInvoices as $invoice)
                                <tr>
                                    <td>
                                        <a href="{{ route('client.invoices.show', $invoice) }}" style="font-weight: 600; color: #0891b2; text-decoration: none;">
                                            {{ $invoice->invoice_number }}
                                        </a>
                                    </td>
                                    <td>{{ $invoice->issue_date->format('M d, Y') }}</td>
                                    <td>{{ $invoice->due_date->format('M d, Y') }}</td>
                                    <td style="font-weight: 600;">${{ number_format($invoice->total, 2) }}</td>
                                    <td>
                                        <span style="display: inline-flex; align-items: center; padding: 0.375rem 0.75rem; border-radius: 0.5rem; font-size: 0.8125rem; font-weight: 600; background-color: {{ $invoice->status_badge['color'] }}22; color: {{ $invoice->status_badge['color'] }};">
                                            {{ $invoice->status_badge['text'] }}
                                        </span>
                                    </td>
                                    <td style="text-align: right;">
                                        <a href="{{ route('client.invoices.show', $invoice) }}" style="background: #e0f2fe; color: #0369a1; border: none; padding: 0.5rem 1rem; border-radius: 0.5rem; font-size: 0.8125rem; font-weight: 600; cursor: pointer; transition: all 0.2s ease; text-decoration: none; display: inline-block;" onmouseover="this.style.background='#0891b2'; this.style.color='white';" onmouseout="this.style.background='#e0f2fe'; this.style.color='#0369a1';">
                                            View Details
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div style="text-align: center; padding: 3rem; color: #64748b;">
                    <svg style="width: 4rem; height: 4rem; margin: 0 auto 1rem; color: #cbd5e1;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <p>No invoices yet</p>
                </div>
            @endif
        </div>
    </div>

    <!-- File Uploads -->
    <div class="content-card" style="margin-bottom: 2rem;">
        <div class="content-card-header">
            <h2 class="content-card-title">My Files</h2>
        </div>
        <div class="content-card-body">
            @if(session('file_success'))
                <div style="background: #ecfdf5; border: 2px solid #a7f3d0; color: #065f46; padding: 1rem 1.5rem; border-radius: 0.75rem; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 1rem;">
                    <svg style="width: 1.5rem; height: 1.5rem; flex-shrink: 0;" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                    <span style="font-weight: 600;">{{ session('file_success') }}</span>
                </div>
            @endif

            @if($errors->has('file'))
                <div style="background: #fef2f2; border: 2px solid #fecaca; color: #991b1b; padding: 1rem 1.5rem; border-radius: 0.75rem; margin-bottom: 1.5rem;">
                    <strong>Error:</strong> {{ $errors->first('file') }}
                </div>
            @endif

            <!-- Upload Form -->
            <form action="{{ route('client.files.upload') }}" method="POST" enctype="multipart/form-data" style="margin-bottom: 2rem; padding: 1.5rem; background: #f8fafc; border: 2px dashed #cbd5e1; border-radius: 0.75rem;">
                @csrf
                <div style="margin-bottom: 1rem;">
                    <label style="display: block; font-weight: 600; color: #1e293b; margin-bottom: 0.5rem;">Upload File</label>
                    <input type="file" name="file" required style="display: block; width: 100%; padding: 0.625rem; border: 2px solid #e2e8f0; border-radius: 0.5rem; font-size: 0.9375rem;">
                    <p style="font-size: 0.875rem; color: #64748b; margin-top: 0.5rem;">Max file size: 10MB. Accepted formats: PDF, DOC, DOCX, XLS, XLSX, PNG, JPG, ZIP</p>
                </div>

                <div style="margin-bottom: 1rem;">
                    <label style="display: block; font-weight: 600; color: #1e293b; margin-bottom: 0.5rem;">Description (Optional)</label>
                    <textarea name="description" rows="2" style="display: block; width: 100%; padding: 0.625rem; border: 2px solid #e2e8f0; border-radius: 0.5rem; font-size: 0.9375rem; resize: vertical;" placeholder="Add a description for this file..."></textarea>
                </div>

                <div style="margin-bottom: 1rem;">
                    <label style="display: block; font-weight: 600; color: #1e293b; margin-bottom: 0.5rem;">Associate with Invoice (Optional)</label>
                    <select name="invoice_id" style="display: block; width: 100%; padding: 0.625rem; border: 2px solid #e2e8f0; border-radius: 0.5rem; font-size: 0.9375rem;">
                        <option value="">-- Not associated with an invoice --</option>
                        @foreach($user->invoices()->orderBy('created_at', 'desc')->get() as $inv)
                            <option value="{{ $inv->id }}">{{ $inv->invoice_number }} - ${{ number_format($inv->total, 2) }}</option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="btn-dashboard" style="padding: 0.625rem 1.5rem;">
                    Upload File
                </button>
            </form>

            <!-- Files List -->
            @php
                $files = $user->fileUploads()->where('is_visible_to_client', true)->orderBy('created_at', 'desc')->get();
            @endphp

            @if($files->count() > 0)
                <div style="overflow-x: auto;">
                    <table class="dashboard-table">
                        <thead>
                            <tr>
                                <th>File</th>
                                <th>Description</th>
                                <th>Invoice</th>
                                <th>Uploaded</th>
                                <th>Size</th>
                                <th style="text-align: right;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($files as $file)
                                <tr>
                                    <td>
                                        <div style="display: flex; align-items: center; gap: 0.5rem;">
                                            <span style="font-size: 1.5rem;">{{ $file->fileIcon }}</span>
                                            <div>
                                                <div style="font-weight: 600; color: #1e293b;">{{ $file->filename }}</div>
                                                <div style="font-size: 0.75rem; color: #64748b;">{{ $file->mime_type }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div style="max-width: 300px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; color: #64748b;">
                                            {{ $file->description ?: '-' }}
                                        </div>
                                    </td>
                                    <td>
                                        @if($file->invoice)
                                            <a href="{{ route('client.invoices.show', $file->invoice) }}" style="color: #0891b2; text-decoration: none; font-weight: 600;">
                                                {{ $file->invoice->invoice_number }}
                                            </a>
                                        @else
                                            <span style="color: #94a3b8;">-</span>
                                        @endif
                                    </td>
                                    <td style="color: #64748b; white-space: nowrap;">{{ $file->created_at->format('M d, Y') }}</td>
                                    <td style="color: #64748b; white-space: nowrap;">{{ $file->formattedFileSize }}</td>
                                    <td style="text-align: right;">
                                        <div style="display: flex; gap: 0.5rem; justify-content: flex-end;">
                                            <a href="{{ route('client.files.download', $file) }}" style="background: #e0f2fe; color: #0369a1; border: none; padding: 0.5rem 1rem; border-radius: 0.5rem; font-size: 0.8125rem; font-weight: 600; text-decoration: none; display: inline-block;">
                                                Download
                                            </a>
                                            <form action="{{ route('client.files.delete', $file) }}" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this file?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" style="background: #fee2e2; color: #991b1b; border: none; padding: 0.5rem 1rem; border-radius: 0.5rem; font-size: 0.8125rem; font-weight: 600; cursor: pointer;">
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div style="text-align: center; padding: 3rem; color: #64748b;">
                    <svg style="width: 4rem; height: 4rem; margin: 0 auto 1rem; color: #cbd5e1;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                    </svg>
                    <p>No files uploaded yet</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Activity Timeline -->
    <div class="content-card" style="margin-bottom: 2rem;">
        <div class="content-card-header">
            <h2 class="content-card-title">Recent Activity</h2>
        </div>
        <div class="content-card-body">
            @php
                $activities = collect();

                // Add messages to timeline
                foreach($user->messages()->orderBy('created_at', 'desc')->limit(10)->get() as $message) {
                    $activities->push([
                        'type' => 'message',
                        'icon' => '💬',
                        'color' => '#0891b2',
                        'title' => 'New Message',
                        'description' => 'Received message: ' . $message->subject,
                        'timestamp' => $message->created_at,
                    ]);
                }

                // Add invoices to timeline
                foreach($user->invoices()->orderBy('created_at', 'desc')->limit(10)->get() as $invoice) {
                    $activities->push([
                        'type' => 'invoice',
                        'icon' => '📄',
                        'color' => '#8b5cf6',
                        'title' => 'Invoice ' . ucfirst($invoice->status),
                        'description' => 'Invoice ' . $invoice->invoice_number . ' - $' . number_format($invoice->total, 2),
                        'timestamp' => $invoice->status === 'paid' && $invoice->paid_date ? $invoice->paid_date : $invoice->created_at,
                    ]);
                }

                // Add file uploads to timeline
                foreach($user->fileUploads()->where('is_visible_to_client', true)->orderBy('created_at', 'desc')->limit(10)->get() as $file) {
                    $activities->push([
                        'type' => 'file',
                        'icon' => '📎',
                        'color' => '#10b981',
                        'title' => 'File ' . ($file->uploaded_by === $user->id ? 'Uploaded' : 'Received'),
                        'description' => $file->filename . ' (' . $file->formattedFileSize . ')',
                        'timestamp' => $file->created_at,
                    ]);
                }

                // Add inquiries to timeline
                foreach($user->invoices as $invoice) {
                    foreach($invoice->inquiries()->orderBy('created_at', 'desc')->limit(5)->get() as $inquiry) {
                        $activities->push([
                            'type' => 'inquiry',
                            'icon' => '❓',
                            'color' => '#f59e0b',
                            'title' => $inquiry->admin_response ? 'Inquiry Responded' : 'Inquiry Submitted',
                            'description' => $inquiry->subject . ' (Invoice ' . $invoice->invoice_number . ')',
                            'timestamp' => $inquiry->responded_at ?? $inquiry->created_at,
                        ]);
                    }
                }

                // Sort by timestamp descending and limit to 15
                $activities = $activities->sortByDesc('timestamp')->take(15);
            @endphp

            @if($activities->count() > 0)
                <div style="position: relative; padding-left: 2.5rem;">
                    <!-- Timeline line -->
                    <div style="position: absolute; left: 0.75rem; top: 0.5rem; bottom: 0.5rem; width: 2px; background: linear-gradient(to bottom, #0891b2, #e2e8f0);"></div>

                    @foreach($activities as $index => $activity)
                        <div style="position: relative; margin-bottom: {{ $loop->last ? '0' : '1.5rem' }};">
                            <!-- Timeline dot -->
                            <div style="position: absolute; left: -2rem; top: 0.25rem; width: 1.5rem; height: 1.5rem; background: {{ $activity['color'] }}; border: 3px solid white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 0.75rem; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                                {{ $activity['icon'] }}
                            </div>

                            <!-- Activity content -->
                            <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-left: 3px solid {{ $activity['color'] }}; border-radius: 0.5rem; padding: 1rem;">
                                <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 0.25rem;">
                                    <div style="font-weight: 700; color: #1e293b; font-size: 0.9375rem;">{{ $activity['title'] }}</div>
                                    <div style="font-size: 0.8125rem; color: #64748b; white-space: nowrap; margin-left: 1rem;">
                                        {{ $activity['timestamp']->diffForHumans() }}
                                    </div>
                                </div>
                                <div style="font-size: 0.875rem; color: #64748b;">{{ $activity['description'] }}</div>
                                <div style="font-size: 0.75rem; color: #94a3b8; margin-top: 0.25rem;">
                                    {{ $activity['timestamp']->format('M d, Y \a\t g:i A') }}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div style="text-align: center; padding: 3rem; color: #64748b;">
                    <svg style="width: 4rem; height: 4rem; margin: 0 auto 1rem; color: #cbd5e1;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <p>No activity yet</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Account Information -->
    <div class="content-card" style="margin-bottom: 2rem;">
        <div class="content-card-header">
            <h2 class="content-card-title">Account Information</h2>
        </div>
        <div class="content-card-body">
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 2rem;">
                <div>
                    <div style="font-size: 0.875rem; color: #64748b; font-weight: 600; margin-bottom: 0.5rem; text-transform: uppercase; letter-spacing: 0.05em;">Full Name</div>
                    <div style="font-size: 1.125rem; font-weight: 700; color: #1e293b;">{{ $user->name }}</div>
                </div>

                <div>
                    <div style="font-size: 0.875rem; color: #64748b; font-weight: 600; margin-bottom: 0.5rem; text-transform: uppercase; letter-spacing: 0.05em;">Email Address</div>
                    <div style="font-size: 1.125rem; font-weight: 700; color: #1e293b;">{{ $user->email }}</div>
                </div>

                <div>
                    <div style="font-size: 0.875rem; color: #64748b; font-weight: 600; margin-bottom: 0.5rem; text-transform: uppercase; letter-spacing: 0.05em;">Account Type</div>
                    <div style="font-size: 1.125rem; font-weight: 700; color: #1e293b;">
                        <span class="badge badge-primary">Client Account</span>
                    </div>
                </div>

                <div>
                    <div style="font-size: 0.875rem; color: #64748b; font-weight: 600; margin-bottom: 0.5rem; text-transform: uppercase; letter-spacing: 0.05em;">Member Since</div>
                    <div style="font-size: 1.125rem; font-weight: 700; color: #1e293b;">{{ $user->created_at->format('F d, Y') }}</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="content-card">
        <div class="content-card-header">
            <h2 class="content-card-title">Quick Actions</h2>
        </div>
        <div class="content-card-body">
            <div class="action-grid">
                <a href="{{ route('profile.edit') }}" class="action-card">
                    <div class="action-icon">👤</div>
                    <div class="action-title">Edit Profile</div>
                    <div class="action-description">Update your account information</div>
                </a>

                <a href="{{ url('/#contact') }}" class="action-card">
                    <div class="action-icon">✉️</div>
                    <div class="action-title">Contact Us</div>
                    <div class="action-description">Get in touch with our team</div>
                </a>

                <a href="{{ url('/#services') }}" class="action-card">
                    <div class="action-icon">📋</div>
                    <div class="action-title">View Services</div>
                    <div class="action-description">Explore our offerings</div>
                </a>

                <button id="enableNotifications" class="action-card" style="border: none; cursor: pointer; width: 100%; text-align: left;">
                    <div class="action-icon">🔔</div>
                    <div class="action-title">Enable Notifications</div>
                    <div class="action-description" id="notificationStatus">Get alerts for new messages</div>
                </button>
            </div>
        </div>
    </div>

    @vite(['resources/js/app.js'])

    <script>
        let lastCheck = null;
        let notificationsEnabled = false;

        document.addEventListener('DOMContentLoaded', function() {
            const notificationButton = document.getElementById('enableNotifications');
            const notificationStatus = document.getElementById('notificationStatus');

            // Check initial notification permission
            if ('Notification' in window) {
                if (Notification.permission === 'granted') {
                    notificationsEnabled = true;
                    notificationStatus.textContent = 'Notifications enabled';
                    notificationButton.style.opacity = '0.7';
                    window.notificationManager.enabled = true;
                    startPolling();
                } else if (Notification.permission === 'denied') {
                    notificationStatus.textContent = 'Notifications blocked by browser';
                    notificationButton.style.opacity = '0.5';
                    notificationButton.style.cursor = 'not-allowed';
                }
            }

            // Handle notification button click
            notificationButton.addEventListener('click', async function() {
                if (Notification.permission === 'denied') {
                    alert('Notifications are blocked. Please enable them in your browser settings.');
                    return;
                }

                if (Notification.permission === 'granted') {
                    return; // Already enabled
                }

                const permission = await window.notificationManager.requestPermission();
                if (permission) {
                    notificationsEnabled = true;
                    notificationStatus.textContent = 'Notifications enabled';
                    notificationButton.style.opacity = '0.7';
                    startPolling();
                } else {
                    alert('Please enable notifications to receive alerts for new messages and invoices.');
                }
            });
        });

        // Poll for new notifications
        function startPolling() {
            // Initial check
            checkNotifications();

            // Poll every 30 seconds
            setInterval(checkNotifications, 30000);
        }

        async function checkNotifications() {
            try {
                const url = '/api/notifications/check' + (lastCheck ? `?last_check=${encodeURIComponent(lastCheck)}` : '');
                const response = await fetch(url);
                const data = await response.json();

                // Show notifications for new messages
                data.messages.forEach(message => {
                    if (notificationsEnabled && window.notificationManager) {
                        window.notificationManager.newMessage(message.sender, message.preview);
                    }
                });

                // Show notifications for new invoices
                data.invoices.forEach(invoice => {
                    if (notificationsEnabled && window.notificationManager) {
                        window.notificationManager.newInvoice(invoice.invoice_number, invoice.total);
                    }
                });

                // Update last check timestamp
                lastCheck = data.checked_at;

                // Update unread count in the stat card
                if (data.messages.length > 0) {
                    // Optionally reload the page to show new messages
                    // location.reload();
                }
            } catch (error) {
                console.error('Error checking notifications:', error);
            }
        }
    </script>
</x-app-layout>
