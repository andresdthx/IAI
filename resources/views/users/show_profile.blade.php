@extends('layouts.app')

@section('content')
    
    <usuarios-show-prfile :user="{{($user)}}"></usuarios-show-prfile>

@endsection