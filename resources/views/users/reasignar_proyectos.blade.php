@extends('layouts.app')

@section('content')
    
    <usuarios-reasignar-proyectos
        :proyectos="{{$proyectos}}"
        :usuarios="{{$usuarios}}"
        :usuario="{{$usuario}}">
    </usuarios-reasignar-proyectos>

@endsection