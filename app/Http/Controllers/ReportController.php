<?php

namespace App\Http\Controllers;

use App\{ Activo, User, Dpi, DpiHerramienta, Herramienta, Proyecto, Subproyecto };
use Illuminate\Http\Request;
use DB;
use App\Quotation;
use Illuminate\Support\Facades\Input;

class ReportController extends Controller {

    private function dpiChart($subProyectos) {

        $dpis = Dpi::all();

        $dpi_colors = [
            'Diseño industrial'     => '#9932CC',
            'Patente de invención'  => '#8B0000',
            'Signos distintivos'    => '#FF8C00',
            'Secreto empresarial'   => "#FFD700",
            'Variedades vegetales'  => '#8FBC8F',
            'Derecho de autor'      => '#483D8B',
            'Esquema de trazado'    => '#2F4F4F',
        ];

        $dpi_chart = [
            'labels' => [],
            'activos' => [],
             'datasets' => [[
                'backgroundColor' => [],
                'data' => []
             ]],
        ];

        $y = Dpi::with(['activos' => function($query) use($subProyectos) {
            $query->select('nombre_asociado')->whereIn('subproyecto_id', $subProyectos)->where('tipo_asociacion', 'dpi_asociado');
        }]
        )->select('nombre', 'id')->get();
        
        foreach($dpis as $dpi) {
            array_push($dpi_chart['labels'], $dpi->nombre);
            array_push($dpi_chart['datasets'][0]['backgroundColor'], $dpi_colors[$dpi->nombre]);

            $activos = $y->first( function($row) use($dpi) {
                return $row->id == $dpi->id;
            });

            array_push($dpi_chart['datasets'][0]['data'], $activos->activos->count());
            array_push($dpi_chart['activos'], $activos->activos );
        }

        return $dpi_chart;
    }

    private function clasificacionChart($subProyectos) {

        $clasificacion_colors = [
            'logos_signos_palabras'     => '#9932CC',
            'publicacion'               => '#8B0000',
            'articulo'                  => '#FF8C00',
            'ensayo'                    => '#FF8C99',
            'presentacion'              => '#FF8A66',
            'poster'                    => '#FF8C33',
            'diseño'                    => '#FFD700',
            'planos_esquemas'           => '#8FBC8F',
            'lema'                      => '#483D8B',
            'resultadoID'               => '#2F4F4F',
            'audiovisual'               => '#FF7F50',
            'musical'                   => '#FFA500',
            'info'                      => '#DA70D6',
            'software'                  => '#FF0000',
            'base_datos'                => '#A0522D',
            'know_how'                  => '#708090',
            'otro'                      => '#9ACD32',
        ];

        $clasificacion_labels = [
            'logos_signos_palabras' => 'Logos, signos, palabras o frases distintivas',
            'publicacion'           => 'Publicación',
            'articulo'              => 'Artículo',
            'ensayo'                => 'Ensayo',
            'presentacion'          => 'Presentación',
            'poster'                => 'Poster',
            'diseño'                => 'Diseños',
            'planos_esquemas'       => 'Planos, esquemas, representaciones gráficas, dibujos, posters, fotografías',
            'lema'                  => 'Lema',
            'resultadoID'           => 'Resultado de I+D',
            'audiovisual'           => 'Obra Audiovisual',
            'musical'               => 'Obra musical',
            'info'                  => 'Información confidencial',
            'software'              => 'Software',
            'base_datos'            => 'Base de datos',
            'know_how'              => 'Know-how',
            'otro'                  => 'Otro' ,
        ];


        $clasificacion_chart = [
            'labels' => [],
            'activos' => [],
             'datasets' => [[
                'backgroundColor' => [],
                'data' => []
             ]],
        ];

        $clasificaciones = Activo::select('nombre_asociado', 'id', 'clasificacion')
                    ->whereIn('subproyecto_id', $subProyectos)
                    ->get()->groupBy('clasificacion');

        $otros = Activo::select('nombre_asociado', 'id', 'clasificacion')
                        ->whereIn('subproyecto_id', $subProyectos)
                        ->whereNotIn('clasificacion', ['logos_signos_palabras', 'publicacion', 'articulo', 'diseño', 'planos_esquemas', 'lema', 
                                                       'resultadoID', 'audiovisual', 'musical', 'info', 'software', 'base_datos', 'know_how'])
                        ->get();

        $clasificaciones->put('otro', $otros);

        foreach($clasificacion_labels as $key=>$clasificacion) {
            array_push($clasificacion_chart['labels'], $clasificacion);
            array_push($clasificacion_chart['datasets'][0]['backgroundColor'], $clasificacion_colors[$key]);
            array_push($clasificacion_chart['datasets'][0]['data'], $clasificaciones->get($key) ? $clasificaciones->get($key)->count() : 0);
            array_push($clasificacion_chart['activos'],  $clasificaciones->get($key) ?  $clasificaciones->get($key) : [] );
        }

        return $clasificacion_chart;
    }

    private function cesionChart($subProyectos) {

        $cesion_labels = [
            'si'    => 'AI con contrato de cesión firmado',
            'no'    => 'AI sin contrato de cesión firmado',
        ];

        $cesion_colors = [
            'si'    => '#00a651',
            'no'    => '#ff0000',
        ];

        $cesion_chart = [
            'labels' => [],
            'activos' => [],
             'datasets' => [[
                'backgroundColor' => [],
                'data' => []
             ]],
        ];

        $contratos = Activo::select('nombre_asociado', 'id', 'contrato_cesion')
                            ->whereIn('subproyecto_id', $subProyectos)
                            ->get()->groupBy('contrato_cesion')->filter( function ($row, $key) { return $key; }     );

        foreach($cesion_labels as $key=>$cesion) {
            array_push($cesion_chart['labels'], $cesion);
            array_push($cesion_chart['datasets'][0]['backgroundColor'], $cesion_colors[$key]);
            array_push($cesion_chart['datasets'][0]['data'], $contratos->get($key) ? $contratos->get($key)->count() : 0);
            array_push($cesion_chart['activos'],  $contratos->get($key) ?  $contratos->get($key) : [] );
        }


        return $cesion_chart;
    }

    private function confidencialidadChart($subProyectos) {

        $confidencialidad_labels = [
            'si'    => ' AI con acuerdo de confidencialidad firmado',
            'no'    => ' AI sin acuerdo de confidencialidad firmado',
        ];

        $confidencialidad_colors = [
            'si'    => '#00a651',
            'no'    => '#ff0000',
        ];

        $confidencialidad_chart = [
            'labels' => [],
            'activos' => [],
             'datasets' => [[
                'backgroundColor' => [],
                'data' => []
             ]],
        ];

        $contratos = Activo::select('nombre_asociado', 'id', 'contrato_confidencialidad')
                            ->whereIn('subproyecto_id', $subProyectos)
                            ->get()->groupBy('contrato_confidencialidad')->filter( function ($row, $key) { return $key; }     );

        foreach($confidencialidad_labels as $key=>$confidencialdad) {
            array_push($confidencialidad_chart['labels'], $confidencialdad);
            array_push($confidencialidad_chart['datasets'][0]['backgroundColor'], $confidencialidad_colors[$key]);
            array_push($confidencialidad_chart['datasets'][0]['data'], $contratos->get($key) ? $contratos->get($key)->count() : 0);
            array_push($confidencialidad_chart['activos'],  $contratos->get($key) ?  $contratos->get($key) : [] );
        }

        return $confidencialidad_chart;
    }

    private function estadoChart($subProyectos) {
        $estado_labels = [
            'no_identificado'           => 'AI no identificados',
            'identificado_no_protegido' => 'AI identificados y no protegidos',
            'identificado_protegido'    => 'AI identificados y protegidos',
        ];

        $estado_colors = [
            'no_identificado'           =>  '#ff0000',
            'identificado_no_protegido' =>  '#FF8C00',
            'identificado_protegido'    =>  '#00a651',
        ];

        $estados_chart = [
            'labels' => [],
            'activos' => [],
             'datasets' => [[
                'backgroundColor' => [],
                'data' => []
             ]],
        ];

        $estados = Activo::select('nombre_asociado', 'id', 'estado')
                            ->whereIn('subproyecto_id', $subProyectos)
                            ->get()->groupBy('estado')->filter( function ($row, $key) { return $key; } );

        foreach( $estado_labels as $key=>$estado ) {
            array_push($estados_chart['labels'], $estado);
            array_push($estados_chart['datasets'][0]['backgroundColor'], $estado_colors[$key]);
            array_push($estados_chart['datasets'][0]['data'], $estados->get($key) ? $estados->get($key)->count() : 0);
            array_push($estados_chart['activos'],  $estados->get($key) ?  $estados->get($key) : [] );
        }

        return $estados_chart;
    }

    private function depositoSugeridosChart($subProyectos){

        $dpis = Dpi::all();

        $dpi_labels = [
            'Diseño industrial'     => 'Diseño industrial'     ,
            'Patente de invención'  => 'Patente de invención',
            'Signos distintivos'    => 'Signos distintivos'    ,
            'Variedades vegetales'  => 'Variedades vegetales'  ,
            'Derecho de autor'      => 'Derecho de autor',
            'Esquema de trazado'    => 'Esquema de trazado',
            'Ninguno'               => 'Ninguno'
        ];

        $dpi_colors = [
            'Diseño industrial'     => '#9932CC',
            'Patente de invención'  => '#8B0000',
            'Signos distintivos'    => '#FF8C00',
            // 'Secreto empresarial'   => "#FFD700",
            'Variedades vegetales'  => '#8FBC8F',
            'Derecho de autor'      => '#483D8B',
            'Esquema de trazado'    => '#2F4F4F',
            'Ninguno'               => '#A0522D'
        ];

        $depositos_chart = [
            'labels' => [],
            'activos' => [],
             'datasets' => [[
                'backgroundColor' => [],
                'data' => []
             ]],
        ];

        $depositos = Dpi::with(['activos' => function($query) use($subProyectos) {
            $query->select('nombre_asociado')->whereIn('subproyecto_id', $subProyectos)->where('tipo_asociacion', 'propiedad_industria_deposito');
        }])
        ->where('nombre', '!=', 'Derecho de autor')
        ->where('nombre', '!=', 'Secreto empresarial')
        ->select('nombre', 'id')->get();

        $da = Activo::select('nombre_asociado', 'id')
                                    ->whereIn('subproyecto_id', $subProyectos)
                                    ->where('registro_da', 'si')
                                    ->get();

        $ninguno =  Activo::select('nombre_asociado', 'id')
                            ->whereIn('subproyecto_id', $subProyectos)
                            ->where('registro_da', 'no')
                            ->where('propiedad_industrial', 'no')
                            ->get();

        $depositos->push(
            collect(["nombre"=>"Derecho de autor",
             "id"=> $dpis->first( function($dpi) {return $dpi->nombre == 'Derecho de autor'; })->id,
             "activos"=> $da->map( function($d)  { return ["nombre_asociado" => $d->nombre_asociado, "pivot" => ["activo_id" => $d->id] ];  })
            ])
        );

        $depositos->push(
            collect(["nombre" => "Ninguno",
             "activos"=> $ninguno->map( function($row)  { return ["nombre_asociado" => $row->nombre_asociado, "pivot" => ["activo_id" => $row->id] ];  })
            ])
        );

        foreach($dpi_labels as $key=>$dpi) {
            array_push($depositos_chart['labels'], $dpi);
            array_push($depositos_chart['datasets'][0]['backgroundColor'], $dpi_colors[$dpi]);

            $activos = $depositos->first( function($row) use($dpi) {
                return $row['nombre'] == $dpi;
            });

            array_push($depositos_chart['datasets'][0]['data'], count($activos['activos']));
            array_push($depositos_chart['activos'], $activos['activos'] );
        }

        return $depositos_chart;
    }

    private function registroDepositoChart($subProyectos){

        $dpis = Dpi::all();

        $dpi_labels = [
            'Diseño industrial'     => 'Diseño industrial'     ,
            'Patente de invención'  => 'Patente de invención',
            'Signos distintivos'    => 'Signos distintivos'    ,
            'Variedades vegetales'  => 'Variedades vegetales'  ,
            'Derecho de autor'      => 'Derecho de autor',
            'Esquema de trazado'    => 'Esquema de trazado',
        ];

        $dpi_colors = [
            'Diseño industrial'     => '#9932CC',
            'Patente de invención'  => '#8B0000',
            'Signos distintivos'    => '#FF8C00',
            // 'Secreto empresarial'   => "#FFD700",
            'Variedades vegetales'  => '#8FBC8F',
            'Derecho de autor'      => '#483D8B',
            'Esquema de trazado'    => '#2F4F4F',
        ];

        $depositos_chart = [
            'labels' => [],
            'activos' => [],
             'datasets' => [[
                'backgroundColor' => [],
                'data' => []
             ]],
        ];

        $depositos = Dpi::with(['activos' => function($query) use($subProyectos) {
            $query->select('nombre_asociado')->whereIn('subproyecto_id', $subProyectos)->where('tipo_asociacion', 'propiedad_industria_registro');
        }])
        ->where('nombre', '!=', 'Derecho de autor')
        ->where('nombre', '!=', 'Secreto empresarial')
        ->select('nombre', 'id')->get();

        $da = Activo::select('nombre_asociado', 'id')
                                    ->whereIn('subproyecto_id', $subProyectos)
                                    ->where('deposito_da', 'si')
                                    ->get();

        $depositos->push(
            collect(["nombre"=>"Derecho de autor",
                "id"=> $dpis->first( function($dpi) {return $dpi->nombre == 'Derecho de autor'; })->id,
                "activos"=> $da->map( function($d)  { return ["nombre_asociado" => $d->nombre_asociado, "pivot" => ["activo_id" => $d->id] ];  })
            ])
        );

        foreach($dpi_labels as $key=>$dpi) {
            array_push($depositos_chart['labels'], $dpi);
            array_push($depositos_chart['datasets'][0]['backgroundColor'], $dpi_colors[$dpi]);

            $activos = $depositos->first( function($row) use($dpi) {
                return $row['nombre'] == $dpi;
            });

            array_push($depositos_chart['datasets'][0]['data'], count($activos['activos']));
            array_push($depositos_chart['activos'], $activos['activos'] );
        }

        return $depositos_chart;

    }

    private function secretoEmpresarialChart($subProyectos) {

        $se_labels = [
            'si'    => 'AI que se sugieren conservar en secreto',
            'no'    => 'AI que se no se sugieren conservar en secreto',
        ];

        $se_colors = [
            'si'    => '#9932CC',
            'no'    => '#8B0000',
        ];

        $se_chart = [
            'labels' => [],
            'activos' => [],
             'datasets' => [[
                'backgroundColor' => [],
                'data' => []
             ]],
        ];

        $se = Activo::select('nombre_asociado', 'id', 'medidas_proteccion')
                            ->whereIn('subproyecto_id', $subProyectos)
                            ->get()->groupBy('medidas_proteccion')->filter( function ($row, $key) { return $key; } );

        foreach($se_labels as $key=>$row) {
            array_push($se_chart['labels'], $row);
            array_push($se_chart['datasets'][0]['backgroundColor'], $se_colors[$key]);
            array_push($se_chart['datasets'][0]['data'], $se->get($key) ? $se->get($key)->count() : 0);
            array_push($se_chart['activos'],  $se->get($key) ?  $se->get($key) : [] );
        }

        return $se_chart;

    }

    private function priorizacionChart($subProyectos) {

        $priorizacion_labels = [
            'Búsqueda con opinión de patentabilidad'    =>  'Búsqueda con opinión de patentabilidad',
            'Vigilancia tecnológica'                    =>  'Vigilancia tecnológica',
            'Libertad de operación'                     =>  'Libertad de operación',
            'Estudio de mercado'                        =>  'Estudio de mercado',
            'Reporte de Patent Landscape'               =>  'Reporte de Patent Landscape',
            'Otro'                                      =>  'Otro',
            'Ninguno'                                   =>  'Ninguno'
        ];

        $priorizacion_colors = [
            'Búsqueda con opinión de patentabilidad'    =>  '#FFD700',
            'Vigilancia tecnológica'                    =>  '#FFA500',
            'Libertad de operación'                     =>  '#DA70D6',
            'Estudio de mercado'                        =>  '#FF0000',
            'Reporte de Patent Landscape'               =>  '#708090',
            'Otro'                                      =>  '#9ACD32',
            'Ninguno'                                   =>  '#8B0000'
        ];

        $priorizacion_chart = [
            'labels' => [],
            'activos' => [],
             'datasets' => [[
                'backgroundColor' => [],
                'data' => []
             ]],
        ];

        $herramientas = DB::table('activos')
            ->join('dpiherramientas', 'activos.id', '=', 'dpiherramientas.activo_id')
            ->join('herramientas', 'herramientas.id', '=', 'dpiherramientas.herramienta_id')
            ->whereIn('subproyecto_id', $subProyectos)
            ->select('nombre_asociado', 'activos.id as id', 'herramientas.nombre as nombre_herramienta', 'herramientas.id as herramienta_id')
            ->get()->groupBy('nombre_herramienta');
        
        $otros = DB::table('activos')
                ->join('dpiherramientas', 'activos.id', '=', 'dpiherramientas.activo_id')
                ->join('herramientas', 'herramientas.id', '=', 'dpiherramientas.herramienta_id')
                ->whereIn('subproyecto_id', $subProyectos)
                ->whereNotIn('herramientas.nombre', ['Búsqueda con opinión de patentabilidad', 'Vigilancia tecnológica',
                                                    'Libertad de operación', 'Estudio de mercado', 'Reporte de Patent Landscape'])
                ->select('nombre_asociado', 'activos.id as id', 'herramientas.nombre as nombre_herramienta', 'herramientas.id as herramienta_id')
                ->get();

        $ninguno = Activo::select('nombre_asociado', 'id', 'busqueda')
                            ->whereIn('subproyecto_id', $subProyectos)
                            ->where('busqueda', 'no')
                            ->get();

        
        $herramientas->put('Otro',$otros);
        $herramientas->put('Ninguno',$ninguno);

        foreach($priorizacion_labels as $key => $row) {
            array_push($priorizacion_chart['labels'], $row);
            array_push($priorizacion_chart['datasets'][0]['backgroundColor'], $priorizacion_colors[$key]);
            array_push($priorizacion_chart['datasets'][0]['data'], $herramientas->get($key) ? $herramientas->get($key)->count() : 0);
            array_push($priorizacion_chart['activos'],  $herramientas->get($key) ?  $herramientas->get($key) : [] );
        }

        return $priorizacion_chart;

    }

    private function contabilidadChart($subProyectos) {

        $contabilidad_labels = [
            'si'    => 'AI incorporados en contabilidad',
            'no'    => 'AI no incorporados en contabilidad',
        ];

        $contabilidad_colors = [
            'si'    => '#00a651',
            'no'    => '#ff0000',
        ];

        $contabilidad_chart = [
            'labels' => [],
            'activos' => [],
             'datasets' => [[
                'backgroundColor' => [],
                'data' => []
             ]],
        ];

        $contabilidad = Activo::select('nombre_asociado', 'id', 'en_contabilidad')
                            ->whereIn('subproyecto_id', $subProyectos)
                            ->get()->groupBy('en_contabilidad')->filter( function ($row, $key) { return $key; } );

        foreach($contabilidad_labels as $key=>$row) {
            array_push($contabilidad_chart['labels'], $row);
            array_push($contabilidad_chart['datasets'][0]['backgroundColor'], $contabilidad_colors[$key]);
            array_push($contabilidad_chart['datasets'][0]['data'], $contabilidad->get($key) ? $contabilidad->get($key)->count() : 0);
            array_push($contabilidad_chart['activos'],  $contabilidad->get($key) ?  $contabilidad->get($key) : [] );
        }

        return $contabilidad_chart;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    //TODO: si el usuario es admin el reporte es con todos los activos sino solo con los propios
    public function index() {
        $user = \Auth::user();

        $grupos = $user->roles[0]->name == 'admin' ? Proyecto::with('sub_proyectos.activos')->get() : Proyecto::where('user_id',$user->id)->get();

        return view('report.index', compact('grupos'));
    }

    public function  apiIndex(Request $request) {

        $grupos = $request->grupos;

        $subProyectos = Subproyecto::whereIn('proyecto_id', $grupos)->get()->map( function($row) { return $row->id; });

        $dpi_chart                  = $this->dpiChart($subProyectos);
        $clasificacion_chart        = $this->clasificacionChart($subProyectos);
        $cesion_chart               = $this->cesionChart($subProyectos);
        $confidencialidad_chart     = $this->confidencialidadChart($subProyectos);
        $estados_chart              = $this->estadoChart($subProyectos);
        $depositos_chart            = $this->depositoSugeridosChart($subProyectos);
        $registros_chart            = $this->registroDepositoChart($subProyectos);
        $priorizacion_chart         = $this->priorizacionChart($subProyectos);
        $se_chart                   = $this->secretoEmpresarialChart($subProyectos);
        $contabilidad_chart         = $this->contabilidadChart($subProyectos);

        return response()->json([
            'dpi_chart'                 => $dpi_chart,
            'clasificacion_chart'       => $clasificacion_chart,
            'cesion_chart'              => $cesion_chart,
            'confidencialidad_chart'    => $confidencialidad_chart,
            'estados_chart'             => $estados_chart,
            'depositos_chart'           => $depositos_chart,
            'registros_chart'           => $registros_chart,
            'priorizacion_chart'        => $priorizacion_chart,
            'se_chart'                  => $se_chart,
            'contabilidad_chart'        => $contabilidad_chart,
        ]); 

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
