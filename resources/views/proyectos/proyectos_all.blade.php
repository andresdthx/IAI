@extends('layouts.app')

@section('content')

    <proyectos-index-all
        :init_data="{{$init_data}}"
        :user="{{$user}}"
        :users="{{$users}}"
        :role="{{$role}}"
        :filt="{{json_encode($filters)}}"
    >
    </proyectos-index-all>
@endsection