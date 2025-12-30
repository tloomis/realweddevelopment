# Authentication System Documentation

Your Laravel portfolio site now includes a complete authentication system with role-based access control.

## Overview

The system provides:
- **User Registration & Login** powered by Laravel Breeze
- **Two User Roles**: Client and Admin
- **Separate Dashboards**: Custom dashboards for each role
- **Access Control**: Middleware protecting admin routes
- **Professional UI**: Matches your Deep Teal theme (#0891b2)

---

## User Roles

### Client Role (Default)
- Can register via the public registration form
- Access to client dashboard
- View their account information
- Cannot access admin area

### Admin Role
- Pre-configured admin account
- Access to admin dashboard
- View all client users
- See system statistics
- Cannot be created via registration (security)

---

## Quick Start

### 1. Admin Login

Visit: http://127.0.0.1:8000/login

**Credentials:**
- Email: `admin@realwebdevelopment.com`
- Password: `password`

**⚠️ IMPORTANT**: Change this password immediately after first login!

### 2. Create Client Account

Visit: http://127.0.0.1:8000/register

Fill out the registration form. All new users automatically become clients.

### 3. Access Dashboards

**Admin Dashboard**: http://127.0.0.1:8000/admin/dashboard
- Only accessible by admin users
- Shows list of all clients
- Displays system statistics

**Client Dashboard**: http://127.0.0.1:8000/client/dashboard
- Only accessible by authenticated clients
- Shows personalized account info
- Quick action links

---

## Features

### Authentication Pages

All styled to match your site's Deep Teal theme:

- **Login** (`/login`) - User authentication
- **Register** (`/register`) - New user signup
- **Forgot Password** (`/forgot-password`) - Password reset
- **Email Verification** - Verify email address (optional)
- **Profile** (`/profile`) - Edit account settings

### Admin Dashboard Features

✅ **Client Management**
- View all registered clients
- See join dates
- Monitor user accounts

✅ **Statistics Cards**
- Total Clients count
- Active Users count
- New Users this month

✅ **Professional Design**
- Clean table layout
- Deep Teal accents
- Responsive design

### Client Dashboard Features

✅ **Account Information**
- Personalized welcome
- Account details display
- Membership duration

✅ **Quick Actions**
- Edit Profile
- Contact Support
- View Services

✅ **Status Indicator**
- Account status badge
- Visual feedback

---

## Folder Structure

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── Admin/
│   │   │   └── DashboardController.php    # Admin dashboard logic
│   │   ├── Client/
│   │   │   └── DashboardController.php    # Client dashboard logic
│   │   └── Auth/                          # Breeze auth controllers
│   └── Middleware/
│       └── AdminMiddleware.php            # Protects admin routes
├── Models/
│   └── User.php                           # User model with role methods
database/
├── migrations/
│   └── 2025_11_13_*_add_role_to_users_table.php
└── seeders/
    └── AdminSeeder.php                    # Creates admin user
resources/
└── views/
    ├── admin/
    │   └── dashboard.blade.php            # Admin dashboard view
    ├── client/
    │   └── dashboard.blade.php            # Client dashboard view
    └── auth/                              # Breeze auth views
routes/
└── web.php                                # All routes defined
```

---

## How It Works

### Registration Flow

1. User visits `/register`
2. Fills out registration form
3. Account created with `role = 'client'` (default)
4. Automatically logged in
5. Redirected to `/client/dashboard`

### Login Flow

1. User visits `/login`
2. Enters credentials
3. System checks user role:
   - **Admin** → Redirected to `/admin/dashboard`
   - **Client** → Redirected to `/client/dashboard`

### Access Control

**Admin Routes** (protected by AdminMiddleware):
```
GET  /admin/dashboard  → Admin\DashboardController@index
```

**Client Routes** (protected by auth middleware):
```
GET  /client/dashboard → Client\DashboardController@index
```

**If a client tries to access `/admin/dashboard`:**
→ Redirected to `/client/dashboard` with error message

---

## User Model Methods

The User model includes helper methods for role checking:

```php
// Check if user is admin
if ($user->isAdmin()) {
    // Admin logic
}

// Check if user is client
if ($user->isClient()) {
    // Client logic
}
```

---

## Database Schema

### Users Table

| Column | Type | Description |
|--------|------|-------------|
| id | bigint | Primary key |
| name | string | User's full name |
| email | string | Unique email address |
| **role** | **string** | **'client' or 'admin'** |
| email_verified_at | timestamp | Email verification |
| password | string | Hashed password |
| remember_token | string | Remember me token |
| created_at | timestamp | Registration date |
| updated_at | timestamp | Last update |

---

## Customization

### Change Admin Email in Seeder

Edit `database/seeders/AdminSeeder.php`:

```php
User::create([
    'name' => 'Your Name',
    'email' => 'youremail@example.com',
    'password' => Hash::make('your-secure-password'),
    'role' => 'admin',
    'email_verified_at' => now(),
]);
```

Then run:
```bash
php artisan migrate:fresh --seed
```

### Add More Admin Features

Edit `app/Http/Controllers/Admin/DashboardController.php` to add:
- User management (edit/delete)
- Role assignment
- Advanced statistics
- System settings

### Add More Client Features

Edit `app/Http/Controllers/Client/DashboardController.php` to add:
- Project management
- File uploads
- Service requests
- Ticket system

### Customize Dashboard Views

**Admin Dashboard**: `resources/views/admin/dashboard.blade.php`
**Client Dashboard**: `resources/views/client/dashboard.blade.php`

Both extend Laravel Breeze's `app` layout and use your Deep Teal theme.

---

## Security Best Practices

### 1. Change Default Password

After first login as admin:
1. Go to Profile
2. Change password to something secure
3. Save changes

### 2. Email Verification (Optional)

Enable email verification in Laravel Breeze:
- Uncomment `verified` middleware in routes
- Configure mail settings
- Users must verify email before accessing dashboard

### 3. Rate Limiting

Laravel Breeze includes rate limiting on login attempts to prevent brute force attacks.

### 4. CSRF Protection

All forms include CSRF tokens automatically via `@csrf` directive.

### 5. Password Hashing

Passwords are automatically hashed using bcrypt (Laravel default).

---

## Testing

### Test Admin Access

```bash
# Start server
php artisan serve

# In browser:
1. Visit http://127.0.0.1:8000
2. Click "Login"
3. Enter: admin@realwebdevelopment.com / password
4. Should redirect to /admin/dashboard
5. Should see list of clients (if any exist)
```

### Test Client Registration

```bash
# In browser:
1. Visit http://127.0.0.1:8000
2. Click "Register"
3. Fill out form with test data
4. Submit
5. Should redirect to /client/dashboard
6. Should see personalized welcome
```

### Test Access Control

```bash
# As client user:
1. Try to visit /admin/dashboard
2. Should be denied and redirected to /client/dashboard
3. Should see error message
```

---

## Troubleshooting

### "Admin already exists" Error

If you see this when running the seeder:

```bash
# Reset database and re-seed
php artisan migrate:fresh
php artisan db:seed --class=AdminSeeder
```

### Can't Login After Registration

Check that:
1. Database migration was run: `php artisan migrate`
2. User was created: Check `users` table in database
3. Password is correct
4. Email is valid

### Redirected to Wrong Dashboard

Check:
1. User's role in database: `SELECT role FROM users WHERE email = 'your@email.com'`
2. Should be either 'admin' or 'client'
3. If incorrect, update manually

### Styling Issues

If dashboards don't look right:
1. Make sure Vite is built: `npm run build`
2. Clear browser cache
3. Check that CSS file loads
4. Verify Deep Teal color variables in CSS

---

## Advanced Features (Future)

### Email Notifications
- Welcome email on registration
- Password reset emails
- Admin notifications for new users

### Two-Factor Authentication
- Add Laravel Fortify
- SMS or TOTP authentication
- Enhanced security for admin

### User Management
- Admin can edit user details
- Admin can delete users
- Admin can change user roles
- Bulk actions

### Client Projects
- Clients can create projects
- Upload files and documents
- Track project status
- Communication with admin

### API Access
- RESTful API for dashboards
- Token-based authentication
- Mobile app support

---

## Commands Reference

```bash
# Create new admin user
php artisan db:seed --class=AdminSeeder

# Reset database and reseed
php artisan migrate:fresh --seed

# Create new seeder
php artisan make:seeder ClientSeeder

# Create new middleware
php artisan make:middleware RoleMiddleware

# Create new controller
php artisan make:controller Admin/UsersController
```

---

## Support

For authentication issues or questions:
- Laravel Breeze Docs: https://laravel.com/docs/12.x/starter-kits
- Laravel Auth Docs: https://laravel.com/docs/12.x/authentication

---

**Your authentication system is ready to use! Start by logging in as admin at http://127.0.0.1:8000/login**
