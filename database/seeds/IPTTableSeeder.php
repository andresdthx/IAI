<?php

use Illuminate\Database\Seeder;
use App\{User, Role};

class IPTTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User();
        $user->name = 'Daniela';
        $user->email = 'daniela.lopera@olartemoure.com';
        $user->password = bcrypt('password');
        $user->save();
        $role = Role::where('name', 'admin')->get();
        $user->roles()->attach($role[0]->id);

        $user = new User();
        $user->name = 'Carlos';
        $user->email = 'carlos.parra@olartemoure.com';
        $user->password = bcrypt('password');
        $user->save();
        $role = Role::where('name', 'admin')->get();
        $user->roles()->attach($role[0]->id);

        $user = new User();
        $user->name = 'Ilis';
        $user->email = 'yaneth.perez@olartemoure.com';
        $user->password = bcrypt('password');
        $user->save();
        $role = Role::where('name', 'admin')->get();
        $user->roles()->attach($role[0]->id);

        $user = new User();
        $user->name = 'Jose Jairo';
        $user->email = 'jose.dangond@olartemoure.com';
        $user->password = bcrypt('password');
        $user->save();
        $role = Role::where('name', 'admin')->get();
        $user->roles()->attach($role[0]->id);

        $user = new User();
        $user->name = 'Juan Carlos';
        $user->email = 'juan.suarez@olartemoure.com';
        $user->password = bcrypt('password');
        $user->save();
        $role = Role::where('name', 'admin')->get();
        $user->roles()->attach($role[0]->id);

        $user = new User();
        $user->name = 'Luciana';
        $user->email = 'estudiante.lmm@gmail.com';
        $user->password = bcrypt('password');
        $user->save();
        $role = Role::where('name', 'admin')->get();
        $user->roles()->attach($role[0]->id);

        $user = new User();
        $user->name = 'Anngy';
        $user->email = 'anngy.gutierrez@olartemoure.com';
        $user->password = bcrypt('password');
        $user->save();
        $role = Role::where('name', 'admin')->get();
        $user->roles()->attach($role[0]->id);
    }
}
