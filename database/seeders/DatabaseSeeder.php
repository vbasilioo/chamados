<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // Executar o Role Seeder primeiro
        $this->call(RoleSeeder::class);
        
        // Criar usuário admin
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
        ]);
        $admin->assignRole('admin');
        
        // Criar usuário operador
        $operador = User::create([
            'name' => 'Operador',
            'email' => 'operador@example.com',
            'password' => Hash::make('password'),
        ]);
        $operador->assignRole('operador');
        
        // Criar usuário normal
        $usuario = User::create([
            'name' => 'Usuário',
            'email' => 'usuario@example.com',
            'password' => Hash::make('password'),
        ]);
        $usuario->assignRole('usuario');

        $this->call([
            CategorySeeder::class,
        ]);
    }
}
