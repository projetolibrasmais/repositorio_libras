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
        $adminRole = Role::create([
            'name' => 'Administrador',
            'guard_name' => 'web',
        ]);
        $permissions = Permission::all();
        $adminRole->syncPermissions($permissions);

        $interpreterRole = Role::create([
            'name' => 'Intérprete',
            'guard_name' => 'web',
        ]);
        $interpreterRole->syncPermissions([
            'view_sinais',
            'create_sinais',
            'edit_sinais',
            'view_categorias',
        ]);

        $researcherRole = Role::create([
            'name' => 'Pesquisador',
            'guard_name' => 'web',
        ]);
        $researcherRole->syncPermissions([
            'view_sinais',
            'view_categorias',
            'view_materiais',
            'create_materiais',
            'edit_materiais',
        ]);
    }
}
