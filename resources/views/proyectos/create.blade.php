@extends('layouts.app')

@section('content')
        <proyectos-create 
            :users="{{$users}}"
            :auth-user="{{\Auth::user()->id}}"
        >
        </proyectos-create>

@endsection