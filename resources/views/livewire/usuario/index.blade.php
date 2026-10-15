<div>
    <div class="mb-4">
        <input autocomplete="none" type="text" wire:model.live="search" class="input-touch max-w-md"
            placeholder="Buscar...">
    </div>

    @if ($usuarios->count())
        <div class="overflow-x-auto rounded-lg border border-slate-200">
            <table class="table-touch w-full">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Correo</th>
                        <th>Rol</th>
                        <th>Editar</th>
                        <th>Eliminar</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($usuarios as $usuario)
                        <tr>
                            <td>{{ $usuario->name }}</td>
                            <td>{{ $usuario->email }}</td>
                            <td>
                                @if ($usuario->isAdmin())
                                    <span class="badge-neutral bg-brand-100 text-brand-700">Administrador</span>
                                @else
                                    <span class="badge-neutral">Operador</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <a href="#" class="btn-secondary" wire:click="editar({{ $usuario->id }})"
                                    data-toggle="modal" data-target="#editUsuarioSistema"><i
                                        class="far fa-edit"></i></a>
                            </td>
                            <td class="text-center">
                                <a href="#" class="btn-danger"
                                    @click.prevent="Swal.fire({
                                        title: '¿Eliminar a {{ $usuario->name }}?',
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
            {{ $usuarios->links() }}
        </div>
    @else
        <div class="rounded-lg border border-dashed border-slate-300 p-6 text-center text-slate-500">
            No existen registros para mostrar
        </div>
    @endif

    @push('modals')
        @include('modals.nuevo-usuario-sistema')
        @include('modals.editar-usuario-sistema')
    @endpush
</div>
