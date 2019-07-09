@extends('layouts.app')

@section('content')

    <reporte-index :grupos="{{json_encode($grupos)}}"></reporte-index>

@endsection