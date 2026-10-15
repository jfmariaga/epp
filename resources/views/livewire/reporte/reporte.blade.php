<div>
    <table id="example" class="display nowrap table-responsive" style="width:100%">
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
            @isset($reportes)
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
            @endisset
        </tbody>
    </table>
</div>
