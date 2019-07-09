@extends('layouts.app')

@section('content')
    <subproyectos-show
        :subproyecto="{{$subproyecto}}"
        :user="{{$user}}">
    </subproyectos-show>

    <activos-index
        :subproyecto="{{$subproyecto}}"
        :filt='{{json_encode($filters)}}'
        :subproyecto_id="{{$subproyecto->id}}"
        :init_data="{{$activos_data}}">
    </activos-index>

@endsection