@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Firma colaborador</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 offset-md-3 mt-5">
                        <div class="card">
                            @foreach ($emple as $item)
                                <div class="card-header">
                                    <h5><b>Usuario:</b>{{ $item->nombre }}</h5>
                                    <h5><b>Cedula:</b>{{ $item->cc }}</h5>
                                </div>
                                <div class="card-body">
                                    @if (session('success'))
                                        <div class="alert alert-success">
                                            <span>{{ session('success') }}</span>
                                        </div>
                                    @endif

                                    <form method="POST" action="{{ route('signpad.update', $item->id) }}">
                                        @method('PUT')
                                        @csrf
                                        <div class="col-md-12">
                                            <br />
                                            <div id="sig"></div>
                                            <br /><br />
                                            <textarea id="signature" name="signed" style="display: none"></textarea>
                                        </div>
                                        <div>
                                            <p>Me comprometo a utilizar los elementos de protección personal, que me han
                                                sido suministrados para el desempeño de mis funciones
                                                y actividades dentro del área de trabajo.
                                                He sido instruido sobre la manera correcta de su uso y mantenimiento;
                                                igualmente me comprometo a mantenerlos en buen estado y
                                                reportar cualquier anomalía al proceso de seguridad y salud en el trabajo o
                                                mi jefe inmediato, para su reposición o evaluación de
                                                efectividad frente al riesgo.
                                            </p>
                                        </div>
                                        <button class="btn btn-primary btn-sm ml-3">Guardar</button>
                                        <button id="clear" class="btn btn-warning btn-sm">Borrar</button>
                                        <a href="{{ route('empleado') }}" class="btn btn-danger btn-sm">Cancelar</a>

                                    </form>
                                </div>
                            @endforeach

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    @livewireStyles
    <link rel="stylesheet" href="{{ asset('firma/css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('firma/css/jquery.signature.css') }}">
@stop

@section('js')
    @livewireScripts
    <script src="{{ asset('firma/js/alert.min.js') }}"></script>
    <script src="{{ asset('firma/js/jquery-ui.min.js') }}"></script>
    {{-- <script src="{{ asset('firma/js/jquery.min.js') }}"></script> --}}
    <script src="{{ asset('firma/js/jquery.signature.js') }}"></script>
    <script type="text/javascript">
        var sig = $('#sig').signature({
            syncField: '#signature',
            syncFormat: 'PNG'
        });
        $('#clear').click(function(e) {
            e.preventDefault();
            sig.signature('clear');
            $("#signature64").val('');
        });
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
