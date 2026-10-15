@extends('layouts.tailwind')

@section('title', 'Usuarios del sistema')
@section('content_header', 'Usuarios del sistema')

@section('content')
    <div class="card-panel p-4">
        <div class="mb-4 flex justify-end">
            <a href="#" class="btn-success" data-toggle="modal" data-target="#nuevoUsuarioSistema">
                <i class="fas fa-plus"></i> Nuevo usuario
            </a>
        </div>

        @livewire('usuario.index')
    </div>
@stop

@stack('modals')
@section('js')
    <script>
        Livewire.on('usuario_ok', i => {
            try {
                $('#nuevoUsuarioSistema').modal('hide');
                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Usuario creado',
                    showConfirmButton: false,
                    timer: 1500
                })
            } catch (error) {
                console.log('Error alert', error);
            }
        })
        Livewire.on('usuario_editado', i => {
            try {
                $('#editUsuarioSistema').modal('hide');
                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Usuario editado',
                    showConfirmButton: false,
                    timer: 1500
                })
            } catch (error) {
                console.log('Error alert', error);
            }
        })
        Livewire.on('usuario_eliminado', i => {
            Swal.fire({
                position: 'top-end',
                icon: 'success',
                title: 'Usuario eliminado',
                showConfirmButton: false,
                timer: 1500
            })
        })
        Livewire.on('usuario_error', (e) => {
            Swal.fire({
                icon: 'error',
                title: 'No se puede eliminar',
                text: e.mensaje,
            })
        })
    </script>
@stop
