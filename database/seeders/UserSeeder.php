<?php

// database/seeds/UserSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Create admin user
        $superAdminUser = User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@example.com',
            'password' => bcrypt('12345678'),
        ]);

        $superAdminRole = Role::findByName('super-admin');
        $superAdminUser->assignRole($superAdminRole);

        // Create regular user
        $adminUser = User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('12345678'),
        ]);

        $adminRole = Role::findByName('admin');
        $adminUser->assignRole($adminRole);
    }
}