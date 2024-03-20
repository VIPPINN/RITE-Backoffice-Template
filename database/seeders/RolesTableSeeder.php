<?php

namespace Database\Seeders;

use Spatie\Permission\Models\Role;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         // Crear un rol
         $adminRole = Role::create(['name' => 'admin']);
        
         // Crear otro rol
         $userRole = Role::create(['name' => 'user']);
         
         // Asignar permisos al rol de admin
         $adminRole->syncPermissions([
             'create-post',
             'edit-post',
             'delete-post',
         ]);
         
         // Asignar permisos al rol de user
         $userRole->syncPermissions([
             'create-post',
             'edit-post',
         ]);
    }
}
