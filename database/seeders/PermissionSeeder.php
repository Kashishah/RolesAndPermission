<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    public function run()
    {
        // Create permissions
        $permissions = [
            'Delete Permission', 
            'Edit Permission', 
            'Create Permission',
            'View Permission', 
            'Index Permission',
            'See Buttons Permission',
            'Access Role controller',
            'Access Permission controller',
            'Access User controller',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }
    }
}
