<?php

namespace App\Http\Livewire\Reporte;

use App\Models\EntregaEpp;
use Livewire\Component;


class Reporte extends Component
{
    public function render()
    {
        $reportes = EntregaEpp::with(['empleado', 'epp'])->get();
        return view('livewire.reporte.reporte', compact('reportes'));
    }
}
