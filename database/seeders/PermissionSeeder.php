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

            // Roles
            ['name' => 'view_roles', 'description' => 'Visualizar funções', 'guard_name' => 'web'],
            ['name' => 'create_roles', 'description' => 'Criar funções', 'guard_name' => 'web'],
            ['name' => 'edit_roles', 'description' => 'Editar funções', 'guard_name' => 'web'],
            ['name' => 'delete_roles', 'description' => 'Excluir funções', 'guard_name' => 'web'],

            // Categorias
            ['name' => 'view_categorias', 'description' => 'Visualizar categorias', 'guard_name' => 'web'],
            ['name' => 'create_categorias', 'description' => 'Criar categorias', 'guard_name' => 'web'],
            ['name' => 'edit_categorias', 'description' => 'Editar categorias', 'guard_name' => 'web'],
            ['name' => 'delete_categorias', 'description' => 'Excluir categorias', 'guard_name' => 'web'],
            ['name' => 'restore_categorias', 'description' => 'Restaurar categorias', 'guard_name' => 'web'],
            ['name' => 'force_delete_categorias', 'description' => 'Excluir permanentemente categorias', 'guard_name' => 'web'],

            // Logs
            ['name' => 'view_logs', 'description' => 'Visualizar logs de atividade', 'guard_name' => 'web'],

            // Usuários
            ['name' => 'view_users', 'description' => 'Visualizar usuários', 'guard_name' => 'web'],
            ['name' => 'create_users', 'description' => 'Criar usuários', 'guard_name' => 'web'],
            ['name' => 'edit_users', 'description' => 'Editar usuários', 'guard_name' => 'web'],
            ['name' => 'delete_users', 'description' => 'Excluir usuários', 'guard_name' => 'web'],
            ['name' => 'restore_users', 'description' => 'Restaurar usuários', 'guard_name' => 'web'],
            ['name' => 'force_delete_users', 'description' => 'Excluir permanentemente usuários', 'guard_name' => 'web'],

            // Sinais
            ['name' => 'view_sinais', 'description' => 'Visualizar sinais', 'guard_name' => 'web'],
            ['name' => 'create_sinais', 'description' => 'Criar sinais', 'guard_name' => 'web'],
            ['name' => 'edit_sinais', 'description' => 'Editar sinais', 'guard_name' => 'web'],
            ['name' => 'delete_sinais', 'description' => 'Excluir sinais', 'guard_name' => 'web'],
            ['name' => 'restore_sinais', 'dePscription' => 'Restaurar sinais', 'guard_name' => 'web'],
            ['name' => 'force_delete_sinais', 'description' => 'Excluir permanentemente sinais', 'guard_name' => 'web'],
        ];

        foreach ($permissions as $permission) {
            Permission::create($permission);
        }
    }
}
