<?php

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {

        $roles = [
            ['name' => 'admin',
            'description' => 'es el administrador de la pagina, posee todos los permisos'],

            ['name' => 'empleado',
            'description' => 'es el usuario regular de la aplicacion']
        ];

        DB::table('roles')->insert($roles);
    }
}
