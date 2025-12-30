# Real Web Development - Laravel Portfolio

A modern, professional portfolio website built with Laravel, showcasing web development expertise and services with a fully functional contact form that sends emails.

## Features

### Core Features
- **Modern Laravel Backend**: Built on Laravel 12 with proper MVC architecture
- **Authentication System**: Complete Laravel Breeze integration with role-based access control
- **Email Contact Form**: AJAX-powered contact form with real-time validation
- **Form Validation**: Server-side validation with CSRF protection
- **Responsive Design**: Optimized for all devices (desktop, tablet, mobile)
- **Smooth Animations**: Intersection Observer API for scroll-based animations
- **SEO Friendly**: Semantic HTML and meta tags for better search visibility

### Portfolio Showcase
- **Resume-Based Content**: 5 comprehensive project cards from actual experience
- **Horizontal Scrolling**: Modern carousel-style portfolio section
- **Gradient Design**: Beautiful gradient backgrounds (no images needed)
- **Leadership Roles**: CTO, Director, and Manager positions highlighted
- **Impact Metrics**: Key achievements and statistics displayed
- **Technology Tags**: Interactive tag clouds for each project

### Authentication & Dashboards
- **Role-Based Access**: Admin and Client user roles with middleware protection
- **Admin Dashboard**: Client management with modal-based creation, system statistics
- **User Impersonation**: Admins can login as any client user for support/troubleshooting
- **Client Dashboard**: Personalized account information and quick actions
- **Profile Management**: Fully themed settings page (edit profile, change password, delete account)
- **Secure Routes**: Middleware protection for admin areas
- **Admin-Only Registration**: Public registration disabled, only admins can create accounts

### Client Management System
- **Comprehensive Client Details**: Tabbed interface with Overview, Notes, Messages, Invoices, Inquiries, and Files
- **Internal Notes**: Add private notes about clients with creator tracking and timestamps
- **Client Messaging**: Send messages to clients with subject/body and automatic email delivery
- **Invoice Management**: Create detailed invoices with multiple line items and automatic calculations
- **Invoice Status Workflow**: Track invoices through draft, sent, paid, overdue, and cancelled states
- **Invoice Inquiries**: Clients can submit questions or disputes directly on invoices with status tracking (Open → In Progress → Resolved)
- **Two-Way Communication**: Admin responses to inquiries sent via email with full conversation history
- **File Upload System**: Clients and admins can upload documents (PDF, DOC, DOCX, XLS, XLSX, PNG, JPG, ZIP)
- **File Management**: Upload files for clients, toggle visibility, associate with invoices, track uploader
- **File Organization**: Files can be linked to specific invoices for better organization
- **Activity Timeline**: Chronological timeline showing all client activity (messages, invoices, files, inquiries)
- **Payment Tracking**: Record payment method, transaction reference, and payment notes
- **Payment Reminders**: Automated system to send reminder emails for overdue invoices
- **Automatic Invoice Numbering**: Generate sequential invoice numbers (INV-YYYY-00001 format)
- **Financial Calculations**: Auto-calculate subtotals, tax amounts, and totals
- **Email Notifications**: Professional branded emails for messages, invoice updates, inquiries, and payment reminders with PDF attachments
- **PDF Invoice Generation**: Download professional branded invoice PDFs with complete details
- **PDF Email Attachments**: Invoice PDFs automatically attached to all invoice emails (~1,250 KB optimized)
- **Enhanced Client Portal**: Financial dashboard with stats, payment rate, average invoice, next payment alerts, file uploads, activity timeline
- **Visual Analytics**: Progress bars, gradient cards, and statistics for better financial tracking
- **Read Tracking**: Monitor which messages clients have read
- **Audit Trail**: Track who created notes, sent messages, invoices, and uploaded files

### Analytics & Reporting
- **Admin Analytics Dashboard**: Comprehensive analytics with Chart.js visualizations
- **Revenue by Month**: Line chart showing revenue trends over last 12 months
- **Invoice Status Distribution**: Doughnut chart showing breakdown by status
- **Invoices Created per Month**: Bar chart tracking invoice creation trends
- **Top Clients by Revenue**: Horizontal bar chart showing top 10 clients
- **Summary Statistics**: Total revenue, outstanding balance, invoice counts, average invoice value
- **Detailed Reports**: Revenue reports, overdue reports, payment history reports with date filtering
- **Database-Agnostic SQL**: Supports both SQLite and MySQL/PostgreSQL for analytics queries

### Notification Features
- **Browser Notifications**: Push notifications for new messages and invoices
- **Permission Management**: Request and manage browser notification permissions
- **Real-time Polling**: 30-second polling for new activity
- **Weekly Email Digests**: Automated weekly summary emails with activity highlights
- **Smart Skipping**: Digest emails only sent when there's relevant activity
- **Customizable Scheduling**: Configurable digest sending via Artisan command

### Payment Integration
- **Stripe Checkout**: Secure payment processing via Stripe Checkout Sessions
- **Client Payment Portal**: Dedicated payment page with invoice summary
- **Payment Success Page**: Confirmation page with transaction details
- **Automatic Status Updates**: Invoice status automatically updated to "paid" on successful payment
- **Payment Method Tracking**: Stripe payment method and transaction reference recorded
- **Secure Processing**: No sensitive card data handled by application

### Design
- **Deep Teal Theme**: Professional, modern color scheme (#0891b2) throughout all pages
- **Text-Based Logo**: "RealWebDevelopment" with highlighted "Web" in Deep Teal
- **Clean Expertise Section**: 2-column layout with gradient cards
- **Compact Portfolio Cards**: Shorter, cleaner cards with essential info only
- **Modal Overlays**: Animated modals for client creation and account deletion
- **Custom Scrollbars**: Styled scrollbars matching the theme
- **Hover Effects**: Smooth transitions and lift effects throughout
- **Consistent Styling**: All forms and inputs use Deep Teal focus states

## Tech Stack

### Backend
- **Laravel 12**: PHP framework for robust backend
- **SQLite**: Default database (easily switchable to MySQL/PostgreSQL)
- **Laravel Mail**: Email sending functionality
- **DomPDF**: PDF generation for invoices
- **Stripe PHP SDK**: Payment processing integration

### Frontend
- **HTML5**: Semantic markup
- **CSS3**: Modern styling with custom properties
- **JavaScript (ES6+)**: Interactive features
- **Chart.js**: Data visualization and analytics charts
- **Browser Notification API**: Push notifications
- **Google Fonts**: Inter font family

## Installation

### Prerequisites

- PHP >= 8.2
- Composer
- Node.js & NPM (optional, for asset compilation)

### Setup Instructions

1. **Navigate to project directory:**
   ```bash
   cd /Users/tloomis/Documents/GitHub/realwebdevelopment-laravel
   ```

2. **Install PHP dependencies:**
   ```bash
   composer install
   ```

3. **Environment is already configured** - `.env` file already exists with app key generated

4. **Database is ready** - SQLite database is already created and migrated

5. **Configure mail settings (IMPORTANT - see Mail Configuration section below)**

6. **Configure Stripe (OPTIONAL - for payment processing):**
   - Sign up at [Stripe Dashboard](https://dashboard.stripe.com)
   - Get your API keys from the Dashboard
   - Update `.env` with your keys:
   ```env
   STRIPE_KEY=pk_test_your_publishable_key_here
   STRIPE_SECRET=sk_test_your_secret_key_here
   STRIPE_WEBHOOK_SECRET=whsec_your_webhook_secret_here
   ```

7. **Start the development server:**
   ```bash
   php artisan serve
   ```

8. **Visit the site:**
   Open [http://127.0.0.1:8000](http://127.0.0.1:8000) in your browser

## Mail Configuration

**Current Status**: Mail is already configured for local testing with Mailhog on port 1025.

The contact form and client management system (messages & invoices) send emails using the configured mail driver.

### Current Configuration (Mailhog - Local Testing)

Already configured in `.env`:
```env
MAIL_MAILER=smtp
MAIL_HOST=127.0.0.1
MAIL_PORT=1025
MAIL_FROM_ADDRESS="noreply@realwebdevelopment.com"
MAIL_FROM_NAME="Real Web Development"
```

To view emails:
1. Start Mailhog: `mailhog`
2. View at: http://localhost:8025
3. Install: `brew install mailhog` (Mac)

### Option 1: Using Gmail (Development)

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-specific-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your-email@gmail.com
MAIL_FROM_NAME="${APP_NAME}"
```

**Note:** For Gmail, you need to:
1. Enable 2-factor authentication
2. Generate an [App Password](https://myaccount.google.com/apppasswords)
3. Use the App Password instead of your regular password

### Option 2: Using Mailtrap (Testing - RECOMMENDED)

For testing emails without sending real ones:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your-mailtrap-username
MAIL_PASSWORD=your-mailtrap-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=hello@realwebdevelopment.com
MAIL_FROM_NAME="${APP_NAME}"
```

Sign up at [Mailtrap.io](https://mailtrap.io) to get your credentials.

### Option 3: Using Mailgun (Production)

```env
MAIL_MAILER=mailgun
MAILGUN_DOMAIN=your-domain.mailgun.org
MAILGUN_SECRET=your-mailgun-api-key
MAILGUN_ENDPOINT=api.mailgun.net
MAIL_FROM_ADDRESS=hello@realwebdevelopment.com
MAIL_FROM_NAME="${APP_NAME}"
```

### Option 4: Using SendGrid (Production)

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.sendgrid.net
MAIL_PORT=587
MAIL_USERNAME=apikey
MAIL_PASSWORD=your-sendgrid-api-key
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=hello@realwebdevelopment.com
MAIL_FROM_NAME="${APP_NAME}"
```

### Option 5: Log Emails (Development Only)

To preview emails without sending them:

```env
MAIL_MAILER=log
```

Emails will be logged to `storage/logs/laravel.log`

## Customization

### Enable/Disable Headshot

**Status**: Headshot is currently commented out in the hero section

To enable the headshot:
1. Edit [resources/views/home.blade.php](resources/views/home.blade.php) around line 41-44
2. Uncomment the `hero-profile` div
3. Ensure `public/images/todd-loomis-headshot.jpg` exists

### Update Contact Information

Edit [resources/views/home.blade.php](resources/views/home.blade.php):

- **Email address** (line ~282): Update the contact email
- **LinkedIn** (line ~289): Add your LinkedIn profile URL
- **GitHub** (line ~296): Add your GitHub profile URL

### Change Statistics

Edit [resources/views/home.blade.php](resources/views/home.blade.php) lines 58-68 to update:
- Years of experience
- Projects completed
- Happy clients

### Update Services

Edit the services section in [resources/views/home.blade.php](resources/views/home.blade.php) starting at line ~83.

### Add Your Technologies

Edit the expertise section in [resources/views/home.blade.php](resources/views/home.blade.php) starting at line ~156.

### Customize Colors

**Current Theme**: Deep Teal (Professional, Modern, Tech-Forward)

Edit [public/css/styles.css](public/css/styles.css) CSS variables (lines 11-17):

```css
:root {
    /* Color Palette - Deep Teal Theme */
    --primary: #0891b2;        /* Main brand color - Deep Teal */
    --primary-dark: #0e7490;   /* Darker shade */
    --primary-light: #06b6d4;  /* Lighter shade */
    --secondary: #14b8a6;      /* Secondary color - Turquoise */
    --accent: #f59e0b;         /* Accent color - Amber */
}
```

**Alternative Professional Color Themes:**

- **Rich Purple**: `--primary: #7c3aed` (Creative, Innovative, Premium)
- **Forest Green**: `--primary: #059669` (Growth, Stability, Eco-Friendly)
- **Deep Blue**: `--primary: #2563eb` (Trust, Corporate, Traditional)
- **Slate Gray**: `--primary: #475569` (Sophisticated, Timeless, Minimalist)
- **Deep Indigo**: `--primary: #4338ca` (Wisdom, Professional, Corporate)

## Project Structure

```
realwebdevelopment-laravel/
├── app/
│   ├── Console/
│   │   └── Commands/
│   │       └── SendWeeklyDigests.php              # Weekly digest command
│   ├── Http/
│   │   └── Controllers/
│   │       ├── ContactController.php              # Handles contact form
│   │       ├── Admin/
│   │       │   ├── AnalyticsController.php        # Analytics & reports
│   │       │   ├── ClientController.php           # Client management
│   │       │   └── DashboardController.php        # Admin dashboard
│   │       ├── Api/
│   │       │   └── NotificationController.php     # Notification API
│   │       └── Client/
│   │           ├── DashboardController.php        # Client dashboard
│   │           └── PaymentController.php          # Stripe payments
│   ├── Mail/
│   │   ├── ContactFormMail.php                    # Contact form email
│   │   ├── ClientMessageMail.php                  # Client message email
│   │   ├── InvoiceCreatedMail.php                 # New invoice email
│   │   ├── InvoiceStatusUpdatedMail.php           # Invoice status email
│   │   ├── PaymentReminderMail.php                # Payment reminder email
│   │   ├── WeeklyDigestMail.php                   # Weekly digest email
│   │   ├── InquirySubmittedMail.php               # Inquiry submitted email
│   │   └── InquiryRespondedMail.php               # Inquiry response email
│   └── Models/
│       ├── User.php                               # User model with relationships
│       ├── ClientNote.php                         # Client notes model
│       ├── ClientMessage.php                      # Messages model
│       ├── Invoice.php                            # Invoice model
│       ├── InvoiceItem.php                        # Invoice items model
│       ├── InvoiceInquiry.php                     # Invoice inquiries model
│       └── FileUpload.php                         # File uploads model
├── database/
│   └── migrations/
│       ├── 2025_11_13_204039_create_client_notes_table.php
│       ├── 2025_11_13_204039_create_client_messages_table.php
│       ├── 2025_11_13_204039_create_invoices_table.php
│       ├── 2025_11_13_204039_create_invoice_items_table.php
│       ├── 2025_11_15_140517_create_invoice_inquiries_table.php
│       └── 2025_11_17_130735_create_file_uploads_table.php
├── public/
│   ├── css/
│   │   └── styles.css                             # All styling
│   └── js/
│       └── script.js                              # Interactive features
├── resources/
│   ├── js/
│   │   ├── app.js                                 # Main JS entry
│   │   └── notifications.js                       # Notification manager
│   └── views/
│       ├── home.blade.php                         # Main homepage
│       ├── admin/
│       │   ├── dashboard.blade.php                # Admin dashboard
│       │   ├── analytics/
│       │   │   ├── index.blade.php                # Analytics dashboard
│       │   │   └── reports.blade.php              # Detailed reports
│       │   └── clients/
│       │       └── show.blade.php                 # Client detail page
│       ├── client/
│       │   ├── dashboard.blade.php                # Client dashboard
│       │   ├── invoice.blade.php                  # Invoice detail page
│       │   └── payment/
│       │       ├── show.blade.php                 # Payment page
│       │       └── success.blade.php              # Payment success
│       ├── emails/
│       │   ├── contact.blade.php                  # Contact email template
│       │   ├── client-message.blade.php           # Message email template
│       │   ├── invoice-created.blade.php          # Invoice email template
│       │   ├── invoice-status-updated.blade.php   # Status update template
│       │   ├── payment-reminder.blade.php         # Payment reminder template
│       │   ├── weekly-digest.blade.php            # Weekly digest template
│       │   ├── inquiry-submitted.blade.php        # Inquiry submitted template
│       │   └── inquiry-responded.blade.php        # Inquiry response template
│       └── pdfs/
│           └── invoice.blade.php                  # PDF invoice template
├── routes/
│   └── web.php                                    # Route definitions
├── .env                                           # Configuration
└── CLIENT_MANAGEMENT.md                           # Client management docs
```

## How Contact Form Works

1. User fills out the contact form on the homepage
2. Form submits to `/contact` route with CSRF protection
3. `ContactController` validates the data:
   - Name (required, max 255 characters)
   - Email (required, valid email format)
   - Subject (required, max 255 characters)
   - Message (required, max 5000 characters)
4. `ContactFormMail` mailable class formats the email
5. Email is sent using configured mail driver
6. User sees success message on the page
7. Email arrives in your inbox with all form details

## Testing the Contact Form

1. Make sure mail is configured (use Mailtrap for safe testing)
2. Start the server: `php artisan serve`
3. Visit [http://127.0.0.1:8000](http://127.0.0.1:8000)
4. Scroll to the Contact section
5. Fill out the form and submit
6. Check your email inbox or Mailtrap inbox

## Deployment

### Deploy to Laravel Forge

1. Connect your server to [Laravel Forge](https://forge.laravel.com)
2. Create a new site
3. Deploy from your Git repository
4. Set environment variables in Forge
5. Enable Quick Deploy

### Deploy to Laravel Vapor (Serverless)

1. Install Vapor CLI: `composer require laravel/vapor-cli --dev`
2. Configure `vapor.yml`
3. Deploy: `vapor deploy production`

### Deploy to Shared Hosting

1. Build assets locally
2. Upload files via FTP/SFTP
3. Point domain to `/public` directory
4. Configure `.env` file
5. Run migrations via SSH or PHPMyAdmin

### Environment Variables for Production

Make sure to set these in your production environment:

```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://realwebdevelopment.com

# Configure your mail settings
MAIL_MAILER=smtp
MAIL_HOST=your-mail-host
# ... other mail settings
```

## Maintenance

### Clear Cache

```bash
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

### Optimize for Production

```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize
```

### View Application Logs

```bash
tail -f storage/logs/laravel.log
```

## Security Features

- ✅ CSRF Protection on all forms
- ✅ SQL Injection prevention via Eloquent ORM
- ✅ XSS Protection via Blade escaping
- ✅ Email validation
- ✅ Rate limiting on routes (can be added)
- ✅ Secure password hashing (if adding auth)

## Troubleshooting

### Emails Not Sending

1. Check `.env` mail configuration
2. Test with mail log driver: `MAIL_MAILER=log`
3. Check `storage/logs/laravel.log` for errors
4. Verify SMTP credentials
5. Check spam folder

### Permission Errors

```bash
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

### Database Connection Error

1. Verify database credentials in `.env`
2. Ensure database exists
3. Run migrations: `php artisan migrate`

## Performance Optimization

1. **Enable Caching:**
   ```bash
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   ```

2. **Use Queue for Emails:**
   ```bash
   php artisan queue:table
   php artisan migrate
   ```

   Then update `ContactController` to use `Mail::queue()` instead of `Mail::send()`

3. **Enable OPcache** in your PHP configuration

4. **Use CDN** for static assets

## Browser Support

- Chrome (latest)
- Firefox (latest)
- Safari (latest)
- Edge (latest)
- Mobile browsers (iOS Safari, Chrome Mobile)

## Quick Start Commands

```bash
# Start development server
php artisan serve

# Seed admin user
php artisan db:seed --class=AdminSeeder

# Send payment reminders for overdue invoices
php artisan invoices:send-reminders

# Send weekly digest emails to all clients
php artisan digests:send-weekly

# View routes
php artisan route:list

# Clear all caches
php artisan optimize:clear

# Run tests (when added)
php artisan test
```

## Recent Updates

### November 17, 2025

**Invoice Inquiries, File Uploads & Activity Timeline** (Latest)
- Invoice inquiry/dispute system allowing clients to submit questions directly on invoices
- Status workflow for inquiries: Open → In Progress → Resolved
- Admin inquiry management with response forms and email notifications
- Email notifications to admins when inquiries are submitted (InquirySubmittedMail)
- Email notifications to clients when admins respond (InquiryRespondedMail)
- Professional email templates for inquiry communication
- "Inquiries" tab on admin client detail page showing all client inquiries
- File upload system for both clients and admins
- Upload files up to 10MB (PDF, DOC, DOCX, XLS, XLSX, PNG, JPG, ZIP)
- Associate uploaded files with specific invoices for organization
- File visibility controls - admins can hide files from clients
- File management interface showing uploader, size, type, and description
- Automatic file deletion from storage when records are deleted
- File icons based on MIME type (PDF, Word, Excel, images, etc.)
- Human-readable file size formatting (KB, MB, GB)
- "Files" tab on admin client detail page with upload and management
- "My Files" section on client dashboard with upload form
- Activity timeline on client dashboard showing chronological history
- Timeline displays messages, invoices, file uploads, and inquiries
- Color-coded timeline dots and icons for different activity types
- Timestamps with relative time ("2 hours ago") and absolute dates
- Limited to 15 most recent activities for performance

### November 14, 2025

**Analytics, Notifications & Payment Integration**
- Admin analytics dashboard with Chart.js visualizations
- Revenue by month line chart showing 12-month trends
- Invoice status distribution doughnut chart
- Invoices created per month bar chart
- Top 10 clients by revenue horizontal bar chart
- Summary statistics: total revenue, outstanding, invoice counts, averages
- Detailed reports page with filtering: revenue, overdue, payment history
- Database-agnostic SQL functions supporting SQLite and MySQL
- Browser push notifications for new messages and invoices
- Notification permission management and 30-second polling
- Weekly email digest with activity summary (messages, invoices, payments)
- Smart digest skipping - only send when there's activity
- Artisan command `digests:send-weekly` for automated digest sending
- Stripe payment integration with secure Checkout Sessions
- Client payment portal with invoice summary and secure payment form
- Payment success page with transaction details and receipt download
- Automatic invoice status updates to "paid" on successful payment
- Stripe payment method and transaction reference tracking
- Payment confirmation emails with all transaction details

**Advanced Invoice Features & Enhanced Dashboard**
- Payment tracking: track payment method, reference, and notes for paid invoices
- Enhanced client dashboard with gradient stat cards and icons
- Payment statistics with visual progress bars showing payment rate
- Next payment alert showing upcoming/overdue invoices prominently
- Average invoice amount calculation and display
- Payment reminder system with automated email notifications
- Artisan command `invoices:send-reminders` for scheduled reminder emails
- Payment reminder emails include PDF attachments and days overdue
- Conditional payment fields that show/hide based on invoice status
- Payment details displayed for paid invoices (method, reference, notes)
- Migration adds payment_method, payment_reference, payment_notes, payment_reminder_sent_at fields

**PDF Invoice Email Attachments & Optimization**
- PDF invoices automatically attached to all invoice-related emails
- InvoiceCreatedMail and InvoiceStatusUpdatedMail include PDF attachments
- Clients receive professional PDFs directly in their inbox
- Optimized PDF file size from ~2,264 KB to ~1,249 KB (45% reduction)
- Reduced spacing, margins, and redundant CSS for optimal email delivery
- Professional logo box with "RW" branding in deep teal
- Updated documentation with PDF attachment and optimization details

**PDF Invoice Generation & Client Portal**
- Professional PDF invoice generation with barryvdh/laravel-dompdf (v3.1)
- Beautiful branded PDF template with deep teal theme and professional layout
- Download PDFs from both admin and client interfaces
- Client portal with financial dashboard (total billed, paid, outstanding)
- Clients can view their invoices and download PDFs
- Invoice detail page for clients with full line item breakdown
- Authorization checks ensure clients only access their own data
- PDF includes conditional sections based on invoice status (paid stamp, payment info)
- Automatic filename generation (INV-YYYY-00001.pdf)
- Table-based layouts for better PDF compatibility
- ~1,250 KB optimized PDFs ready for printing and email

### November 13, 2025

**Client Management System**
- Comprehensive client detail page with tabbed interface (Overview, Notes, Messages, Invoices)
- Internal notes system with creator tracking and timestamps
- Client messaging with automatic email delivery to clients
- Full invoice management with line items and automatic calculations
- Invoice status workflow: draft → sent → paid/overdue/cancelled
- Automatic invoice number generation (INV-YYYY-00001 format)
- Email notifications for messages and invoice updates
- Professional branded email templates matching site design
- Read/unread message tracking
- Financial calculations: subtotal, tax, and total auto-calculated
- Delete functionality for notes and invoices with confirmation
- Audit trail tracking who created each note, message, and invoice
- Clickable client names in dashboard linking to detail page

**Admin Features & User Management**
- Text-based logo "RealWebDevelopment" with Deep Teal highlighted "Web"
- Admin can create client accounts via modal overlay on dashboard
- User impersonation system - admins can login as clients with visual banner
- "Return to Admin" functionality with session-based tracking
- Admin dashboard with "Add Client" button and "Login as User" actions
- Public registration completely disabled (admin-only account creation)
- Validation errors auto-reopen modals for better UX

**Profile Page Redesign**
- Complete theme update matching Deep Teal dashboard design
- Three card-based sections: Profile Information, Update Password, Delete Account
- Deep Teal focus states on all input fields
- Modal-based account deletion with red gradient danger styling
- Success messages with auto-fade animations
- Consistent button styling with `btn-dashboard` class

**Portfolio Section Redesign**
- Completely redesigned portfolio based on actual resume experience
- 5 comprehensive project cards showcasing leadership roles (CTO, Director, Manager)
- Horizontal scrolling carousel layout with custom Deep Teal scrollbar
- Beautiful gradient backgrounds (teal, green, purple, orange, blue)
- No images required - company initials displayed in large gradient headers
- Role badges, timeline indicators, and impact metrics
- Technology tag clouds for each project
- Compact cards: 340px width with descriptions hidden for cleaner look
- Responsive design optimized for mobile

**Expertise Section Improvements**
- Cleaner 2-column layout (1 column on mobile)
- Subtle gradient backgrounds on category cards
- Colored accent bars before category titles
- Modern white tech tags with hover effects
- Better spacing and visual hierarchy

**Authentication System**
- Complete Laravel Breeze integration with custom styling
- Admin and Client user roles with middleware protection
- Admin Dashboard: View all clients, create new clients, impersonate users
- Client Dashboard: Account information, quick actions
- Profile management with themed forms
- Secure login with "Forgot Password" functionality

**Contact Form Enhancements**
- AJAX-powered contact form (no page refresh)
- Real-time validation and feedback
- Mailhog integration for development testing
- Professional email template

For complete changelog, see [CHANGELOG.md](CHANGELOG.md)

## Deployment to Railway

This application is configured for deployment to [Railway](https://railway.app) with MySQL database and AWS S3 file storage.

### Prerequisites

1. **Railway Account** - Sign up at [railway.app](https://railway.app)
2. **AWS Account** - For S3 file storage ([AWS Console](https://console.aws.amazon.com))
3. **SMTP Service** - SendGrid, Mailgun, or similar for production emails

### Pre-Deployment Setup

#### 1. Create AWS S3 Bucket

1. Go to [AWS S3 Console](https://console.aws.amazon.com/s3)
2. Create a new bucket (e.g., `your-app-uploads`)
3. Keep all default settings (block public access enabled)
4. Create IAM user with S3 access:
   - Go to IAM → Users → Create User
   - Attach policy: `AmazonS3FullAccess` (or create custom policy)
   - Create access key → Save Access Key ID and Secret Access Key

#### 2. Setup SMTP Email Service

**Option A: SendGrid (Recommended - Free tier available)**
1. Sign up at [sendgrid.com](https://sendgrid.com)
2. Create API key
3. Note: `smtp.sendgrid.net`, Port `587`, Username: `apikey`, Password: `your_api_key`

**Option B: Mailgun**
1. Sign up at [mailgun.com](https://mailgun.com)
2. Get SMTP credentials from dashboard
3. Note: `smtp.mailgun.org`, Port `587`, and your credentials

### Railway Deployment Steps

#### 1. Create New Project on Railway

1. Click **"New Project"** on Railway dashboard
2. Select **"Deploy from GitHub repo"**
3. Connect your GitHub account and select this repository
4. Railway will detect the Laravel application automatically

#### 2. Add MySQL Database

1. In your Railway project, click **"New"** → **"Database"** → **"Add MySQL"**
2. Railway will automatically create a MySQL database and provide connection variables
3. Copy the connection details for the next step

#### 3. Configure Environment Variables

Go to your Railway project → Variables → Add these environment variables:

**Application Settings:**
```env
APP_NAME="Your App Name"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-app.up.railway.app
APP_KEY=base64:... (copy from your local .env or generate new)
```

**Database (from Railway MySQL service):**
```env
DB_CONNECTION=mysql
DB_HOST=containers-us-west-xxx.railway.app
DB_PORT=3306
DB_DATABASE=railway
DB_USERNAME=root
DB_PASSWORD=your_railway_mysql_password
```

**File Storage (AWS S3):**
```env
FILESYSTEM_DISK=s3
AWS_ACCESS_KEY_ID=your_aws_access_key_id
AWS_SECRET_ACCESS_KEY=your_aws_secret_access_key
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=your-bucket-name
```

**Email (SendGrid example):**
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.sendgrid.net
MAIL_PORT=587
MAIL_USERNAME=apikey
MAIL_PASSWORD=your_sendgrid_api_key
MAIL_FROM_ADDRESS=noreply@yourdomain.com
MAIL_FROM_NAME="${APP_NAME}"
```

**Session & Cache:**
```env
SESSION_DRIVER=database
CACHE_STORE=database
QUEUE_CONNECTION=database
```

**Stripe (if using payments):**
```env
STRIPE_KEY=pk_live_your_publishable_key
STRIPE_SECRET=sk_live_your_secret_key
STRIPE_WEBHOOK_SECRET=whsec_your_webhook_secret
```

#### 4. Deploy the Application

1. Railway will automatically deploy after connecting the repository
2. First deployment will:
   - Install PHP dependencies (`composer install`)
   - Install Node dependencies (`npm ci`)
   - Build assets (`npm run build`)
   - Cache Laravel configs

#### 5. Run Migrations

After first deployment, run migrations:

1. Go to Railway project → Service → Settings
2. Scroll to **"Custom Start Command"** (or use Railway CLI)
3. Run one-time command:
   ```bash
   php artisan migrate --force
   ```

Alternatively, use Railway CLI:
```bash
railway run php artisan migrate --force
```

#### 6. Setup Queue Worker (Required for Background Jobs)

1. In Railway project, click **"New"** → **"Empty Service"**
2. Link it to your GitHub repo (same repository)
3. Add all same environment variables
4. Under Settings → Deploy → **"Custom Start Command"**:
   ```
   php artisan queue:work --tries=3 --timeout=90
   ```

This creates a separate worker process for handling email jobs and notifications.

#### 7. Setup Cron Jobs (Optional - for weekly digests)

For scheduled tasks like weekly digest emails:

**Option A: Railway Cron Triggers**
1. Use Railway's cron trigger feature (if available in your plan)
2. Configure trigger for weekly schedule
3. Endpoint: `POST /artisan/schedule:run`

**Option B: External Cron Service**
1. Use [cron-job.org](https://cron-job.org) or similar
2. Create job to hit: `https://your-app.up.railway.app/cron/schedule`
3. Schedule: Weekly (configure in your app)
4. Add route and controller to handle external cron requests

#### 8. Verify Deployment

1. Visit your Railway app URL: `https://your-app.up.railway.app`
2. Test login and admin features
3. Upload a test file (verify S3 working)
4. Send a test email/message (verify SMTP working)
5. Check logs in Railway dashboard for any errors

### Post-Deployment

#### Custom Domain (Optional)

1. In Railway project → Settings → **"Domains"**
2. Click **"Custom Domain"**
3. Add your domain (e.g., `app.yourdomain.com`)
4. Update DNS records as instructed by Railway
5. Update `APP_URL` environment variable to your custom domain

#### SSL Certificate

- Railway automatically provides SSL certificates
- No additional configuration needed

#### Monitoring

- Check Railway logs regularly: Project → Service → **"Deployments"** → View logs
- Monitor database usage and storage
- Set up Railway notifications for deployment failures

### Troubleshooting

**Database Connection Failed:**
- Verify all `DB_*` variables are correct
- Check MySQL service is running in Railway
- Ensure variables are copied exactly (no extra spaces)

**File Upload Errors:**
- Verify S3 credentials are correct
- Check S3 bucket exists and IAM user has access
- Ensure `FILESYSTEM_DISK=s3` is set

**Emails Not Sending:**
- Check SMTP credentials
- Verify `MAIL_MAILER=smtp` (not `log`)
- Check Railway logs for email errors
- Test SMTP credentials locally first

**Queue Jobs Not Processing:**
- Ensure worker service is running
- Check worker service logs in Railway
- Verify `QUEUE_CONNECTION=database` is set

**Assets Not Loading:**
- Run `npm run build` locally and commit `public/build` folder
- Or ensure Railway runs `npm run build` during deployment

### Cost Estimates (Railway)

- **Hobby Plan**: $5/month (includes $5 credit)
  - Web service: ~$2-3/month
  - Worker service: ~$1-2/month
  - MySQL database: Included
  - Total: Usually within $5 credit

- **AWS S3**: ~$0.023/GB/month (first 50GB)
- **SendGrid**: Free up to 100 emails/day

### Files Created for Railway Deployment

This repository includes:
- `Procfile` - Defines web and worker processes
- `nixpacks.toml` - Build configuration for Railway
- Updated `.env.example` - Production configuration examples

## Documentation

- **[CLIENT_MANAGEMENT.md](CLIENT_MANAGEMENT.md)** - Client management system guide (Notes, Messages, Invoices)
- **[CHANGELOG.md](CHANGELOG.md)** - Complete change history
- **[ADMIN.md](ADMIN.md)** - Complete admin system and user management guide
- **[AUTHENTICATION.md](AUTHENTICATION.md)** - Authentication system guide
- **[COLORS.md](COLORS.md)** - Color theme customization guide
- **[EMAIL-SETUP.md](EMAIL-SETUP.md)** - Production email configuration
- **[MAILHOG-SETUP.md](MAILHOG-SETUP.md)** - Local email testing setup

## License

This project is open source and available for personal and commercial use.

## Support

For questions or support:
- Email: contact@realwebdevelopment.com

---

**Built with Laravel 12 and modern web technologies**
