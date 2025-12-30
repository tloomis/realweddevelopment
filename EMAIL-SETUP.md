# Email Setup Guide

Your contact form is configured to send emails via Gmail SMTP. Follow these steps to complete the setup:

## Quick Setup (Gmail)

### Step 1: Enable 2-Factor Authentication

1. Go to your Google Account: https://myaccount.google.com/
2. Click "Security" in the left navigation
3. Under "How you sign in to Google", select "2-Step Verification"
4. Follow the prompts to enable 2FA

### Step 2: Create an App Password

1. Go to: https://myaccount.google.com/apppasswords
2. You may need to sign in again
3. In the "Select app" dropdown, choose "Mail"
4. In the "Select device" dropdown, choose "Other (Custom name)"
5. Type "Laravel Contact Form" and click "Generate"
6. **Copy the 16-character password** that appears (it will look like: `xxxx xxxx xxxx xxxx`)

### Step 3: Update Your .env File

1. Open `.env` in your code editor
2. Find this line:
   ```
   MAIL_PASSWORD=your-app-password-here
   ```
3. Replace `your-app-password-here` with the 16-character app password (no spaces)
4. Save the file

### Step 4: Test It!

1. Start your Laravel server (if not already running):
   ```bash
   php artisan serve
   ```

2. Visit http://127.0.0.1:8000

3. Scroll to the Contact section and fill out the form

4. Click "Send Message"

5. You should see a success message without page refresh!

6. Check your Gmail inbox (tloomis323@gmail.com) for the email

## Current Configuration

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=tloomis323@gmail.com
MAIL_PASSWORD=your-app-password-here  ← Update this
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="tloomis323@gmail.com"
MAIL_FROM_NAME="Real Web Development"
```

## Features Implemented

✅ **AJAX Form Submission** - No page refresh when submitting
✅ **Real-time Validation** - Shows errors without losing form data
✅ **Success Messages** - Displays success message and clears form
✅ **Error Handling** - Gracefully handles and displays errors
✅ **Loading State** - Button shows "Sending..." during submission
✅ **Auto-dismiss** - Success message auto-removes after 5 seconds
✅ **Smooth Scrolling** - Auto-scrolls to alert message
✅ **Fallback Email** - Error message includes direct email link

## Alternative: Use Mailtrap for Testing

If you want to test without sending real emails:

1. Sign up at https://mailtrap.io (free)
2. Get your Mailtrap credentials from the inbox settings
3. Update `.env`:
   ```env
   MAIL_MAILER=smtp
   MAIL_HOST=smtp.mailtrap.io
   MAIL_PORT=2525
   MAIL_USERNAME=your-mailtrap-username
   MAIL_PASSWORD=your-mailtrap-password
   MAIL_ENCRYPTION=tls
   ```

## Troubleshooting

### "Authentication failed" error
- Make sure you're using an App Password, not your regular Gmail password
- Verify the app password is correct (no spaces)
- Ensure 2FA is enabled on your Google account

### "Connection timeout" error
- Check your internet connection
- Verify port 587 is not blocked by your firewall
- Try port 465 with `MAIL_ENCRYPTION=ssl` instead

### Form not submitting
- Check browser console (F12) for JavaScript errors
- Verify `contact-handler.js` is loading correctly
- Make sure you're not blocking JavaScript

### Need help?
Check the Laravel logs for detailed error messages:
```bash
tail -f storage/logs/laravel.log
```

## File Locations

- **Controller**: `app/Http/Controllers/ContactController.php`
- **Email Template**: `resources/views/emails/contact.blade.php`
- **AJAX Handler**: `public/js/contact-handler.js`
- **Form View**: `resources/views/home.blade.php`
- **Alert Styles**: `public/css/styles.css`

---

**You're almost there!** Just add your Gmail App Password to `.env` and you'll be able to receive contact form submissions.
