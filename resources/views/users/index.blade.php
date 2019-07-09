@extends('layouts.app')

@section('content')
    <usuarios-index 
        :users="{{$users}}"
        :roles="{{$roles}}"
        :user_role="{{json_encode($user_role)}}"
        :config="{{json_encode($config)}}"
        :values="{{json_encode($values)}}"
        :all_users="{{json_encode($all_users)}}"
        >
    </usuarios-index>
@endsection