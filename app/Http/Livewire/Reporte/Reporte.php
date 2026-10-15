<?php

namespace App\Http\Livewire\Reporte;

use App\Models\EntregaEpp;
use Livewire\Component;


class Reporte extends Component
{
    public function render()
    {
        $reportes = EntregaEpp::all();
        return view('livewire.reporte.reporte', compact('reportes'));
    }
}
