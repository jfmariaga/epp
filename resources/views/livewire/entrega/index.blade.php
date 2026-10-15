<div>
    <div class="mb-2 col-lg-4" style="margin-left: -8px">
        <input autocomplete="none" type="password" wire:model="search" class="form-control" placeholder="Clave del empleado">
    </div>
    @if ($search != null)
        <div class="row">
            <div class="col-lg-12">
                <div class="float-left">
                    @if ($firma == '')
                        <div>
                            <p><b>Por favor agregar una firma para {{ $nombre }}</b></p>
                        </div>
                        <a class="btn btn-md btn-outline-danger" href="{{ route('signpad.index', $item2) }}">Agregar
                            firma</a>
                    @else
                        <a href="#" class="btn btn-md btn-outline-success"
                            wire:click="selecItem({{ $idemple }},'nuevo')" data-toggle="modal"
                            data-target="#nuevaEntrega">Nueva entrega</a>
                    @endif
                </div>
            </div>
        </div>
        @if ($entrega->count())
            <div class="row mt-2">
                <div class="col-lg-12 ">
                    <div class="float-left">
                        @if ($firma != null)
                            <a class="btn btn-md btn-outline-warning"
                                href="{{ route('signpad.so-32', $idemple) }}">FO-SO-32</a>
                        @endif
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="text-center">
                        <h1>ULTIMAS ENTREGAS PARA {{ $nombre }}</h1>
                    </div>
                </div>
            </div>
            <table class="table table-responsive table-striped table-hover table-bordered dataex-html5-export">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Cedula</th>
                        <th>Centro de costos</th>
                        <th>Area</th>
                        <th>EPP entregado</th>
                        <th>Motivo</th>
                        <th>Labor</th>
                        <th>Linea</th>
                        <th>Responsable</th>
                        <th>Observación</th>
                        <th>Fecha de entrega</th>
                        <th colspan="2">Firmar entrega</th>
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
                            @if ($item->linea != null)
                                <td>{{ $item->linea }}</td>
                            @else
                                <td>No registra</td>
                            @endif
                            <td>{{ $item->responsable }}</td>
                            <td>
                                @if ($item->observacion != null)
                                    {{ $item->observacion }}
                                @endif
                            </td>
                            <td>{{ $item->fechaEntrega }}</td>
                            @if ($item->firma == null)
                            <td class="text-center">
                                <a class="btn btn-sm btn-primary" target="_blank" href="{{ route('firma.index', $item->empleado_id) }}"><i
                                        class="far fa-edit"></i></a>
                            </td>
                            @else
                                <td><b>Epp Firmado</b></td>
                            @endif
                            
                            {{-- @if ($item->epp->acta == 1)
                                <td class="text-center">
                                    <a class="btn btn-sm btn-primary" href="{{ route('signpad.Addtopdf', $item) }}"><i
                                            class="far fa-edit"></i></a>
                                </td>
                            @endif --}}
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="card-footer">
                {{ $entrega->links() }}
            </div>
        @else
            <div class="card-body">

                @if ($nombre == '')
                    <h3>No existen coincidencias para la clave ingresada</h3>
                @else
                    <h3>No existen entregas para {{ $nombre }}</h3>
                @endif
            </div>
        @endif
    @else
        <div class="card-body">
            <h3>Ingrese la clave del empleado</h3>
        </div>
    @endif
    @push('modals')
        @include('modals.nueva-entrega')
        {{-- @include('modals.editar-usuario') --}}
    @endpush
</div>
