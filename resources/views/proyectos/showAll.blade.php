@extends('layouts.app')

@section('content')
    <proyectos-show-all
        :user="{{$user}}"
        :init_data="{{$init_data}}"
        :filt="{{json_encode($filters)}}"
    ></proyectos-show-all>

@endsection