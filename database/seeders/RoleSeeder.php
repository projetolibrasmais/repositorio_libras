<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $superAdminRole = Role::create([
            'name' => 'Super-Admin',
            'guard_name' => 'web',
        ]);
        $adminRole = Role::create([
            'name' => 'Administrador',
            'guard_name' => 'web',
        ]);
        $interpreterRole = Role::create([
            'name' => 'Interprete',
            'guard_name' => 'web',
        ]);
        $pesquisadorRole = Role::create([
            'name' => 'Pesquisador',
            'guard_name' => 'web',
        ]);

        // Assign permissions to roles
        $superAdminRole->syncPermissions(Permission::all());
        $adminRole->syncPermissions(Permission::whereIn('name', [
            'view_permissions',
            'view_roles', 'create_roles', 'edit_roles', 'delete_roles',
            'view_categorias', 'create_categorias', 'edit_categorias', 'delete_categorias', 'restore_categorias', 'force_delete_categorias',
            'view_materiais', 'create_materiais', 'edit_materiais', 'delete_materiais', 'restore_materiais', 'force_delete_materiais',
            'view_logs',
            'view_users', 'create_users', 'edit_users', 'delete_users', 'restore_users', 'force_delete_users',
            'view_sinais', 'create_sinais', 'edit_sinais', 'delete_sinais', 'restore_sinais', 'force_delete_sinais',
            'view_contatos', 'edit_contatos',
        ])->get());
        $interpreterRole->syncPermissions(Permission::whereIn('name', [
            'view_categorias', 'view_sinais', 'create_sinais', 'edit_sinais',
        ])->get());
        $pesquisadorRole->syncPermissions(Permission::whereIn('name', [
            'view_categorias', 'view_materiais', 'create_materiais', 'edit_materiais',
            'view_sinais', 'create_sinais', 'edit_sinais',
        ])->get());
    }
}
