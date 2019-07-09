<?php

$resources = \Config::get('constants')->resources;

Auth::routes();
Route::redirect('/home', '/');
Route::get('/', 'HomeController@index')->name('home');

$users = $resources->users;
Route::resource($users->basePath, $users->controller);
Route::get($users->apiPath, $users->apiController);
Route::post('users/invitation', 'UserController@invitation');
Route::get('users/registration/{token}', 'UserController@createFromInvitation');
Route::post('users/{token}', 'UserController@store');
Route::match(['get', 'post'], '/users/validateCode/{token}', 'UserController@validateCode');
Route::get('users/reasignarProyectos/{userId}', 'UserController@reasignarProyectos');
Route::delete('users/asignProyectsAndDestroy/{assginUserId}/{destroyUserId}', 'UserController@asignProyectsAndDestroy');//delete
Route::post('users/reasignProyectAndDestroy/{assginUserId}', 'UserController@reasignProyectAndDestroy');

// En el controlador ProyectoController.php, el método @index devuelve los proyectos
// del usuario, el método @indexAll devuelve todos los proyectos
$proyectos = $resources->proyectos;
Route::get('mis_proyectos', $proyectos->controller . '@index');
Route::get('todos_los_proyectos', $proyectos->controller . '@indexAll');
Route::get('todos_los_semilleros', $proyectos->controller . '@indexAllSemilleros');
Route::resource($proyectos->basePath, $proyectos->controller, ['except' => ['index']]);

Route::get($proyectos->apiPath, $proyectos->apiController);

$activos = $resources->activos;
Route::get('/todos_mis_activos', 'ActivoController@indexAll');
Route::get('activos/showApi/{activoId}', 'ActivoController@showApi');
Route::get('activos/show/{activoId}', 'ActivoController@show');
Route::put('activos/create', 'ActivoController@store');
Route::get('activos/{subproyectoId}', 'ActivoController@index');
Route::get('activos/donwloadFile/{archivoId}', 'ActivoController@downloadFile');
Route::put('activos/donwloadFiles', 'ActivoController@downloadFiles');
Route::delete('activos/deleteFile/{activoId}/{archivoId}/', 'ActivoController@deleteFile');
Route::delete('activos/deleteFiles/{activoId}', 'ActivoController@deleteFiles');
Route::post('activos/updates/{proyectoId}', 'ActivoController@updates');
Route::put('/activos/addEstrategia', 'ActivoController@addNewEstrategia');
Route::post('/activos/addEstrategiaGeneral', 'ActivoController@addEstrategiaGeneral');
Route::put('/activos/updateName/{id}', 'ActivoController@updateName');

Route::get($activos->apiPath, $activos->apiController);
Route::get('/api_index_mis_activos', 'ActivoController@apiIndexMisActivos');
Route::resource($activos->basePath, $activos->controller, ['except' => ['index', 'create']]);

Route::delete('comentario/{id}', 'ComentarioController@destroy');
Route::delete('estrategia/{id}', 'EstrategiaController@destroy');

Route::post('subproyectos/create', 'SubproyectosController@store');
Route::get('subproyectos/{id}', 'SubproyectosController@show');
Route::put('subproyectos/{id}', 'SubproyectosController@update');
Route::delete('subproyectos/{id}', 'SubproyectosController@destroy');

Route::get('glosario', 'GlosarioController@show');
Route::get('manual_usuario', 'ManualUsuarioController@show');

Route::get('/user/perfil', 'UserController@showPerfil');
Route::get('/user/perfil/{id}', 'UserController@editPerfil');
Route::put('/user/perfil/{id}', 'UserController@updatePerfil');
Route::get('/user/perfil/{id}/password', 'UserController@editPassword');
Route::put('/user/perfil/{id}/password', 'UserController@updatePassword');

Route::get('/proyectos/api-user/{id}', 'ProyectoController@apiProyectosUser');
Route::get('/proyectosAll', 'ProyectoController@showAll');
Route::post('/proyectos/users', 'ProyectoController@addusers');

Route::delete('/activos/delete/{herramienta_id}/{activo_id}/{dpi_id}', 'ActivoController@deleteOtraHerramienta');

Route::get('/busqueda', 'HomeController@busqueda');

Route::get('/report', 'ReportController@index');
Route::post('/apiReport', 'ReportController@apiIndex');