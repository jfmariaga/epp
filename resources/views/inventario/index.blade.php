@extends('layouts.tailwind')

@section('title', 'Items de inventario')
@section('content_header', 'Items de inventario')

@section('content')
    <div class="card-panel p-4">
        <div class="mb-4 flex justify-end">
            <a href="#" class="btn-success" data-toggle="modal" data-target="#nuevoItem">
                <i class="fas fa-plus"></i> Nuevo item
            </a>
        </div>

        @livewire('inventario.index')
    </div>
@stop

@stack('modals')
@section('js')
    <script>
        Livewire.on('usuario_ok', i => {
            try {
                $('#nuevoItem').modal('hide');

                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Nuevo Item',
                    showConfirmButton: false,
                    timer: 1500
                })
            } catch (error) {
                console.log('Error alert', error);
            }
        })
    </script>
    <script>
        Livewire.on('editar', i => {
            try {
                $('#editItem').modal('hide');

                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Item editado',
                    showConfirmButton: false,
                    timer: 1500
                })
            } catch (error) {
                console.log('Error alert', error);
            }
        })
    </script>
@stop
