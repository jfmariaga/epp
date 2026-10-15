<?php

namespace App\Http\Livewire\Inventario;

use App\Models\Epp;
use Livewire\Component;

class NuevoItem extends Component
{
    public $codigo, $descripcion,$acta;
    protected $rules = [
        'codigo' => 'required',
        'descripcion' => 'required',
        'acta' => 'required',
    ];
    public function render()
    {
        return view('livewire.inventario.nuevo-item');
    }

    public function guardar()
    {
        $this->validate();

            $datos = [
                'item' => $this->codigo,
                'descripcion' => $this->descripcion,
                'acta' => $this->acta,
            ];

            Epp::create($datos);
            $this->dispatch('render')->to('inventario.index');
            $this->reset();
            $this->dispatch('usuario_ok');
    }

    public function resetear()
    {
        $this->reset();
    }
}
