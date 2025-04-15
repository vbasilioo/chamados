<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Limpar o cache de permissões
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Criar ou atualizar papéis
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $operadorRole = Role::firstOrCreate(['name' => 'operador']);
        $usuarioRole = Role::firstOrCreate(['name' => 'usuario']);

        // Criar ou atualizar permissões
        $manageUsers = Permission::firstOrCreate(['name' => 'manage users']);
        $viewAllTickets = Permission::firstOrCreate(['name' => 'view all tickets']);
        $manageAllTickets = Permission::firstOrCreate(['name' => 'manage all tickets']);
        
        // Atribuir permissões às funções
        $adminRole->syncPermissions([
            $manageUsers,
            $viewAllTickets,
            $manageAllTickets,
        ]);
        
        $operadorRole->syncPermissions([
            $viewAllTickets,
            $manageAllTickets,
        ]);
        
        // Usuário normal não recebe permissões específicas, 
        // pois ele já pode gerenciar seus próprios tickets
    }
}
