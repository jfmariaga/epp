<?php

namespace App\Http\Livewire\Usuario;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class NuevoUsuario extends Component
{
    public $name, $email, $password, $role = 'operador';

    protected $rules = [
        'name' => 'required',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|min:8',
        'role' => 'required|in:admin,operador',
    ];

    public function render()
    {
        return view('livewire.usuario.nuevo-usuario');
    }

    public function guardar()
    {
        $this->validate();

        User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'role' => $this->role,
        ]);

        $this->dispatch('render')->to('usuario.index');
        $this->reset();
        $this->dispatch('usuario_ok');
    }

    public function resetear()
    {
        $this->reset();
        $this->resetValidation();
    }
}
