<?php

namespace App\Http\Livewire\Usuario;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\On;
use Livewire\Component;

class EditarUsuario extends Component
{
    public $modelId, $name, $email, $password, $role;

    protected function rules()
    {
        return [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $this->modelId,
            'password' => 'nullable|min:8',
            'role' => 'required|in:admin,operador',
        ];
    }

    public function render()
    {
        return view('livewire.usuario.editar-usuario');
    }

    #[On('getModelId')]
    public function getModelId($modelId)
    {
        $this->modelId = $modelId;
        $model = User::find($modelId);
        $this->name = $model->name;
        $this->email = $model->email;
        $this->role = $model->role;
        $this->password = '';
    }

    public function update()
    {
        $this->validate();

        $usuario = User::find($this->modelId);

        if ($usuario->isAdmin() && $this->role !== 'admin' && User::where('role', 'admin')->count() <= 1) {
            $this->addError('role', 'No puedes quitarle el rol admin al último administrador del sistema.');
            return;
        }

        $usuario->name = $this->name;
        $usuario->email = $this->email;
        $usuario->role = $this->role;

        if ($this->password) {
            $usuario->password = Hash::make($this->password);
        }

        $usuario->save();

        $this->dispatch('render')->to('usuario.index');
        $this->dispatch('usuario_editado');
        $this->reset();
    }

    public function resetear()
    {
        $this->reset();
        $this->resetValidation();
    }
}
