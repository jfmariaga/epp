<div>
    <div class="mb-4 flex flex-col gap-3 md:flex-row md:items-end">
        <div class="max-w-xs">
            <label class="mb-1 block text-sm font-medium text-slate-700">Clave del empleado</label>
            <input autocomplete="none" type="password" wire:model.live="search" class="input-touch"
                placeholder="RFID o cédula">
        </div>
        <button type="button" class="btn-primary" id="btn-escanear-qr" data-toggle="modal"
            data-target="#modalEscanearQr">
            <i class="fas fa-camera"></i> Escanear carné QR
        </button>
    </div>

    <div class="modal fade" id="modalEscanearQr" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Escanear carné</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="qr-reader" style="width: 100%;"></div>
                    <p id="qr-reader-status" class="text-muted mt-2"></p>
                </div>
            </div>
        </div>
    </div>

    <script>
        (function() {
            const wireId = '{{ $this->getId() }}';
            let qrScanner = null;

            $('#modalEscanearQr').on('shown.bs.modal', function() {
                qrScanner = new Html5Qrcode('qr-reader');
                qrScanner.start(
                    { facingMode: 'environment' },
                    { fps: 10, qrbox: 250 },
                    (decodedText) => {
                        Livewire.find(wireId).call('buscarPorQr', decodedText);
                        $('#modalEscanearQr').modal('hide');
                    },
                    () => {}
                ).catch((err) => {
                    $('#qr-reader-status').text('No se pudo acceder a la cámara: ' + err);
                });
            });

            $('#modalEscanearQr').on('hidden.bs.modal', function() {
                if (qrScanner) {
                    qrScanner.stop().catch(() => {});
                    qrScanner = null;
                }
            });
        })();
    </script>

    @if ($search != null)
        <div class="mb-4">
            @if ($firma == '')
                <p class="mb-2 text-amber-700"><b>Por favor agregar una firma para {{ $nombre }}</b></p>
                <a class="btn-danger" href="{{ route('signpad.index', $item2) }}">
                    <i class="fas fa-signature"></i> Agregar firma
                </a>
            @else
                <a href="#" class="btn-success" wire:click="selecItem({{ $idemple }},'nuevo')" data-toggle="modal"
                    data-target="#nuevaEntrega">
                    <i class="fas fa-plus"></i> Nueva entrega
                </a>
            @endif
        </div>

        @if ($entrega->count())
            <div class="mb-4 flex items-center justify-between">
                @if ($firma != null)
                    <a class="btn-secondary" href="{{ route('signpad.so-32', $idemple) }}">
                        <i class="fas fa-file-pdf"></i> FO-SO-32
                    </a>
                @else
                    <span></span>
                @endif
                <h2 class="text-lg font-semibold text-slate-700">Últimas entregas para {{ $nombre }}</h2>
            </div>

            <div class="overflow-x-auto rounded-lg border border-slate-200">
                <table class="table-touch w-full">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Cédula</th>
                            <th>Centro de costos</th>
                            <th>Área</th>
                            <th>EPP entregado</th>
                            <th>Motivo</th>
                            <th>Labor</th>
                            <th>Línea</th>
                            <th>Responsable</th>
                            <th>Observación</th>
                            <th>Fecha de entrega</th>
                            <th>Firmar entrega</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($entrega as $item)
                            <tr>
                                <td>{{ $item->empleado->nombre }}</td>
                                <td>{{ $item->empleado->cc }}</td>
                                <td>{{ $item->empleado->centro }}</td>
                                <td>{{ $item->empleado->area }}</td>
                                <td>{{ $item->epp->item }}-{{ $item->epp->descripcion }}</td>
                                <td>{{ $item->motivo }}</td>
                                <td>{{ $item->empleado->cargo }}</td>
                                <td>{{ $item->linea ?? 'No registra' }}</td>
                                <td>{{ $item->responsable }}</td>
                                <td>{{ $item->observacion }}</td>
                                <td>{{ $item->fechaEntrega }}</td>
                                <td class="text-center">
                                    @if ($item->firma == null)
                                        <a class="btn-secondary" target="_blank"
                                            href="{{ route('firma.index', $item->empleado_id) }}">
                                            <i class="far fa-edit"></i>
                                        </a>
                                    @else
                                        <span class="badge-success">Firmado</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-4">
                {{ $entrega->links() }}
            </div>
        @else
            <div class="rounded-lg border border-dashed border-slate-300 p-6 text-center text-slate-500">
                @if ($nombre == '')
                    No existen coincidencias para la clave ingresada
                @else
                    No existen entregas para {{ $nombre }}
                @endif
            </div>
        @endif
    @else
        <div class="rounded-lg border border-dashed border-slate-300 p-6 text-center text-slate-500">
            Ingrese la clave del empleado o escanee su carné
        </div>
    @endif

    @push('modals')
        @include('modals.nueva-entrega')
    @endpush
</div>
