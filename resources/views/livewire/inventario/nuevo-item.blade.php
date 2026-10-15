<div>
    <div class="modal-body space-y-4">
        <div>
            <label class="mb-1 block text-sm font-medium text-slate-700">Código Item</label>
            <input type="text" class="input-touch @error('codigo') border-red-500 @enderror" placeholder="Código"
                wire:model="codigo">
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
    </div>
    <div class="modal-footer gap-2">
        <button type="button" class="btn-primary" wire:click="guardar()">Guardar</button>
        <button type="button" class="btn-secondary" data-dismiss="modal" wire:click="resetear()">Cancelar</button>
    </div>
</div>
