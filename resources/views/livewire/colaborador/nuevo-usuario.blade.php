<div>
    <div class="modal-body">
        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
            <div>
                <label class="mb-1 block text-sm font-medium text-slate-700">Nombre</label>
                <input type="text" class="input-touch @error('nombre') border-red-500 @enderror" placeholder="Nombre"
                    wire:model="nombre">
                @error('nombre')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label class="mb-1 block text-sm font-medium text-slate-700">Cargo</label>
                <select wire:model="cargo" class="select-touch @error('cargo') border-red-500 @enderror">
                    <option value="" selected>Seleccionar...</option>
                    @foreach ($cargos as $item)
                        <option value="{{ $item }}">{{ $item }}</option>
                    @endforeach
                </select>
                @error('cargo')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label class="mb-1 block text-sm font-medium text-slate-700">Área</label>
                <select wire:model="area" class="select-touch @error('area') border-red-500 @enderror">
                    <option value="" selected>Seleccionar...</option>
                    @foreach ($areas as $item)
                        <option value="{{ $item }}">{{ $item }}</option>
                    @endforeach
                </select>
                @error('area')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label class="mb-1 block text-sm font-medium text-slate-700">Centro de costos</label>
                <select wire:model="centro" class="select-touch @error('centro') border-red-500 @enderror">
                    <option value="" selected>Seleccionar...</option>
                    @foreach ($centros as $item)
                        <option value="{{ $item }}">{{ $item }}</option>
                    @endforeach
                </select>
                @error('centro')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label class="mb-1 block text-sm font-medium text-slate-700">Cédula</label>
                <input type="number" class="input-touch @error('cc') border-red-500 @enderror" placeholder="Cédula"
                    wire:model="cc">
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
                @error('estado')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>
    </div>
    <div class="modal-footer gap-2">
        <button type="button" class="btn-primary" wire:click="guardar()">Guardar</button>
        <button type="button" class="btn-secondary" data-dismiss="modal" wire:click="resetear()">Cancelar</button>
    </div>
</div>
