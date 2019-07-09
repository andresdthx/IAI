<?php

use Illuminate\Database\Seeder;
use App\{User, Role};


class UsersTableSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        // $user = new User();
        // $user->name = 'admin';
        // $user->email = 'admin@iamd.com';
        // $user->password = bcrypt('administrador');
        // $user->save();
        // $role = Role::where('name', 'admin')->get();
        //$user->roles()->attach($role[0]->id);

        $user = new User();
        $user->name = 'Luis Eduardo Rodriguez Cheu';
        $user->email = 'luis.rodriguez@escuelaing.edu.co';
        $user->password = bcrypt('password');
        $user->save();
        $role = Role::where('name', 'admin')->get();
        $user->roles()->attach($role[0]->id);

        $user = new User();
        $user->name = 'Martha Pimienta';
        $user->email = 'martha.pimienta@escuelaing.edu.co';
        $user->password = bcrypt('password');
        $user->save();
        $role = Role::where('name', 'admin')->get();
        $user->roles()->attach($role[0]->id);

        $user = new User();
        $user->name = 'Franklin Páez';
        $user->email = 'franklin.paez@escuelaing.edu.co';
        $user->password = bcrypt('password');
        $user->save();
        $role = Role::where('name', 'admin')->get();
        $user->roles()->attach($role[0]->id);

        $user = new User();
        $user->name = 'Paola Mora';
        $user->email = 'paola.mora@escuelaing.edu.co';
        $user->password = bcrypt('password');
        $user->save();
        $role = Role::where('name', 'empleado')->get();
        $user->roles()->attach($role[0]->id);
    }
    
}
