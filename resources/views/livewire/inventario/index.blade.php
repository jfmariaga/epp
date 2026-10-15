<div>
    <div class="mb-2 col-lg-4" style="margin-left: -8px">
        <input autocomplete="none" type="text" wire:model="search" class="form-control" placeholder="Buscar...">
    </div>

    @if ($items->count())
        <table class="table table-striped table-hover table-bordered dataex-html5-export">
            <thead>
                <tr>
                    <th>Item</th>
                    <th>Descripción</th>
                    <th>Requiere acta de entrega</th>
                    <th colspan="2">Acción</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($items as $epp)
                    <tr>
                        <td>{{ $epp->item }}</td>
                        <td>{{ $epp->descripcion }}</td>
                        @if ($epp->acta == 1)
                            <td>SI</td>
                        @else
                            <td>NO</td>
                        @endif
                        <td class="text-center">
                            <a href="#" class="btn btn-sm btn-warning"
                                wire:click="selecItem({{ $epp->id }},'update')" data-toggle="modal"
                                data-target="#editItem"><i class="far fa-edit"></i></a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="card-footer">
            {{ $items->links() }}
        </div>
    @else
        <div class="card-body">
            <strong>No existen registros para mostrar</strong>
        </div>
    @endif

    @push('modals')
        @include('modals.nuevo-epp')
        @include('modals.editar-epp')
    @endpush
</div>
