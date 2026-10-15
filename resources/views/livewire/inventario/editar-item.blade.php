<div>
    <div class="modal-header">
        <h5 class="modal-title">Editar Item</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" wire:click="resetear()">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body space-y-4">
        @if ($modelId)
            <div>
                <label class="mb-1 block text-sm font-medium text-slate-700">Código Item</label>
                <input type="text" class="input-touch @error('codigo') border-red-500 @enderror"
                    placeholder="Código" wire:model="codigo">
                @error('codigo')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label class="mb-1 block text-sm font-medium text-slate-700">Descripción</label>
                <input type="text" class="input-touch @error('descripcion') border-red-500 @enderror"
                    placeholder="Descripción" wire:model="descripcion">
                @error('descripcion')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label class="mb-1 block text-sm font-medium text-slate-700">Requiere acta de entrega</label>
                <select wire:model="acta" class="select-touch">
                    <option value="" selected>Seleccionar...</option>
                    <option value="1">SI</option>
                    <option value="2">NO</option>
                </select>
                @error('acta')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        @else
            <div class="flex justify-center py-6">
                <div class="spinner-border text-brand-600" role="status"></div>
            </div>
        @endif
    </div>
    <div class="modal-footer gap-2">
        <button type="button" class="btn-primary" wire:click="update()">Actualizar</button>
        <button type="button" class="btn-secondary" data-dismiss="modal" wire:click="resetear()">Cancelar</button>
    </div>
</div>
