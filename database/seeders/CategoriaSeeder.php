<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategoriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            // Permissions
            ['name' => 'view_permissions', 'description' => 'View permissions', 'guard_name' => 'web'],

            //Categorias
            
        ];

        foreach ($permissions as $permission) {
            Permission::create($permission);
        }
    }
}
