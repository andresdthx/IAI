<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\{Activo, User, Proyecto, Subproyecto};
use Illuminate\Support\Facades\Input;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function busqueda() {

        $search = Input::get("search");

        $user = \Auth::user();

        $activos = Activo::with('subproyecto.proyecto')->where('nombre_asociado', 'ILIKE', '%'. strtolower($search)  . '%')->where('activo_id', null)->get()
                        ->filter( function($activo) use($user) {
                            return $activo->subproyecto->proyecto->user_id == $user->id;
                        })->values();
    
        
        $sub_proyectos = Subproyecto::with('proyecto')->where('nombre', 'ILIKE', '%'. strtolower($search) . '%')->get()
                                    ->filter( function($x) use($user) {
                                        return $x->proyecto->user_id == $user->id;
                                    })->values();

        $proyectos = Proyecto::where('nombre', 'ILIKE', '%'. strtolower($search) . '%')->where('user_id', $user->id)->get();


        return view( 'home.busqueda', compact('activos', 'sub_proyectos', 'proyectos', 'search') );
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $user = \Auth::user();
        $proyectos = Proyecto::with('sub_proyectos')->where('user_id', $user->id)->get();
        $activos = 0;
        $en_progreso = 0;
        $terminados = 0;

        $allActivos = [];

        foreach( $proyectos as $proyecto) {
            $subProyectos = $proyecto->sub_proyectos;
            foreach($subProyectos as $subProyecto) {
                $acts = Activo::where('subproyecto_id', $subProyecto->id)->get();
                $activos = $activos + collect($acts)->count();
                foreach($acts as $act) {
                    array_push($allActivos, $act);
                    if ($act->estado_diligencia == 'En progreso') {
                        $en_progreso = $en_progreso + 1; 
                    } else {
                        $terminados += 1;
                    }

                }
            }
        }

        $last_activos= (collect($allActivos)->sortByDesc('updated_at')->take(7));

        $char_data = (Object) [
            'datasets' => [
                (Object) [
                    'backgroundColor' => [
                        '#0083A9',
                        '#490E6F'
                    ],
                    'data' => [
                        $terminados,
                        $en_progreso
                    ]
                ]
                
            ],
            'labels'=> [
                'activos terminados',
                'activos en progreso'
            ]
        ];

        
        $proyectos = collect($proyectos)->count();
        $users = User::all()->count();  
        $char_data= json_encode($char_data);
        return view('home', compact('activos', 'proyectos', 'users', 'char_data', 'last_activos', 'user'));
    }
}
