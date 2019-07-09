@extends('layouts.app')

@section('content')
        <div>


        <div class="card-create-container" style= "height: 200px">

            <form action={{"/users/validateCode/" . $current_token }} method="POST">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">  
                <h4 class="step-title">Ingresa el codigo de registro*</h4>
                <input type="string"
                       class="input-style"
                       name="codigo"
                       placeholder="ingresa el de registro envidado al correo"
                       required>

                    @if ($errors->any() and $errors->codigo)
 
                        <span  class="help-block">
                            <strong  style="color:red;"class="col-md-12" >{{$errors->getBags()['default']->getMessages()['codigo'][0]}}</strong>
                        </span>
                    @endif


                    <div style="float: right; margin-top:30px">
                        <button type="submit" class="btn btn-guardar">Continuar</button>
                    </div>
    

            </form>

        </div>
    </div>


@endsection
