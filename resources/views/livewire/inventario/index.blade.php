<div>
    <div class="mb-4">
        <input autocomplete="none" type="text" wire:model.live="search" class="input-touch max-w-md"
            placeholder="Buscar...">
    </div>

    @if ($items->count())
        <div class="overflow-x-auto rounded-lg border border-slate-200">
            <table class="table-touch w-full">
                <thead>
                    <tr>
                        <th>Item</th>
                        <th>Descripción</th>
                        <th>Requiere acta de entrega</th>
                        <th>Editar</th>
                        <th>Eliminar</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($items as $epp)
                        <tr>
                            <td>{{ $epp->item }}</td>
                            <td>{{ $epp->descripcion }}</td>
                            <td>
                                @if ($epp->acta == 1)
                                    <span class="badge-success">SI</span>
                                @else
                                    <span class="badge-neutral">NO</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <a href="#" class="btn-secondary" wire:click="selecItem({{ $epp->id }},'update')"
                                    data-toggle="modal" data-target="#editItem"><i class="far fa-edit"></i></a>
                            </td>
                            <td class="text-center">
                                <a href="#" class="btn-danger"
                                    @click.prevent="Swal.fire({
                                        title: '¿Eliminar {{ $epp->item }}?',
                                        text: 'Esta acción no se puede deshacer.',
                                        icon: 'warning',
                                        showCancelButton: true,
                                        confirmButtonText: 'Sí, eliminar',
                                        cancelButtonText: 'Cancelar',
                                        confirmButtonColor: '#dc2626',
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            $wire.eliminar({{ $epp->id }})
                                        }
                                    })"><i class="far fa-trash-alt"></i></a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-4">
            {{ $items->links() }}
        </div>
    @else
        <div class="rounded-lg border border-dashed border-slate-300 p-6 text-center text-slate-500">
            No existen registros para mostrar
        </div>
    @endif

    @push('modals')
        @include('modals.nuevo-epp')
        @include('modals.editar-epp')
    @endpush
</div>
