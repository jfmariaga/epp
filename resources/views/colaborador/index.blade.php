@extends('layouts.tailwind')

@section('title', 'Colaboradores')
@section('content_header', 'Colaboradores')

@section('content')
    <div class="card-panel p-4">
        <div class="mb-4 flex justify-end">
            <a href="#" class="btn-success" data-toggle="modal" data-target="#nuevoUsuario">
                <i class="fas fa-plus"></i> Nuevo colaborador
            </a>
        </div>

        @livewire('colaborador.index')
    </div>
@stop

@stack('modals')
@section('js')
    <script>
        Livewire.on('usuario_ok', i => {
            try {
                $('#nuevoUsuario').modal('hide');

                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Nuevo usuario',
                    showConfirmButton: false,
                    timer: 1500
                })
            } catch (error) {
                console.log('Error alert', error);
            }
        })
    </script>
    <script>
        Livewire.on('editar_user', i => {
            try {
                $('#editUsuario').modal('hide');
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
        Livewire.on('delete_success', () => {
            Swal.fire({
                position: 'top-end',
                icon: 'success',
                title: 'Colaborador eliminado',
                showConfirmButton: false,
                timer: 1500
            })
        })
        Livewire.on('delete_error', (e) => {
            Swal.fire({
                icon: 'error',
                title: 'No se puede eliminar',
                text: e.mensaje,
            })
        })
    </script>
@stop
