<div>
    <div class="mb-2 col-lg-4" style="margin-left: -8px">
        <input autocomplete="none" type="text" wire:model="search" class="form-control" placeholder="Buscar...">
    </div>

    @if ($colaborador->count())
        <table class="table table-striped table-hover table-bordered dataex-html5-export">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Cedula</th>
                    <th>Centro de costos</th>
                    <th>Area</th>
                    <th>Cargo</th>
                    <th>Estado</th>
                    <th>Contrato</th>
                    <th>Editar</th>
                    <th>Firma</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($colaborador as $usuario)
                    <tr>
                        <td>{{ $usuario->nombre }}</td>
                        <td>{{ $usuario->cc }}</td>
                        <td>{{ $usuario->centro }}</td>
                        <td>{{ $usuario->area }}</td>
                        <td>{{ $usuario->cargo }}</td>
                        <td>
                            @if ($usuario->estado === 0)
                                <span class="badge badge-success">Activo</span>
                            @else
                                <span class="badge badge-danger">Inactivo</span>
                            @endif
                        </td>
                        <td>
                            @if ($usuario->tp_contrato != null)
                                <span>{{$usuario->tp_contrato }}</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <a href="#" class="btn btn-sm btn-warning"
                                wire:click="selecItem({{ $usuario->id }},'update')" data-toggle="modal"
                                data-target="#editUsuario"><i class="far fa-edit"></i></a>
                        </td>
                        <td class="text-center">
                            <a class="btn btn-sm btn-primary" href="{{ route('signpad.index', $usuario) }}"><i
                                    class="far fa-edit"></i></a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="card-footer">
            {{ $colaborador->links() }}
        </div>
    @else
        <div class="card-body">
            <strong>No existen registros para mostrar</strong>
        </div>
    @endif

    @push('modals')
        @include('modals.nuevo-usuario')
        @include('modals.editar-usuario')
    @endpush
</div>
