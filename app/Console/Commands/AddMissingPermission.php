<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AddMissingPermission extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'permissions:add-missing';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add missing manage users permission';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Adding missing permissions...');

        // Check if the permission already exists
        if (!Permission::where('name', 'manage users')->exists()) {
            // Create the permission
            $permission = Permission::create(['name' => 'manage users']);
            $this->info('Permission "manage users" created successfully.');
            
            // Assign to admin role
            $adminRole = Role::findByName('admin');
            $adminRole->givePermissionTo($permission);
            $this->info('Permission assigned to admin role.');
        } else {
            $this->info('Permission "manage users" already exists.');
        }

        $this->info('Done!');

        return Command::SUCCESS;
    }
} 