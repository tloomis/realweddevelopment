# Client Management System Documentation

## Overview

This Laravel application includes a comprehensive client management system that allows administrators to manage clients, add notes, send messages, create invoices, and automatically send email notifications.

## Table of Contents

1. [Database Structure](#database-structure)
2. [Models & Relationships](#models--relationships)
3. [Features](#features)
4. [Routes](#routes)
5. [Email Notifications](#email-notifications)
6. [Usage Guide](#usage-guide)
7. [Analytics & Reporting Dashboard](#7-analytics--reporting-dashboard)
8. [Browser Notifications](#8-browser-notifications)
9. [Weekly Email Digests](#9-weekly-email-digests)
10. [Invoice Inquiries & Dispute System](#10-invoice-inquiries--dispute-system)
11. [File Upload System](#11-file-upload-system)
12. [Activity Timeline](#12-activity-timeline)

---

## Database Structure

### Client Notes Table
**File**: `database/migrations/2025_11_13_204039_create_client_notes_table.php`

Internal notes about clients that only admins can see.

```php
Schema::create('client_notes', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained()->onDelete('cascade');
    $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
    $table->text('note');
    $table->timestamps();
});
```

### Client Messages Table
**File**: `database/migrations/2025_11_13_204039_create_client_messages_table.php`

Messages sent from admin to clients with read tracking and email notifications.

```php
Schema::create('client_messages', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained()->onDelete('cascade');
    $table->foreignId('sent_by')->constrained('users')->onDelete('cascade');
    $table->string('subject');
    $table->text('message');
    $table->boolean('read')->default(false);
    $table->timestamps();
});
```

### Invoices Table
**File**: `database/migrations/2025_11_13_204039_create_invoices_table.php`

Invoice header with status workflow and financial tracking.

```php
Schema::create('invoices', function (Blueprint $table) {
    $table->id();
    $table->string('invoice_number')->unique();
    $table->foreignId('user_id')->constrained()->onDelete('cascade');
    $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
    $table->string('status')->default('draft'); // draft, sent, paid, overdue, cancelled
    $table->date('issue_date');
    $table->date('due_date');
    $table->text('notes')->nullable();
    $table->decimal('subtotal', 10, 2);
    $table->decimal('tax_rate', 5, 2)->default(0);
    $table->decimal('tax_amount', 10, 2)->default(0);
    $table->decimal('total', 10, 2);
    $table->date('paid_date')->nullable();
    $table->timestamps();
});
```

### Invoice Items Table
**File**: `database/migrations/2025_11_13_204039_create_invoice_items_table.php`

Line items for each invoice with quantity and pricing.

```php
Schema::create('invoice_items', function (Blueprint $table) {
    $table->id();
    $table->foreignId('invoice_id')->constrained()->onDelete('cascade');
    $table->string('description');
    $table->integer('quantity')->default(1);
    $table->decimal('unit_price', 10, 2);
    $table->decimal('total', 10, 2);
    $table->timestamps();
});
```

---

## Models & Relationships

### User Model
**File**: `app/Models/User.php`

Extended with client management relationships:

```php
// Relationships added
public function notes()
{
    return $this->hasMany(ClientNote::class);
}

public function messages()
{
    return $this->hasMany(ClientMessage::class);
}

public function invoices()
{
    return $this->hasMany(Invoice::class);
}
```

### ClientNote Model
**File**: `app/Models/ClientNote.php`

```php
protected $fillable = ['user_id', 'created_by', 'note'];

public function user()
{
    return $this->belongsTo(User::class);
}

public function creator()
{
    return $this->belongsTo(User::class, 'created_by');
}
```

### ClientMessage Model
**File**: `app/Models/ClientMessage.php`

```php
protected $fillable = ['user_id', 'sent_by', 'subject', 'message', 'read'];

protected $casts = [
    'read' => 'boolean',
];

public function user()
{
    return $this->belongsTo(User::class);
}

public function sender()
{
    return $this->belongsTo(User::class, 'sent_by');
}
```

### Invoice Model
**File**: `app/Models/Invoice.php`

```php
protected $fillable = [
    'invoice_number', 'user_id', 'created_by', 'status',
    'issue_date', 'due_date', 'notes', 'subtotal',
    'tax_rate', 'tax_amount', 'total', 'paid_date'
];

protected $casts = [
    'issue_date' => 'date',
    'due_date' => 'date',
    'paid_date' => 'date',
    'subtotal' => 'decimal:2',
    'tax_rate' => 'decimal:2',
    'tax_amount' => 'decimal:2',
    'total' => 'decimal:2',
];

public function user()
{
    return $this->belongsTo(User::class);
}

public function creator()
{
    return $this->belongsTo(User::class, 'created_by');
}

public function items()
{
    return $this->hasMany(InvoiceItem::class);
}

public function getStatusBadgeAttribute()
{
    return match($this->status) {
        'draft' => ['text' => 'Draft', 'color' => '#64748b'],
        'sent' => ['text' => 'Sent', 'color' => '#0891b2'],
        'paid' => ['text' => 'Paid', 'color' => '#10b981'],
        'overdue' => ['text' => 'Overdue', 'color' => '#ef4444'],
        'cancelled' => ['text' => 'Cancelled', 'color' => '#6b7280'],
        default => ['text' => 'Unknown', 'color' => '#6b7280'],
    };
}
```

### InvoiceItem Model
**File**: `app/Models/InvoiceItem.php`

```php
protected $fillable = [
    'invoice_id', 'description', 'quantity', 'unit_price', 'total'
];

protected $casts = [
    'quantity' => 'integer',
    'unit_price' => 'decimal:2',
    'total' => 'decimal:2',
];

public function invoice()
{
    return $this->belongsTo(Invoice::class);
}
```

---

## Features

### 1. Client Overview
**Route**: `GET /admin/clients/{user}`
**Controller**: `ClientController@show`
**View**: `resources/views/admin/clients/show.blade.php`

A comprehensive client detail page with tabbed interface:

#### Overview Tab
- Activity summary (total notes + messages)
- Total billed amount across all invoices
- Outstanding balance (unpaid invoices)
- Quick action buttons to navigate to other tabs

#### Notes Tab
- Add internal notes about clients
- View all notes with creator name and timestamp
- Delete notes with confirmation
- Notes are private and not visible to clients

#### Messages Tab
- Send messages to clients with subject and body
- Messages are automatically emailed to clients
- Track read/unread status
- Mark messages as read
- View all message history

#### Invoices Tab
- Create new invoices with multiple line items
- Automatic invoice number generation (INV-YYYY-00001 format)
- Calculate subtotals, tax, and totals automatically
- Set issue date and due date
- Add optional notes to invoices
- Update invoice status (draft, sent, paid, overdue, cancelled)
- Delete invoices with confirmation
- Email notifications sent for new invoices and status changes
- **Download invoices as professional PDFs** with branding and complete details

### 2. Invoice Status Workflow

```
draft → sent → paid
         ↓
      overdue
         ↓
    cancelled
```

- **Draft**: Initial state, no email sent
- **Sent**: Invoice sent to client, email notification triggered
- **Paid**: Invoice paid, thank you email sent
- **Overdue**: Past due date, warning email sent
- **Cancelled**: Invoice cancelled, notification email sent

### 3. Enhanced Client Dashboard

**Route**: `GET /client/dashboard`
**Controller**: `Client\DashboardController@index`
**View**: `resources/views/client/dashboard.blade.php`

A comprehensive client portal with enhanced financial tracking and visual analytics:

#### Financial Summary Cards
- **Total Billed**: Gradient teal card showing total amount across all invoices with invoice count
- **Total Paid**: Gradient green card displaying paid amount with paid invoice count
- **Outstanding**: Gradient orange card showing unpaid amount with overdue count
- **Unread Messages**: White card with message count indicator

#### Next Payment Alert
- Prominent alert box showing next upcoming or overdue payment
- Color-coded: blue for upcoming, red for overdue
- Displays invoice number, amount, and due date
- Shows days overdue for overdue invoices
- Direct link to invoice details

#### Payment Statistics
- **Payment Rate**: Visual progress bar showing percentage of invoices paid
- Displays "X of Y invoices paid" for transparency
- Green gradient progress bar with smooth animation
- **Average Invoice**: Large display of average invoice amount
- Based on total invoices count

#### Recent Messages
- Last 5 messages with sender name and timestamp
- Visual "New" badge for unread messages
- Color-coded backgrounds (blue for unread, gray for read)
- Message preview with 150-character limit
- Empty state with icon when no messages

#### Recent Invoices
- Last 5 invoices in responsive table format
- Clickable invoice numbers linking to detail page
- Status badges with color coding
- "View Details" button for each invoice
- Empty state with icon when no invoices

#### Account Information
- Full name, email, account type, member since
- Clean two-column grid layout on desktop
- Badge for client account type

#### Quick Actions
- Edit Profile, Contact Us, View Services
- Icon-based cards with hover effects

### 4. Email Notifications

All emails feature professional branding with the deep teal color scheme (#0891b2).

#### Client Message Email
**Template**: `resources/views/emails/client-message.blade.php`
**Mailable**: `app/Mail/ClientMessageMail.php`

- Subject line matches message subject
- Displays sender name and timestamp
- Full message content
- Call-to-action button to login

#### Invoice Created Email
**Template**: `resources/views/emails/invoice-created.blade.php`
**Mailable**: `app/Mail/InvoiceCreatedMail.php`

- Invoice number and dates
- Complete line item breakdown
- Subtotal, tax, and total calculations
- Status badge with color coding
- Optional invoice notes
- Login button to view details
- **PDF attachment**: Professional invoice PDF automatically attached to email

#### Invoice Status Updated Email
**Template**: `resources/views/emails/invoice-status-updated.blade.php`
**Mailable**: `app/Mail/InvoiceStatusUpdatedMail.php`

- Contextual messaging based on status
- Highlighted status badge
- Payment confirmation (if paid)
- Overdue warnings with red styling (if overdue)
- Amount due information
- Login button for full details
- **PDF attachment**: Professional invoice PDF automatically attached to email

#### Payment Reminder Email
**Template**: `resources/views/emails/payment-reminder.blade.php`
**Mailable**: `app/Mail/PaymentReminderMail.php`

- Warning-styled header with alert icon
- Days overdue calculation and display
- Complete invoice details in red-themed box
- Payment method instructions
- **PDF attachment**: Professional invoice PDF automatically attached to email
- Sent automatically via Artisan command for overdue invoices

### 4. Payment Tracking

When marking an invoice as "paid", admins can record detailed payment information:

**Payment Fields**:
- **Payment Method**: Cash, Check, Credit Card, Bank Transfer, PayPal, or Other
- **Payment Reference**: Transaction ID, check number, or other reference
- **Payment Notes**: Additional payment details or notes
- **Payment Reminder Sent**: Timestamp tracking when last reminder was sent

**Display**:
- Payment details shown in green success box for paid invoices
- Method, reference, and notes displayed for audit trail
- Payment info accessible to both admin and client

### 5. Payment Reminder System

Automated system to send reminder emails for overdue invoices:

**Artisan Command**:
```bash
php artisan invoices:send-reminders
```

**Options**:
- `--days=7`: Send reminders for invoices overdue by specified days (default: 7)

**Behavior**:
- Finds invoices with status 'overdue'
- Checks if due date is at least X days ago
- Only sends if no reminder sent, or last reminder was 7+ days ago
- Updates `payment_reminder_sent_at` timestamp after sending
- Includes PDF invoice attachment
- Displays days overdue in email

**Scheduling** (add to `app/Console/Kernel.php`):
```php
protected function schedule(Schedule $schedule)
{
    // Send payment reminders daily at 9 AM
    $schedule->command('invoices:send-reminders')->dailyAt('09:00');
}
```

### 6. Analytics & Reporting Dashboard

Comprehensive analytics system for tracking revenue, invoices, and client metrics:

**Admin Analytics Dashboard**:
```
Route: GET /admin/analytics
Controller: AnalyticsController@index
View: resources/views/admin/analytics/index.blade.php
```

**Features**:
- **Summary Statistics**:
  - Total revenue from all paid invoices
  - Outstanding balance from sent/overdue invoices
  - Total invoice count
  - Average invoice value
  - Overdue invoice count
  - Total client count

- **Charts** (using Chart.js):
  - **Revenue by Month**: Line chart showing revenue trends over last 12 months
  - **Invoice Status Distribution**: Doughnut chart showing breakdown by status (draft, sent, paid, overdue, cancelled)
  - **Invoices Created per Month**: Bar chart tracking invoice creation trends
  - **Top 10 Clients by Revenue**: Horizontal bar chart showing highest-paying clients

- **Detailed Reports Page**:
  ```
  Route: GET /admin/analytics/reports
  Controller: AnalyticsController@reports
  View: resources/views/admin/analytics/reports.blade.php
  ```

- **Report Types**:
  - **Revenue Report**: All paid invoices with date filtering
  - **Overdue Report**: All overdue invoices sorted by due date
  - **Payment History Report**: Breakdown by payment method with totals

- **Database Compatibility**:
  - Uses database-agnostic SQL functions
  - Supports both SQLite (strftime) and MySQL/PostgreSQL (DATE_FORMAT)
  - Runtime driver detection for cross-database compatibility

**Navigation**: Analytics link added to admin navigation menu

### 7. Browser Notifications

Real-time push notifications for new messages and invoices:

**Files**:
- `resources/js/notifications.js` - NotificationManager class
- `app/Http/Controllers/Api/NotificationController.php` - API endpoints
- `routes/api.php` - Notification API routes

**Features**:
- **Permission Management**: Request browser notification permissions
- **30-Second Polling**: Automatically checks for new activity every 30 seconds
- **Notification Types**:
  - New messages with sender name and subject
  - New invoices with invoice number and amount
- **API Endpoints**:
  - `GET /api/notifications/check` - Check for new activity since last check
  - `GET /api/notifications/unread-count` - Get count of unread messages

**Client Dashboard Integration**:
- "Enable Notifications" button on dashboard
- Visual feedback when notifications are enabled
- Automatic polling starts after enabling

**NotificationManager Class**:
```javascript
class NotificationManager {
    async requestPermission()    // Request browser permissions
    showNotification(title, body) // Display notification
}
```

### 8. Weekly Email Digests

Automated weekly summary emails for clients:

**Artisan Command**:
```bash
php artisan digests:send-weekly
```

**File**: `app/Console/Commands/SendWeeklyDigests.php`

**Features**:
- **Activity Summary**:
  - Total messages received this week
  - New invoices created this week
  - Total amount paid this week
  - Outstanding balance
  - Overdue invoice count
  - Unread message count

- **Recent Activity List**:
  - Last 5 messages with subjects and timestamps
  - Last 5 invoices with numbers, amounts, and statuses

- **Action Items**:
  - Pay overdue invoices
  - Read unread messages
  - Review new invoices

- **Smart Skipping**:
  - Only sends digest if client has activity:
    - New messages in past week
    - New invoices in past week
    - Overdue invoices
    - Unread messages
  - Skips clients with no activity to avoid spam

**Email Template**: `resources/views/emails/weekly-digest.blade.php`
**Mailable**: `app/Mail/WeeklyDigestMail.php`

**Scheduling** (add to `app/Console/Kernel.php`):
```php
protected function schedule(Schedule $schedule)
{
    // Send weekly digests every Monday at 8 AM
    $schedule->command('digests:send-weekly')->weeklyOn(1, '08:00');
}
```

### 9. Stripe Payment Integration

Secure online payment processing for invoices:

**Controllers**:
- `app/Http/Controllers/Client/PaymentController.php`

**Routes**:
```php
GET  /client/invoices/{invoice}/payment          -> PaymentController@show
POST /client/invoices/{invoice}/payment/checkout -> PaymentController@createCheckoutSession
GET  /client/invoices/{invoice}/payment/success  -> PaymentController@success
GET  /client/invoices/{invoice}/payment/cancel   -> PaymentController@cancel
```

**Configuration** (`.env`):
```env
STRIPE_KEY=pk_test_your_publishable_key_here
STRIPE_SECRET=sk_test_your_secret_key_here
STRIPE_WEBHOOK_SECRET=whsec_your_webhook_secret_here
```

**Configuration File**: `config/services.php`
```php
'stripe' => [
    'key' => env('STRIPE_KEY'),
    'secret' => env('STRIPE_SECRET'),
    'webhook_secret' => env('STRIPE_WEBHOOK_SECRET'),
],
```

**Features**:
- **Secure Checkout Sessions**: Stripe handles all payment details
- **Payment Flow**:
  1. Client clicks "Pay Now" button on invoice
  2. Redirected to payment page with invoice summary
  3. Clicks "Pay $X.XX Now" to initiate Stripe Checkout
  4. Redirected to Stripe's hosted payment page
  5. Completes payment on Stripe's secure platform
  6. Redirected back to success page with confirmation

- **Automatic Updates**:
  - Invoice status changed to "paid"
  - Payment date recorded
  - Payment method set to "Credit Card"
  - Stripe transaction ID stored as payment reference

- **Payment Success Page**:
  - Shows payment confirmation
  - Displays transaction details
  - Payment date, method, transaction ID
  - Links to view invoice or download PDF receipt

**Security**:
- No sensitive card data handled by application
- All payment processing on Stripe's PCI-compliant servers
- HTTPS required for production
- CSRF protection on all forms

**Views**:
- `resources/views/client/payment/show.blade.php` - Payment page
- `resources/views/client/payment/success.blade.php` - Success confirmation
- `resources/views/client/invoice.blade.php` - Updated with "Pay Now" button

**Dependencies**:
- `stripe/stripe-php` package (installed via Composer)

---

## Routes

**File**: `routes/web.php`

### Admin Routes (Prefix: `/admin`, Middleware: `auth`, `admin`)

```php
// Client Management
GET    /admin/clients/{user}                 -> ClientController@show
POST   /admin/clients/{user}/impersonate     -> ClientController@impersonate

// Client Notes
POST   /admin/clients/{user}/notes           -> ClientController@storeNote
DELETE /admin/notes/{note}                   -> ClientController@deleteNote

// Client Messages
POST   /admin/clients/{user}/messages        -> ClientController@storeMessage
PATCH  /admin/messages/{message}/read        -> ClientController@markMessageAsRead

// Client Invoices
POST   /admin/clients/{user}/invoices        -> ClientController@storeInvoice
PATCH  /admin/invoices/{invoice}/status      -> ClientController@updateInvoiceStatus
DELETE /admin/invoices/{invoice}             -> ClientController@deleteInvoice
GET    /admin/invoices/{invoice}/pdf         -> ClientController@downloadInvoicePdf

// Analytics & Reports
GET    /admin/analytics                      -> AnalyticsController@index
GET    /admin/analytics/reports              -> AnalyticsController@reports
```

### Client Routes (Prefix: `/client`, Middleware: `auth`)

```php
// Client Portal
GET    /client/dashboard                     -> DashboardController@index
GET    /client/invoices/{invoice}            -> DashboardController@showInvoice
GET    /client/invoices/{invoice}/pdf        -> DashboardController@downloadInvoicePdf

// Payments
GET    /client/invoices/{invoice}/payment          -> PaymentController@show
POST   /client/invoices/{invoice}/payment/checkout -> PaymentController@createCheckoutSession
GET    /client/invoices/{invoice}/payment/success  -> PaymentController@success
GET    /client/invoices/{invoice}/payment/cancel   -> PaymentController@cancel
```

### API Routes (Prefix: `/api`, Middleware: `auth:web`)

```php
// Notifications
GET    /api/notifications/check              -> NotificationController@check
GET    /api/notifications/unread-count       -> NotificationController@unreadCount
```

---

## Email Notifications

### Configuration

Email settings are configured in `.env`:

```env
MAIL_MAILER=smtp
MAIL_HOST=127.0.0.1
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="noreply@realwebdevelopment.com"
MAIL_FROM_NAME="Real Web Development"
```

### Local Testing with Mailhog

1. Install Mailhog:
   ```bash
   # macOS
   brew install mailhog

   # Or download from: https://github.com/mailhog/MailHog
   ```

2. Start Mailhog:
   ```bash
   mailhog
   ```

3. View emails at: http://localhost:8025

### Testing with Log Driver

For quick testing without SMTP, change `.env`:

```env
MAIL_MAILER=log
```

Emails will be written to `storage/logs/laravel.log`

### Production Setup

For production, update `.env` with your SMTP provider:

**Gmail Example**:
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="noreply@realwebdevelopment.com"
MAIL_FROM_NAME="Real Web Development"
```

**SendGrid/Mailgun/SES**: Configure according to provider documentation

---

## PDF Invoice Generation

### Overview

The system includes professional PDF invoice generation using the `barryvdh/laravel-dompdf` package (v3.1). Both admins and clients can download invoices as PDFs, and PDFs are automatically attached to all invoice-related emails.

### Email Attachments

**Files**:
- `app/Mail/InvoiceCreatedMail.php`
- `app/Mail/InvoiceStatusUpdatedMail.php`

Both email classes automatically generate and attach invoice PDFs:

```php
public function attachments(): array
{
    // Generate PDF
    $pdf = Pdf::loadView('pdfs.invoice', ['invoice' => $this->invoice]);

    // Attach PDF with invoice number as filename
    return [
        Attachment::fromData(fn () => $pdf->output(), $this->invoice->invoice_number . '.pdf')
            ->withMime('application/pdf'),
    ];
}
```

When an invoice is created or its status is updated, the client receives an email with a professional PDF invoice attached.

### PDF Template

**File**: `resources/views/pdfs/invoice.blade.php`

The PDF template features a professional, print-ready design optimized for file size:

**Header Section**:
- Professional logo box with "RW" branding in deep teal (#0891b2)
- Company name and tagline
- Contact information
- Clean border separator

**Invoice Details**:
- Large, bold "INVOICE" title with invoice number
- Color-coded status badge
- Prominent total amount display in gray box
- Two-column layout for Bill To and Invoice Details
- Issue date, due date, and paid date (if applicable)

**Line Items Table**:
- Teal header with white text
- Alternating row colors for readability
- Columns: Description, Quantity, Unit Price, Total
- Clean borders and spacing

**Totals Section**:
- Bordered box for professional appearance
- Subtotal breakdown
- Tax calculation with rate
- Grand total highlighted in teal

**Status-Based Sections**:
- **Paid invoices**: Green "✓ PAID" stamp with payment date
- **Sent invoices**: Blue payment information box with contact details
- **Overdue invoices**: Red warning text with due date notice
- **Draft/Cancelled**: No additional section

**Footer**:
- Company branding
- Contact information
- Thank you message

**Technical Features**:
- Inline CSS for PDF compatibility
- Table-based layouts for DomPDF stability
- DejaVu Sans font (built into DomPDF)
- Optimized file size (~1,250 KB average)
- No gradients (DomPDF limitation)
- Solid colors with borders for visual depth

### Controllers

**Admin PDF Download** (`app/Http/Controllers/Admin/ClientController.php:300-310`):
```php
public function downloadInvoicePdf(Invoice $invoice)
{
    // Load relationships
    $invoice->load(['user', 'items']);

    // Generate PDF
    $pdf = Pdf::loadView('pdfs.invoice', compact('invoice'));

    // Download with filename
    return $pdf->download($invoice->invoice_number . '.pdf');
}
```

**Client PDF Download** (`app/Http/Controllers/Client/DashboardController.php:71-86`):
```php
public function downloadInvoicePdf(Invoice $invoice)
{
    // Ensure the invoice belongs to the authenticated client
    if ($invoice->user_id !== auth()->id()) {
        abort(403, 'Unauthorized access to invoice.');
    }

    // Load relationships
    $invoice->load(['user', 'items']);

    // Generate PDF
    $pdf = Pdf::loadView('pdfs.invoice', compact('invoice'));

    // Download with filename
    return $pdf->download($invoice->invoice_number . '.pdf');
}
```

### Security

- **Admin access**: No restrictions - admins can download any invoice
- **Client access**: Authorization check ensures clients can only download their own invoices
- **403 Forbidden**: Returned if client attempts to access another client's invoice

### Usage

**For Admins**:
1. Navigate to client detail page
2. Go to Invoices tab
3. Click the "PDF" button next to any invoice
4. Invoice downloads automatically with filename: `INV-YYYY-00001.pdf`

**For Clients**:
1. Login to client dashboard
2. Click on any invoice from the Recent Invoices table
3. Click the "Download PDF" button in the invoice header
4. Invoice downloads automatically

### PDF Styling & Optimization

- **Fonts**: DejaVu Sans (included with DomPDF)
- **Layout**: Table-based for better PDF compatibility
- **Colors**: Deep teal (#0891b2) for branding, status-specific colors
- **File Size**: Optimized to ~1,250 KB per invoice (45% reduction from initial design)
- **Format**: Optimized for printing on standard letter/A4 paper
- **Spacing**: Reduced margins and padding for optimal file size
- **Line Heights**: Balanced for readability and efficiency (1.5-1.6)
- **Border Radius**: Moderate rounding (6-10px) for modern look without excess code

### Optimization Techniques

The PDF template has been optimized for file size while maintaining professional appearance:

1. **Reduced Spacing**: Page padding reduced from 40px to 35px
2. **Compact Typography**: Line-height reduced from 1.7 to 1.5-1.6
3. **Smaller Margins**: Section margins reduced by 10-20%
4. **Efficient Borders**: Simplified border styling
5. **Removed Redundancies**: Eliminated duplicate CSS properties
6. **Font Size Reduction**: Slightly smaller fonts where appropriate
7. **Simplified Decorative Elements**: Reduced letter-spacing and other visual enhancements

These optimizations reduced the average PDF size from ~2,264 KB to ~1,249 KB (45% reduction) while preserving the professional design quality.

---

## Usage Guide

### Accessing Client Management

1. Login as admin user
2. Navigate to Admin Dashboard
3. Click on any client name or "View Details" button
4. You'll see the client detail page with four tabs

### Adding a Note

1. Go to the Notes tab
2. Enter your note in the textarea
3. Click "Add Note"
4. Note is saved with your name and timestamp

### Sending a Message

1. Go to the Messages tab
2. Enter subject and message
3. Click "Send Message"
4. Message is saved AND emailed to the client immediately
5. Success message confirms email was sent

### Creating an Invoice

1. Go to the Invoices tab
2. Fill in the invoice form:
   - Issue Date (defaults to today)
   - Due Date (defaults to 30 days from today)
   - Tax Rate (percentage)
   - Optional notes
3. Add line items:
   - Description
   - Quantity
   - Unit Price
   - Click "+ Add Item" for more items
4. Click "Create Invoice"
5. Invoice is created as "draft" status
6. Email is sent to client immediately

### Updating Invoice Status

1. Find the invoice in the Invoices tab
2. Use the status dropdown to select new status
3. If marking as paid, enter the paid date
4. Click "Update"
5. Status is updated and email notification sent (unless changing to/from draft)

### Invoice Number Format

Invoices are automatically numbered:
- Format: `INV-YYYY-00001`
- Year updates automatically
- Sequential numbering starting from 00001

### Financial Calculations

All calculations are automatic:
1. **Line Item Total** = Quantity × Unit Price
2. **Subtotal** = Sum of all line item totals
3. **Tax Amount** = Subtotal × (Tax Rate / 100)
4. **Total** = Subtotal + Tax Amount

---

## Design & Branding

### Color Scheme

- **Primary**: #0891b2 (Deep Teal)
- **Primary Dark**: #0e7490
- **Success**: #10b981 (Green)
- **Warning**: #f59e0b (Amber)
- **Danger**: #ef4444 (Red)
- **Text**: #334155 (Slate)

### Typography

- **Font Family**: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif
- **Headers**: Bold, larger sizing
- **Body**: 16px base size, 1.6 line height

### UI Components

- **Tabs**: Clean, modern tabbed interface
- **Buttons**: Gradient backgrounds with hover effects
- **Cards**: Rounded corners, subtle shadows
- **Tables**: Alternating row colors, responsive design
- **Forms**: Clear labels, validation feedback
- **Status Badges**: Color-coded, rounded pills

---

## Security Features

1. **Authentication Required**: All routes protected by auth middleware
2. **Admin Authorization**: Only admin users can access client management
3. **CSRF Protection**: All forms include CSRF tokens
4. **SQL Injection Prevention**: Eloquent ORM with parameter binding
5. **Mass Assignment Protection**: Fillable properties defined on models
6. **Foreign Key Constraints**: Cascade deletes maintain data integrity
7. **Input Validation**: All user input validated before processing

---

## Data Integrity

1. **Cascade Deletes**:
   - Deleting a client deletes all their notes, messages, and invoices
   - Deleting an invoice deletes all its line items

2. **Relationships**:
   - All foreign keys properly constrained
   - Creator/sender tracking for audit trail

3. **Type Casting**:
   - Dates properly cast to Carbon instances
   - Decimals cast for accurate financial calculations
   - Booleans cast for read status

---

## Future Enhancements

### Completed Features ✓

The following features have been implemented:
- ✅ **Payment Integration**: Stripe Checkout for online invoice payment
- ✅ **Notifications**: Browser push notifications and weekly email digests
- ✅ **Reports**: Analytics dashboard with charts and detailed financial reports
- ✅ **Invoice Reminders**: Automated payment reminders for overdue invoices

### Pending Features

Features planned for future development:

1. **Invoice Dispute/Inquiry System**: Allow clients to submit questions or disputes about invoices
2. **File Upload Functionality**: Enable clients to upload documents and files
3. **Activity Timeline**: Chronological activity history on client portal
4. **Recurring Invoices**: Automatic invoice generation on schedule
5. **Email Templates**: Customizable email templates for different scenarios
6. **Multi-currency**: Support for different currencies
7. **Two-way Messaging**: Allow clients to reply to admin messages
8. **Time Tracking**: Log billable hours and convert to invoices

---

## Troubleshooting

### Emails Not Sending

1. Check `.env` mail configuration
2. Verify Mailhog is running (if using local testing)
3. Check `storage/logs/laravel.log` for errors
4. Ensure `MAIL_FROM_ADDRESS` is valid

### Invoice Calculations Wrong

1. Verify tax_rate is entered as percentage (not decimal)
2. Check that item quantities and prices are positive numbers
3. Ensure database columns use decimal(10,2) precision

### Client Not Showing

1. Verify user has `role` set to 'client'
2. Check that admin middleware is applied to routes
3. Ensure user is authenticated as admin

---

## Support

For issues or questions:
- Check the Laravel logs: `storage/logs/laravel.log`
- Review database migrations are run: `php artisan migrate:status`
- Clear cache if needed: `php artisan cache:clear`

---

## Recent Additions

**November 14, 2025** - Added the following major features:
- **Analytics & Reporting Dashboard** with Chart.js visualizations
- **Browser Notifications** with real-time polling for new messages/invoices
- **Weekly Email Digests** with smart activity-based sending
- **Stripe Payment Integration** for secure online invoice payments

See the main [README.md](README.md) for complete feature list and recent updates.

---

## 10. Invoice Inquiries & Dispute System

### Overview

Clients can submit questions or disputes directly on invoices, and admins can respond with status tracking.

### Database Structure

**File**: `database/migrations/2025_11_15_140517_create_invoice_inquiries_table.php`

```php
Schema::create('invoice_inquiries', function (Blueprint $table) {
    $table->id();
    $table->foreignId('invoice_id')->constrained()->onDelete('cascade');
    $table->foreignId('user_id')->constrained()->onDelete('cascade');
    $table->string('subject');
    $table->text('message');
    $table->string('status')->default('open'); // open, in_progress, resolved
    $table->text('admin_response')->nullable();
    $table->foreignId('responded_by')->nullable()->constrained('users')->onDelete('set null');
    $table->timestamp('responded_at')->nullable();
    $table->timestamps();
});
```

### Model

**File**: `app/Models/InvoiceInquiry.php`

```php
public function invoice()
{
    return $this->belongsTo(Invoice::class);
}

public function user()
{
    return $this->belongsTo(User::class);
}

public function responder()
{
    return $this->belongsTo(User::class, 'responded_by');
}

public function getStatusBadgeAttribute()
{
    return match($this->status) {
        'open' => ['text' => 'Open', 'color' => '#0891b2'],
        'in_progress' => ['text' => 'In Progress', 'color' => '#f59e0b'],
        'resolved' => ['text' => 'Resolved', 'color' => '#10b981'],
        default => ['text' => 'Unknown', 'color' => '#6b7280'],
    };
}
```

### Client Interface

**Inquiry Form on Invoice Page**
- Form at bottom of `client/invoice.blade.php`
- Subject and message fields
- Lists existing inquiries with status badges
- Shows admin responses when available

### Admin Interface

**Inquiries Tab** (`admin/clients/show.blade.php`)
- Shows all client inquiries
- Displays client question and invoice number
- Response form with status dropdown
- Records responder and timestamp

### Email Notifications

**InquirySubmittedMail** - Sent to all admins when client submits inquiry
**InquiryRespondedMail** - Sent to client when admin responds

### Routes

```php
// Client routes
Route::post('/invoices/{invoice}/inquiries', [ClientDashboardController::class, 'storeInquiry'])
    ->name('invoices.inquiries.store');

// Admin routes
Route::post('/inquiries/{inquiry}/respond', [ClientController::class, 'respondToInquiry'])
    ->name('inquiries.respond');
```

---

## 11. File Upload System

### Overview

Clients and admins can upload documents and files, associate them with invoices, and control visibility.

### Database Structure

**File**: `database/migrations/2025_11_17_130735_create_file_uploads_table.php`

```php
Schema::create('file_uploads', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained()->onDelete('cascade');
    $table->foreignId('uploaded_by')->constrained('users')->onDelete('cascade');
    $table->foreignId('invoice_id')->nullable()->constrained()->onDelete('cascade');
    $table->string('filename'); // Original filename
    $table->string('stored_filename'); // Unique filename in storage
    $table->string('file_path'); // Full path in storage
    $table->unsignedBigInteger('file_size'); // Size in bytes
    $table->string('mime_type');
    $table->text('description')->nullable();
    $table->boolean('is_visible_to_client')->default(true);
    $table->timestamps();
});
```

### Model

**File**: `app/Models/FileUpload.php`

```php
public function user()
{
    return $this->belongsTo(User::class);
}

public function uploader()
{
    return $this->belongsTo(User::class, 'uploaded_by');
}

public function invoice()
{
    return $this->belongsTo(Invoice::class);
}

public function getFormattedFileSizeAttribute()
{
    // Returns human-readable file size (KB, MB, GB)
}

public function getFileIconAttribute()
{
    // Returns emoji icon based on MIME type
}

protected static function booted()
{
    // Automatically deletes file from storage when record is deleted
}
```

### Client Interface

**My Files Section** (`client/dashboard.blade.php`)
- Upload form with file input, description, and invoice association
- Table showing all visible files
- Download and delete actions
- File type icons and formatted sizes

### Admin Interface

**Files Tab** (`admin/clients/show.blade.php`)
- Upload files on behalf of clients
- Toggle visibility to client
- See who uploaded each file
- Download and delete actions
- Associate files with specific invoices

### File Storage

- Files stored in `storage/app/uploads/`
- Unique filenames using UUID
- Max size: 10MB
- Supported formats: PDF, DOC, DOCX, XLS, XLSX, PNG, JPG, JPEG, ZIP, RAR

### Routes

```php
// Client routes
Route::post('/files/upload', [ClientDashboardController::class, 'uploadFile'])
    ->name('files.upload');
Route::get('/files/{file}/download', [ClientDashboardController::class, 'downloadFile'])
    ->name('files.download');
Route::delete('/files/{file}', [ClientDashboardController::class, 'deleteFile'])
    ->name('files.delete');

// Admin routes
Route::post('/clients/{user}/files/upload', [ClientController::class, 'uploadFileForClient'])
    ->name('files.upload');
Route::get('/files/{file}/download', [ClientController::class, 'downloadFileAdmin'])
    ->name('files.download');
Route::delete('/files/{file}', [ClientController::class, 'deleteFileAdmin'])
    ->name('files.delete');
Route::patch('/files/{file}/toggle-visibility', [ClientController::class, 'toggleFileVisibility'])
    ->name('files.toggle-visibility');
```

---

## 12. Activity Timeline

### Overview

Chronological timeline on client dashboard showing all activity: messages, invoices, file uploads, and inquiries.

### Implementation

**Location**: `client/dashboard.blade.php` - Activity Timeline section

### Features

- **Combines Multiple Data Sources**
  - Messages received
  - Invoice status changes
  - File uploads/receipts
  - Inquiry submissions and responses

- **Visual Timeline**
  - Color-coded dots and icons
  - Timeline line connecting events
  - Relative timestamps ("2 hours ago")
  - Absolute timestamps (formatted date/time)

- **Activity Types**
  - 💬 Messages (cyan)
  - 📄 Invoices (purple)
  - 📎 Files (green)
  - ❓ Inquiries (amber)

- **Smart Sorting**
  - Automatically sorts by timestamp descending
  - Limited to 15 most recent activities
  - Optimized for performance

### Code Example

```php
$activities = collect();

// Add messages
foreach($user->messages as $message) {
    $activities->push([
        'type' => 'message',
        'icon' => '💬',
        'color' => '#0891b2',
        'title' => 'New Message',
        'description' => 'Received message: ' . $message->subject,
        'timestamp' => $message->created_at,
    ]);
}

// Sort and limit
$activities = $activities->sortByDesc('timestamp')->take(15);
```

---

**Last Updated**: November 17, 2025
**Laravel Version**: 12.x
**PHP Version**: 8.2+
