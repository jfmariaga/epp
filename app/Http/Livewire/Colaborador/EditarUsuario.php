<?php

namespace App\Http\Livewire\Colaborador;

use App\Models\Empleado;
use Livewire\Component;

class EditarUsuario extends Component
{
    public $nombre, $cc, $area, $password, $centro, $modelId, $estado, $cargo,$contrato;
    public $user;
    protected $rules = [
        'nombre' => 'required',
        'cc' => 'required',
        'password' => 'required',
        'area' => 'required',
        'cargo' => 'required',
        'contrato' => 'required',
        'centro' => 'required'
    ];
    protected $listeners = ['getModelId'];
    public function render()
    {
        return view('livewire.colaborador.editar-usuario');
    }

    public function getModelId($modelId)
    {
        $this->modelId = $modelId;
        $model = Empleado::find($this->modelId);
        $this->nombre = $model->nombre;
        $this->cc = $model->cc;
        $this->password = $model->rfid;
        $this->area = $model->area;
        $this->centro = $model->centro;
        $this->cargo = $model->cargo;
        $this->estado = $model->estado;
        $this->contrato = $model->tp_contrato;
    }

    public function update()
    {

        $this->validate();

        $user = Empleado::find($this->modelId);
        $user->nombre =  $this->nombre;
        $user->cc = $this->cc;
        $user->rfid = $this->password;
        $user->area = $this->area;
        $user->centro = $this->centro;
        $user->cargo = $this->cargo;
        $user->estado = $this->estado;
        $user->tp_contrato = $this->contrato;
        $user->update();

        $this->emitTo('colaborador.index', 'render');
        $this->emit('editar_user');
        $this->reset();
    }

    public function resetear()
    {
        $this->reset();
        $this->resetValidation();
    }
}
