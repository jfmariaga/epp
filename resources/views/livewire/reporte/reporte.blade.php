<div>
    <div class="mb-3 flex items-center gap-3">
        <input type="text" wire:model.live.debounce.400ms="search" placeholder="Buscar por nombre o cédula..."
            class="form-control" style="max-width: 320px">
        <a class="btn btn-outline-success" href="{{ route('reportes.export', ['search' => $search]) }}">
            Exportar a Excel
        </a>
    </div>

    <div class="table-responsive">
        <table class="table table-striped nowrap" style="width:100%">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Cedula</th>
                    <th>T. Contrato</th>
                    <th>Centro de costos</th>
                    <th>Area</th>
                    <th>Item EPP</th>
                    <th>EPP entregado</th>
                    <th>Motivo</th>
                    <th>Labor</th>
                    <th>Linea</th>
                    <th>Responsable</th>
                    <th>Fecha de entrega</th>
                    <th>FO-SO</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($reportes as $item)
                    <tr>
                        <td>{{ $item->empleado->nombre }}</td>
                        <td>{{ $item->empleado->cc }}</td>
                        <td>{{ $item->empleado->tp_contrato }}</td>
                        <td>{{ $item->empleado->centro }}</td>
                        <td>{{ $item->empleado->area }}</td>
                        <td>{{ $item->epp->item }}</td>
                        <td>{{ $item->epp->descripcion }}</td>
                        <td>{{ $item->motivo }}</td>
                        <td>{{ $item->empleado->cargo }}</td>
                        <td>{{ $item->linea }}</td>
                        <td>{{ $item->responsable }}</td>
                        <td>{{ $item->fechaEntrega }}</td>
                        <td> <a class="btn btn-md btn-outline-warning"
                            href="{{ route('signpad.so-32', $item->empleado->id) }}">FO-SO-32</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-3">
        {{ $reportes->links() }}
    </div>
</div>
