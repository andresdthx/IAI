@extends('layouts.app')

@section('content')

     <usuarios-create
        token="{{$current_token}}"
        errors = "{{ json_encode( $errors->any() ? $errors->getBags()['default']->getMessages() : array() ) }}">
    </usuarios-create> 
@endsection
