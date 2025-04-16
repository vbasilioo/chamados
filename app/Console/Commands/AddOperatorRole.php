<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class AddOperatorRole extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'role:add-operator {email? : Email do usuário que receberá o papel de operador}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Adiciona o papel de operador ao sistema e opcionalmente atribui a um usuário';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Verificando papel de operador...');

        // Verifica se o papel já existe
        $operatorRole = Role::where('name', 'operador')->first();
        
        if (!$operatorRole) {
            $this->info('Criando papel de operador...');
            $operatorRole = Role::create(['name' => 'operador']);
            
            // Adiciona permissões ao papel de operador
            $permissions = [
                'view dashboard',
                'view stats',
                'view charts',
                'view activities',
                'view tickets',
                'edit tickets',
                'change ticket status',
                'accept tickets',
                'edit profile',
                'view profile'
            ];
            
            foreach ($permissions as $permissionName) {
                $permission = Permission::where('name', $permissionName)->first();
                if ($permission) {
                    $operatorRole->givePermissionTo($permission);
                } else {
                    $this->warn("Permissão '$permissionName' não encontrada. Criando...");
                    $permission = Permission::create(['name' => $permissionName]);
                    $operatorRole->givePermissionTo($permission);
                }
            }
            
            $this->info('Papel de operador criado com sucesso!');
        } else {
            $this->info('Papel de operador já existe.');
        }
        
        // Se foi fornecido um email, atribui o papel ao usuário
        $email = $this->argument('email');
        if ($email) {
            $user = User::where('email', $email)->first();
            
            if (!$user) {
                $this->error("Usuário com email '$email' não encontrado.");
                return Command::FAILURE;
            }
            
            $user->assignRole($operatorRole);
            $this->info("Papel de operador atribuído ao usuário {$user->name} com sucesso!");
        }
        
        if (!$email && !$this->confirm('Deseja criar um usuário operador padrão?')) {
            return Command::SUCCESS;
        }
        
        // Cria um usuário operador padrão se não existir
        if (!User::where('email', 'operator@example.com')->exists()) {
            $this->info('Criando usuário operador padrão...');
            
            $user = User::create([
                'name' => 'Operador',
                'email' => 'operator@example.com',
                'password' => 'password',
            ]);
            
            $user->assignRole($operatorRole);
            
            $this->info('Usuário operador padrão criado com sucesso!');
            $this->info('Email: operator@example.com');
            $this->info('Senha: password');
        } else {
            $this->info('Usuário operador padrão já existe.');
        }
        
        return Command::SUCCESS;
    }
} 