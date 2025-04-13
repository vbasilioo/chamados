<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::create([
            'name' => 'Hardware',
            'description' => 'Problemas relacionados a equipamentos',
        ]);

        Category::create([
            'name' => 'Software',
            'description' => 'Problemas relacionados a programas',
        ]);

        Category::create([
            'name' => 'Rede',
            'description' => 'Problemas de conectividade',
        ]);

        Category::create([
            'name' => 'Outros',
            'description' => 'Outros tipos de problemas',
        ]);
    }
} 