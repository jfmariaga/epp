@extends('adminlte::page')

@section('css')
    <link rel="stylesheet" href="{{ asset('mask_jf/datatables/css/jquery.dataTables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('mask_jf/datatables/css/buttons.dataTables.min.css') }}">
    @livewireStyles
@endsection

@section('title', 'Dashboard')


@section('content_header')
    <h1>Reportes</h1>
@stop
@section('content')
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-lg-12">
                    @livewire('reporte.reporte')
                </div>
            </div>
        </div>
    </div>
@stop

@section('js')
    <script src="{{ asset('mask_jf/datatables/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('mask_jf/datatables/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('mask_jf/datatables/js/jszip.min.js') }}"></script>
    <script src="{{ asset('mask_jf/datatables/js/pdfmake.min.js') }}"></script>
    <script src="{{ asset('mask_jf/datatables/js/vfs_fonts.js') }}"></script>
    <script src="{{ asset('mask_jf/datatables/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('mask_jf/datatables/js/buttons.print.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            var printCounter = 0;

            $('#example').DataTable({
                dom: 'Bfrtip',
                buttons: [{
                    extend: 'excel',

                }],
                language: {
                    url: "https://cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json",
                },
                dom: 'B<"float-left"i><"float-right"f>t<"float-left"l><"float-right"p><"clearfix">',

            });
        });
    </script>
    @livewireScripts
@endsection
