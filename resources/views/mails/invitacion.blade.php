Saludos,

<p>Has sido invitado(a) para registrarte en la aplicación de inventario de activos intangibles.</p>
 
<p>Para completar el registro ingresa el codigo <strong>{{$invitacion->codigo}}</strong> accediendo al siguiente enlace</p>

<p>
@if (App::environment('local'))
    <a href={{'http://localhost:8000/users/registration/' . $invitacion->token }}>http://localhost:8000/users/registration/{{$invitacion->token}}</a>
@else
    <a href={{ env('APP_URL', false) . '/users/registration/' . $invitacion->token }}>{{ env('APP_URL', false) . '/users/registration/' . $invitacion->token }}</a>
@endif
</p>

Cordialmente.
<br/>
