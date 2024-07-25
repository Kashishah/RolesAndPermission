<?php
// database/seeds/RolePermissionSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run()
    {
        // Assign permissions to roles
        $superAdminRole = Role::findByName('super-admin');
        $adminRole = Role::findByName('admin');

        $superAdminRole->givePermissionTo([
            'Delete Permission', 
            'Edit Permission', 
            'Create Permission',
            'View Permission', 
            'Index Permission',
            'See Buttons Permission',
            'Access Role controller',
            'Access Permission controller',
            'Access User controller'
        ]);

        $adminRole->givePermissionTo([
            'View Permission', 
            'Index Permission',
            'See Buttons Permission',
            'Access Role controller',
            'Access Permission controller'
        ]);
    }
}
