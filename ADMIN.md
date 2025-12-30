# Admin Features Documentation

Complete guide to the admin system and user management features in RealWebDevelopment Laravel.

## Table of Contents

- [Overview](#overview)
- [Admin Dashboard](#admin-dashboard)
- [Client Management](#client-management)
- [User Impersonation](#user-impersonation)
- [Profile Management](#profile-management)
- [Security Features](#security-features)
- [Technical Details](#technical-details)

## Overview

The RealWebDevelopment application features a complete admin system with role-based access control. There are two user roles:

- **Admin**: Full system access, can manage clients and impersonate users
- **Client**: Standard user access to personal dashboard and profile

### Key Features

✅ Admin-only client account creation (public registration disabled)
✅ Modal-based client creation form
✅ User impersonation for support and troubleshooting
✅ Session-based impersonation tracking
✅ Visual impersonation banner with "Return to Admin" button
✅ Fully themed profile management pages
✅ Role-based middleware protection
✅ Deep Teal consistent design throughout

## Admin Dashboard

**Location**: [resources/views/admin/dashboard.blade.php](resources/views/admin/dashboard.blade.php)
**Route**: `/admin/dashboard`
**Middleware**: `auth`, `admin`

### Features

#### Statistics Cards
- **Total Clients**: Count of all client users
- **Active Users**: Count of active client accounts
- **New This Month**: Clients registered in the past 30 days

#### Client Management Table
Displays all client users with:
- Name
- Email address
- Registration date
- Status badge (Active)
- "Login as User" button for impersonation

#### Add Client Button
Prominent button in header that opens modal overlay for creating new clients.

### Creating a New Client

1. Click "Add Client" button in dashboard header
2. Modal overlay appears with creation form
3. Fill in required fields:
   - Full Name (required, max 255 characters)
   - Email Address (required, valid email, unique)
   - Password (required, confirmed, meets Laravel password defaults)
   - Confirm Password (required, must match)
4. Click "Create Client" button
5. Validation errors will keep modal open with error messages
6. Success redirects to dashboard with success message

**Technical Details**:
- Form uses CSRF protection
- Validation handled server-side in `ClientController@store`
- Passwords automatically hashed using `Hash::make()`
- New users assigned 'client' role automatically
- Modal auto-reopens on validation errors

## User Impersonation

One of the most powerful admin features - allows admins to view the application exactly as a specific client sees it.

### How to Impersonate a User

1. Go to Admin Dashboard
2. Find the client in the table
3. Click "Login as User" button
4. You'll be instantly logged in as that client
5. Orange impersonation banner appears at top
6. View exactly what the client sees

### Impersonation Banner

When impersonating, an orange gradient banner appears showing:
- User icon and "Viewing as [Client Name]"
- "Return to Admin" button

**Banner Styling**:
- Orange gradient background (#f59e0b to #ea580c)
- Fixed at top of page above navigation
- White text for high contrast
- Prominent call-to-action button

### Returning to Admin Account

Click "Return to Admin" button in the impersonation banner:
- Logs you back in as admin
- Clears impersonation session
- Redirects to admin dashboard
- Shows "Returned to admin account" success message

### Security Features

- ✅ Only admins can initiate impersonation
- ✅ Only client users can be impersonated (not other admins)
- ✅ Session-based tracking prevents unauthorized access
- ✅ Visual indicator always shows when impersonating
- ✅ Easy one-click return to admin account

**Technical Implementation**:
- Original admin ID stored in session: `impersonate_admin_id`
- Session cleared when returning to admin
- Route protection via auth middleware
- Role checks in `ClientController@impersonate`

## Client Management

### Routes

```php
// Admin Routes (protected by auth + admin middleware)
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::post('/clients', [ClientController::class, 'store'])->name('clients.store');
    Route::post('/clients/{user}/impersonate', [ClientController::class, 'impersonate'])->name('clients.impersonate');
});

// Impersonation Routes (protected by auth only)
Route::middleware(['auth'])->group(function () {
    Route::post('/stop-impersonating', [ClientController::class, 'stopImpersonating'])->name('stop-impersonating');
});
```

### ClientController Methods

**Location**: [app/Http/Controllers/Admin/ClientController.php](app/Http/Controllers/Admin/ClientController.php)

#### `store(Request $request)`
Creates a new client user account.

**Validation Rules**:
```php
'name' => ['required', 'string', 'max:255'],
'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
'password' => ['required', 'confirmed', Rules\Password::defaults()],
```

**Returns**: Redirect to admin dashboard with success message

#### `impersonate(User $user)`
Allows admin to login as a client user.

**Security Checks**:
1. Verify current user is admin
2. Verify target user is client (not admin)
3. Store admin ID in session
4. Login as target user
5. Redirect to dashboard

**Returns**: Redirect to dashboard with success message

#### `stopImpersonating()`
Returns admin to their original account.

**Process**:
1. Retrieve admin ID from session
2. Verify admin user exists
3. Clear impersonation session
4. Login as original admin
5. Redirect to admin dashboard

**Returns**: Redirect to admin dashboard with success message

## Profile Management

Complete profile settings page with Deep Teal theme throughout.

**Location**: [resources/views/profile/edit.blade.php](resources/views/profile/edit.blade.php)
**Route**: `/profile`
**Middleware**: `auth`

### Profile Sections

#### 1. Profile Information
**Partial**: [resources/views/profile/partials/update-profile-information-form.blade.php](resources/views/profile/partials/update-profile-information-form.blade.php)

Features:
- Update name and email
- Email verification status
- Deep Teal focus states on inputs
- "Save Changes" button with btn-dashboard styling
- Success message with auto-fade (2 seconds)

#### 2. Update Password
**Partial**: [resources/views/profile/partials/update-password-form.blade.php](resources/views/profile/partials/update-password-form.blade.php)

Features:
- Current password verification
- New password (must meet Laravel defaults)
- Password confirmation
- Deep Teal focus states
- "Save Changes" button
- Success message with auto-fade

#### 3. Delete Account
**Partial**: [resources/views/profile/partials/delete-user-form.blade.php](resources/views/profile/partials/delete-user-form.blade.php)

Features:
- Red gradient danger button (#dc2626 to #991b1b)
- Modal confirmation dialog
- Password verification required
- Warning about permanent deletion
- "Cancel" and "Delete Account" buttons
- Modal auto-reopens on validation errors

**Modal Styling**:
- Animated overlay with fadeIn
- Modal content slides up
- Red focus state on password input
- Red gradient submit button matching trigger

## Security Features

### Authentication

- **Laravel Breeze**: Complete authentication scaffolding
- **Password Hashing**: Bcrypt via `Hash::make()`
- **CSRF Protection**: All forms include `@csrf` token
- **Session Management**: Secure session handling

### Authorization

- **Middleware Protection**: Routes protected by `auth` and `admin` middleware
- **Role-Based Access**: Admin vs Client role checks
- **Impersonation Guards**: Multiple security checks before allowing impersonation
- **Route Protection**: Only authenticated users can access protected areas

### Registration Control

**Public Registration Disabled**:
- Registration routes commented out in [routes/auth.php](routes/auth.php)
- "Create account" link removed from login page
- Only admins can create new accounts
- Clear documentation in route comments

### Input Validation

All forms include server-side validation:
- **Client Creation**: Name, email (unique), password (confirmed)
- **Profile Update**: Name, email, email verification
- **Password Update**: Current password, new password (confirmed)
- **Account Deletion**: Password confirmation

### Data Protection

- **XSS Prevention**: Blade `{{ }}` escaping by default
- **SQL Injection**: Eloquent ORM parameterized queries
- **Mass Assignment**: Fillable properties defined in User model
- **Password Security**: Laravel's password rules enforced

## Technical Details

### Middleware

**Admin Middleware**: [app/Http/Middleware/AdminMiddleware.php](app/Http/Middleware/AdminMiddleware.php)

```php
public function handle(Request $request, Closure $next)
{
    if (Auth::check() && Auth::user()->role === 'admin') {
        return $next($request);
    }
    abort(403, 'Unauthorized action.');
}
```

### User Model

**Role Field**: Added to users table migration

```php
$table->string('role')->default('client');
```

**Roles**:
- `admin` - Full system access
- `client` - Standard user access

### Session Keys

- `impersonate_admin_id` - Stores original admin ID during impersonation

### Styling Classes

**Button Classes** (defined in [public/css/styles.css](public/css/styles.css)):
- `.btn-dashboard` - Primary Deep Teal gradient button
- `.btn-dashboard-secondary` - Secondary gray button
- `.content-card` - White card with shadow
- `.content-card-header` - Card header with border
- `.content-card-body` - Card content area
- `.dashboard-header` - Page header with gradient
- `.dashboard-title` - Large page title
- `.dashboard-subtitle` - Subtitle text

### Modal Implementation

**CSS Classes**:
```css
.modal-overlay - Full screen overlay with dark background
.modal-overlay.active - Displayed state (flex)
.modal-content - White modal box with shadow
.modal-header - Modal header with title
.modal-body - Modal content area
.modal-footer - Modal footer with buttons
```

**JavaScript**:
```javascript
// Open modal
document.getElementById('modalId').classList.add('active');

// Close modal
document.getElementById('modalId').classList.remove('active');

// Close on overlay click
onclick="if(event.target === this) this.classList.remove('active')"
```

**Animations**:
- `fadeIn` - Overlay fade in (0.2s)
- `slideUp` - Modal slide up from bottom (0.3s)

### Form Validation

**Client-Side**:
- HTML5 validation attributes (required, type="email", etc.)
- Inline onfocus/onblur styling for immediate feedback

**Server-Side**:
- Laravel validation rules in controller methods
- Error bag namespacing for multiple forms on same page
- Redirect back with errors and old input

### Database Structure

**Users Table**:
```sql
id - bigint, primary key
name - varchar(255)
email - varchar(255), unique
password - varchar(255)
role - varchar(255), default 'client'
email_verified_at - timestamp, nullable
created_at - timestamp
updated_at - timestamp
```

## Best Practices

### Admin Account Creation

1. Seed initial admin via `AdminSeeder`
2. Never create admin accounts through the UI
3. Use Tinker or seeders for admin creation
4. Keep admin credentials secure

### Impersonation Usage

- Use for support and troubleshooting
- Document when and why you impersonated
- Always return to admin when done
- Never perform destructive actions while impersonating

### Client Management

- Always validate email addresses
- Enforce strong passwords
- Provide clients with secure credentials
- Consider password reset workflow

### Security Maintenance

- Regularly review admin access logs
- Keep Laravel and dependencies updated
- Monitor failed login attempts
- Implement rate limiting on auth routes

## Troubleshooting

### Cannot Access Admin Dashboard

**Issue**: Redirected to login or 403 error

**Solutions**:
1. Verify you're logged in as admin
2. Check user role in database: `SELECT role FROM users WHERE email='your@email.com'`
3. Clear cache: `php artisan cache:clear`
4. Verify middleware is registered in `bootstrap/app.php`

### Impersonation Not Working

**Issue**: Can't login as client or return to admin

**Solutions**:
1. Check session is working: `php artisan session:table && php artisan migrate`
2. Clear sessions: `php artisan session:flush`
3. Verify routes are registered: `php artisan route:list`
4. Check user roles are correct in database

### Modal Not Opening

**Issue**: Click button but modal doesn't appear

**Solutions**:
1. Check browser console for JavaScript errors
2. Verify modal ID matches button onclick
3. Ensure CSS classes are loaded
4. Test in different browser

### Validation Errors Not Showing

**Issue**: Form submits but errors don't display

**Solutions**:
1. Check `@error` blade directives
2. Verify error bag names match controller
3. Check validation rules in controller
4. Ensure CSRF token is present

## Future Enhancements

Potential features to add:

- [ ] Client activity logs
- [ ] Email notifications for new accounts
- [ ] Bulk client import/export
- [ ] Client status management (active/suspended)
- [ ] Admin audit trail
- [ ] Two-factor authentication
- [ ] Password reset by admin
- [ ] Client notes/comments
- [ ] Advanced filtering and search
- [ ] Client dashboard customization

---

**Last Updated**: November 13, 2025
**Version**: 1.0
**Maintained By**: RealWebDevelopment Team
