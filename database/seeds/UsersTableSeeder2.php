<?php

use Illuminate\Database\Seeder;
use App\{User, Role};


class UsersTableSeeder2 extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $user = new User();
        $user->name = 'Hernan Paz';
        $user->email = 'hernan.paz@escuelaing.edu.co';
        $user->cargo = 'Director del Grupo de Investigación Ecitrónica';
        $user->password = bcrypt('password');
        $user->save();
        $role = Role::where('name', 'empleado')->get();
        $user->roles()->attach($role[0]->id);

        $user = new User();
        $user->name = 'Julian Agredo';
        $user->email = 'julian.agredo@escuelaing.edu.co';
        $user->cargo = 'Director del Grupo de Investigación en Matemáticas de la Escuela Colombiana de Ingeniería – GIMATH';
        $user->password = bcrypt('password');
        $user->save();
        $role = Role::where('name', 'empleado')->get();
        $user->roles()->attach($role[0]->id);
        
        $user = new User();
        $user->name = 'Victoria Ospina';
        $user->email = 'victoria.ospina@escuelaing.edu.co';
        $user->cargo = 'Directora del Grupo de Investigación CTG - Informática';
        $user->password = bcrypt('password');
        $user->save();
        $role = Role::where('name', 'empleado')->get();
        $user->roles()->attach($role[0]->id);

        $user = new User();
        $user->name = 'Ivan Duran';
        $user->email = 'ivan.duran@escuelaing.edu.co';
        $user->cargo = 'Director del Grupo de Investigación Modelación Estratégica en Energía y Potencia - MEEP';
        $user->password = bcrypt('password');
        $user->save();
        $role = Role::where('name', 'empleado')->get();
        $user->roles()->attach($role[0]->id);

        $user = new User();
        $user->name = 'Irma Vaquero';
        $user->email = 'irma.baquero@escuelaing.edu.co';
        $user->cargo = 'Directora del Grupo de Investigación Estudios Socioeconómicos';
        $user->password = bcrypt('password');
        $user->save();
        $role = Role::where('name', 'empleado')->get();
        $user->roles()->attach($role[0]->id);
        
        $user = new User();
        $user->name = 'German Santos';
        $user->email = 'german.santos@escuelaing.edu.co';
        $user->cargo = 'Director del Grupo de Investigación Centro de Estudios Hidráulicos';
        $user->password = bcrypt('password');
        $user->save();
        $role = Role::where('name', 'empleado')->get();
        $user->roles()->attach($role[0]->id);

        $user = new User();
        $user->name = 'Eduardo Sarmiento';
        $user->email = 'eduardo.sarmiento@escuelaing.edu.co';
        $user->cargo = 'Director del Grupo de Investigación Centro de Estudios Económicos';
        $user->password = bcrypt('password');
        $user->save();
        $role = Role::where('name', 'empleado')->get();
        $user->roles()->attach($role[0]->id);

        $user = new User();
        $user->name = 'Hector Matamoros';
        $user->email = 'hector.matamoros@escuelaing.edu.co';
        $user->cargo = 'Director del Grupo de Investigación Centro de Estudios Ambientales';
        $user->password = bcrypt('password');
        $user->save();
        $role = Role::where('name', 'empleado')->get();
        $user->roles()->attach($role[0]->id);

        $user = new User();
        $user->name = 'Adriana Esguerra';
        $user->email = 'adriana.esguerra@escuelaing.edu.co';
        $user->cargo = 'Directora del Grupo de Investigación Centro de Investigaciones en Manufactura y Servicios - CIMSER';
        $user->password = bcrypt('password');
        $user->save();
        $role = Role::where('name', 'empleado')->get();
        $user->roles()->attach($role[0]->id);

        $user = new User();
        $user->name = 'Sandra Campagnoli';
        $user->email = 'sandra.campagnoli@escuelaing.edu.co';
        $user->cargo = 'Directora del Grupo de Investigación en Geotecnia';
        $user->password = bcrypt('password');
        $user->save();
        $role = Role::where('name', 'empleado')->get();
        $user->roles()->attach($role[0]->id);

        $user = new User();
        $user->name = 'Monica Suarez';
        $user->email = 'monica.suarez@escuelaing.edu.co';
        $user->cargo = 'Directora del Grupo de Investigación en Vías y Transporte';
        $user->password = bcrypt('password');
        $user->save();
        $role = Role::where('name', 'empleado')->get();
        $user->roles()->attach($role[0]->id);

        $user = new User();
        $user->name = 'Sandra Jerez';
        $user->email = 'sandra.jerez@escuelaing.edu.co';
        $user->cargo = 'Directora Grupo de Investigación en Estructuras y Materiales';
        $user->password = bcrypt('password');
        $user->save();
        $role = Role::where('name', 'empleado')->get();
        $user->roles()->attach($role[0]->id);

        $user = new User();
        $user->name = 'Miguel Montoya';
        $user->email = 'miguel.montoyav@escuelaing.edu.co';
        $user->cargo = '	
        Director del Grupo de Investigación Diseño sostenible en ingeniería mecánica (DSIM)';
        $user->password = bcrypt('password');
        $user->save();
        $role = Role::where('name', 'empleado')->get();
        $user->roles()->attach($role[0]->id);

        $user = new User();
        $user->name = 'Jose Rodriguez';
        $user->email = 'jose.rodriguez@escuelaing.edu.co';
        $user->cargo = 'Director del Grupo de Investigación Desarrollo y Gerencia Integral de Proyectos';
        $user->password = bcrypt('password');
        $user->save();
        $role = Role::where('name', 'empleado')->get();
        $user->roles()->attach($role[0]->id);

        $user = new User();
        $user->name = 'Liliana Pedraza';
        $user->email = 'liliana.pedraza@escuelaing.edu.co';
        $user->cargo = 'Director del Grupo de Investigación Innovación Docente e Investigación Educativa-INNOVAD-IE';
        $user->password = bcrypt('password');
        $user->save();
        $role = Role::where('name', 'empleado')->get();
        $user->roles()->attach($role[0]->id);
    }
    
}
