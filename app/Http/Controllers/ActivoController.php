<?php

namespace App\Http\Controllers;

use App\{Activo, Archivo, Dpi, Comentario, Herramienta, DpiHerramienta, Estrategia, Subproyecto, Proyecto};
use Illuminate\Http\Request;
use App\Utilities\Crud;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class ActivoController extends Controller {

    private $activosConsts;
    private $configConst;
    private $file_size;
    private $file_name;

    public function __construct() {
        $this->middleware('auth');
        $this->configConst = \Config::get('constants')->config;
        $this->activosConsts = \Config::get('constants')->resources->activos;
        $this->file_size = intval(str_replace("M","",ini_get('upload_max_filesize')));
        $this->file_name = 'archivosEscuela';
    }

    private function mapStep($step) {
        $map = [
            '1'     => 'descripción',
            '2'     => 'clasificación',
            '3'     => 'estado',
            '4'     => 'DPI asociados',
            '5'     => 'estado Actual del AI',
            '6'     => 'comentarios',
            '7'     => 'plan de acción y protección',
            '8'     => 'priorización y decisión',
            '9'     => 'uso comercial',
            '10'    => 'estrategias de gestión'
        ];

        return $step ? $map[$step] :  'nombre';
    }

    private function makeActivoHistorial($activo, $step) {

        //clonar activo
        $historial_activo = $activo->replicate();
        $historial_activo->subproyecto_id = null;
        $historial_activo->activo_id = $activo->id;
        $historial_activo->commit = 'Modificación ' . $this->mapStep($step);
        $historial_activo->commit_field = $step;
        $historial_activo->responsable_modificacion_email = Auth::user()->email;
        $historial_activo->responsable_modificacion_nombre = Auth::user()->name;
        $historial_activo->save();

        //clonar archivos
        if ( count($activo->archivos) > 0) {
            $historial_archivos = $activo->archivos;

            $historial_archivos->each( function($archivo) use($historial_activo) {
                
                $historial_archivo = $archivo->replicate();
                $historial_archivo->activo_id = $historial_activo->id;
                $id = $archivo->id . $historial_activo->id;
                $historial_archivo->id = $id;
                $historial_archivo->save();

            });
        } 

        //clonar comentario
        if ( count($activo->comentarios) > 0) {
            $historial_comentario = $activo->comentarios->last()->replicate();
            $historial_comentario->activo_id = $historial_activo->id;
            $historial_comentario->save();
        }

        //clonar dpis asociados
        if ( count($activo->dpis) > 0 ) {
            $historial_dpis = $activo->dpis;
            $historial_dpis->each( function($dpi) use($historial_activo) {
                $historial_dpi = $dpi;
                $historial_dpi->activo_id = $historial_activo->id;
                if ($dpi->pivot->tipo_asociacion == 'propiedad_industria_registro') {
                    $historial_activo->dpis()->attach($dpi->pivot->dpi_id, ['tipo_asociacion' => $dpi->pivot->tipo_asociacion, 'numero_registro' => $dpi->pivot->numero_registro]);
                } else {
                    $historial_activo->dpis()->attach($dpi->pivot->dpi_id, ['tipo_asociacion' => $dpi->pivot->tipo_asociacion]);
                }
            });
        }

        //clonar herramientas de priorizacion
        if ( count($activo->dpiHerramientas) > 0)  {
            $historial_herramientas = $activo->dpiHerramientas;
            $historial_herramientas->each( function ($herramienta) use($historial_activo) {
                    $hitorial_herramienta = $herramienta->replicate();
                    $hitorial_herramienta->activo_id = $historial_activo->id;
                    $hitorial_herramienta->save();
            });
        }

        //clonar estrategias
        if ( count($activo->estrategias) > 0 ) {
            $historial_estrategias = $activo->estrategias;
            $historial_estrategias->each( function($estrategia) use($historial_activo) {
                $historial_estrategia = $estrategia->replicate();
                $historial_estrategia->activo_id = $historial_activo->id;
                $historial_estrategia->save();
            });
        }

    }

    private function returnData($activo, $finalizado, $step) {             
        $this->makeActivoHistorial($activo, $step);
        list($side_menu, $activo) = $this->makeData($activo->id);

        return response()->json([
            'side_menu' => $side_menu,
            'activo' => $activo,
            'finalizado' => $finalizado
        ]); 
    }

    public function updateName(Request $request, $id) {
        $activo = Activo::with('subproyecto')->where('id',$id)->first();

        $this->validate($request, [
            'nombre' => [
                'required',
                function($attribute, $value, $fail) use($request, $activo) {
                    $activos = Activo::where('subproyecto_id', '=', $activo->subproyecto->id)
                                ->where('nombre_asociado', '=', $value)
                                ->count();
                    if($activos > 0) {
                        return $fail('Ya existe un activo con este nombre.');
                    }
                }]
        ]);

        $activo->nombre_asociado = $request->nombre;
        $activo->save();

        $this->makeActivoHistorial($activo, '0');
    }

    public function deleteOtraHerramienta($herramienta_id, $activo_id, $dpi_id) {

        if ( $herramienta_id != -1) {
            $dpi_herramienta = DpiHerramienta::where('herramienta_id', $herramienta_id)->where('activo_id', $activo_id)->where('dpi_id', $dpi_id)->first();
            $herramienta = $dpi_herramienta->herramienta;

            // $herramienta->delete();
            $dpi_herramienta->delete();
        }

        $activo = Activo::find($activo_id);

        return $this->returnData($activo, false, '8');
        
        // list($side_menu, $activo) = $this->makeData($activo_id);

        // return response()->json([
        //     'side_menu' => $side_menu,
        //     'activo' => $activo,
        // ]);

    }

    private function mapToEstrategia($value) {
        $map = array(
            'no_identificado' => 'danger',
            'identificado_no_protegido' => 'warning',
            'identificado_protegido' => 'good',
            'no' => 'danger',
            'nose' => 'warning',
            'si' => 'good',
            'sin_estado' => null
        );
        return $map[$value];
    }
    

    private function addEstrategia($activo, $step, $campo, $estado) { 
        $estrategiaState = $this->mapToEstrategia($estado);
        $estrategia =  Estrategia::where('activo_id', $activo->id)
                            ->where('nombre_paso', $step)
                            ->where('campo', $campo)
                            ->first();

        if (!$estrategia) {
            $estrategia = new Estrategia();
            $estrategia->nombre_paso = $step;
            $estrategia->campo = $campo;
        }
        
        $estrategia->estado = $estrategiaState;

        if ($estrategiaState == 'good') {
            $estrategia->estrategia = null;
            $estrategia->responsable = null;
        }

        $activo->estrategias()->save($estrategia);
    }

    public function addNewEstrategia(Request $request) {

        $this->validate($request, [
            'activo' => 'required',
            'estrategia_id' => 'required',
            'estrategia' => 'required',
            'responsable' => 'required',
        ]);

        $estrategia = Estrategia::find($request->estrategia_id);
        $estrategia->estrategia = $request->estrategia;
        $estrategia->responsable = $request->responsable;
        $estrategia->save();

        $activo = Activo::find($request->activo);
        return $this->returnData($activo, false , '10');

        // list($side_menu, $activo) = $this->makeData($request->activo);

        // return response()->json([
        //     'side_menu' => $side_menu,
        //     'activo' => $activo,
        // ]); 
    }

    public function addEstrategiaGeneral(Request $request) {
        $estrategia = Estrategia::where('activo_id', $request->activo)->where('campo', 'estrategia_general')->count();
        $activo = Activo::find($request->activo);

        $this->validate($request, [
            'activo' => 'required',
            'estrategia' => 'required',
            'responsable' => 'required',
        ]);

        if ($estrategia == 0) {
            $estrategia = new Estrategia();
            $estrategia->nombre_paso = 'estrategia_general';
            $estrategia->campo = 'estrategia_general';
            $estrategia->estado = 'estrategia_general';
            $estrategia->estrategia = $request->estrategia;
            $estrategia->responsable = $request->responsable;
            $activo->estrategias()->save($estrategia);
        } else {
            $estrategia = Estrategia::where('activo_id', $request->activo)->where('campo', 'estrategia_general')->first();
            $estrategia->estrategia = $request->estrategia;
            $estrategia->responsable = $request->responsable;
            $estrategia->save();
        }

        return $this->returnData($activo, false , '10');

        // list($side_menu, $activo) = $this->makeData($request->activo);

        // return response()->json([
        //     'side_menu' => $side_menu,
        //     'activo' => $activo,
        // ]); 
    }

    private function mapClasificacion($clasificacion) {
        $map  = [
            'logos_signos_palabras' => 'Logos, signos, palabras o frases distintivas',
            'publicacion' => 'Publicación',
            'articulo' => 'Artículo',
            'ensayo' => 'Ensayo',
            'presentacion' => 'Presentación',
            'poster' => 'Poster',
            'diseño' => 'Diseños',
            'planos_esquemas' => 'Planos, esquemas, representaciones gráficas, dibujos, posters, fotografías',
            'lema' => 'Lema',
            'resultadoID' => 'Resultado de I+D',
            'audiovisual' => 'Obra Audiovisual',
            'musical' => 'Obra musical',
            'info' => 'Información confidencial',
            'software' => 'Software',
            'base_datos' => 'Base de datos',
            'know_how' => 'Know-how',
            'otro' => 'Otro'
        ];

        if ($clasificacion == null) {
            return 'Sin definir';
        } 

        return  array_key_exists($clasificacion, $map) ?  $map[$clasificacion] : $clasificacion;
    }

    public function indexAll() {
        $user = \Auth::user();

        $activos_data = Activo::select('activos.nombre_asociado as nombre', 'activos.estado_diligencia', 'activos.id', 'activos.clasificacion as clasificacion', 'subproyectos.nombre as proyecto', 'proyectos.nombre as grupo_investigacion')
                                ->join('subproyectos', 'activos.subproyecto_id', '=', 'subproyectos.id')
                                ->join('proyectos', 'proyectos.id', 'subproyectos.proyecto_id')
                                ->where('proyectos.user_id', '=', $user->id)
                                ->get();
        $grupos = [];
        $proyectos = [];
        $clasificacion = [];

        foreach($activos_data as $item) {
            array_push($grupos, (Object) ['id' => $item->grupo_investigacion, 'name' => $item->grupo_investigacion]);
            array_push($proyectos, (Object) ['id' => $item->proyecto, 'name' => $item->proyecto]);
            array_push($clasificacion, (Object) ['id' => $item->clasificacion, 'name' => $this->mapClasificacion($item->clasificacion)]);
        }

        $grupos = collect($grupos)->unique('id')->values()->all();
        $proyectos = collect($proyectos)->unique('id')->values()->all();
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
                'name' => 'grupo_investigacion',
                'value' => [],
                'options' => $grupos
            ],

            (Object) [
                'name' => 'proyecto',
                'value' => [],
                'options' => $proyectos
            ],

            (Object) [
                'name' => 'clasificacion',
                'value' => [],
                'options' => $clasificacion
            ]
        ];

        return view('activos.indexAll', compact('user', 'activos_data', 'filters'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($subproyectoId) {
        $activo = new Activo();

        list($config, $values) = Crud::createIndexParams($this->activosConsts);

        $user_role = \Auth::user()->id;

        $activos_data = Activo::select('activos.nombre_asociado as nombre', 'activos.estado_diligencia', 'activos.id', 'activos.clasificacion')
                            ->join('subproyectos', 'activos.subproyecto_id', '=', 'subproyectos.id')
                            ->where('subproyectos.id', '=', $subproyectoId)
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

        return response()->json([
            'activos_data' => $activos_data,
            'config' => $config,
            'values'=> $values,
            'user_role' => $user_role
        ]);

    }

    public function apiIndexMisActivos() {
        $user = \Auth::user()->id;

        $activos_data = Activo::select('activos.nombre_asociado as nombre', 'activos.estado_diligencia', 'activos.id', 'activos.clasificacion', 'subproyectos.nombre as proyecto', 'proyectos.nombre as grupo_investigacion')
                                ->join('subproyectos', 'activos.subproyecto_id', '=', 'subproyectos.id')
                                ->join('proyectos', 'proyectos.id', 'subproyectos.proyecto_id')
                                ->where('proyectos.user_id', '=', $user)
                                ->get();
        
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
            ]
        ];

        return response()->json([
            'activos' => $activos_data,
            'filters' => $filters
        ]);
    }

    public function apiIndex($proyectos='', $nombre_asociado='', $estado_diligencia='', $sortField='', $dir='') {

        $estado_diligencia = array_map(function($x){return str_replace('"','', $x);}, 
                                      explode(',', substr($estado_diligencia, 1, -1)));

        $proyectos = array_map('intval', explode(',', substr($proyectos, 1, -1)));
        $nombre_asociado = $nombre_asociado == $this->configConst->nullParam ? null : $nombre_asociado;
        $sortField = $sortField == $this->configConst->nullParam  ? null : $sortField;
        $dir = $dir == $this->configConst->nullParam ? null : $dir;

        $user_role = \Auth::user()->id;

        $activos_data = Activo::select('activos.nombre_asociado', 'activos.estado_diligencia', 'activos.id')
                            ->join('subproyectos', 'activos.subproyecto_id', '=', 'subproyectos.id')
                            ->when($sortField, function ($query) use ($sortField, $dir) {
                                return $query->orderBy($sortField, $dir);
                            }, function ($query) {
                                return $query->orderBy('activos.nombre_asociado');
                            })
                            ->when($proyectos[0] != 0 , function ($query) use ($proyectos) {

                                return $query->whereIn('subproyectos.id', $proyectos);
                            })
                            ->when($estado_diligencia[0] != 'ul' , function ($query) use ($estado_diligencia) {
                                return $query->whereIn('activos.estado_diligencia', $estado_diligencia);
                            })
                            ->whereRaw('LOWER(activos.nombre_asociado) LIKE ?', ['%'.strtolower($nombre_asociado).'%'])
                            ->paginate($this->activosConsts->pagination)->toJson();
    
        return response()->json([
            'activos' => $activos_data,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $activo = new Activo();

        $this->validate($request, [
            'nombre' => [
                'required',
                function($attribute, $value, $fail) use($request) {
                    $activos = Activo::where('subproyecto_id', '=', $request->input('subproyecto'))
                                ->where('nombre_asociado', '=', $value)
                                ->count();
                    if($activos > 0) {
                        return $fail('Ya existe un activo con este nombre.');
                    }
                }]
        ]);

        $activo->nombre_asociado = $request->input('nombre');
        $activo->subproyecto_id = $request->input('subproyecto');
        $activo->estado_diligencia = 'En progreso';
        $activo->save();
        
        $repsActivo = [
            'nombre' => $activo->nombre_asociado,
            'estado_diligencia' => $activo->estado_diligencia,
            'clasificacion' => $activo->clasificacion,
            'id' => $activo->id
        ];

        $this->makeActivoHistorial($activo, '0');

        return response()->json([
            'activo' => $repsActivo,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Activo  $activo
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        return view('activos.show', compact('id'));
    }

    public function showApi($id) {

        list($side_menu, $activo) = $this->makeData($id);
        return response()->json([
            'side_menu' => $side_menu,
            'activo' => $activo,
        ]);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Activo  $activo
     * @return \Illuminate\Http\Response
     */
    public function edit(Activo $activo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Activo  $activo
     * @return \Illuminate\Http\Response
     */
    public function updates(Request $request, int $activoId) {

        $activo = Activo::find($activoId);
        $this->validate($request, [
            'step' => 'required',
        ]);

        switch ($request->step) {
            case 1:
                $finalizado = $this->updatePaso1Descripcion($request, $activo);
                break;
            case 2:
                $finalizado = $this->updatePaso2Clasificacion($request, $activo);
                break;
            case 3:
                $finalizado = $this->updatePaso3Estado($request, $activo);
                break;
            case 4:
                $finalizado = $this->updatePaso4DpiAsociado($request, $activo);
                break;
            case 5:
                $finalizado = $this->updatePaso5EstadoActualDPI($request, $activo);
                break;
            case 6:
                $finalizado = $this->updatePaso6Comentarios($request, $activo);
                break;
            case 7:
                $finalizado = $this->updatePaso7Proteccion($request, $activo);
                break;
            case 8:
                $finalizado = $this->updatePaso8Priorizacion($request, $activo);
                break;
            case 9: 
                $finalizado = $this->updatePaso9UsoComercial($request, $activo);
            case 10:
                $finalizado = $this->updatePaso10UsoComercial($request, $activo);
                break;
            default:
                break;
        }

        return $this->returnData($activo, $finalizado, $request->step);
    }

    private function updatePaso1Descripcion(Request $request, Activo $activo) {

        $finalizado = false;
        $activo->descripcion = $request->descripcion;

        $activo->save();

        if ($activo->descripcion) {
            $finalizado = true;
        } 

        $files = $request->file('descripcion_adjuntos');

        if (!empty($files)) {
            foreach ($files as $file) {
                
                // $path = Storage::putFile('archivo', $file);

                //-------------------------------------------------------------------------------------------------------------------//
                $path = $file->store($this->file_name);
                //-------------------------------------------------------------------------------------------------------------------//


                $archivo = new Archivo();
                $archivo->tipo = 'descripcion_adjuntos';
                $archivo->nombre = preg_replace('/[[:^print:]]/', '', $file->getClientOriginalName());
                $archivo->id = $path;
                $archivo->activo_id = $activo->id;
                $archivo->save();
            }
        }

        return $finalizado;
        

    }

    public function updatePaso2Clasificacion(Request $request, Activo $activo) {
        $finalizado = false;
        $activo->clasificacion = ($request->clasificacion != 'otro' ? $request->clasificacion : $request->cual);
 
        $activo->save();

        if ($activo->clasificacion) {
            $finalizado = true;
        }

        $files = $request->file('clasificacion_adjuntos');
        if (!empty($files)) {
            foreach ($files as $file) {

                $path = $file->store($this->file_name);
                $archivo = new Archivo();
                $archivo->tipo = 'clasificacion_adjuntos';
                $archivo->nombre = preg_replace('/[[:^print:]]/', '', $file->getClientOriginalName());
                $archivo->id = $path;
                $archivo->activo_id = $activo->id;
                $archivo->save();
            }
        }
        return $finalizado;

    }

    //requiere estrategia en estado
    public function updatePaso3Estado(Request $request, Activo $activo) {

        $finalizado = false;
        $activo->estado = $request->estado;
        $activo->save();

        if ($activo->estado) {
            $this->addEstrategia($activo, 'Estado', 'estado', $activo->estado);
            $finalizado = true;
        }

        return $finalizado;

    }

    public function updatePaso4DpiAsociado(Request $request, Activo $activo) {
        $finalizado = false;
        $activo->dpis()->wherePivot('tipo_asociacion', '=' , 'dpi_asociado')->detach();

        $activo->dpis()->attach($request->dpi_asociado, ['tipo_asociacion' => 'dpi_asociado']);
        
        if($request->dpi_asociado) {
            $finalizado = true;
        }

        return $finalizado;
    }

    public function updatePaso5EstadoActualDPI(Request $request, Activo $activo) {
        $finalizado = false;
        
        //------------------------------------------------------------------
        $activo->publicado_divulgado      = $request->publicado_divulgado;
        if($request->publicado_divulgado == 'si'){
            $activo->lugar_publicacion       = $request->lugar_publicacion;
            $activo->fecha_publicacion       = $request->fecha_publicacion;
        } else {
            $activo->lugar_publicacion       = null;
            $activo->fecha_publicacion       = null;
        }
        //------------------------------------------------------------------

        //------------------------------------------------------------------
        $activo->contrato_confidencialidad  = $request->contrato_confidencialidad;
        if ($request->contrato_confidencialidad == 'si') {
            $contrato_confidencialidad = $request->file('contrato_confidencialidad_adjunto');
            if (!empty($contrato_confidencialidad)) {
                foreach ($contrato_confidencialidad as $file) {
                    $path = $file->store($this->file_name);
                    $archivo = new Archivo();
                    $archivo->tipo = 'contrato_confidencialidad_adjunto';
                    $archivo->nombre = preg_replace('/[[:^print:]]/', '', $file->getClientOriginalName());
                    $archivo->id = $path;
                    $archivo->activo_id = $activo->id;
                    $archivo->save();
                }
            }
        } else {
            \DB::table('archivos')
            ->where('activo_id', '=', $activo->id)
            ->where('tipo', '=', 'contrato_confidencialidad_adjunto')
            ->delete();
        }

        //------------------------------------------------------------------

        //------------------------------------------------------------------
        //$activo->tiene_titular   = $request->tiene_titular;
        $activo->nombre_titular  = $request->nombre_titular ; 
        // //------------------------------------------------------------------

        // //------------------------------------------------------------------
        $activo->contrato_cesion = $request->contrato_cesion;
        if ($request->contrato_cesion == 'si') {
            $contrato_cesion = $request->file('contrato_cesion_adjunto');
            if (!empty($contrato_cesion)) {
                foreach ($contrato_cesion as $file) {
                    $path = $file->store($this->file_name);
                    $archivo = new Archivo();
                    $archivo->tipo = 'contrato_cesion_adjunto';
                    $archivo->nombre = preg_replace('/[[:^print:]]/', '', $file->getClientOriginalName());
                    $archivo->id = $path;
                    $archivo->activo_id = $activo->id;
                    $archivo->save();
                }
            }
        } else {
            \DB::table('archivos')
                ->where('activo_id', '=', $activo->id)
                ->where('tipo', '=', 'contrato_cesion_adjunto')
                ->delete();
        }
        // //------------------------------------------------------------------
        
        // //------------------------------------------------------------------
        $activo->ubicacion_ai                  = $request->ubicacion_ai;
        // //------------------------------------------------------------------

        // //------------------------------------------------------------------
        $activo->en_contabilidad   = $request->en_contabilidad;
        if ($request->en_contabilidad  == 'si') {
            $activo->valor_de_ai = $request->valor_de_ai;
            $activo->valor_de_ai_comentarios = $request->valor_de_ai_comentarios;
        } else {
            $activo->valor_de_ai = null;
            $activo->valor_de_ai_comentarios = null;
        }
        //$activo->valor_de_ai = ($request->en_contabilidad  == 'si') ? $request->valor_de_ai : null;
        // //------------------------------------------------------------------

        $activo->save();

        $finalizado =  ($request->en_contabilidad &&
                        $request->ubicacion_ai &&
                        $request->contrato_cesion && 
                        $request->nombre_titular && 
                        $request->contrato_confidencialidad && 
                        $request->publicado_divulgado);
        
       $activo->contrato_confidencialidad && $this->addEstrategia($activo, 'Estado Actual del AI', 'contrato_confidencialidad', $activo->contrato_confidencialidad);
       $activo->contrato_cesion && $this->addEstrategia($activo, 'Estado Actual del AI', 'contrato_cesion', $activo->contrato_cesion);
       $activo->en_contabilidad && $this->addEstrategia($activo, 'Estado Actual del AI', 'en_contabilidad', $activo->en_contabilidad);
       //$activo->tiene_titular && $this->addEstrategia($activo, 'Estado Actual del AI', 'tiene_titular', $activo->tiene_titular);

       return $finalizado;

    }

    public function updatePaso6Comentarios(Request $request, Activo $activo) {
        $finalizado = false;

        $nuevoComentario = $request->comentarios;

        if ($nuevoComentario != '') {
            $actualizarEste = Comentario::where('activo_id', $activo->id)->orderBy('id')->first();

            if ($actualizarEste) {
                $actualizarEste->comentario = $nuevoComentario;
                $actualizarEste->save();
            }

            $comentario = new Comentario();
            $comentario->comentario = $nuevoComentario;
            $activo->comentarios()->save($comentario);
        }
        $finalizado = true;
        
        return $finalizado;

    }

    public function updatePaso7Proteccion(Request $request, Activo $activo) {
        $finalizado = false;

        $activo->deposito_da            = $request->deposito_da;
        $activo->numero_registro_da     = $request->numero_registro_da;
        $activo->registro_da            = $request->registro_da;
        $activo->medidas_proteccion     = $request->medidas_proteccion;
        $activo->cuales_medidas         = $request->cuales_medidas;
        $activo->propiedad_industrial   = $request->propiedad_industrial;
        $activo->contratos              = $request->contratos;
        $activo->cuales_contratos       = $request->cuales_contratos;

        $activo->dpis()->wherePivot('tipo_asociacion', '=' , 'propiedad_industria_deposito')->detach();
        if ($request->propiedad_industria_deposito && count($request->propiedad_industria_deposito)>0 && $activo->propiedad_industrial=='si') {
            $activo->dpis()->attach($request->propiedad_industria_deposito, ['tipo_asociacion' => 'propiedad_industria_deposito']);          
        }

        $activo->dpis()->wherePivot('tipo_asociacion', '=' , 'propiedad_industria_registro')->detach();
        if($request->propiedad_industria_registro && count($request->propiedad_industria_registro) > 0) {    
            foreach ($request->propiedad_industria_registro as $item) {
                $itemObject = json_decode($item);
                $activo->dpis()->attach($itemObject->id, ['tipo_asociacion' => 'propiedad_industria_registro', 
                                                          'numero_registro' => $itemObject->value]);
            }
        }

        $activo->save();

        $finalizado =  ($request->deposito_da &&
                        $request->medidas_proteccion &&
                        $request->propiedad_industrial && 
                        $request->contratos);
        
        return $finalizado;
    }

    public function updatePaso8Priorizacion(Request $request, Activo $activo) {
        $dpis = json_decode($request->herramientas);
        
        $finalizado = false;

        $activo->busqueda = $request->busqueda;
        $activo->presupuesto_priorizacion = $request->presupuesto_priorizacion;
        $activo->cantidad_presupuesto = $request->cantidad_presupuesto;
        $activo->save();

        DpiHerramienta::where('activo_id', '=', $activo->id)->delete();
        if ($request->busqueda == 'si') { 
            foreach ($dpis as $dpi) {

                foreach($dpi->herramientas as $herramienta) {
                    $dpi_herramienta = new DpiHerramienta();
                    $dpi_herramienta->activo_id = $activo->id;
                    $dpi_herramienta->dpi_id = $dpi->id;
                    $dpi_herramienta->herramienta_id = $herramienta->id;
                    $dpi_herramienta->save();
                }

                foreach($dpi->herramientas_nuevas as $herramienta) {
                    $nuevaHerramenta = new Herramienta();
                    $nuevaHerramenta->nombre = $herramienta->nombre;
                    $nuevaHerramenta->default = false;
                    $nuevaHerramenta->save();

                    $dpi_herramienta = new DpiHerramienta();
                    $dpi_herramienta->activo_id = $activo->id;
                    $dpi_herramienta->dpi_id = $dpi->id;
                    $dpi_herramienta->herramienta_id = $nuevaHerramenta->id;
                    $dpi_herramienta->save();

                }
            }
        }

        $finalizado =  ($request->busqueda && $request->presupuesto_priorizacion);
        $request->presupuesto_priorizacion && $this->addEstrategia($activo, 'Priorización y decisión', 'presupuesto_priorizacion', $activo->presupuesto_priorizacion);


        return $finalizado;

    }

    public function updatePaso9UsoComercial(Request $request, Activo $activo) {
        $finalizado = false;
        $activo->uso_comercial = $request->uso_comercial;
        $activo->cual_uso_comercial = ($request->uso_comercial == 'si' ? $request->cual_uso_comercial : '');

        $finalizado = $request->uso_comercial =! '';

        if ($finalizado) {
            $activo->estado_diligencia = 'Terminado';
        }

        $activo->save();

        return $finalizado;
    }

    public function updatePaso10UsoComercial(Request $request, Activo $activo) {
        $finalizado = false;

        $nuevaEstrategia = $request->estrategias;

        if ($nuevaEstrategia != '') {
            $estrategia = new Estrategia();
            $estrategia->estrategia = $nuevaEstrategia;
            $activo->estrategias()->save($estrategia);
            $activo->estado_diligencia = 'Terminado';
            $activo->save();
            $finalizado = true;
        }

        return $finalizado;

    }

    public function makeData($id) {
        $side_menu = \Config::get('constants')->sideMenu;
        $activo = Activo::with('archivos', 'dpis', 'comentarios', 'estrategias', 'subproyecto')->where('id', '=', $id)->first();
        $historial = Activo::with('comentarios', 'dpis', 'dpiHerramientas', 'archivos', 'estrategias')->where('activo_id', $activo->id)->get();
        $activo->herramientas = Herramienta::all();

        $subproyecto = $activo->subproyecto;
        $dpis = Dpi::all();

        $activo->dpis_opt = $dpis;

        $fields = $side_menu->steps->submenus;
        $archivos = $activo->archivos;
        $steps_complete = 0;
        $finished_prev = true;
        foreach ($fields as $step) {

            $percentage_complete = 0;
            if ($step->fields) {
                foreach ($step->fields as $item) {

                    // if($item->name == 'deposito_da') {
                    //     $stepDPiAsociado = collect($fields)->filter(function($item){ return $item->step == 4;});
                    //     $dpis_asociados = collect(collect(collect(collect($stepDPiAsociado['4'])['fields'])['dpi_asociado'])['data'])->filter( function($item) { return $item['nombre'] == 'Derecho de autor';});
                    //      if ($dpis_asociados->count() == 0) {
                    //          $item->required  = false;
                    //          $step->size = $step->size - 1;
                    //      }
                    //  }

                    if ($item->type == 'select-multi') {
                        if ($item->name == 'herramientas') {
                            $herramientas = Herramienta::where('default', '=', true)->get();

                            $dpis->map(function($dpi) {
                                $dpi->herramientas=[];
                                $dpi->herramientas_nuevas=[];
                                return $dpi;
                            });

                            $item->values = (Object) 
                                [   'herramientas' => $herramientas,
                                    'dpis' => $dpis,
                                ];

                        } else {
                            $item->values = $item->industry ? Dpi::where('derecho_de_industria', '=', true)->get() : $dpis;
                        }
                    } 

                    if ($item->type == 'adjunto') {

                        $filterArchivos = $archivos->filter( function($archivo) use ($item, $activo) {
                            return $archivo->tipo == $item->name;
                        });
                        
                        if ($filterArchivos->count() > 0) {
                            $item->finished = true;
                            $item->data = $filterArchivos;
                            if ($item->required && !isset($item->reference_to)) {
                                $percentage_complete += 1;
                            }
                        }

                    } else if($item->type == 'select-multi') {
                        if ($item->name == 'herramientas'){
                            
                            $item->values->dpis->map( function($dpi) use ($id) {
       
                                $herramientasIds = DpiHerramienta::select('herramienta_id')
                                                                ->where('activo_id', '=', $id)
                                                                ->where('dpi_id', '=', $dpi->id)
                                                                ->get();
                                $herramientas = [];
                                $herramientas_nuevas = [];
                                foreach($herramientasIds as $herramientaId) {
                                    $herramienta = Herramienta::find($herramientaId->herramienta_id);

                                    if ($herramienta->default) {
    
                                        array_push($herramientas, $herramienta); 
                                    } else {
                                        array_push($herramientas_nuevas, $herramienta); 
                                    }
                                }

                                $dpi->herramientas = $herramientas;
                                $dpi->herramientas_nuevas =$herramientas_nuevas;
                                return $dpi;
                            });
                            
                        } else {
                            $filtermulti = $activo->dpis->filter( function($dpi) use ($item) {
                                return $dpi->pivot->tipo_asociacion == $item->name;
                            });

                            $x=[];
                            foreach ($filtermulti as $dpi) {
                                array_push($x, $dpi);
                            }
                    
                            if ($filtermulti->count() > 0 ) {
                                $item->finished = true;
                                $item->data = $x;
                                if ($item->required && !isset($item->reference_to)) {
                                    $percentage_complete += 1;
                                }
                            } else {
                                $item->data = '';
                            }
                        }
                    }

                    else {

                        if($activo[$item->name] && collect($activo[$item->name])->count()) {

                            $item->finished = true;
                            $item->data = $activo[$item->name];
                        

                            if($item->name == 'estrategias') {
                                $estrategias = Estrategia::where('activo_id', $id)->orderBy('campo')->get();
                                $item->data = $estrategias;
                            }

                            if($item->name == 'comentarios') {
                                $item->data = [Comentario::where('activo_id', $id)->orderBy('id')->get()][0];
                                $percentage_complete += 1;
                            }

                            if ($item->required && !isset($item->reference_to)){
                                $percentage_complete += 1;
                            }
                        } else {
                            if ($item->name == 'comentarios') {
                                $item->data = [new Comentario()];
                            }
                        }
                    }
                }
            }

            $step->percentage_complete = $percentage_complete/$step->size;
            $step->finished = ($step->percentage_complete == 1);
            $steps_complete += ($step->finished ? 1 : 0);
            $step->available = $finished_prev;
            $finished_prev = $step->finished;
        }

        $x = collect($side_menu->steps->submenus)->filter(function($val){
            return $val->name == 'Estrategias de gestión';
        ;});
        
        $estrategias = Estrategia::where('activo_id', $id)->orderBy('campo')->get();;

        //agregar estrategia general si esta no existe
        $estrategia_general = $estrategias->filter(function($estrategia){ return $estrategia->campo == 'estrategia_general';})->count();
        
        if(!$estrategia_general) {
            $add = new Estrategia();
            $add->nombre_paso = 'estrategia_general';
            $add->campo = 'estrategia_general';
            $add->estado = 'estrategia_general';
            $add->estrategia = null;
            $add->activo_id = $id;

            $estrategias->push($add);
        }
        
        $estrategias->each( function($estrategia) {

            $estrategia->errors = '';

            $estrategia->otro = $estrategia->responsable;
            if ( $estrategia->responsable != 'responsable' and $estrategia->responsable != 'director' and $estrategia->responsable != null) {
                $estrategia->responsable = 'otro';
            }
            else if ($estrategia->responsable == null) {
                $estrategia->responsable = null;
                $estrategia->otro = '';
            } else {
                $estrategia->otro = '';
            }
        });

        $side_menu->steps->estrategias = $estrategias;

        $side_menu->steps->percentage_complete = $steps_complete/$side_menu->steps->size;
        $side_menu->steps->subproyecto = $subproyecto;

        $activo->file_size = $this->file_size;

        $activo->historial = $historial;
        return [$side_menu, $activo];
    }

    public function downloadFile($archivoId) {
        error_log($archivoId);
        $archivoId = str_replace('-', '/', $archivoId);
        error_log($archivoId);
        $archivo = Archivo::find($archivoId);
        return Storage::download($archivoId, $archivo->nombre);
    }

    public function downloadFiles(Request $request) {
        //toca comrimirlo los archivos para descargarlos;
        error_log('downloadFiles');

    }

    public function deleteFile($activoId, $archivoId) {
        $archivoId = str_replace('-', '/', $archivoId);
        $archivo = Archivo::find($archivoId);

        $tipo = $archivo->tipo;

        Storage::delete($archivoId);
        $archivo->delete();

        $step = [
            'descripcion_adjuntos' => '1',
            'clasificacion_adjuntos' => '2',
            'contrato_confidencialidad_adjunto' => '5',
            'contrato_cesion_adjunto' => '5',
        ];

        $activo = Activo::find($activoId);
        return $this->returnData($activo, false, $step[$tipo]);

    }

    public function deleteFiles($activoId, Request $request) {
        $idFiles = $request->idFiles;

        $tipo = Archivo::find($idFiles[0])->tipo;
        Storage::delete($idFiles);
        $archivo = Archivo::destroy($idFiles);

        $step = [
            'descripcion_adjuntos' => '1',
            'clasificacion_adjuntos' => '2',
            'contrato_confidencialidad_adjunto' => '5',
            'contrato_cesion_adjunto' => '5',
        ];

        $activo = Activo::find($activoId);

        return $this->returnData($activo, false, $step[$tipo]);
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Activo  $activo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Activo $activo) {

        $historial = Activo::where('activo_id', $activo->id)->get();

        $historial->each( function($activo_hist) {
            $activo_hist->delete();
        });

        $activo->delete();
    }
}
