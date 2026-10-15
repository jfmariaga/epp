<div>
    <div class="modal-body">
        <div class="row">
            <fieldset class="form-group floating-label-form-group col-lg-6 col-12">
                <label for="">Codigo Item</label>
                <input type="text" class="form-control  @error('codigo') border_error @enderror" placeholder="Codigo"
                    wire:model="codigo">
                @error('codigo') <span class="input_error error text-danger">{{ $message }}</span> @enderror
            </fieldset>
            <br>
            <fieldset class="form-group floating-label-form-group col-lg-6 col-12">
                <label>Descripción</label>
                <input type="text" class="form-control  @error('descripcion') border_error @enderror" placeholder="Descricrión"
                    wire:model="descripcion">
                @error('descripcion')
                    <span class="input_error error text-danger">{{ $message }}</span>
                @enderror
            </fieldset>
            <br>
            <fieldset class="form-group floating-label-form-group col-lg-6 col-12">
                <label>Requiere Acta de entrega</label>
                <select wire:model.defer="acta" class="form-control">
                    <option value="" selected>Seleccionar...</option>
                    <option value="1">SI</option>
                    <option value="2">NO</option>
                </select>
                @error('acta')
                    <span class="input_error error text-danger">{{ $message }}</span>
                @enderror
            </fieldset>       
        </div>
    </div>
    <div class="modal-footer">
        <input type="submit" class="btn btn-outline-primary btn-sm" wire:click="guardar()" value="Guardar">
        <input type="reset" class="btn btn-outline-danger btn-sm" data-dismiss="modal" wire:click="resetear()"
        value="Cancelar">
    </div>
</div>


