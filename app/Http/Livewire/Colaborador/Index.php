<?php

namespace App\Http\Livewire\Colaborador;

use App\Models\Empleado;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    protected $paginationTheme = "bootstrap";
    public $item,$action,$search;

    protected $listeners=['render'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $colaborador = Empleado::where(function ($query) {
            return $query->where('nombre', 'LIKE', '%' . $this->search . '%')
                ->orWhere('rfid', 'LIKE', '%' . $this->search . '%')
                ->orWhere('centro', 'LIKE', '%' . $this->search . '%')
                ->orWhere('area', 'LIKE', '%' . $this->search . '%')
                ->orWhere('cc', 'LIKE', '%' . $this->search . '%');
        })
            ->paginate(10);
        return view('livewire.colaborador.index',compact('colaborador'));
    }

    public function selecItem($userId, $action)
    {
        $this->item = $userId;

        if ($action == 'delete') {
           $this->emit('delete_ok');
        } else {
            $this->emitTo('colaborador.editar-usuario','getModelId', $this->item);
        }
    }
   
}
