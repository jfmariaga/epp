<?php

namespace App\Http\Livewire\Inventario;

use App\Models\Epp;
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
           $this->dispatch('delete_ok');
        } else {
            $this->dispatch('getModelId', $this->item)->to('inventario.editar-item');
        }
    }
}
