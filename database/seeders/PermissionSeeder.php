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
            ['name' => 'view_permissions', 'description' => 'View permissions', 'guard_name' => 'web'],

            //Roles
            ['name' => 'view_roles', 'description' => 'View roles', 'guard_name' => 'web'],
            ['name' => 'create_roles', 'description' => 'Create roles', 'guard_name' => 'web'],
            ['name' => 'edit_roles', 'description' => 'Edit roles', 'guard_name' => 'web'],
            ['name' => 'delete_roles', 'description' => 'Delete roles', 'guard_name' => 'web'],

            //Categorias
            ['name' => 'view_categorias', 'description' => 'View categorias', 'guard_name' => 'web'],
            ['name' => 'create_categorias', 'description' => 'Create categorias', 'guard_name' => 'web'],
            ['name' => 'edit_categorias', 'description' => 'Edit categorias', 'guard_name' => 'web'],
            ['name' => 'delete_categorias', 'description' => 'Delete categorias', 'guard_name' => 'web'],
        ];

        foreach ($permissions as $permission) {
            Permission::create($permission);
        }
    }
}
