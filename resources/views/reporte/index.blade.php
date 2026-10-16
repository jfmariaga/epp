@extends('layouts.tailwind')

@section('title', 'Reportes')
@section('content_header', 'Reportes')

@section('content')
    <div class="card-panel p-4">
        @livewire('reporte.reporte')
    </div>
@stop
