<?php

use Illuminate\Database\Seeder;

class DpisTableSeeder extends Seeder
{
     /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {

        $dpis = [
            ['nombre' => 'Derecho de autor',
            'derecho_de_industria' => false,
            'descripcion' => 'Protección que se le da a las obras literaria, artísticas y científicas
            como novelas, poemas, representaciones escénicas, guiones, artículos académicos,
            científicos y periodísticos, folletos, conferencias, alocuciones, películas, videos,
            composiciones musicales, coreografías, cuadros, dibujos, fotografías, esculturas,
            planos arquitectónicos, anuncios, mapas, dibujos técnicos, traducciones, entre otros.'],

            ['nombre' => 'Esquema de trazado',
            'derecho_de_industria' => true,
            'descripcion' => 'Son los planes o diseños de los elementos que componen un
                            circuito integrado que le dan un orden o disposición especial y que permiten que
                            ejecuten una función específica.'],

            ['nombre' => 'Diseño industrial', 
            'derecho_de_industria' => true,
            'descripcion' => 'La apariencia particular de un producto que resulte de
                                cualquier reunión de líneas o combinación de colores, o de cualquier forma externa
                                bidimensional o tridimensional, línea, contorno, configuración, textura o material, sin
                                que cambie el destino o finalidad de dicho producto. Tomado del artículo 113,
                                Decisión 486 de la CAN.'],

            ['nombre' => 'Patente de invención',
            'derecho_de_industria' => true, 
            'descripcion' => 'La patente es la protección que se le da al titular del invento
                                (productos, procedimientos, métodos de fabricación, máquinas) para que impida que
                                otro explote su invento sin su autorización, por un tiempo determinado.'],
                
            ['nombre' => 'Variedades vegetales', 
            'derecho_de_industria' => true,
            'descripcion' => 'Los derechos de obtentores de variedades vegetales se otorgan
                              a quienes desarrollan y terminan una variedad vegetal para su explotación.'],

            ['nombre' => 'Signos distintivos',
            'derecho_de_industria' => true,
            'descripcion' => 'Cualquier símbolo que sea capaz de distinguir un producto o
                                servicio en el mercado. Estos pueden ser marcas, lemas, nombres o enseñas
                                comerciales.'],

            ['nombre' => 'Secreto empresarial',
            'derecho_de_industria' => true,
            'descripcion' => 'Se considera secreto toda aquella información que no se ha
                            divulgado y que pueda usarse en una actividad productiva, industrial o comercial y
                            que por lo tanto sea susceptible de ser transferida a un tercero.'],
        ];

        DB::table('dpis')->insert($dpis);
    }
}
