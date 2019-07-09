@extends('layouts.app')

@section('content')
    
    <usuarios-edit-prfile :user="{{($user)}}"></usuarios-edit-prfile>

@endsection