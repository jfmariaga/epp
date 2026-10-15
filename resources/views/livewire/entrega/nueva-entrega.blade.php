<div>
    <div class="modal-header">
        <h5 class="modal-title">Nueva entrega</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" wire:click="resetear()">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        @if ($idEmple != null)
            @if ($estado === 0)
                <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                    <div>
                        <label class="mb-1 block text-sm font-medium text-slate-700">Cédula</label>
                        <input type="number" class="input-touch @error('cc') border-red-500 @enderror"
                            wire:model="cc" disabled>
                    </div>
                    <div>
                        <label class="mb-1 block text-sm font-medium text-slate-700">Nombre</label>
                        <input type="text" class="input-touch @error('nombreEmpleado') border-red-500 @enderror"
                            wire:model="nombreEmpleado" disabled>
                    </div>
                    <div>
                        <label class="mb-1 block text-sm font-medium text-slate-700">Labor</label>
                        <input type="text" class="input-touch @error('cargo') border-red-500 @enderror"
                            wire:model="cargo" disabled>
                    </div>
                    <div>
                        <label class="mb-1 block text-sm font-medium text-slate-700">Motivo</label>
                        <select wire:model="motivo" class="select-touch @error('motivo') border-red-500 @enderror">
                            <option value="" selected>Seleccionar...</option>
                            <option value="NUEVO">NUEVO</option>
                            <option value="PERDIDA">PERDIDA</option>
                            <option value="REPOSICION">DAÑO</option>
                            <option value="APROVECHAMIENTO">APROVECHAMIENTO</option>
                        </select>
                        @error('motivo')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="mb-1 block text-sm font-medium text-slate-700">Seleccionar EPP</label>
                        <select wire:model="epp_id" class="select-touch @error('epp_id') border-red-500 @enderror">
                            <option value="" selected>Seleccionar...</option>
                            @foreach ($epp as $item)
                                <option value="{{ $item->id }}">{{ $item->descripcion }}</option>
                            @endforeach
                        </select>
                        @error('epp_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="mb-1 block text-sm font-medium text-slate-700">Línea</label>
                        <select wire:model="linea" class="select-touch @error('linea') border-red-500 @enderror">
                            <option value="" selected>Seleccionar...</option>
                            <option value="LINEA FLEXIBLES">LINEA FLEXIBLES</option>
                            <option value="LINEA SACHETS">LINEA SACHETS</option>
                            <option value="LINEA NECTAR">LINEA NECTAR</option>
                            <option value="LINEA CONSERVAS FRASCOS">LINEA CONSERVAS FRASCOS</option>
                            <option value="LINEA ENLATADOS">LINEA ENLATADOS</option>
                            <option value="LINEA LIQUIDOS FRASCOS">LINEA LIQUIDOS FRASCOS</option>
                            <option value="LINEA LIQUIDOS GALONES">LINEA LIQUIDOS GALONES</option>
                            <option value="LINEA BOCADILLO-CERNIDO">LINEA BOCADILLO-CERNIDO</option>
                            <option value="GRANELES">GRANELES</option>
                            <option value="LINEA GALONES PASTOSOS">LINEA GALONES PASTOSOS</option>
                            <option value="EMPAQUES MANUALES">EMPAQUES MANUALES</option>
                            <option value="ENSAMBLES">ENSAMBLES</option>
                            <option value="ADMINISTRATIVA">ADMINISTRATIVA</option>
                            <option value="MANTENIMIENTO">MANTENIMIENTO</option>
                            <option value="AMBIENTAL">AMBIENTAL</option>
                            <option value="CEDI">CEDI</option>
                            <option value="CTRL PRODUCCION">CTRL PRODUCCION</option>
                            <option value="BPM">BPM</option>
                            <option value="SERVICIOS GENERALES">SERVICIOS GENERALES</option>
                            <option value="CALIDAD">CALIDAD</option>
                            <option value="MEJORA CONTINUA">MEJORA CONTINUA</option>
                            <option value="PROYECTOS">PROYECTOS</option>
                            <option value="GENTE Y CULTURA">GENTE Y CULTURA</option>
                            <option value="TECNOLOGIA">TECNOLOGIA</option>
                            <option value="MATERIAS PRIMAS">MATERIAS PRIMAS</option>
                        </select>
                        @error('linea')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="md:col-span-2">
                        <label class="mb-1 block text-sm font-medium text-slate-700">Observación</label>
                        <textarea cols="30" rows="4" wire:model="observacion"
                            class="input-touch !h-auto @error('observacion') border-red-500 @enderror"></textarea>
                        @error('observacion')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            @else
                <p class="text-amber-700">Este usuario está <strong>INACTIVO</strong></p>
            @endif
        @else
            <div class="flex justify-center py-6">
                <div class="spinner-border text-brand-600" role="status"></div>
            </div>
        @endif
    </div>
    <div class="modal-footer gap-2">
        <button type="button" class="btn-primary" wire:click="guardar()">Guardar</button>
        <button type="button" class="btn-secondary" data-dismiss="modal" wire:click="resetear()">Cancelar</button>
    </div>
</div>
