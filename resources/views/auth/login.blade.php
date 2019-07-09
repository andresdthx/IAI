@extends('layouts.app')

@section('content')
    {{-- <div style="background-color: #E00000;position: absolute; right: 0px; top: 0px; width: 60%;height: 20px;border-top-left-radius: 50px;border-bottom-left-radius: 50px;"></div> --}}
    {{-- <div style="background-color: #E00000;position: absolute; right: 0px; top: 25px; width: 40%;height: 15px;border-top-left-radius: 50px;border-bottom-left-radius: 50px;"></div> --}}

    <div class="card-login">
    <div style="text-align: center;">
        <img  src="{{asset('images/escuela.png')}}" alt="" width="200">
        {{-- <img  style="margin-left: 20px; margin-right: 30px;margin-top: 5px;" src="{{asset('images/ip_data.png')}}" alt="" width="150">  --}}
    </div>

        <p id="profile-name" class="profile-name-card"></p>
        <form class="form-signin" action="{{ route('login') }}" method="POST">
            {{ csrf_field() }}
            <span id="reauth-email" class="reauth-email"></span>

            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                <input type="email" id="inputEmail" name="email" class="form-control login-text" placeholder="Correo electrónico" required autofocus>
                @if ($errors->has('email'))
                    <span class="help-block">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif
            </div>

            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                <input type="password" id="inputPassword" name="password" class="form-control login-text" placeholder="Contraseña" required>
                @if ($errors->has('password'))
                    <span class="help-block">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                @endif
            </div>  
            
            <div id="remember" class="checkbox">
                <label>
                    <input type="checkbox" value="remember-me"> Recordarme
                </label>
            </div>

            <button style="background-color: #990000; font-family: 'Open Sans'; font-weight: bold" 
                    class="btn btn-lg btn-warning btn-block btn-signin" 
                    type="submit">Iniciar sesión</button>

        </form>

         

        <div class="foot">
            
            <a style="padding-left: 10px;" href="https://www.facebook.com/EscuelaIng/" target="_blank">
                <i style="color: white;" class="fa fa-facebook"></i>
            </a>

            <a style="padding-left: 10px;" href="https://twitter.com/Escuelaing" target="_blank">
                <i style="color: white;" class="fa fa-twitter"></i>
            </a>

            <a style="padding-left: 10px;" href="https://www.instagram.com/escuelaing/?hl=en" target="_blank">
                <i style="color: white;" class="fa fa-instagram"></i>
            </a>

            <a style="padding-left: 10px;" href="https://www.youtube.com/user/escuelacolingenieria" target="_blank">
                <i style="color: white;" class="fa fa-youtube"></i>
            </a>

            <a style="padding-left: 10px;" href="https://www.linkedin.com/school/escuela-colombiana-de-ingenieria/" target="_blank">
                <i style="color: white;" class="fa fa-linkedin"></i>
            </a>

            <a title="Canal I+i" style="padding-left: 10px;" href="https://www.youtube.com/channel/UCWqevVrYtgVYAL8sFKsQGUw" target="_blank">
                <img  src="{{asset('images/logo_canal.png')}}" width="20px">
            </a>
        </div>
    </div>

    {{-- <p style="color: #B1B1B1;padding-top:20px; text-align: center;margin: auto">© 2018 OlarteMoure & Asociados ALL RIGHTS RESERVED </p> --}}
    
    @if ($errors->has('password'))
        <span class="help-block">
            <strong>{{ $errors->first('password') }}</strong>
        </span>
    @endif
@endsection
