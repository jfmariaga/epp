<div>
    <div class="mb-4">
        <input autocomplete="none" type="text" wire:model.live="search" class="input-touch max-w-md"
            placeholder="Buscar por nombre, cédula, área o centro...">
    </div>

    @if ($colaborador->count())
        <div class="overflow-x-auto rounded-lg border border-slate-200">
            <table class="table-touch w-full">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Cédula</th>
                        <th>Centro de costos</th>
                        <th>Área</th>
                        <th>Cargo</th>
                        <th>Estado</th>
                        <th>Contrato</th>
                        <th>Editar</th>
                        <th>Firma</th>
                        <th>Eliminar</th>
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
                                    <span class="badge-success">Activo</span>
                                @else
                                    <span class="badge-danger">Inactivo</span>
                                @endif
                            </td>
                            <td>
                                @if ($usuario->tp_contrato != null)
                                    <span>{{ $usuario->tp_contrato }}</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <a href="#" class="btn-secondary"
                                    wire:click="selecItem({{ $usuario->id }},'update')" data-toggle="modal"
                                    data-target="#editUsuario"><i class="far fa-edit"></i></a>
                            </td>
                            <td class="text-center">
                                <a class="btn-secondary" href="{{ route('signpad.index', $usuario) }}"><i
                                        class="far fa-edit"></i></a>
                            </td>
                            <td class="text-center">
                                <a href="#" class="btn-danger"
                                    @click.prevent="Swal.fire({
                                        title: '¿Eliminar a {{ $usuario->nombre }}?',
                                        text: 'Esta acción no se puede deshacer.',
                                        icon: 'warning',
                                        showCancelButton: true,
                                        confirmButtonText: 'Sí, eliminar',
                                        cancelButtonText: 'Cancelar',
                                        confirmButtonColor: '#dc2626',
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            $wire.eliminar({{ $usuario->id }})
                                        }
                                    })"><i class="far fa-trash-alt"></i></a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-4">
            {{ $colaborador->links() }}
        </div>
    @else
        <div class="rounded-lg border border-dashed border-slate-300 p-6 text-center text-slate-500">
            No existen registros para mostrar
        </div>
    @endif

    @push('modals')
        @include('modals.nuevo-usuario')
        @include('modals.editar-usuario')
    @endpush
</div>
