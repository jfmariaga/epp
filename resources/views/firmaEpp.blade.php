@extends('layouts.tailwind')

@section('title', 'Firma de EPP')
@section('content_header', 'Firma de EPP')

@section('content')
    <div class="mx-auto max-w-xl">
        @foreach ($emple as $item)
            <div class="card-panel p-6">
                <h2 class="text-lg font-semibold text-slate-800">{{ $item->nombre }}</h2>
                <p class="mb-4 text-sm text-slate-500">Cédula: {{ $item->cc }}</p>

                @if (session('success'))
                    <div class="mb-4 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-emerald-800">
                        {{ session('success') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('firma.update', $item->id) }}">
                    @method('PUT')
                    @csrf
                    <canvas id="sig-canvas"
                        class="w-full rounded-lg border border-slate-300"
                        style="height:200px; touch-action:none;"></canvas>
                    <textarea id="signature" name="signed" style="display: none"></textarea>

                    <p class="mt-4 text-sm text-slate-600">
                        Me comprometo a utilizar los elementos de protección personal, que me han sido
                        suministrados para el desempeño de mis funciones y actividades dentro del área de
                        trabajo. He sido instruido sobre la manera correcta de su uso y mantenimiento;
                        igualmente me comprometo a mantenerlos en buen estado y reportar cualquier anomalía al
                        proceso de seguridad y salud en el trabajo o mi jefe inmediato, para su reposición o
                        evaluación de efectividad frente al riesgo.
                    </p>

                    <div class="mt-4 flex flex-wrap gap-3">
                        <button class="btn-primary">Guardar</button>
                        <button type="button" id="clear" class="btn-secondary">Borrar</button>
                        <a href="{{ route('empleado') }}" class="btn-danger">Cancelar</a>
                    </div>
                </form>
            </div>
        @endforeach
    </div>
@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.1.7/dist/signature_pad.umd.min.js"></script>
    <script type="text/javascript">
        const sigCanvas = document.getElementById('sig-canvas');
        const signaturePad = new SignaturePad(sigCanvas);

        function resizeSigCanvas() {
            const ratio = Math.max(window.devicePixelRatio || 1, 1);
            sigCanvas.width = sigCanvas.offsetWidth * ratio;
            sigCanvas.height = sigCanvas.offsetHeight * ratio;
            sigCanvas.getContext('2d').scale(ratio, ratio);
            signaturePad.clear();
        }
        window.addEventListener('resize', resizeSigCanvas);
        resizeSigCanvas();

        document.getElementById('clear').addEventListener('click', function(e) {
            e.preventDefault();
            signaturePad.clear();
        });

        document.querySelector('#sig-canvas').closest('form').addEventListener('submit', function(e) {
            if (signaturePad.isEmpty()) {
                e.preventDefault();
                alert('Por favor firme antes de guardar.');
                return;
            }
            document.getElementById('signature').value = signaturePad.toDataURL('image/png');
        });
    </script>
@stop
