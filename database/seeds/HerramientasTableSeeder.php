<?php

use Illuminate\Database\Seeder;

class HerramientasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){
        $herramientas = [
            ['nombre' => 'Búsqueda con opinión de patentabilidad',
            'default' =>true,
            'descripcion' => 'Es una búsqueda en el estado de la
            técnica que tiene por finalidad analizar los requisitos de patentabilidad a la luz
            del estado de la técnica.'
            ],
            
            ['nombre' => 'Vigilancia tecnológica',
            'default' =>true,
            'descripcion' => 'Es un proceso sistemático que tiene por finalidad
            aportar información para la toma de decisiones estratégicas.'
            ],
            
            ['nombre' => 'Libertad de operación',
            'default' =>true,
            'descripcion' => 'Como su nombre lo indica es un análisis que tiene
            por finalidad conceptuar sobre los riesgos de operar en un mercado en cuanto
            la posibilidad de infringir un derecho de un tercero.'
            ],
            
            ['nombre' => 'Estudio de mercado',
            'default' =>true,
            'descripcion' => 'Es para analizar el mercado donde tiene participación
            un producto o servicio. Se analizan aspectos como tamaño de mercado,
            segmento de mercado, productos sustitutos y complementarios entre otros.'
            ],
            
            ['nombre' => 'Patent landscaping',
            'default' =>true,
            'descripcion' => 'Tiene por finalidad analizar el entorno de las patentes en
            un campo técnico a fin de identificar zonas blancas y zonas altamente
            protegidas.'
                ]
        ];

        DB::table('herramientas')->insert($herramientas);
    }
}
