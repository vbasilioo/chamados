<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create roles
        $adminRole = Role::create(['name' => 'admin']);
        $userRole = Role::create(['name' => 'user']);

        // Create permissions
        $permissions = [
            // Dashboard permissions
            'view dashboard',
            'view stats',
            'view charts',
            'view activities',
            
            // User management permissions
            'create users',
            'edit users',
            'delete users',
            'view users',
            
            // Ticket management permissions
            'create tickets',
            'edit tickets',
            'delete tickets',
            'view tickets',
            'assign tickets',
            'change ticket status',
            
            // Profile permissions
            'edit profile',
            'view profile'
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Assign permissions to roles
        $adminRole->givePermissionTo(Permission::all());
        $userRole->givePermissionTo([
            'create tickets',
            'view tickets',
            'edit profile',
            'view profile'
        ]);

        // Create admin user
        $admin = User::create([
            'name' => 'Administrador',
            'email' => 'admin@example.com',
            'password' => 'password', // Será hasheado pelo mutator
        ]);

        $admin->assignRole('admin');

        // Create regular user
        $user = User::create([
            'name' => 'Usuário',
            'email' => 'user@example.com',
            'password' => 'password', // Será hasheado pelo mutator
        ]);

        $user->assignRole('user');
    }
}
