@extends('layouts.app')

@section('content')
    <proyectos-edit
        :proyecto="{{$proyecto}}"
        :users="{{$users}}">
    </proyectos-edit>

@endsection