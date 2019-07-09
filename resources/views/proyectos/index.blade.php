@extends('layouts.app')

@section('content')

    <proyectos-index
        :init_data="{{$init_data}}"
        :user="{{$user}}"
        :users="{{$users}}"
        :role="{{$role}}"
        :filt="{{json_encode($filters)}}"
    ></proyectos-index>
@endsection