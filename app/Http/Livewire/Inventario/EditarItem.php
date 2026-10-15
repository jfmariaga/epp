<?php

namespace App\Http\Livewire\Inventario;

use App\Models\Epp;
use Livewire\Component;

class EditarItem extends Component
{
    public $codigo, $descripcion,$modelId,$acta;
    protected $rules = [
        'codigo' => 'required',
        'descripcion' => 'required',
        'acta'=> 'required'
    ];

    protected $listeners=['getModelId'];


    public function render()
    {
        return view('livewire.inventario.editar-item');
    }

    public function getModelId($modelId)
    {
        $this->modelId = $modelId;
        $model = Epp::find($this->modelId);
        $this->codigo = $model->item;
        $this->descripcion = $model->descripcion;
        $this->acta = $model->acta;

    }

    public function update()
    {

        $this->validate();

        $epp = Epp::find($this->modelId);
        $epp->item =  $this->codigo;
        $epp->descripcion = $this->descripcion;
        $epp->acta =  $this->acta;

        $epp->update();

        $this->emitTo('inventario.index', 'render');
        $this->reset();
        $this->emit('editar');
    }

    public function resetear()
    {
        $this->reset();
    }
}
