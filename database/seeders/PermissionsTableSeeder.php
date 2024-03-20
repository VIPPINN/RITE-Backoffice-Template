<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         // Crear un permiso
         Permission::create(['name' => 'create-post']);
        
         // Crear otro permiso
         Permission::create(['name' => 'edit-post']);
         
         // Crear un permiso más
         Permission::create(['name' => 'delete-post']);
    }
}
