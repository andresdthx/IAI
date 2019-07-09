<?php

use Illuminate\Database\Seeder;
use App\{User, Role};


class UserTableSeederSemillero extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        // $user = new User();
        // $user->name = 'Alexander Perez';
        // $user->email = 'alexander.perez@escuelaing.edu.co';
        // $user->cargo = 'Tutor Semillero AgroIngeniería';
        // $user->password = bcrypt('password');
        // $user->save();
        // $role = Role::where('name', 'empleado')->get();
        // $user->roles()->attach($role[0]->id);

        // $user = new User();
        // $user->name = 'Gladyz Gonzalez';
        // $user->email = 'gladys.gonzalez@escuelaing.edu.co';
        // $user->cargo = 'Tutora Semillero Biología Ambiental';
        // $user->password = bcrypt('password');
        // $user->save();
        // $role = Role::where('name', 'empleado')->get();
        // $user->roles()->attach($role[0]->id);

        // $user = new User();
        // $user->name = 'Raul torrea';
        // $user->email = 'raul.torres@escuelaing.edu.co';
        // $user->cargo = 'Tutor Semillero Cultura organizacional';
        // $user->password = bcrypt('password');
        // $user->save();
        // $role = Role::where('name', 'empleado')->get();
        // $user->roles()->attach($role[0]->id);

        // $user = new User();
        // $user->name = 'Juan Salazar';
        // $user->email = 'juan.salazar-h@escuelaing.edu.co';
        // $user->cargo = 'Tutor Semillero Desarrollo Sostenible';
        // $user->password = bcrypt('password');
        // $user->save();
        // $role = Role::where('name', 'empleado')->get();
        // $user->roles()->attach($role[0]->id);

        // $user = new User();
        // $user->name = 'Camilo Hernandez';
        // $user->email = 'camilo.hernandez@escuelaing.edu.co';
        // $user->cargo = 'Tutor Semillero Diseño Mecánico (SIDIME)';
        // $user->password = bcrypt('password');
        // $user->save();
        // $role = Role::where('name', 'empleado')->get();
        // $user->roles()->attach($role[0]->id);

        // $user = new User();
        // $user->name = 'Ivan Lozada';
        // $user->email = 'ivan.lozada@escuelaing.edu.co';
        // $user->cargo = 'Tutor Semillero Elektronomía';
        // $user->password = bcrypt('password');
        // $user->save();
        // $role = Role::where('name', 'empleado')->get();
        // $user->roles()->attach($role[0]->id);

        // $user = new User();
        // $user->name = 'Ivan Duran';
        // $user->email = 'ivan.duran@escuelaing.edu.co';
        // $user->cargo = 'Tutor Semillero Energía y Potencia';
        // $user->password = bcrypt('password');
        // $user->save();
        // $role = Role::where('name', 'empleado')->get();
        // $user->roles()->attach($role[0]->id);

        $user = new User();
        $user->name = 'Nancy Torres';
        $user->email = 'nancy.torres@escuelaing.edu.co';
        $user->cargo = 'Tutora Semillero Estructuras, Materiales y Construcción - Estructuras de Guadua';
        $user->password = bcrypt('password');
        $user->save();
        $role = Role::where('name', 'empleado')->get();
        $user->roles()->attach($role[0]->id);

        $user = new User();
        $user->name = 'Maria Torres';
        $user->email = 'maria.torrest@escuelaing.edu.co';
        $user->cargo = 'Tutora Semillero Finanzas y la Economía';
        $user->password = bcrypt('password');
        $user->save();
        $role = Role::where('name', 'empleado')->get();
        $user->roles()->attach($role[0]->id);

        $user = new User();
        $user->name = 'Erika Olaya';
        $user->email = 'erika.olaya@escuelaing.edu.co';
        $user->cargo = 'Tutora Semillero Gerencia de proyectos';
        $user->password = bcrypt('password');
        $user->save();
        $role = Role::where('name', 'empleado')->get();
        $user->roles()->attach($role[0]->id);

        $user = new User();
        $user->name = 'Catalina Lozada';
        $user->email = 'catalina.lozada@escuelaing.edu.co';
        $user->cargo = 'Tutora Semillero Geotecnia';
        $user->password = bcrypt('password');
        $user->save();
        $role = Role::where('name', 'empleado')->get();
        $user->roles()->attach($role[0]->id);

        $user = new User();
        $user->name = 'Joan Cruz';
        $user->email = 'joan.cruz@escuelaing.edu.co';
        $user->cargo = 'Tutora Semillero Gestión';
        $user->password = bcrypt('password');
        $user->save();
        $role = Role::where('name', 'empleado')->get();
        $user->roles()->attach($role[0]->id);

        $user = new User();
        $user->name = 'Claudia Rodriguez';
        $user->email = 'claudia.rodriguez@escuelaing.edu.co';
        $user->cargo = 'Tutora Semillero Gestión de procesos empresariales BPM (Business Process Management)';
        $user->password = bcrypt('password');
        $user->save();
        $role = Role::where('name', 'empleado')->get();
        $user->roles()->attach($role[0]->id);

        $user = new User();
        $user->name = 'Oscar Vanegas';
        $user->email = 'oscar.venegas@escuelaing.edu.co';
        $user->cargo = '	
        Tutor Semillero Gestión Energética (SIGEN)';
        $user->password = bcrypt('password');
        $user->save();
        $role = Role::where('name', 'empleado')->get();
        $user->roles()->attach($role[0]->id);

        $user = new User();
        $user->name = 'Angelica Sarmiento';
        $user->email = 'angelica.sarmiento@escuelaing.edu.co';
        $user->cargo = 'Tutora Semillero Gestión y Optimización de Operaciones';
        $user->password = bcrypt('password');
        $user->save();
        $role = Role::where('name', 'empleado')->get();
        $user->roles()->attach($role[0]->id);

        $user = new User();
        $user->name = 'Wilmer Garzon';
        $user->email = 'wilmer.garzon@escuelaing.edu.co';
        $user->cargo = 'Tutor Semillero Grupo de Algoritmia';
        $user->password = bcrypt('password');
        $user->save();
        $role = Role::where('name', 'empleado')->get();
        $user->roles()->attach($role[0]->id);

        $user = new User();
        $user->name = 'Hector Martinez';
        $user->email = 'hector.martinez@escuelaing.edu.co';
        $user->cargo = 'Tutor Semillero Historia Económica';
        $user->password = bcrypt('password');
        $user->save();
        $role = Role::where('name', 'empleado')->get();
        $user->roles()->attach($role[0]->id);

        $user = new User();
        $user->name = 'Marcela Munera';
        $user->email = 'marcela.munera@escuelaing.edu.co';
        $user->cargo = 'Tutora Semillero Ingeniería de la Rehabilitación (SIRA)';
        $user->password = bcrypt('password');
        $user->save();
        $role = Role::where('name', 'empleado')->get();
        $user->roles()->attach($role[0]->id);

        $user = new User();
        $user->name = 'Maria Acero';
        $user->email = 'maria.acero@escuelaing.edu.co';
        $user->cargo = 'Tutora Semillero Ingeniería Clínica (SICLIC)';
        $user->password = bcrypt('password');
        $user->save();
        $role = Role::where('name', 'empleado')->get();
        $user->roles()->attach($role[0]->id);

        $user = new User();
        $user->name = 'Adriana Zambrano';
        $user->email = 'adriana.zambrano@escuelaing.edu.co';
        $user->cargo = 'Tutora Semillero Jóvenes emprendedores';
        $user->password = bcrypt('password');
        $user->save();
        $role = Role::where('name', 'empleado')->get();
        $user->roles()->attach($role[0]->id);

        $user = new User();
        $user->name = 'David Blanco';
        $user->email = 'david.blanco@escuelaing.edu.co';
        $user->cargo = 'Tutor Semillero Materiales (SIMAT)';
        $user->password = bcrypt('password');
        $user->save();
        $role = Role::where('name', 'empleado')->get();
        $user->roles()->attach($role[0]->id);

        $user = new User();
        $user->name = 'Sonia Jaimes';
        $user->email = 'sonia.jaimes@escuelaing.edu.co';
        $user->cargo = 'Tutora Semillero Movilidad';
        $user->password = bcrypt('password');
        $user->save();
        $role = Role::where('name', 'empleado')->get();
        $user->roles()->attach($role[0]->id);

        $user = new User();
        $user->name = 'Juan Lopez';
        $user->email = 'juan.lopezl@escuelaing.edu.co';
        $user->cargo = 'Tutor Semillero Procesamiento de Imágenes y Señales PROMISE';
        $user->password = bcrypt('password');
        $user->save();
        $role = Role::where('name', 'empleado')->get();
        $user->roles()->attach($role[0]->id);

        $user = new User();
        $user->name = 'Javier Chaparro';
        $user->email = 'javier.chaparro@escuelaing.edu.co';
        $user->cargo = 'Tutor Semillero Robótica ECIBOT';
        $user->password = bcrypt('password');
        $user->save();
        $role = Role::where('name', 'empleado')->get();
        $user->roles()->attach($role[0]->id);
    }
    
}
