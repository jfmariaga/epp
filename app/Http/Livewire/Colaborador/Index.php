<?php

namespace App\Http\Livewire\Colaborador;

use App\Models\Empleado;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    protected $paginationTheme = "bootstrap";
    public $item,$action,$search;

    public function updatingSearch()
    {
        $this->resetPage();
    }

    #[On('render')]
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
           $this->dispatch('delete_ok');
        } else {
            $this->dispatch('getModelId', $this->item)->to('colaborador.editar-usuario');
        }
    }

    public function eliminar($userId)
    {
        $colaborador = Empleado::find($userId);

        if (! $colaborador) {
            return;
        }

        if (! $colaborador->puedeEliminarse()) {
            $this->dispatch('delete_error', mensaje: 'No se puede eliminar: tiene entregas de EPP registradas. Puedes marcarlo como Inactivo en su lugar.');
            return;
        }

        $colaborador->delete();
        $this->dispatch('render')->to('colaborador.index');
        $this->dispatch('delete_success');
    }

}
