@extends('layouts.tailwind')

@section('title', 'Dashboard')
@section('content_header', 'Dashboard')

@section('content')
    <div class="card-panel p-8 text-center">
        <img src="{{ asset('img/epp.png') }}" alt="Entrega EPP" class="mx-auto mb-6 h-24">
        <p class="text-lg text-slate-700">
            Bienvenid@ <strong>{{ auth()->user()->name }}</strong> a la plataforma de entregas de EPP de Panal
            S.A.S. Esta aplicación es de uso exclusivo para colaboradores de Panal
        </p>
    </div>
@stop
