@extends('layouts.app')

@section('content')
        <busqueda
            :activos="{{$activos}}"
            :sub_proyectos="{{$sub_proyectos}}"
            :proyectos="{{$proyectos}}"
            busqueda="{{$search}}"
        ></busqueda>
@endsection