@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Entrega de EPP</h1>
@stop

@section('content')
    @if (session('info'))
        <div class="alert alert-success">
            <strong>{{ session('info') }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-lg-12">
                    @livewire('entrega.index')
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    {{-- <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" /> --}}

    {{-- @livewireStyles --}}

@stop

@stack('modals')
@section('js')
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    {{-- <script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script> --}}
    {{-- @livewireScripts --}}
    <script>
        Livewire.on('usuario_ok', i => {
            try {
                $('#nuevaEntrega').modal('hide');

                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Entrega realizada con exito',
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
