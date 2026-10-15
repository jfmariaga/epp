<div>
    <div class="modal-body space-y-4">
        <div>
            <label class="mb-1 block text-sm font-medium text-slate-700">Nombre</label>
            <input type="text" class="input-touch @error('name') border-red-500 @enderror" placeholder="Nombre"
                wire:model="name">
            @error('name')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
        <div>
            <label class="mb-1 block text-sm font-medium text-slate-700">Correo</label>
            <input type="email" class="input-touch @error('email') border-red-500 @enderror" placeholder="Correo"
                wire:model="email">
            @error('email')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
        <div>
            <label class="mb-1 block text-sm font-medium text-slate-700">Contraseña (dejar en blanco para no
                cambiarla)</label>
            <input type="password" class="input-touch @error('password') border-red-500 @enderror"
                placeholder="Nueva contraseña" wire:model="password">
            @error('password')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
        <div>
            <label class="mb-1 block text-sm font-medium text-slate-700">Rol</label>
            <select wire:model="role" class="select-touch @error('role') border-red-500 @enderror">
                <option value="operador">Operador</option>
                <option value="admin">Administrador</option>
            </select>
            @error('role')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
    </div>
    <div class="modal-footer gap-2">
        <button type="button" class="btn-primary" wire:click="update()">Guardar</button>
        <button type="button" class="btn-secondary" data-dismiss="modal" wire:click="resetear()">Cancelar</button>
    </div>
</div>
