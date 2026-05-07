<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create Permissions
        Permission::create(['name' => 'view_dashboard']);
        Permission::create(['name' => 'view_users']);
        Permission::create(['name' => 'create_user']);
        Permission::create(['name' => 'edit_user']);
        Permission::create(['name' => 'delete_user']);

        Permission::create(['name' => 'view_hotels']);
        Permission::create(['name' => 'create_hotel']);
        Permission::create(['name' => 'edit_hotel']);
        Permission::create(['name' => 'delete_hotel']);

        Permission::create(['name' => 'view_rooms']);
        Permission::create(['name' => 'create_room']);
        Permission::create(['name' => 'edit_room']);
        Permission::create(['name' => 'delete_room']);

        Permission::create(['name' => 'view_bookings']);
        Permission::create(['name' => 'create_booking']);
        Permission::create(['name' => 'edit_booking']);
        Permission::create(['name' => 'delete_booking']);

        Permission::create(['name' => 'view_reviews']);
        Permission::create(['name' => 'create_review']);
        Permission::create(['name' => 'delete_review']);

        Permission::create(['name' => 'manage_roles']);
        Permission::create(['name' => 'manage_permissions']);

        // Create Roles and Assign Permissions

        // Admin Role - Has all permissions
        $adminRole = Role::create(['name' => 'admin']);
        $adminRole->givePermissionTo(Permission::all());

        // HotelOwner Role - Can manage hotels, rooms, bookings, and reviews
        $hotelOwnerRole = Role::create(['name' => 'hotel_owner']);
        $hotelOwnerRole->givePermissionTo([
            'view_dashboard',
            'view_hotels',
            'create_hotel',
            'edit_hotel',
            'delete_hotel',
            'view_rooms',
            'create_room',
            'edit_room',
            'delete_room',
            'view_bookings',
            'view_reviews',
        ]);

        // User Role - Can view hotels, bookings, and create reviews
        $userRole = Role::create(['name' => 'user']);
        $userRole->givePermissionTo([
            'view_dashboard',
            'view_hotels',
            'view_bookings',
            'create_booking',
            'view_reviews',
            'create_review',
        ]);
    }
}
