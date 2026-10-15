<?php

namespace App\Http\Livewire\Entrega;

use App\Models\Empleado;
use App\Models\EntregaEpp;
use App\Services\CarneQrParser;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    protected $paginationTheme = "bootstrap";
    public $item,$idNew, $action, $search,$idemple="",$firma="1",$item2,$nombre="";

    public function updatingSearch()
    {
        $this->resetPage();
    }

    #[On('render')]
    public function render()
    {
        if ($this->search === "") {
            $this->idemple = "";
        }

        $empleado = Empleado::where('rfid', $this->search )
        ->orWhere('cc', $this->search)
        ->Where('estado', 0)
        ->get();

        $empleado = Empleado::where('rfid', $this->search)
        ->orWhere('cc', $this->search)
        ->Where('estado', 0)
        ->get();
        foreach ($empleado as $item) {
        $this->item2 = $item;
        $this->idemple = $item->id;
        $this->firma = $item->firma;
        $this->nombre = $item->nombre;
        }
        $entrega = EntregaEpp::latest('id')
        ->where('empleado_id', $this->idemple)
        ->paginate(8);
        
        return view('livewire.entrega.index', compact('entrega','empleado'));
    }

    public function buscarPorQr($payload)
    {
        \Log::warning('buscarPorQr: payload recibido', [
            'longitud' => strlen($payload),
            'payload' => $payload,
        ]);

        $datos = CarneQrParser::parse($payload);

        if (! $datos) {
            $this->dispatch('qr_invalido');
            return;
        }

        $cedula = ltrim($datos['cedula'], '0') ?: '0';

        $existe = Empleado::where('cc', $cedula)->Where('estado', 0)->exists();

        if (! $existe) {
            $this->dispatch('qr_sin_match', cedula: $cedula);
            return;
        }

        $this->search = $cedula;
    }

    public function selecItem($userId, $action)
    {
        $this->idNew = $userId;

        if ($action == 'delete') {
           $this->dispatch('delete_ok');
        } else {
            $this->dispatch('getModelId', $this->idNew)->to('entrega.nueva-entrega');
        }
    }
}
