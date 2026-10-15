<?php

namespace App\Http\Livewire\Usuario;

use App\Models\User;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    protected $paginationTheme = "bootstrap";
    public $item, $search;

    public function updatingSearch()
    {
        $this->resetPage();
    }

    #[On('render')]
    public function render()
    {
        $usuarios = User::where(function ($query) {
            return $query->where('name', 'LIKE', '%' . $this->search . '%')
                ->orWhere('email', 'LIKE', '%' . $this->search . '%');
        })
            ->orderBy('name')
            ->paginate(10);

        return view('livewire.usuario.index', compact('usuarios'));
    }

    public function editar($userId)
    {
        $this->item = $userId;
        $this->dispatch('getModelId', $this->item)->to('usuario.editar-usuario');
    }

    public function eliminar($userId)
    {
        $usuario = User::find($userId);

        if (! $usuario) {
            return;
        }

        if ($usuario->id === auth()->id()) {
            $this->dispatch('usuario_error', mensaje: 'No puedes eliminar tu propio usuario.');
            return;
        }

        if ($usuario->isAdmin() && User::where('role', 'admin')->count() <= 1) {
            $this->dispatch('usuario_error', mensaje: 'No puedes eliminar al último administrador del sistema.');
            return;
        }

        $usuario->delete();
        $this->dispatch('usuario_eliminado');
    }
}
