@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body text-center" style="font-size: 25px">
            Bienvenid@ <strong>{{ auth()->user()->name }}</strong> a la plataforma de entregas de EPP de Panal S.A.S. Esta
            aplicación es de uso exclusivo para colaboradores de Panal
        </div>
        <div class="card-title text-center">
            <div class="p-1">
                <img src="{{ asset('img/epp.png') }}" alt="branding logo">
            </div>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script>
        console.log('Hi!');
    </script>
@stop
