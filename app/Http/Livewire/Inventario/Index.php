<?php

namespace App\Http\Livewire\Inventario;

use App\Models\Epp;
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
        $items = Epp::where(function ($query) {
            return $query->where('item', 'LIKE', '%' . $this->search . '%')
                ->orWhere('descripcion', 'LIKE', '%' . $this->search . '%');
        })
            ->paginate(10);
        return view('livewire.inventario.index',compact('items'));
    }

    public function selecItem($userId, $action)
    {
        $this->item = $userId;

        if ($action == 'delete') {
           $this->emit('delete_ok');
        } else {
            $this->emitTo('inventario.editar-item','getModelId', $this->item);
        }
    }
}
