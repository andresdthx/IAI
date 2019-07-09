@extends('layouts.app')

@section('content')

    <!-- <usuarios-create 
        :roles="{{$roles}}"
        errors = "{{ json_encode( $errors->any() ? $errors->getBags()['default']->getMessages() : array() ) }}">
    </usuarios-create> -->

    <usuarios-invitation
        :roles="{{$roles}}"
        errors = "{{ json_encode( $errors->any() ? $errors->getBags()['default']->getMessages() : array() ) }}">
    </usuarios-invitation>
    

@endsection