# Spatie Permission Setup Documentation

## Overview
Spatie Permission has been successfully installed and configured with 3 roles (Admin, HotelOwner, User) and 22 permissions.

---

## Installation Steps Completed

### Step 1: Package Installation ✅
- Installed `spatie/laravel-permission` v6.24.1
- Command: `composer require spatie/laravel-permission`

### Step 2: Configuration & Migrations ✅
- Published configuration files
- Created migration file: `2026_02_11_080905_create_spatie_permission_tables.php`
- Migration creates tables:
  - `permissions` - Stores permission names
  - `roles` - Stores role names
  - `model_has_permissions` - Associates permissions to users/models
  - `model_has_roles` - Associates roles to users/models
  - `role_has_permissions` - Associates permissions to roles

### Step 3: Database Migrations ✅
- Ran `php artisan migrate`
- All permission tables created successfully

### Step 4: Seeder Creation ✅
- Created `RoleAndPermissionSeeder` class
- File: `database/seeders/RoleAndPermissionSeeder.php`
- Created 3 roles with assigned permissions
- Seeded the database

### Step 5: User Model Updated ✅
- Added `HasRoles` trait to User model
- File: `app/Models/User.php`
- Now users can be assigned roles and permissions

---

## Roles & Permissions Overview

### 1. Admin Role
**Permissions (22 total - ALL permissions):**
- view_dashboard, view_users, create_user, edit_user, delete_user
- view_hotels, create_hotel, edit_hotel, delete_hotel
- view_rooms, create_room, edit_room, delete_room
- view_bookings, create_booking, edit_booking, delete_booking
- view_reviews, create_review, delete_review
- manage_roles, manage_permissions

### 2. Hotel Owner Role
**Permissions (11 total):**
- view_dashboard
- view_hotels, create_hotel, edit_hotel, delete_hotel
- view_rooms, create_room, edit_room, delete_room
- view_bookings
- view_reviews

### 3. User Role
**Permissions (6 total):**
- view_dashboard
- view_hotels
- view_bookings, create_booking
- view_reviews, create_review

---

## How to Use

### Assigning Roles to Users
```php
$user = User::find(1);

// Assign a single role
$user->assignRole('admin');

// Assign multiple roles
$user->assignRole(['admin', 'hotel_owner']);

// Check if user has role
$user->hasRole('admin');

// Get all roles
$user->getRoleNames();
```

### Working with Permissions
```php
$user = User::find(1);

// Check if user has permission
$user->can('create_hotel');

// Check if user has any of the permissions
$user->hasAnyPermission(['create_hotel', 'edit_hotel']);

// Check if user has all permissions
$user->hasAllPermissions(['create_hotel', 'edit_hotel']);
```

### In Middleware/Routes
```php
// Protect routes with role middleware
Route::post('/hotels', [HotelController::class, 'store'])
    ->middleware('role:admin|hotel_owner');

// Protect routes with permission middleware
Route::delete('/hotels/{hotel}', [HotelController::class, 'destroy'])
    ->middleware('permission:delete_hotel');
```

### In Controllers
```php
public function create()
{
    if (!auth()->user()->can('create_hotel')) {
        abort(403);
    }
    // ... create hotel logic
}
```

### In Blade Templates
```blade
@can('create_hotel')
    <button>Create Hotel</button>
@endcan

@role('admin')
    <button>Admin Panel</button>
@endrole

@hasrole('hotel_owner')
    <button>Manage Your Hotels</button>
@endhasrole
```

---

## Verification Command
To verify all roles and permissions are correctly set up:
```bash
php artisan app:verify-roles-permissions
```

---

## Files Created/Modified

### Created:
- `database/seeders/RoleAndPermissionSeeder.php` - Role and permission seeder
- `database/migrations/2026_02_11_080905_create_spatie_permission_tables.php` - Permission tables migration
- `app/Console/Commands/VerifyRolesAndPermissions.php` - Verification command

### Modified:
- `database/seeders/DatabaseSeeder.php` - Added RoleAndPermissionSeeder call
- `app/Models/User.php` - Added HasRoles trait

---

## Useful Commands

```bash
# List all roles
php artisan permission:show

# List all permissions
php artisan permission:show --permissions

# Clear cached permissions (if you add new permissions)
php artisan permission:cache-reset

# Run the verification command
php artisan app:verify-roles-permissions
```

---

## Next Steps

1. **Assign Roles to Users**: Create users and assign appropriate roles
2. **Add Authorization**: Use middleware and policies to protect routes/actions
3. **Test Permissions**: Use Blade directives or Controller checks to verify permissions
4. **Create Admin Panel**: Build interface to manage roles and permissions dynamically

---

**Setup Date**: February 11, 2026
**Package**: spatie/laravel-permission v6.24.1
**Status**: ✅ Complete and Verified
