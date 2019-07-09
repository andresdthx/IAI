@extends('layouts.app')

@section('content')
    <proyectos-show
        :proyecto="{{$proyecto}}"
        :users="{{$users}}"
        :integrantes="{{$integrantes}}"
        :init_data="{{$init_data}}"
        :filt="{{json_encode($filters)}}">
    </proyectos-show>

@endsection