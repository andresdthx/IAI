<?php

namespace App\Http\Controllers;

use App\{Subproyecto, Activo};
use Illuminate\Http\Request;

class SubproyectosController extends Controller
{

    public function index(){}

    public function create(){}

    public function store(Request $request) {

        $this->validate($request, [
            'proyecto' => 'required',
            'nombre' => 'required|unique:subproyectos'
        ]);

        $subProyecto = new Subproyecto();
        $subProyecto->nombre = $request->nombre;
        $subProyecto->proyecto_id = $request->proyecto;
        $subProyecto->descripcion = $request->descripcion;
        $subProyecto->investigador_principal = $request->investigador_principal;
        $subProyecto->save();

        return response()->json([
            'subproyecto' => $subProyecto,
        ]);
    }

    private function mapClasificacion($clasificacion) {
        $map  = [
            'marca_logo'    => 'Marca/Logo',
            'articulo'      => 'Articulo',
            'ensayo'        => 'Ensayo',
            'presentacion'  => 'Presentación',
            'poster'        => 'Poster',
            'diseño'        => 'Diseño',
            'libro'         => 'Libro',
            'tesis'         => 'Tesis',
            'lema'          => 'Lema',
            'resultadoID'   => 'Resultado I+D',
            'audiovisual'   => 'Pieza audiovisual',
            'musical'       => 'Pieza musical',
            'info'          => 'Informacion confidecial',
            'software'      => 'Software',
            'otro'          => 'Otro' 
        ];

        if ($clasificacion == null) {
            return 'Sin definir';
        } 

        return  array_key_exists($clasificacion, $map) ?  $map[$clasificacion] : $clasificacion;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        $subproyecto = Subproyecto::with('proyecto')->where('id', $id)->first();
        $proyecto = $subproyecto->proyecto;
        $user = collect(['encargado' => $proyecto->user, 'director' => $proyecto->director_del_grupo]);


        $activos_data = Activo::select('activos.nombre_asociado as nombre', 'activos.estado_diligencia', 'activos.id', 'activos.clasificacion')
                            ->join('subproyectos', 'activos.subproyecto_id', '=', 'subproyectos.id')
                            ->where('subproyectos.id', '=', $subproyecto->id)
                            ->orderBy('activos.nombre_asociado')->get();

        $clasificacion = [];

        foreach($activos_data as $item) {
            array_push($clasificacion, (Object) ['id' => $item->clasificacion, 'name' => $this->mapClasificacion($item->clasificacion)]);
        }

        $clasificacion = collect($clasificacion)->unique('id')->values()->all();

        
        $filters = [
            (Object) [
                'name' => 'nombre',
                'value' => ''
            ],

            (Object) [
                'name' => 'estado_diligencia',
                'value' => [],
                'options' =>  [(Object) ['name' => 'En progreso', 'id' => 'En progreso'],
                                (Object) ['name' => 'Terminado',   'id' => 'Terminado']
                                ]
            ],

            (Object) [
                'name' => 'clasificacion',
                'value' => [],
                'options' => $clasificacion
            ]
        ];


        return view('subproyectos.show', compact('user', 'proyecto', 'subproyecto', 'filters', 'activos_data' ));
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
    public function update(Request $request, $id) {
        $subProyecto = Subproyecto::with('proyecto')->where('id', $id)->first();

        $this->validate($request, [
            'investigador principal',
            'nombre' => [
                'required',
                function($attribute, $value, $fail) use ($request, $subProyecto) {
                    $activos = Subproyecto::where('proyecto_id', '=', $subProyecto->proyecto->id)
                                ->where('nombre', '=', $request->nombre)
                                ->count();
                    if($activos > 0 and ($request->nombre !=  $subProyecto->nombre) ) {
                        return $fail('Este grupo de investigación ya tiene un proyecto con este nombre.');
                    }
                }],
        ]);
        
        $subProyecto->investigador_principal = $request->investigador_principal;
        $subProyecto->nombre = $request->nombre;
        $subProyecto->descripcion = $request->descripcion;
        $subProyecto->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $subproyecto = Subproyecto::with('activos')->where('id', $id)->first();
        $subproyecto->activos->each( function($activo) {

            $historial = Activo::where('activo_id', $activo->id)->get();

            $historial->each( function($activo_hist) {
                $activo_hist->delete();
            });

            $activo->delete();
        });

        $subproyecto->delete();
    }
}
