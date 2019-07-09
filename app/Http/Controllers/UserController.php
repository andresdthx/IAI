<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\Invitation;
use Illuminate\Support\Facades\Mail;
use App\{User, Role, Invitacion, Proyecto};
use App\Utilities\Crud;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller {

    private $usersConsts;
    private $configConst;
    
    public function __construct() {
        $this->middleware('auth', ['except' => ['validateCode', 'createFromInvitation', 'store']]);
        $this->configConst = \Config::get('constants')->config;
        $this->usersConsts = \Config::get('constants')->resources->users;
    }

    public function updatePassword($id, Request $request) {
        $user = User::find($id);

        $request->validate([
            'current_password' => [
              'required',
              function($attribute, $value, $fail) use ($user) {
                  if (!Hash::check($value, $user->password)) {
                      return $fail('El password es incorrecto');
                  }
              },
            ],
            'new_password' => 'required|confirmed|min:6',
          ]);
    
        $user->password = bcrypt($request->new_password);
        $user->save();
    }

    public function editPassword($id) {
        $user = User::find($id);
        return view('users.show_password', compact('user'));
    }

    public function updatePerfil($id, Request $request) {
        $user = User::find($id);
        $this->validate($request, [
            'name' => 'required',
        ]);

        $user->name = $request->name;
        $user->save();

    }

    public function editPerfil($id) {
        $user = User::find($id);
        return view('users.edit_profile', compact('user'));
    }

    public function showPerfil() {
        $user = User::with('roles')->where('id', \Auth::user()->id)->first();
        return view('users.show_profile', compact('user'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $user = new User();
        $this->authorize('view', $user);

        list($config, $values) = Crud::createIndexParams($this->usersConsts);

        $user_role = \Auth::user()->id;
        $all_users = User::all();
        $users = User::select('users.id as id',
                              'users.name as nombre',
                              'users.email',
                              'roles.name as rol',
                              \DB::raw('count(proyectos.id) as proyectos'))
                            ->join('role_user', 'role_user.user_id', '=', 'users.id')
                            ->join('roles', 'roles.id', '=', 'role_user.role_id')
                            ->leftJoin('proyectos', 'proyectos.user_id', '=', 'users.id')
                            ->groupBy('users.id', 'roles.name')
                            ->orderBy('users.name')
                       ->paginate($this->usersConsts->pagination)->toJson();
        $roles = Role::all();
        
        return view('users.index', compact('users', 'roles', 'user_role', 'config', 'values', 'all_users'));
    }

    public function apiIndex($nombre='', $email='', $roles='', $sortField='', $dir='') {
        $roles = array_map('intval', explode(',', substr($roles, 1, -1)));
        $nombre = $nombre == $this->configConst->nullParam ? null : $nombre;
        $email = $email == $this->configConst->nullParam ? null : $email;

        $sortField = $sortField == $this->configConst->nullParam  ? null : $sortField;
        $dir = $dir == $this->configConst->nullParam ? null : $dir;

        $users = User::select('users.id as id',
                            'users.name as nombre',
                            'users.email',
                            'roles.name as rol',
                            \DB::raw('count(proyectos.id) as proyectos'))
                            ->join('role_user', 'role_user.user_id', '=', 'users.id')
                            ->join('roles', 'roles.id', '=', 'role_user.role_id')
                            ->leftJoin('proyectos', 'proyectos.user_id', '=', 'users.id')
                            ->when($sortField, function ($query) use ($sortField, $dir) {
                                return $query->orderBy($sortField, $dir);
                            }, function ($query) {
                                return $query->orderBy('users.name');
                            })
                            ->when($roles[0] != 0, function ($query) use ($roles) {
                                return $query->whereIn('roles.id', $roles);
                            })
                            ->whereRaw('LOWER(users.name) LIKE ?', ['%'.strtolower($nombre).'%'])
                            ->whereRaw('LOWER(users.email) LIKE ?', ['%'.strtolower($email).'%'])
                            ->groupBy('users.id', 'roles.name')
                            ->paginate($this->usersConsts->pagination)
                            ->toJson();
    
        return response()->json([
            'users' => $users,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $user = new User();
        $this->authorize('create', $user);
        $roles = Role::all();
        return view('users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $token) {
        $user = new User();
        // $this->authorize('create', $user);

        $this->validate($request, [
            'nombre' => 'required',
            'contraseña' => 'required|confirmed|min:6',
        ]);

        $invitacion = Invitacion::where('token', '=', $token)->first();

        $rol = $invitacion->rol;
        $email = $invitacion->correo;

        $user->name = $request->input('nombre');
        $user->email = $email;
        $user->password = bcrypt($request->input('contraseña'));
        $user->save();
        $user->roles()->attach($rol);
        
        $invitacion->valido = false;
        $invitacion->save();
        
        // return 'stored';
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        $user = new User();
        $this->authorize('update', $user);

        $this->validate($request, [
            'rol' => 'required',
        ]);

        $user = User::where('id', $id)->first();
        $roleId = $user->roles()->get()[0]->id;
        \DB::update('UPDATE role_user SET role_id = ? WHERE role_id = ? and user_id = ?', [$request->input('rol'), $roleId, $id]);
        return 'updated';
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $user = new User();
        $this->authorize('delete', $user);
        $user = User::where('id', $id)->first();
        $roleId = $user->roles()->get()[0]->id;

        \DB::delete('DELETE FROM role_user WHERE role_id = ? and user_id = ?', [$roleId, $id]);
        $user->delete();

    }

    public function asignProyectsAndDestroy($assginUserId, $destroyUserId) {
        $user = new User();
        $this->authorize('delete', $user);
        error_log('sdfdsf');

        $user = User::where('id', $destroyUserId)->first();
        $roleId = $user->roles()->get()[0]->id;

        \DB::update('UPDATE proyectos set user_id = ? where user_id = ?', [$assginUserId, $destroyUserId]);
        \DB::delete('DELETE FROM role_user WHERE role_id = ? and user_id = ?', [$roleId, $destroyUserId]);
        $user->delete();
    }

    public function invitation(Request $request) {
        $user = new User();
        $this->authorize('create', $user);

        $this->validate($request, [
            'rol' => 'required',
            'email' => [
                'required',
                'confirmed',
                function($attribute, $value, $fail){
                    $user = User::where('email', '=', $value)->first();
                    error_log($user);
                    if ($user){
                        return $fail('Este correo ya tiene un usuario registrado');
                    }
                }]
        ]);

        $invitaciones = Invitacion::all();
        $token = '';
        
        do {
            $token = md5(uniqid(rand(), true));
        } while (!$invitaciones->every(function($invitacion) use ($token) {
            return $invitacion->token != $token;
        }));

        $codigo = '';

        do {
            $codigo = rand(100000, 999999);
        } while(!$invitaciones->every(function($invitacion) use ($codigo) 
                {return $invitacion->codigo != $codigo;})
        );


        $fecha_expiracion = today()->addDays(\Config::get('constants')->invitationDaysExpiration);  ;

        $invitacion                     = new Invitacion();
        $invitacion->rol                = $request->rol;
        $invitacion->correo             = $request->email;
        $invitacion->fecha_expiracion   = $fecha_expiracion;
        $invitacion->token              = $token;
        $invitacion->valido             = true;
        $invitacion->codigo             = $codigo;
        $invitacion->save();

        $resp = Mail::to($invitacion->correo)->send(new Invitation($invitacion));
    }

    public function createFromInvitation($token) {
        $invitacion = Invitacion::select('valido', 'fecha_expiracion')->where('token', '=', $token)->first();
        if (!$invitacion or !$invitacion->valido or Carbon::parse($invitacion->fecha_expiracion)->lt(today()) ) {
            return abort(404);
        }

        $current_token = $token;
        return view('users.new', compact('current_token'));
    }

    public function validateCode(Request $request, $token) {
        $this->validate($request, [
            'codigo' => [
                'required',
                function($attribute, $value, $fail) use ($token) {
                    $invitacion = Invitacion::where('token', $token)->first();
                    if ($invitacion->codigo != $value){
                        return $fail('El codigo es incorrecto');
                    }
                },
            ]
        ]);
        $current_token = $token;
        return view('users.add_user', compact('current_token'));
    }
    
    public function reasignarProyectos($id) {
        $proyectos = Proyecto::where('user_id', '=', $id)->get();
        $usuario = User::find($id);
        $usuarios = User::where('id', '<>', $id)->get();
        return view('users.reasignar_proyectos', compact('proyectos', 'usuarios', 'usuario'));
    }

    public function reasignProyectAndDestroy($userId, Request $request) {
        $this->validate($request, [
            'selectUsers' => 'required'
        ]);

        foreach($request->selectUsers as $user) {
            foreach($user['newProyects'] as $proyect) {
                \DB::update('UPDATE proyectos set user_id = ? where id = ?', [$user['id'], $proyect['id']]);
            }
        }

        $user = User::find($userId);
        $roleId = $user->roles()->get()[0]->id;

        \DB::delete('DELETE FROM role_user WHERE role_id = ? and user_id = ?', [$roleId, $userId]);
        $user->delete();
    }
        
}
