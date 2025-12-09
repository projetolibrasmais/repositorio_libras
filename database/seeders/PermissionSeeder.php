<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            // Permissions
            ['name' => 'view_permissions', 'description' => 'Visualizar permissões', 'guard_name' => 'web'],

            //Roles
            ['name' => 'view_roles', 'description' => 'Visualizar funções', 'guard_name' => 'web'],
            ['name' => 'create_roles', 'description' => 'Criar funções', 'guard_name' => 'web'],
            ['name' => 'edit_roles', 'description' => 'Editar funções', 'guard_name' => 'web'],
            ['name' => 'delete_roles', 'description' => 'Excluir funções', 'guard_name' => 'web'],

            //Categorias
            ['name' => 'view_categorias', 'description' => 'Visualizar categorias', 'guard_name' => 'web'],
            ['name' => 'create_categorias', 'description' => 'Criar categorias', 'guard_name' => 'web'],
            ['name' => 'edit_categorias', 'description' => 'Editar categorias', 'guard_name' => 'web'],
            ['name' => 'delete_categorias', 'description' => 'Excluir categorias', 'guard_name' => 'web'],
        ];

        foreach ($permissions as $permission) {
            Permission::create($permission);
        }
    }
}
