<div>
    <div class="modal-body">
        @if ($modelId)
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                <div>
                    <label class="mb-1 block text-sm font-medium text-slate-700">Nombre</label>
                    <input type="text" class="input-touch @error('nombre') border-red-500 @enderror"
                        placeholder="Nombre" wire:model="nombre">
                    @error('nombre')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="mb-1 block text-sm font-medium text-slate-700">Cargo</label>
                    <input type="text" class="input-touch @error('cargo') border-red-500 @enderror"
                        placeholder="Cargo" wire:model="cargo">
                    @error('cargo')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="mb-1 block text-sm font-medium text-slate-700">Área</label>
                    <input type="text" class="input-touch @error('area') border-red-500 @enderror"
                        placeholder="Área" wire:model="area">
                    @error('area')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="mb-1 block text-sm font-medium text-slate-700">Centro de costos</label>
                    <input type="number" class="input-touch @error('centro') border-red-500 @enderror"
                        placeholder="Centro de costos" wire:model="centro">
                    @error('centro')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="mb-1 block text-sm font-medium text-slate-700">Cédula</label>
                    <input type="number" class="input-touch @error('cc') border-red-500 @enderror"
                        placeholder="Cédula" wire:model="cc">
                    @error('cc')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="mb-1 block text-sm font-medium text-slate-700">Número de tarjeta</label>
                    <input type="password" class="input-touch @error('password') border-red-500 @enderror"
                        placeholder="Número de tarjeta" wire:model="password">
                    @error('password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="mb-1 block text-sm font-medium text-slate-700">Tipo de contrato</label>
                    <select wire:model="contrato" class="select-touch @error('contrato') border-red-500 @enderror">
                        <option selected>Seleccionar...</option>
                        <option value="Vinculado">Vinculado</option>
                        <option value="Ahora">Ahora</option>
                        <option value="Manpower">ManpowerGroup</option>
                    </select>
                </div>
                <div>
                    <label class="mb-1 block text-sm font-medium text-slate-700">Estado</label>
                    <select wire:model="estado" class="select-touch @error('estado') border-red-500 @enderror">
                        <option selected>Seleccionar...</option>
                        <option value="0">Activo</option>
                        <option value="1">Inactivo</option>
                    </select>
                    @error('estado')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        @else
            <div class="flex justify-center py-6">
                <div class="spinner-border text-brand-600" role="status"></div>
            </div>
        @endif
    </div>
    <div class="modal-footer gap-2">
        <button type="button" class="btn-primary" wire:click="update()">Guardar</button>
        <button type="button" class="btn-secondary" data-dismiss="modal" wire:click="resetear()">Cancelar</button>
    </div>
</div>
