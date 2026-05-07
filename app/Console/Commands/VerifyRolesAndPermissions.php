<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class VerifyRolesAndPermissions extends Command
{
    protected $signature = 'app:verify-roles-permissions';
    protected $description = 'Verify roles and permissions are set up correctly';

    public function handle()
    {
        $this->info('=== Roles and Permissions Verification ===\n');

        $roles = Role::all();

        foreach ($roles as $role) {
            $this->line("Role: <info>{$role->name}</info>");
            $permissions = $role->permissions;
            if ($permissions->count() > 0) {
                foreach ($permissions as $permission) {
                    $this->line("  ✓ {$permission->name}");
                }
            } else {
                $this->line("  (No permissions assigned)");
            }
            $this->line('');
        }

        $this->info('Total Roles: ' . $roles->count());
        $this->info('Total Permissions: ' . Permission::count());
    }
}
