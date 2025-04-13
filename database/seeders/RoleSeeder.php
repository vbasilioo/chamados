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

        // Criar funções
        $admin = Role::create(['name' => 'admin']);
        $operador = Role::create(['name' => 'operador']);
        $usuario = Role::create(['name' => 'usuario']);

        // Criar permissões para gerenciar usuários
        $manageUsers = Permission::create(['name' => 'manage users']);
        
        // Criar permissões para tickets
        $viewAllTickets = Permission::create(['name' => 'view all tickets']);
        $manageAllTickets = Permission::create(['name' => 'manage all tickets']);
        
        // Atribuir permissões às funções
        $admin->givePermissionTo([
            $manageUsers,
            $viewAllTickets,
            $manageAllTickets,
        ]);
        
        $operador->givePermissionTo([
            $viewAllTickets,
            $manageAllTickets,
        ]);
        
        // Usuário normal não recebe permissões específicas, 
        // pois ele já pode gerenciar seus próprios tickets
    }
}
