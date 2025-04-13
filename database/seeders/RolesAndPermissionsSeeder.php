<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        // Dashboard permissions
        Permission::create(['name' => 'view dashboard']);
        Permission::create(['name' => 'view stats']);
        Permission::create(['name' => 'view charts']);
        Permission::create(['name' => 'view activities']);
        
        // User management permissions
        Permission::create(['name' => 'create users']);
        Permission::create(['name' => 'edit users']);
        Permission::create(['name' => 'delete users']);
        Permission::create(['name' => 'view users']);
        
        // Role management permissions
        Permission::create(['name' => 'assign roles']);
        Permission::create(['name' => 'view roles']);
        Permission::create(['name' => 'create roles']);
        Permission::create(['name' => 'edit roles']);
        Permission::create(['name' => 'delete roles']);
        
        // Profile permissions
        Permission::create(['name' => 'edit profile']);
        Permission::create(['name' => 'view profile']);

        // Create roles and assign permissions
        $administratorRole = Role::create(['name' => 'administrator']);
        $administratorRole->givePermissionTo(Permission::all());
        
        $operatorRole = Role::create(['name' => 'operator']);
        $operatorRole->givePermissionTo([
            'view dashboard',
            'view stats',
            'view charts',
            'view activities',
            'view users',
            'edit profile',
            'view profile'
        ]);
        
        $clientRole = Role::create(['name' => 'client']);
        $clientRole->givePermissionTo([
            'edit profile',
            'view profile'
        ]);

        // Create admin user if it doesn't exist
        $admin = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin User',
                'password' => bcrypt('password'),
                'email_verified_at' => now(),
            ]
        );
        $admin->assignRole('administrator');

        // Create operator user
        $operator = User::firstOrCreate(
            ['email' => 'operator@example.com'],
            [
                'name' => 'Operator User',
                'password' => bcrypt('password'),
                'email_verified_at' => now(),
            ]
        );
        $operator->assignRole('operator');

        // Create client user
        $client = User::firstOrCreate(
            ['email' => 'client@example.com'],
            [
                'name' => 'Client User',
                'password' => bcrypt('password'),
                'email_verified_at' => now(),
            ]
        );
        $client->assignRole('client');
    }
}
