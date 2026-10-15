<div>
    <div class="modal-header">
        <h5 class="modal-title">Nuevo entrega</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" wire:click="resetear()">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        @if ($idEmple != null)
            <div class="modal-body">
                @if ($estado === 0)
                    <div class="row">
                        <fieldset class="form-group floating-label-form-group col-lg-6 col-12">
                            <label for="">Cedula</label>
                            <input type="number" class="form-control  @error('cc') border_error @enderror"
                                wire:model="cc" disabled>
                            @error('cc')
                                <span class="input_error error text-danger">{{ $message }}</span>
                            @enderror
                        </fieldset>
                        <br>
                        <fieldset class="form-group floating-label-form-group col-lg-6 col-12">
                            <label for="">Nombre</label>
                            <input type="text" class="form-control  @error('nombreEmpleado') border_error @enderror"
                                wire:model="nombreEmpleado" disabled>
                            @error('nombreEmpleado')
                                <span class="input_error error text-danger">{{ $message }}</span>
                            @enderror
                        </fieldset>
                    </div>
                    <div class="row">
                        <fieldset class="form-group floating-label-form-group col-lg-6 col-12">
                            <label for="">Labor</label>
                            <input type="text" class="form-control  @error('cargo') border_error @enderror"
                                wire:model="cargo" disabled>
                            @error('cargo')
                                <span class="input_error error text-danger">{{ $message }}</span>
                            @enderror
                        </fieldset>
                        <br>
                        <fieldset class="form-group floating-label-form-group col-lg-6 col-12">
                            <label for="">Motivo</label>
                            <select wire:model.defer="motivo" class="form-control">
                                <option value="" selected>Seleccionar...</option>
                                <option value="NUEVO">NUEVO</option>
                                <option value="PERDIDA">PERDIDA</option>
                                <option value="REPOSICION">DAÑO</option>
                                <option value="APROVECHAMIENTO">APROVECHAMIENTO</option>
                            </select>
                            @error('motivo')
                                <span class="input_error error text-danger">{{ $message }}</span>
                            @enderror
                        </fieldset>
                    </div>
                    <div class="row">
                        <fieldset class="form-group floating-label-form-group col-lg-6 col-12">
                            <label class="float-left"><b>Seleccionar EPP</b></label>
                            <select wire:model.defer="epp_id" class="form-control ">
                                <option value="" selected>Seleccionar...</option>
                                @foreach ($epp as $item)
                                    <option value="{{ $item->id }}"> {{ $item->descripcion }} </option>
                                @endforeach
                            </select>
                            @error('epp_id')
                                <span class="c_error2 error text-danger">{{ $message }}</span>
                            @enderror
                        </fieldset>
                        <br>
                        <fieldset class="form-group floating-label-form-group col-lg-6 col-12">
                            <label class="float-left"><b>Linea</b></label>
                            <select wire:model.defer="linea" class="form-control">
                                <option value="" selected>Seleccionar...</option>
                                <option value="LINEA FLEXIBLES
                                ">LINEA FLEXIBLES
                                </option>
                                <option value="LINEA SACHETS
                                ">LINEA SACHETS
                                </option>
                                <option value="LINEA NECTAR
                                ">LINEA NECTAR
                                </option>
                                <option value="LINEA CONSERVAS FRASCOS
                                ">LINEA CONSERVAS
                                    FRASCOS
                                </option>
                                <option value="LINEA ENLATADOS
                                ">LINEA ENLATADOS
                                </option>
                                <option value="LINEA LIQUIDOS FRASCOS
                                ">LINEA LIQUIDOS
                                    FRASCOS
                                </option>
                                <option value="LINEA LIQUIDOS GALONES
                                ">LINEA LIQUIDOS
                                    GALONES
                                </option>
                                <option value="LINEA BOCADILLO-CERNIDO
                                ">LINEA
                                    BOCADILLO-CERNIDO
                                </option>
                                <option value="GRANELES
                                ">GRANELES
                                </option>
                                <option value="LINEA GALONES PASTOSOS
                                ">LINEA GALONES
                                    PASTOSOS
                                </option>
                                <option value="EMPAQUES MANUALES
                                ">EMPAQUES MANUALES
                                </option>
                                <option value="ENSAMBLES
                                ">ENSAMBLES
                                </option>
                                <option value="ADMINISTRATIVA
                                ">ADMINISTRATIVA
                                </option>
                                <option value="MANTENIMIENTO
                                ">MANTENIMIENTO
                                </option>
                                <option value="AMBIENTAL
                                ">AMBIENTAL
                                </option>
                                <option value="CEDI
                                ">CEDI
                                </option>
                                <option value="CTRL PRODUCCION
                                ">CTRL PRODUCCION
                                </option>
                                <option value="BPM
                                ">BPM
                                </option>
                                <option value="SERVICIOS GENERALES
                                ">SERVICIOS GENERALES
                                </option>
                                <option value="CALIDAD
                                ">CALIDAD
                                </option>
                                <option value="MEJORA CONTINUA
                                ">MEJORA CONTINUA
                                </option>
                                <option value="PROYECTOS
                                ">PROYECTOS
                                </option>
                                <option value="GENTE Y CULTURA
                                ">GENTE Y CULTURA
                                </option>
                                <option value="TECNOLOGIA
                                ">TECNOLOGIA
                                </option>
                                <option value="MATERIAS PRIMAS
                                ">MATERIAS PRIMAS
                                </option>
                            </select>
                            @error('linea')
                                <span class="c_error2 error text-danger">{{ $message }}</span>
                            @enderror
                        </fieldset>
                    </div>
                    <div class="row">
                        <fieldset class="form-group floating-label-form-group col-lg-6 col-12">
                            <label for="">Observación</label>
                            <textarea cols="30" rows="5" wire:model="observacion"
                                class=" @error('observacion') border_error @enderror form-control"></textarea>
                            @error('observacion')
                                <span class="input_error error text-danger">{{ $message }}</span>
                            @enderror
                        </fieldset>
                    </div>
                @else
                    <h3>Este usuario esta <strong>INACTIVO</strong>😒</h3>
                @endif
            </div>
        @else
            <div class="spinner-border text-primary" role="status">
                <span class=" text-center"></span>
            </div>
        @endif
        <div class="modal-footer">
            <input type="submit" class="btn btn-outline-primary btn-sm" wire:click="guardar()" value="Guardar">
            <input type="reset" class="btn btn-outline-danger btn-sm" data-dismiss="modal" wire:click="resetear()"
                value="Cancelar">
        </div>
    </div>
    {{-- <script>
        document.addEventListener('livewire:load', function(){
            $('.select2').select2();
            $('.select2').on('change', function(){
                @this.set('epp_id', this.value);
            })
         })
    </script> --}}
</div>
