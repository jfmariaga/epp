<?php

namespace App\Http\Livewire\Reporte;

use App\Models\EntregaEpp;
use Livewire\Component;
use Livewire\WithPagination;

class Reporte extends Component
{
    use WithPagination;

    public string $search = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $reportes = EntregaEpp::query()
            ->with(['empleado', 'epp'])
            ->when($this->search, function ($query) {
                $term = '%' . $this->search . '%';
                $query->whereHas('empleado', function ($q) use ($term) {
                    $q->where('nombre', 'like', $term)
                        ->orWhere('cc', 'like', $term);
                });
            })
            ->latest('fechaEntrega')
            ->paginate(30);

        return view('livewire.reporte.reporte', compact('reportes'));
    }
}
