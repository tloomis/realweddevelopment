<x-app-layout>
    <style>
        .tabs-container {
            background: white;
            border-radius: 1rem;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .tabs-header {
            display: flex;
            border-bottom: 2px solid #e2e8f0;
            background: #f8fafc;
        }

        .tab-button {
            flex: 1;
            padding: 1rem 1.5rem;
            background: none;
            border: none;
            font-size: 0.9375rem;
            font-weight: 600;
            color: #64748b;
            cursor: pointer;
            transition: all 0.2s ease;
            border-bottom: 3px solid transparent;
            position: relative;
        }

        .tab-button:hover {
            color: #0891b2;
            background: white;
        }

        .tab-button.active {
            color: #0891b2;
            background: white;
            border-bottom-color: #0891b2;
        }

        .tab-content {
            display: none;
            padding: 1.5rem;
        }

        .tab-content.active {
            display: block;
        }

        .client-header {
            background: linear-gradient(135deg, #0891b2 0%, #0e7490 100%);
            color: white;
            padding: 2rem;
            border-radius: 1rem;
            margin-bottom: 1.5rem;
        }

        .client-info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.5rem;
            margin-top: 1rem;
        }

        .client-info-item {
            display: flex;
            flex-direction: column;
            gap: 0.25rem;
        }

        .client-info-label {
            font-size: 0.875rem;
            opacity: 0.9;
        }

        .client-info-value {
            font-size: 1.125rem;
            font-weight: 600;
        }

        .note-item, .message-item, .invoice-item {
            background: #f8fafc;
            padding: 1rem;
            border-radius: 0.75rem;
            border: 1px solid #e2e8f0;
            margin-bottom: 1rem;
        }

        .note-header, .message-header, .invoice-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 0.75rem;
        }

        .note-meta, .message-meta, .invoice-meta {
            font-size: 0.8125rem;
            color: #64748b;
        }

        .note-content, .message-content {
            color: #1e293b;
            line-height: 1.6;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            padding: 0.375rem 0.75rem;
            border-radius: 0.5rem;
            font-size: 0.8125rem;
            font-weight: 600;
        }

        .form-section {
            background: #f8fafc;
            padding: 1.5rem;
            border-radius: 0.75rem;
            border: 2px dashed #cbd5e1;
            margin-bottom: 1.5rem;
        }

        .form-section-title {
            font-size: 1rem;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 1rem;
        }

        .invoice-items-table {
            width: 100%;
            margin-top: 1rem;
        }

        .invoice-items-table th {
            text-align: left;
            padding: 0.5rem;
            font-size: 0.875rem;
            color: #64748b;
            font-weight: 600;
        }

        .invoice-items-table td {
            padding: 0.5rem;
            color: #1e293b;
        }

        .invoice-total {
            background: white;
            padding: 1rem;
            border-radius: 0.5rem;
            margin-top: 1rem;
        }

        .invoice-total-row {
            display: flex;
            justify-content: space-between;
            padding: 0.5rem 0;
        }

        .invoice-total-row.total {
            border-top: 2px solid #e2e8f0;
            margin-top: 0.5rem;
            padding-top: 1rem;
            font-weight: 700;
            font-size: 1.125rem;
        }
    </style>

    <!-- Success Message -->
    @if(session('success'))
        <div style="padding: 1rem 1.5rem; background: #ecfdf5; border: 1px solid #a7f3d0; border-radius: 0.75rem; color: #065f46; font-size: 0.9375rem; margin-bottom: 1.5rem; font-weight: 500; display: flex; align-items: center; justify-content: space-between;">
            <span>{{ session('success') }}</span>
            <button onclick="this.parentElement.remove()" style="background: none; border: none; color: #065f46; cursor: pointer; font-size: 1.25rem; padding: 0; margin-left: 1rem;">&times;</button>
        </div>
    @endif

    <!-- Back Button -->
    <div style="margin-bottom: 1rem;">
        <a href="{{ route('admin.dashboard') }}" style="color: #0891b2; text-decoration: none; font-weight: 600; font-size: 0.9375rem; display: inline-flex; align-items: center; gap: 0.5rem;" onmouseover="this.style.color='#0e7490'" onmouseout="this.style.color='#0891b2'">
            <svg style="width: 1.25rem; height: 1.25rem;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            Back to Dashboard
        </a>
    </div>

    <!-- Client Header -->
    <div class="client-header">
        <div style="display: flex; justify-content: space-between; align-items: start;">
            <div>
                <h1 style="font-size: 2rem; font-weight: 700; margin-bottom: 0.5rem;">{{ $user->name }}</h1>
                <p style="opacity: 0.9;">Client Account Details & Management</p>
            </div>
            <form method="POST" action="{{ route('admin.clients.impersonate', $user) }}">
                @csrf
                <button type="submit" style="background: white; color: #0891b2; border: none; padding: 0.75rem 1.5rem; border-radius: 0.5rem; font-size: 0.9375rem; font-weight: 600; cursor: pointer; transition: all 0.2s ease;" onmouseover="this.style.background='#f0f9ff'" onmouseout="this.style.background='white'">
                    Login as User
                </button>
            </form>
        </div>

        <div class="client-info-grid">
            <div class="client-info-item">
                <div class="client-info-label">Email Address</div>
                <div class="client-info-value">{{ $user->email }}</div>
            </div>
            <div class="client-info-item">
                <div class="client-info-label">Member Since</div>
                <div class="client-info-value">{{ $user->created_at->format('M d, Y') }}</div>
            </div>
            <div class="client-info-item">
                <div class="client-info-label">Total Notes</div>
                <div class="client-info-value">{{ $user->notes->count() }}</div>
            </div>
            <div class="client-info-item">
                <div class="client-info-label">Total Messages</div>
                <div class="client-info-value">{{ $user->messages->count() }}</div>
            </div>
            <div class="client-info-item">
                <div class="client-info-label">Total Invoices</div>
                <div class="client-info-value">{{ $user->invoices->count() }}</div>
            </div>
        </div>
    </div>

    <!-- Tabs Container -->
    <div class="tabs-container">
        <div class="tabs-header">
            <button class="tab-button active" onclick="switchTab('overview')">Overview</button>
            <button class="tab-button" onclick="switchTab('notes')">Notes ({{ $user->notes->count() }})</button>
            <button class="tab-button" onclick="switchTab('messages')">Messages ({{ $user->messages->count() }})</button>
            <button class="tab-button" onclick="switchTab('invoices')">Invoices ({{ $user->invoices->count() }})</button>
            <button class="tab-button" onclick="switchTab('inquiries')">Inquiries ({{ $user->invoices->sum(function($invoice) { return $invoice->inquiries->count(); }) }})</button>
            <button class="tab-button" onclick="switchTab('files')">Files ({{ $user->fileUploads->count() }})</button>
        </div>

        <!-- Overview Tab -->
        <div id="overview-tab" class="tab-content active">
            <h2 style="font-size: 1.5rem; font-weight: 700; color: #1e293b; margin-bottom: 1rem;">Account Overview</h2>

            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem;">
                <div style="background: linear-gradient(135deg, #ecfdf5 0%, #d1fae5 100%); padding: 1.5rem; border-radius: 0.75rem; border: 1px solid #a7f3d0;">
                    <div style="font-size: 0.875rem; color: #065f46; margin-bottom: 0.5rem; font-weight: 600;">Recent Activity</div>
                    <div style="font-size: 2rem; font-weight: 700; color: #047857;">{{ $user->notes->count() + $user->messages->count() }}</div>
                    <div style="font-size: 0.8125rem; color: #059669; margin-top: 0.25rem;">Total Interactions</div>
                </div>

                <div style="background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%); padding: 1.5rem; border-radius: 0.75rem; border: 1px solid #93c5fd;">
                    <div style="font-size: 0.875rem; color: #1e40af; margin-bottom: 0.5rem; font-weight: 600;">Invoices</div>
                    <div style="font-size: 2rem; font-weight: 700; color: #1d4ed8;">${{ number_format($user->invoices->sum('total'), 2) }}</div>
                    <div style="font-size: 0.8125rem; color: #2563eb; margin-top: 0.25rem;">Total Billed</div>
                </div>

                <div style="background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%); padding: 1.5rem; border-radius: 0.75rem; border: 1px solid #fcd34d;">
                    <div style="font-size: 0.875rem; color: #92400e; margin-bottom: 0.5rem; font-weight: 600;">Outstanding</div>
                    <div style="font-size: 2rem; font-weight: 700; color: #b45309;">${{ number_format($user->invoices->whereNotIn('status', ['paid', 'cancelled'])->sum('total'), 2) }}</div>
                    <div style="font-size: 0.8125rem; color: #d97706; margin-top: 0.25rem;">Unpaid Invoices</div>
                </div>
            </div>

            <div style="margin-top: 2rem;">
                <h3 style="font-size: 1.125rem; font-weight: 700; color: #1e293b; margin-bottom: 1rem;">Quick Actions</h3>
                <div style="display: flex; flex-wrap: wrap; gap: 1rem;">
                    <button onclick="switchTab('notes'); setTimeout(() => document.getElementById('note-textarea').focus(), 100)" class="btn-dashboard">
                        Add Note
                    </button>
                    <button onclick="switchTab('messages'); setTimeout(() => document.getElementById('message-subject').focus(), 100)" class="btn-dashboard">
                        Send Message
                    </button>
                    <button onclick="switchTab('invoices'); setTimeout(() => document.getElementById('issue_date').focus(), 100)" class="btn-dashboard">
                        Create Invoice
                    </button>
                </div>
            </div>
        </div>

        <!-- Notes Tab -->
        <div id="notes-tab" class="tab-content">
            <h2 style="font-size: 1.5rem; font-weight: 700; color: #1e293b; margin-bottom: 1rem;">Client Notes</h2>

            <!-- Add Note Form -->
            <div class="form-section">
                <h3 class="form-section-title">Add New Note</h3>
                <form method="POST" action="{{ route('admin.clients.notes.store', $user) }}">
                    @csrf
                    <textarea id="note-textarea" name="note" rows="4" placeholder="Enter note about this client..." required style="width: 100%; padding: 0.75rem 1rem; border: 1.5px solid #e2e8f0; border-radius: 0.5rem; font-size: 0.9375rem; font-family: inherit; resize: vertical; margin-bottom: 1rem;"></textarea>
                    <button type="submit" class="btn-dashboard">Add Note</button>
                </form>
            </div>

            <!-- Notes List -->
            @if($user->notes->count() > 0)
                @foreach($user->notes->sortByDesc('created_at') as $note)
                    <div class="note-item">
                        <div class="note-header">
                            <div class="note-meta">
                                <strong>{{ $note->creator->name }}</strong> • {{ $note->created_at->diffForHumans() }}
                            </div>
                            <form method="POST" action="{{ route('admin.notes.delete', $note) }}" onsubmit="return confirm('Are you sure you want to delete this note?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" style="background: none; border: none; color: #dc2626; cursor: pointer; font-size: 0.875rem; font-weight: 600;">Delete</button>
                            </form>
                        </div>
                        <div class="note-content">{{ $note->note }}</div>
                    </div>
                @endforeach
            @else
                <div style="text-align: center; padding: 3rem; color: #64748b;">
                    <p>No notes yet. Add your first note above.</p>
                </div>
            @endif
        </div>

        <!-- Messages Tab -->
        <div id="messages-tab" class="tab-content">
            <h2 style="font-size: 1.5rem; font-weight: 700; color: #1e293b; margin-bottom: 1rem;">Client Messages</h2>

            <!-- Send Message Form -->
            <div class="form-section">
                <h3 class="form-section-title">Send New Message</h3>
                <form method="POST" action="{{ route('admin.clients.messages.store', $user) }}">
                    @csrf
                    <div style="margin-bottom: 1rem;">
                        <label for="message-subject" style="display: block; font-size: 0.875rem; font-weight: 600; color: #334155; margin-bottom: 0.5rem;">Subject</label>
                        <input id="message-subject" type="text" name="subject" required placeholder="Message subject" style="width: 100%; padding: 0.75rem 1rem; border: 1.5px solid #e2e8f0; border-radius: 0.5rem; font-size: 0.9375rem;">
                    </div>
                    <div style="margin-bottom: 1rem;">
                        <label for="message-body" style="display: block; font-size: 0.875rem; font-weight: 600; color: #334155; margin-bottom: 0.5rem;">Message</label>
                        <textarea id="message-body" name="message" rows="5" placeholder="Enter your message..." required style="width: 100%; padding: 0.75rem 1rem; border: 1.5px solid #e2e8f0; border-radius: 0.5rem; font-size: 0.9375rem; font-family: inherit; resize: vertical;"></textarea>
                    </div>
                    <button type="submit" class="btn-dashboard">Send Message</button>
                </form>
            </div>

            <!-- Messages List -->
            @if($user->messages->count() > 0)
                @foreach($user->messages->sortByDesc('created_at') as $message)
                    <div class="message-item">
                        <div class="message-header">
                            <div>
                                <div style="font-weight: 700; color: #1e293b; margin-bottom: 0.25rem;">{{ $message->subject }}</div>
                                <div class="message-meta">
                                    From <strong>{{ $message->sender->name }}</strong> • {{ $message->created_at->diffForHumans() }}
                                    @if($message->read)
                                        • <span style="color: #10b981;">Read</span>
                                    @else
                                        • <span style="color: #f59e0b;">Unread</span>
                                    @endif
                                </div>
                            </div>
                            @if(!$message->read)
                                <form method="POST" action="{{ route('admin.messages.read', $message) }}">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" style="background: #ecfdf5; color: #059669; border: none; padding: 0.375rem 0.75rem; border-radius: 0.5rem; font-size: 0.8125rem; font-weight: 600; cursor: pointer;">Mark as Read</button>
                                </form>
                            @endif
                        </div>
                        <div class="message-content">{{ $message->message }}</div>
                    </div>
                @endforeach
            @else
                <div style="text-align: center; padding: 3rem; color: #64748b;">
                    <p>No messages yet. Send your first message above.</p>
                </div>
            @endif
        </div>

        <!-- Invoices Tab -->
        <div id="invoices-tab" class="tab-content">
            <h2 style="font-size: 1.5rem; font-weight: 700; color: #1e293b; margin-bottom: 1rem;">Client Invoices</h2>

            <!-- Create Invoice Form -->
            <div class="form-section">
                <h3 class="form-section-title">Create New Invoice</h3>
                <form method="POST" action="{{ route('admin.clients.invoices.store', $user) }}" id="invoiceForm">
                    @csrf
                    <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 1rem; margin-bottom: 1rem;">
                        <div>
                            <label for="issue_date" style="display: block; font-size: 0.875rem; font-weight: 600; color: #334155; margin-bottom: 0.5rem;">Issue Date</label>
                            <input id="issue_date" type="date" name="issue_date" required value="{{ date('Y-m-d') }}" style="width: 100%; padding: 0.75rem 1rem; border: 1.5px solid #e2e8f0; border-radius: 0.5rem; font-size: 0.9375rem;">
                        </div>
                        <div>
                            <label for="due_date" style="display: block; font-size: 0.875rem; font-weight: 600; color: #334155; margin-bottom: 0.5rem;">Due Date</label>
                            <input id="due_date" type="date" name="due_date" required value="{{ date('Y-m-d', strtotime('+30 days')) }}" style="width: 100%; padding: 0.75rem 1rem; border: 1.5px solid #e2e8f0; border-radius: 0.5rem; font-size: 0.9375rem;">
                        </div>
                    </div>

                    <div style="margin-bottom: 1rem;">
                        <label for="tax_rate" style="display: block; font-size: 0.875rem; font-weight: 600; color: #334155; margin-bottom: 0.5rem;">Tax Rate (%)</label>
                        <input id="tax_rate" type="number" name="tax_rate" step="0.01" min="0" max="100" value="0" required style="width: 100%; padding: 0.75rem 1rem; border: 1.5px solid #e2e8f0; border-radius: 0.5rem; font-size: 0.9375rem;">
                    </div>

                    <div style="margin-bottom: 1rem;">
                        <label for="notes" style="display: block; font-size: 0.875rem; font-weight: 600; color: #334155; margin-bottom: 0.5rem;">Notes (Optional)</label>
                        <textarea id="notes" name="notes" rows="2" placeholder="Add any notes for the invoice..." style="width: 100%; padding: 0.75rem 1rem; border: 1.5px solid #e2e8f0; border-radius: 0.5rem; font-size: 0.9375rem; font-family: inherit; resize: vertical;"></textarea>
                    </div>

                    <div style="margin-bottom: 1rem;">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.75rem;">
                            <label style="font-size: 0.875rem; font-weight: 600; color: #334155;">Invoice Items</label>
                            <button type="button" onclick="addInvoiceItem()" style="background: #0891b2; color: white; border: none; padding: 0.5rem 1rem; border-radius: 0.5rem; font-size: 0.8125rem; font-weight: 600; cursor: pointer;">+ Add Item</button>
                        </div>
                        <div id="invoiceItems">
                            <div class="invoice-item-row" style="display: grid; grid-template-columns: 2fr 1fr 1fr auto; gap: 0.75rem; margin-bottom: 0.75rem;">
                                <input type="text" name="items[0][description]" placeholder="Description" required style="padding: 0.75rem 1rem; border: 1.5px solid #e2e8f0; border-radius: 0.5rem; font-size: 0.9375rem;">
                                <input type="number" name="items[0][quantity]" placeholder="Qty" min="1" value="1" required style="padding: 0.75rem 1rem; border: 1.5px solid #e2e8f0; border-radius: 0.5rem; font-size: 0.9375rem;">
                                <input type="number" name="items[0][unit_price]" placeholder="Price" step="0.01" min="0" required style="padding: 0.75rem 1rem; border: 1.5px solid #e2e8f0; border-radius: 0.5rem; font-size: 0.9375rem;">
                                <button type="button" onclick="removeInvoiceItem(this)" style="background: #fee2e2; color: #dc2626; border: none; padding: 0.75rem; border-radius: 0.5rem; font-weight: 600; cursor: pointer;">×</button>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn-dashboard">Create Invoice</button>
                </form>
            </div>

            <!-- Invoices List -->
            @if($user->invoices->count() > 0)
                @foreach($user->invoices->sortByDesc('created_at') as $invoice)
                    <div class="invoice-item">
                        <div class="invoice-header" style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 1rem;">
                            <div>
                                <div style="font-weight: 700; color: #1e293b; font-size: 1.125rem; margin-bottom: 0.25rem;">{{ $invoice->invoice_number }}</div>
                                <div class="invoice-meta">
                                    Issued: {{ $invoice->issue_date->format('M d, Y') }} • Due: {{ $invoice->due_date->format('M d, Y') }}
                                </div>
                            </div>
                            <div style="display: flex; gap: 0.5rem; align-items: center;">
                                <span class="status-badge" style="background-color: {{ $invoice->status_badge['color'] }}22; color: {{ $invoice->status_badge['color'] }};">
                                    {{ $invoice->status_badge['text'] }}
                                </span>
                                <a href="{{ route('admin.invoices.pdf', $invoice) }}" style="background: #e0f2fe; color: #0369a1; border: none; padding: 0.5rem 0.75rem; border-radius: 0.5rem; font-size: 0.8125rem; font-weight: 600; cursor: pointer; text-decoration: none; display: inline-flex; align-items: center; gap: 0.25rem;" onmouseover="this.style.background='#0891b2'; this.style.color='white';" onmouseout="this.style.background='#e0f2fe'; this.style.color='#0369a1';">
                                    <svg style="width: 1rem; height: 1rem;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    PDF
                                </a>
                                <form method="POST" action="{{ route('admin.invoices.delete', $invoice) }}" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this invoice?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" style="background: none; border: none; color: #dc2626; cursor: pointer; font-size: 1.25rem; padding: 0.25rem;">×</button>
                                </form>
                            </div>
                        </div>

                        @if($invoice->items->count() > 0)
                            <table class="invoice-items-table">
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
                                            <td style="text-align: right;">${{ number_format($item->total, 2) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif

                        <div class="invoice-total">
                            <div class="invoice-total-row">
                                <span>Subtotal:</span>
                                <span>${{ number_format($invoice->subtotal, 2) }}</span>
                            </div>
                            <div class="invoice-total-row">
                                <span>Tax ({{ $invoice->tax_rate }}%):</span>
                                <span>${{ number_format($invoice->tax_amount, 2) }}</span>
                            </div>
                            <div class="invoice-total-row total">
                                <span>Total:</span>
                                <span>${{ number_format($invoice->total, 2) }}</span>
                            </div>
                        </div>

                        @if($invoice->notes)
                            <div style="margin-top: 1rem; padding: 0.75rem; background: white; border-radius: 0.5rem; font-size: 0.875rem; color: #64748b;">
                                <strong>Notes:</strong> {{ $invoice->notes }}
                            </div>
                        @endif

                        @if($invoice->status !== 'paid')
                            <form method="POST" action="{{ route('admin.invoices.status', $invoice) }}" style="margin-top: 1rem;" id="statusForm{{ $invoice->id }}">
                                @csrf
                                @method('PATCH')
                                <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 0.75rem; margin-bottom: 0.75rem;">
                                    <div>
                                        <label style="display: block; font-size: 0.875rem; font-weight: 600; color: #334155; margin-bottom: 0.5rem;">Update Status</label>
                                        <select name="status" required onchange="togglePaymentFields{{ $invoice->id }}(this)" style="width: 100%; padding: 0.75rem 1rem; border: 1.5px solid #e2e8f0; border-radius: 0.5rem; font-size: 0.9375rem;">
                                            <option value="draft" {{ $invoice->status === 'draft' ? 'selected' : '' }}>Draft</option>
                                            <option value="sent" {{ $invoice->status === 'sent' ? 'selected' : '' }}>Sent</option>
                                            <option value="paid" {{ $invoice->status === 'paid' ? 'selected' : '' }}>Paid</option>
                                            <option value="overdue" {{ $invoice->status === 'overdue' ? 'selected' : '' }}>Overdue</option>
                                            <option value="cancelled" {{ $invoice->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label style="display: block; font-size: 0.875rem; font-weight: 600; color: #334155; margin-bottom: 0.5rem;">Paid Date (if paid)</label>
                                        <input type="date" name="paid_date" value="{{ $invoice->paid_date?->format('Y-m-d') }}" style="width: 100%; padding: 0.75rem 1rem; border: 1.5px solid #e2e8f0; border-radius: 0.5rem; font-size: 0.9375rem;">
                                    </div>
                                </div>

                                <div id="paymentFields{{ $invoice->id }}" style="display: none; padding: 1rem; background: #f8fafc; border-radius: 0.5rem; margin-bottom: 0.75rem;">
                                    <div style="font-weight: 600; color: #0891b2; margin-bottom: 0.75rem; font-size: 0.875rem; text-transform: uppercase;">Payment Details</div>
                                    <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 0.75rem; margin-bottom: 0.75rem;">
                                        <div>
                                            <label style="display: block; font-size: 0.875rem; font-weight: 600; color: #334155; margin-bottom: 0.5rem;">Payment Method</label>
                                            <select name="payment_method" style="width: 100%; padding: 0.75rem 1rem; border: 1.5px solid #e2e8f0; border-radius: 0.5rem; font-size: 0.9375rem;">
                                                <option value="">Select method...</option>
                                                <option value="Cash" {{ $invoice->payment_method === 'Cash' ? 'selected' : '' }}>Cash</option>
                                                <option value="Check" {{ $invoice->payment_method === 'Check' ? 'selected' : '' }}>Check</option>
                                                <option value="Credit Card" {{ $invoice->payment_method === 'Credit Card' ? 'selected' : '' }}>Credit Card</option>
                                                <option value="Bank Transfer" {{ $invoice->payment_method === 'Bank Transfer' ? 'selected' : '' }}>Bank Transfer</option>
                                                <option value="PayPal" {{ $invoice->payment_method === 'PayPal' ? 'selected' : '' }}>PayPal</option>
                                                <option value="Other" {{ $invoice->payment_method === 'Other' ? 'selected' : '' }}>Other</option>
                                            </select>
                                        </div>
                                        <div>
                                            <label style="display: block; font-size: 0.875rem; font-weight: 600; color: #334155; margin-bottom: 0.5rem;">Payment Reference</label>
                                            <input type="text" name="payment_reference" value="{{ $invoice->payment_reference }}" placeholder="Transaction ID, Check #, etc." style="width: 100%; padding: 0.75rem 1rem; border: 1.5px solid #e2e8f0; border-radius: 0.5rem; font-size: 0.9375rem;">
                                        </div>
                                    </div>
                                    <div>
                                        <label style="display: block; font-size: 0.875rem; font-weight: 600; color: #334155; margin-bottom: 0.5rem;">Payment Notes (Optional)</label>
                                        <textarea name="payment_notes" rows="2" placeholder="Additional payment details..." style="width: 100%; padding: 0.75rem 1rem; border: 1.5px solid #e2e8f0; border-radius: 0.5rem; font-size: 0.9375rem; font-family: inherit; resize: vertical;">{{ $invoice->payment_notes }}</textarea>
                                    </div>
                                </div>

                                <button type="submit" class="btn-dashboard">Update Invoice</button>
                            </form>

                            <script>
                                function togglePaymentFields{{ $invoice->id }}(select) {
                                    const paymentFields = document.getElementById('paymentFields{{ $invoice->id }}');
                                    if (select.value === 'paid') {
                                        paymentFields.style.display = 'block';
                                    } else {
                                        paymentFields.style.display = 'none';
                                    }
                                }

                                // Initialize on page load
                                document.addEventListener('DOMContentLoaded', function() {
                                    const statusSelect = document.querySelector('#statusForm{{ $invoice->id }} select[name="status"]');
                                    if (statusSelect && statusSelect.value === 'paid') {
                                        document.getElementById('paymentFields{{ $invoice->id }}').style.display = 'block';
                                    }
                                });
                            </script>
                        @else
                            <div style="margin-top: 1rem; padding: 1rem; background: #ecfdf5; border: 2px solid #a7f3d0; border-radius: 0.75rem;">
                                <div style="font-weight: 700; color: #065f46; margin-bottom: 0.5rem; display: flex; align-items: center; gap: 0.5rem;">
                                    <svg style="width: 1.5rem; height: 1.5rem; color: #10b981;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Paid on {{ $invoice->paid_date->format('M d, Y') }}
                                </div>
                                @if($invoice->payment_method || $invoice->payment_reference || $invoice->payment_notes)
                                    <div style="font-size: 0.875rem; color: #047857; margin-top: 0.75rem;">
                                        @if($invoice->payment_method)
                                            <div><strong>Method:</strong> {{ $invoice->payment_method }}</div>
                                        @endif
                                        @if($invoice->payment_reference)
                                            <div><strong>Reference:</strong> {{ $invoice->payment_reference }}</div>
                                        @endif
                                        @if($invoice->payment_notes)
                                            <div style="margin-top: 0.5rem;"><strong>Notes:</strong> {{ $invoice->payment_notes }}</div>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        @endif
                    </div>
                @endforeach
            @else
                <div style="text-align: center; padding: 3rem; color: #64748b;">
                    <p>No invoices yet. Create your first invoice above.</p>
                </div>
            @endif
        </div>

        <!-- Inquiries Tab -->
        <div id="inquiries-tab" class="tab-content">
            <h2 style="font-size: 1.5rem; font-weight: 700; color: #1e293b; margin-bottom: 1rem;">Invoice Inquiries</h2>

            @php
                $allInquiries = \App\Models\InvoiceInquiry::whereHas('invoice', function($query) use ($user) {
                    $query->where('user_id', $user->id);
                })->with(['invoice', 'responder'])->latest()->get();
            @endphp

            @if($allInquiries->count() > 0)
                @foreach($allInquiries as $inquiry)
                    <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 0.75rem; padding: 1.5rem; margin-bottom: 1.5rem;">
                        <!-- Inquiry Header -->
                        <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 1rem;">
                            <div style="flex: 1;">
                                <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 0.5rem;">
                                    <h3 style="font-size: 1.125rem; font-weight: 600; color: #1e293b; margin: 0;">{{ $inquiry->subject }}</h3>
                                    <span style="display: inline-flex; align-items: center; padding: 0.375rem 0.75rem; border-radius: 0.5rem; font-size: 0.875rem; font-weight: 600; background-color: {{ $inquiry->status_badge['color'] }}22; color: {{ $inquiry->status_badge['color'] }}; border: 1px solid {{ $inquiry->status_badge['color'] }};">
                                        {{ $inquiry->status_badge['text'] }}
                                    </span>
                                </div>
                                <div style="font-size: 0.875rem; color: #64748b;">
                                    Invoice: <strong>{{ $inquiry->invoice->invoice_number }}</strong> |
                                    Submitted {{ $inquiry->created_at->format('M d, Y \a\t g:i A') }}
                                </div>
                            </div>
                        </div>

                        <!-- Client Message -->
                        <div style="padding: 1rem; background: white; border-radius: 0.5rem; margin-bottom: 1rem;">
                            <div style="font-size: 0.875rem; color: #64748b; margin-bottom: 0.5rem; font-weight: 600;">Client Message:</div>
                            <p style="color: #334155; line-height: 1.6; margin: 0; white-space: pre-wrap;">{{ $inquiry->message }}</p>
                        </div>

                        <!-- Admin Response or Response Form -->
                        @if($inquiry->admin_response)
                            <div style="padding: 1rem; background: #eff6ff; border-left: 4px solid #0891b2; border-radius: 0.5rem;">
                                <div style="font-size: 0.875rem; color: #0891b2; margin-bottom: 0.5rem; font-weight: 600;">
                                    Your Response ({{ $inquiry->responded_at->format('M d, Y \a\t g:i A') }}):
                                </div>
                                <p style="color: #1e3a8a; line-height: 1.6; margin: 0; white-space: pre-wrap;">{{ $inquiry->admin_response }}</p>
                            </div>
                        @else
                            <!-- Response Form -->
                            <form method="POST" action="{{ route('admin.inquiries.respond', $inquiry) }}" style="margin-top: 1rem;">
                                @csrf
                                <div style="display: grid; gap: 1rem;">
                                    <div>
                                        <label style="display: block; font-size: 0.875rem; font-weight: 600; color: #374151; margin-bottom: 0.5rem;">Status</label>
                                        <select name="status" required style="width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 0.5rem; font-size: 0.9375rem;">
                                            <option value="open" {{ $inquiry->status === 'open' ? 'selected' : '' }}>Open</option>
                                            <option value="in_progress" {{ $inquiry->status === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                            <option value="resolved" {{ $inquiry->status === 'resolved' ? 'selected' : '' }}>Resolved</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label style="display: block; font-size: 0.875rem; font-weight: 600; color: #374151; margin-bottom: 0.5rem;">Your Response</label>
                                        <textarea name="response" required rows="4" style="width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 0.5rem; font-size: 0.9375rem; font-family: inherit;" placeholder="Enter your response to the client..."></textarea>
                                    </div>
                                    <div>
                                        <button type="submit" class="btn-dashboard" style="padding: 0.75rem 1.5rem; font-size: 0.9375rem; border: none; cursor: pointer;">
                                            Send Response
                                        </button>
                                    </div>
                                </div>
                            </form>
                        @endif
                    </div>
                @endforeach
            @else
                <div style="text-align: center; padding: 3rem; color: #64748b;">
                    <svg style="width: 4rem; height: 4rem; margin: 0 auto 1rem; color: #cbd5e1;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <p style="font-size: 1.125rem; font-weight: 600; margin-bottom: 0.5rem;">No Inquiries Yet</p>
                    <p style="font-size: 0.9375rem;">This client hasn't submitted any invoice inquiries.</p>
                </div>
            @endif
        </div>

        <!-- Files Tab -->
        <div id="files-tab" class="tab-content">
            <h2 style="font-size: 1.5rem; font-weight: 700; color: #1e293b; margin-bottom: 1rem;">File Management</h2>

            @if(session('file_admin_success'))
                <div style="background: #ecfdf5; border: 2px solid #a7f3d0; color: #065f46; padding: 1rem 1.5rem; border-radius: 0.75rem; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 1rem;">
                    <svg style="width: 1.5rem; height: 1.5rem; flex-shrink: 0;" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                    <span style="font-weight: 600;">{{ session('file_admin_success') }}</span>
                </div>
            @endif

            <!-- Upload Form -->
            <form method="POST" action="{{ route('admin.files.upload', $user) }}" enctype="multipart/form-data" style="background: #f8fafc; border: 2px dashed #cbd5e1; border-radius: 0.75rem; padding: 1.5rem; margin-bottom: 2rem;">
                @csrf
                <h3 style="font-size: 1.125rem; font-weight: 600; color: #1e293b; margin-bottom: 1rem;">Upload File for Client</h3>

                <div style="display: grid; gap: 1rem;">
                    <div>
                        <label style="display: block; font-weight: 600; color: #374151; margin-bottom: 0.5rem;">File</label>
                        <input type="file" name="file" required style="display: block; width: 100%; padding: 0.625rem; border: 2px solid #e2e8f0; border-radius: 0.5rem; font-size: 0.9375rem;">
                        <p style="font-size: 0.875rem; color: #64748b; margin-top: 0.5rem;">Max file size: 10MB. Accepted formats: PDF, DOC, DOCX, XLS, XLSX, PNG, JPG, ZIP</p>
                    </div>

                    <div>
                        <label style="display: block; font-weight: 600; color: #374151; margin-bottom: 0.5rem;">Description (Optional)</label>
                        <textarea name="description" rows="2" style="display: block; width: 100%; padding: 0.625rem; border: 2px solid #e2e8f0; border-radius: 0.5rem; font-size: 0.9375rem; resize: vertical;" placeholder="Add a description for this file..."></textarea>
                    </div>

                    <div>
                        <label style="display: block; font-weight: 600; color: #374151; margin-bottom: 0.5rem;">Associate with Invoice (Optional)</label>
                        <select name="invoice_id" style="display: block; width: 100%; padding: 0.625rem; border: 2px solid #e2e8f0; border-radius: 0.5rem; font-size: 0.9375rem;">
                            <option value="">-- Not associated with an invoice --</option>
                            @foreach($user->invoices()->orderBy('created_at', 'desc')->get() as $inv)
                                <option value="{{ $inv->id }}">{{ $inv->invoice_number }} - ${{ number_format($inv->total, 2) }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer;">
                            <input type="checkbox" name="is_visible_to_client" value="1" checked style="width: 1.125rem; height: 1.125rem; border: 2px solid #cbd5e1; border-radius: 0.25rem;">
                            <span style="font-weight: 600; color: #374151;">Visible to Client</span>
                        </label>
                        <p style="font-size: 0.875rem; color: #64748b; margin-top: 0.25rem; margin-left: 1.625rem;">Uncheck to hide this file from the client</p>
                    </div>

                    <div>
                        <button type="submit" class="btn-dashboard" style="padding: 0.75rem 1.5rem; border: none; cursor: pointer;">
                            Upload File
                        </button>
                    </div>
                </div>
            </form>

            <!-- Files List -->
            @php
                $allFiles = $user->fileUploads()->with(['invoice', 'uploader'])->orderBy('created_at', 'desc')->get();
            @endphp

            @if($allFiles->count() > 0)
                <div style="overflow-x: auto;">
                    <table style="width: 100%; border-collapse: collapse;">
                        <thead>
                            <tr style="background: #f8fafc; border-bottom: 2px solid #e2e8f0;">
                                <th style="padding: 0.75rem; text-align: left; font-size: 0.875rem; font-weight: 600; color: #64748b; text-transform: uppercase; letter-spacing: 0.05em;">File</th>
                                <th style="padding: 0.75rem; text-align: left; font-size: 0.875rem; font-weight: 600; color: #64748b; text-transform: uppercase; letter-spacing: 0.05em;">Description</th>
                                <th style="padding: 0.75rem; text-align: left; font-size: 0.875rem; font-weight: 600; color: #64748b; text-transform: uppercase; letter-spacing: 0.05em;">Invoice</th>
                                <th style="padding: 0.75rem; text-align: left; font-size: 0.875rem; font-weight: 600; color: #64748b; text-transform: uppercase; letter-spacing: 0.05em;">Uploaded By</th>
                                <th style="padding: 0.75rem; text-align: left; font-size: 0.875rem; font-weight: 600; color: #64748b; text-transform: uppercase; letter-spacing: 0.05em;">Date</th>
                                <th style="padding: 0.75rem; text-align: left; font-size: 0.875rem; font-weight: 600; color: #64748b; text-transform: uppercase; letter-spacing: 0.05em;">Size</th>
                                <th style="padding: 0.75rem; text-align: left; font-size: 0.875rem; font-weight: 600; color: #64748b; text-transform: uppercase; letter-spacing: 0.05em;">Visibility</th>
                                <th style="padding: 0.75rem; text-align: right; font-size: 0.875rem; font-weight: 600; color: #64748b; text-transform: uppercase; letter-spacing: 0.05em;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($allFiles as $file)
                                <tr style="border-bottom: 1px solid #e2e8f0;">
                                    <td style="padding: 0.75rem;">
                                        <div style="display: flex; align-items: center; gap: 0.5rem;">
                                            <span style="font-size: 1.5rem;">{{ $file->fileIcon }}</span>
                                            <div>
                                                <div style="font-weight: 600; color: #1e293b; font-size: 0.9375rem;">{{ $file->filename }}</div>
                                                <div style="font-size: 0.75rem; color: #64748b;">{{ $file->mime_type }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td style="padding: 0.75rem;">
                                        <div style="max-width: 250px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; color: #64748b; font-size: 0.875rem;">
                                            {{ $file->description ?: '-' }}
                                        </div>
                                    </td>
                                    <td style="padding: 0.75rem;">
                                        @if($file->invoice)
                                            <a href="{{ route('client.invoices.show', $file->invoice) }}" style="color: #0891b2; text-decoration: none; font-weight: 600; font-size: 0.875rem;">
                                                {{ $file->invoice->invoice_number }}
                                            </a>
                                        @else
                                            <span style="color: #94a3b8; font-size: 0.875rem;">-</span>
                                        @endif
                                    </td>
                                    <td style="padding: 0.75rem; color: #64748b; font-size: 0.875rem;">
                                        {{ $file->uploader->name }}
                                        @if($file->uploader->id !== $user->id)
                                            <span style="color: #0891b2; font-weight: 600;">(Admin)</span>
                                        @endif
                                    </td>
                                    <td style="padding: 0.75rem; color: #64748b; white-space: nowrap; font-size: 0.875rem;">{{ $file->created_at->format('M d, Y') }}</td>
                                    <td style="padding: 0.75rem; color: #64748b; white-space: nowrap; font-size: 0.875rem;">{{ $file->formattedFileSize }}</td>
                                    <td style="padding: 0.75rem;">
                                        <form method="POST" action="{{ route('admin.files.toggle-visibility', $file) }}" style="display: inline;">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" style="background: {{ $file->is_visible_to_client ? '#d1fae5' : '#fee2e2' }}; color: {{ $file->is_visible_to_client ? '#065f46' : '#991b1b' }}; border: none; padding: 0.375rem 0.75rem; border-radius: 0.5rem; font-size: 0.8125rem; font-weight: 600; cursor: pointer;">
                                                {{ $file->is_visible_to_client ? '👁️ Visible' : '🚫 Hidden' }}
                                            </button>
                                        </form>
                                    </td>
                                    <td style="padding: 0.75rem; text-align: right;">
                                        <div style="display: flex; gap: 0.5rem; justify-content: flex-end;">
                                            <a href="{{ route('admin.files.download', $file) }}" style="background: #e0f2fe; color: #0369a1; border: none; padding: 0.5rem 1rem; border-radius: 0.5rem; font-size: 0.8125rem; font-weight: 600; text-decoration: none; display: inline-block;">
                                                Download
                                            </a>
                                            <form action="{{ route('admin.files.delete', $file) }}" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this file?');">
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
                    <p style="font-size: 1.125rem; font-weight: 600; margin-bottom: 0.5rem;">No Files Yet</p>
                    <p style="font-size: 0.9375rem;">No files have been uploaded for this client.</p>
                </div>
            @endif
        </div>
    </div>

    <script>
        function switchTab(tabName) {
            // Hide all tabs
            document.querySelectorAll('.tab-content').forEach(tab => {
                tab.classList.remove('active');
            });

            // Remove active from all buttons
            document.querySelectorAll('.tab-button').forEach(button => {
                button.classList.remove('active');
            });

            // Show selected tab
            document.getElementById(tabName + '-tab').classList.add('active');

            // Add active to clicked button
            event.target.classList.add('active');
        }

        let itemIndex = 1;
        function addInvoiceItem() {
            const container = document.getElementById('invoiceItems');
            const newItem = document.createElement('div');
            newItem.className = 'invoice-item-row';
            newItem.style.cssText = 'display: grid; grid-template-columns: 2fr 1fr 1fr auto; gap: 0.75rem; margin-bottom: 0.75rem;';
            newItem.innerHTML = `
                <input type="text" name="items[${itemIndex}][description]" placeholder="Description" required style="padding: 0.75rem 1rem; border: 1.5px solid #e2e8f0; border-radius: 0.5rem; font-size: 0.9375rem;">
                <input type="number" name="items[${itemIndex}][quantity]" placeholder="Qty" min="1" value="1" required style="padding: 0.75rem 1rem; border: 1.5px solid #e2e8f0; border-radius: 0.5rem; font-size: 0.9375rem;">
                <input type="number" name="items[${itemIndex}][unit_price]" placeholder="Price" step="0.01" min="0" required style="padding: 0.75rem 1rem; border: 1.5px solid #e2e8f0; border-radius: 0.5rem; font-size: 0.9375rem;">
                <button type="button" onclick="removeInvoiceItem(this)" style="background: #fee2e2; color: #dc2626; border: none; padding: 0.75rem; border-radius: 0.5rem; font-weight: 600; cursor: pointer;">×</button>
            `;
            container.appendChild(newItem);
            itemIndex++;
        }

        function removeInvoiceItem(button) {
            const container = document.getElementById('invoiceItems');
            if (container.children.length > 1) {
                button.parentElement.remove();
            } else {
                alert('At least one item is required');
            }
        }
    </script>
</x-app-layout>
