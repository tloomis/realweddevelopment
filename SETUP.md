# Quick Setup Guide

## Your Laravel Portfolio Site is Ready!

The site has been successfully converted from static HTML to a full Laravel application with a working contact form backend.

## What Was Built

### ✅ Complete Laravel Application
- **Laravel 12** installation with all dependencies
- **SQLite database** already configured and migrated
- **Professional frontend** integrated into Laravel Blade templates
- **Contact form** with backend email functionality

### ✅ Files Created/Modified

**Backend:**
- `app/Http/Controllers/ContactController.php` - Handles form submissions
- `app/Mail/ContactFormMail.php` - Email template logic
- `routes/web.php` - Routes configured

**Frontend:**
- `resources/views/home.blade.php` - Main homepage (Blade template)
- `resources/views/emails/contact.blade.php` - Email template
- `public/css/styles.css` - All styling (17KB)
- `public/js/script.js` - Interactive features (9.5KB)

**Documentation:**
- `README.md` - Comprehensive documentation
- `SETUP.md` - This file

## Quick Start (3 Steps)

### 1. Configure Email (REQUIRED)

Edit `.env` file and add your email settings. **Recommended for testing: Use Mailtrap**

```bash
# Sign up at mailtrap.io (free) and add these to .env:
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_mailtrap_username
MAIL_PASSWORD=your_mailtrap_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=hello@realwebdevelopment.com
MAIL_FROM_NAME="Real Web Development"
```

### 2. Start the Server

```bash
php artisan serve
```

### 3. Visit the Site

Open [http://127.0.0.1:8000](http://127.0.0.1:8000)

## Test the Contact Form

1. Scroll to the **Contact** section
2. Fill out the form:
   - Name: Test User
   - Email: test@example.com
   - Subject: Test Message
   - Message: This is a test
3. Click **Send Message**
4. Check your Mailtrap inbox or configured email

## Email Configuration Options

### Option 1: Mailtrap (Testing - RECOMMENDED) ⭐
- Sign up: [mailtrap.io](https://mailtrap.io)
- Free tier available
- Captures all emails without sending real ones
- Perfect for development

### Option 2: Gmail (Real Emails)
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-gmail@gmail.com
MAIL_PASSWORD=your-app-password  # Create at myaccount.google.com/apppasswords
MAIL_ENCRYPTION=tls
```

### Option 3: Log to File (No emails sent)
```env
MAIL_MAILER=log
```
Emails will be in `storage/logs/laravel.log`

## Customization

### Enable/Disable Headshot

**Currently**: Headshot is commented out in the hero section

To enable the headshot, edit `resources/views/home.blade.php` (around line 41-44):
- Uncomment the headshot div
- Make sure `public/images/todd-loomis-headshot.jpg` exists

### Update Your Contact Info

Edit `resources/views/home.blade.php`:
- Line 282: Change `contact@realwebdevelopment.com`
- Line 289: Add your LinkedIn URL
- Line 296: Add your GitHub URL

### Change Site Colors

**Current Theme**: Deep Teal (#0891b2) - Professional, Modern, Tech-Forward

Edit `public/css/styles.css` lines 11-17:
```css
:root {
    /* Color Palette - Deep Teal Theme */
    --primary: #0891b2;        /* Main brand color */
    --primary-dark: #0e7490;   /* Darker shade */
    --primary-light: #06b6d4;  /* Lighter shade */
    --secondary: #14b8a6;      /* Secondary color */
    --accent: #f59e0b;         /* Accent color */
}
```

**Try other professional colors:**
- Rich Purple: `#7c3aed`
- Forest Green: `#059669`
- Deep Blue: `#2563eb`
- Slate Gray: `#475569`

See [COLORS.md](COLORS.md) for complete guide with 8 professional themes.

### Update Statistics

Edit `resources/views/home.blade.php` lines 58-68:
- Years of experience
- Projects completed
- Happy clients

## What Makes This Different From Static HTML?

| Feature | Static HTML | Laravel Version |
|---------|-------------|-----------------|
| Contact Form | ❌ Doesn't work | ✅ Sends real emails |
| Form Validation | ❌ Client-side only | ✅ Server-side validation |
| Security | ⚠️ Basic | ✅ CSRF protection, SQL injection prevention |
| Scalability | ❌ Hard to expand | ✅ Easy to add features |
| Email Template | ❌ None | ✅ Professional HTML email |
| Error Handling | ❌ Basic | ✅ Proper error messages |

## Next Steps

1. **Configure email** (see above)
2. **Test the contact form**
3. **Customize content** for your portfolio
4. **Add your projects** to the portfolio section
5. **Deploy** (see README.md for deployment options)

## Useful Commands

```bash
# Start dev server
php artisan serve

# View all routes
php artisan route:list

# Clear all caches
php artisan optimize:clear

# View logs
tail -f storage/logs/laravel.log

# Test email configuration
php artisan tinker
>>> Mail::raw('Test email', function($msg) { $msg->to('test@example.com')->subject('Test'); });
```

## Troubleshooting

### Form submissions not working?
- Check `.env` mail configuration
- Look at `storage/logs/laravel.log` for errors
- Make sure `php artisan serve` is running

### Permission errors?
```bash
chmod -R 775 storage bootstrap/cache
```

### Want to see email content without sending?
Set `MAIL_MAILER=log` in `.env`

## File Structure

```
realwebdevelopment-laravel/
├── app/
│   ├── Http/Controllers/ContactController.php  ← Form handler
│   └── Mail/ContactFormMail.php                ← Email class
├── public/
│   ├── css/styles.css                          ← Your styling
│   └── js/script.js                            ← Your JavaScript
├── resources/views/
│   ├── home.blade.php                          ← Homepage
│   └── emails/contact.blade.php                ← Email template
├── routes/web.php                              ← URL routes
└── .env                                        ← Configuration
```

## Support

- **Documentation**: See [README.md](README.md) for detailed info
- **Laravel Docs**: [laravel.com/docs](https://laravel.com/docs)

---

**You're all set!** Start the server with `php artisan serve` and visit http://127.0.0.1:8000
