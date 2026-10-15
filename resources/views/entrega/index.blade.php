@extends('layouts.tailwind')

@section('title', 'Entrega de EPP')
@section('content_header', 'Entrega de EPP')

@section('content')
    <div class="card-panel p-4">
        @livewire('entrega.index')
    </div>
@stop

@stack('modals')
@section('js')
    <script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>
    <script>
        Livewire.on('qr_invalido', () => {
            Swal.fire({
                icon: 'error',
                title: 'QR no reconocido',
                text: 'El carné escaneado no coincide con el formato esperado. Intenta de nuevo o busca manualmente por cédula.',
            })
        })
        Livewire.on('qr_sin_match', (e) => {
            Swal.fire({
                icon: 'warning',
                title: 'Colaborador no encontrado',
                text: 'No existe un colaborador activo con cédula ' + e.cedula + '. Verifica el dato o búscalo manualmente.',
            })
        })
    </script>
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
