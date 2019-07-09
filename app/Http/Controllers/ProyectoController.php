<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\{User, Proyecto, Subproyecto, Activo};
use Illuminate\Support\Facades\Route;
use App\Utilities\Crud;

class ProyectoController extends Controller {

    private $proyectosConsts;
    private $configConst;

    public function __construct() {
        $this->middleware('auth');
        $this->configConst = \Config::get('constants')->config;
        $this->proyectosConsts = \Config::get('constants')->resources->proyectos;
    }

    public function apiProyectosUser($id) {
        $proyectos= Proyecto::with('sub_proyectos')->where('user_id', $id)->get();
        return response()->json([
            'proyectos' => $proyectos,
        ]);

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $user = \Auth::user();
        $users = User::all();

        $role = $user->roles[0];

        $init_data = Proyecto::with('sub_proyectos')->select('proyectos.id', 'proyectos.director_del_grupo',  'proyectos.nombre', 'proyectos.descripcion', 'proyectos.user_id')
                             ->where('user_id','=', $user->id)
                             ->get();
        

        $init_data = $init_data->map( function($proyecto) {
            $proyecto->open = false;
            return $proyecto;
        });

        $filters = [
            (Object) [
                'name' => 'nombre',
                'value' => ''
            ],

            (Object) [
                'name' => 'director_del_grupo',
                'value' => ''
            ]
        ];

        return view('proyectos.index', compact('init_data', 'filters', 'user', 'users', 'role'));
    }

    public function indexAll() {
        $user = \Auth::user();
        $users = User::all();
        $role = $user->roles[0];
        
        $init_data = Proyecto::with('sub_proyectos', 'user')->select('proyectos.id', 'proyectos.director_del_grupo', 'proyectos.nombre', 'proyectos.descripcion', 'proyectos.user_id')->get();
        $init_data = $init_data->map( function($proyecto) {
            //dd($proyecto);
            $proyecto->open = false;
            $proyecto->responsable = $proyecto->user->name;
            //dd($proyecto->user->name);
            return $proyecto;
        });

        $responsables= [];

        foreach($init_data as $proyecto) {
            array_push($responsables, (Object) ['id' => $proyecto->user->name, 'name' => $proyecto->user->name]);
        }

        $responsables = collect($responsables)->unique('id')->values()->all();

        $filters = [
            (Object) [
                'name' => 'nombre',
                'value' => ''
            ],

            (Object) [
                'name' => 'responsable',
                'value' => [],
                'options' => $responsables
            ],


            (Object) [
                'name' => 'director_del_grupo',
                'value' => ''
            ]
        ];

        $sem = false;

        return view('proyectos.proyectos_all', compact('init_data', 'filters', 'user', 'users', 'role', 'sem'));

    }


    public function indexAllSemilleros() {
        $user = \Auth::user();
        $users = User::all();
        $role = $user->roles[0];
        
        $init_data = Proyecto::with('sub_proyectos', 'user')->select('proyectos.id', 'proyectos.director_del_grupo', 'proyectos.nombre', 'proyectos.descripcion', 'proyectos.is_semillero', 'proyectos.user_id')->where('proyectos.is_semillero', '=', true)->get();
        $init_data = $init_data->map( function($proyecto) {
            //dd($proyecto);
            $proyecto->open = false;
            $proyecto->responsable = $proyecto->user->name;
            //dd($proyecto->user->name);
            return $proyecto;
        });

        $responsables= [];

        foreach($init_data as $proyecto) {
            array_push($responsables, (Object) ['id' => $proyecto->user->name, 'name' => $proyecto->user->name]);
        }

        $responsables = collect($responsables)->unique('id')->values()->all();

        $filters = [
            (Object) [
                'name' => 'nombre',
                'value' => ''
            ],

            (Object) [
                'name' => 'responsable',
                'value' => [],
                'options' => $responsables
            ],


            (Object) [
                'name' => 'director_del_grupo',
                'value' => ''
            ],

            'semillero'=>'true'
        ];

        $sem = true;

        return view('proyectos.proyectos_s_all', compact('init_data', 'filters', 'user', 'users', 'role', 'sem'));

    }

    public function apiIndex($nombre='', $users='', $descripcion='', $sortField='', $dir='') {
        $users = array_map('intval', explode(',', substr($users, 1, -1)));
        $nombre = $nombre == $this->configConst->nullParam ? null : $nombre;
        $descripcion = null; //Ño
        $sortField = $sortField == $this->configConst->nullParam  ? null : $sortField;
        $dir = $dir == $this->configConst->nullParam ? null : $dir;

        $user_auth = \Auth::user();

        $proyectos = Proyecto::select('descripcion', 'proyectos.id as id', 'nombre','name as encargado')
                            ->join('users', 'proyectos.user_id', '=', 'users.id')
                            ->when($sortField, function ($query) use ($sortField, $dir) {
                                return $query->orderBy($sortField, $dir);
                            }, function ($query) {
                                return $query->orderBy('proyectos.nombre');
                            })
                            ->when($users[0] != 0, function ($query) use ($users) {
                                return $query->whereIn('user_id', $users);
                            })
                            ->whereRaw('LOWER(nombre) LIKE ?', ['%'.strtolower($nombre).'%'])
                            ->paginate($this->proyectosConsts->pagination)
                            ->toJson();

        return response()->json([
            'proyectos' => $proyectos,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $users=collect([]);
        if (\Auth::user()->hasRole('admin')) {
            $users = User::all();
        }
        return view('proyectos.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        
        $this->validate($request, [
            'nombre' => 'required|unique:proyectos,nombre',
            'director' => 'required',
            //'is_semillero' => 'required',
            'encargado' => 'required',
        ]);

        \DB::insert('insert into proyectos (nombre, director_del_grupo, descripcion, is_semillero, user_id) values (?, ?, ?, ?, ?)',
                    [$request->input('nombre'),
                     $request->input('director'),
                     $request->input('descripcion'),
                     $request->input('is_semillero'),
                     $request->input('encargado')]);

        return 'stored';
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        $users = User::all();

        $proyecto = Proyecto::select('users.name as encargado', 'proyectos.director_del_grupo','proyectos.nombre', 'proyectos.descripcion', 'proyectos.id', 'proyectos.user_id as user_id')
                             ->join('users', 'users.id', '=', 'proyectos.user_id')
                             ->where('proyectos.id','=', $id)
                             ->first();

        $this->authorize('view', $proyecto);

        $integrantes = User::select('users.name')
                             ->join('proyecto_user','proyecto_user.user_id', '=', 'users.id')
                             ->where('proyecto_user.proyecto_id', '=', $id)
                             ->get();


        $init_data = Subproyecto::with('activos')->where('proyecto_id', '=', $id)->get();

        $init_data = $init_data->map( function($proyecto) {
            $proyecto->open = false;
            return $proyecto;
        });

        $filters = [
            (Object) [
                'name' => 'nombre',
                'value' => ''
            ],
        ];

        return view('proyectos.show', compact('proyecto', 'init_data', 'filters', 'users', 'integrantes'));
    }

    public function showAll() {
        $user = \Auth::user();

        $init_data = Subproyecto::with('proyecto', 'activos')->get()
        ->filter( function($x) use($user){
            return $x->proyecto->user_id == $user->id;
        })->map( function($x) {
            $data = (Object) [];
            $data->nombre = $x->nombre;
            $data->grupo_investigacion = $x->proyecto->nombre;
            $data->descripcion = $x->descripcion;
            $data->id = $x->id;
            $data->activos = $x->activos;
            return $data;
        })->values();
        
        $grupos = [];

        foreach($init_data as $proyecto) {
            array_push($grupos, (Object) ['id' => $proyecto->grupo_investigacion, 'name' => $proyecto->grupo_investigacion]);
        }


        $grupos = collect($grupos)->unique('id')->values()->all();

        $filters = [
            (Object) [
                'name' => 'nombre',
                'value' => ''
            ],

            (Object) [
                'name' => 'grupo_investigacion',
                'value' => [],
                'options' => $grupos
            ]
        ];



        return view('proyectos.showAll', compact('user', 'init_data', 'filters'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id){
        $proyecto = Proyecto::find($id);
        $this->authorize('update', $proyecto);

        $proyecto = Proyecto::with('user')->where('id', $id)->first();
        $users = collect([]);
        if (\Auth::user()->hasRole('admin')) {
            $users = User::all();
        }

        return view('proyectos.edit', compact('proyecto', 'users'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Proyecto $proyecto){
        $this->authorize('update', $proyecto);

        $this->validate($request, [
            'nombre' => 'required|unique:proyectos,nombre,'.$proyecto->id,
            'director' => 'required',
            'encargado' => 'required'
        ]);

        // $proyecto->fill(['nombre' => $request->input('nombre'), 
        //                  'user_id' => $request->input('encargado'),
        //                  'director_del_grupo' => 'director_update',
        //                  'descripcion' => $request->input('descripcion')
        //                 ]);
        
        $proyecto->nombre               = $request->input('nombre');
        $proyecto->user_id              = $request->input('encargado');
        $proyecto->is_semillero         = $request->input('is_semillero');
        $proyecto->director_del_grupo   = $request->input('director');
        $proyecto->descripcion          = $request->input('descripcion');

        $proyecto->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $subProyectos = Subproyecto::select('id')->where('proyecto_id', $id)->get();
        $activos = $subProyectos->map(function($subProyecto) {
            return Activo::select('id')->where('subproyecto_id', $subProyecto->id)->get();
        });

        $activos->flatten()->each( function($activo) {
            
            $historial = Activo::where('activo_id', $activo->id)->get();

            $historial->each( function($activo_hist) {
                $activo_hist->delete();
            });


            Activo::find($activo->id)->delete();
        });
        
        $subProyectos->each( function($subProyecto) {
            Subproyecto::find($subProyecto->id)->delete();
        });

        Proyecto::find($id)->delete();

    }

    public function addusers(Request $request){
        $proyecto = $request->only('proyecto');
        $users = $request->only('users');

        $cont = 0;

        $grupo = Proyecto::find($proyecto['proyecto']);
        
        foreach($users as $user){
           $grupo->users()->attach($user);
        }

        //return $cont;
    }
}
