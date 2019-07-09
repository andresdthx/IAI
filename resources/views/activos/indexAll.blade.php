@extends('layouts.app')

@section('content')

        <activos-index-all
            :user="{{$user}}"
            :init_data="{{$activos_data}}"
            :filt="{{json_encode($filters)}}"
        ></activos-index-all>
@endsection