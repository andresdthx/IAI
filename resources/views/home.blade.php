@extends('layouts.app')

@section('content')

@if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
@endif

<home-component 
    :activos_count="{{$activos}}"
    :users_count="{{$users}}"
    :proyectos_count="{{$proyectos}}"
    :char_data="{{$char_data}}"
    :user="{{$user}}"
    :last_activos="{{$last_activos}}"
    :role="{{\Auth::user()->roles[0]}}"></home-component>



@endsection
