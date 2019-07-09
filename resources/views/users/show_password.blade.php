@extends('layouts.app')

@section('content')

     <password-edit
        :user="{{$user}}">
    </password-edit> 
@endsection
