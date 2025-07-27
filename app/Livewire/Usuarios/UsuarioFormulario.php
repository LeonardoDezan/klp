<?php

namespace App\Livewire\Usuarios;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class UsuarioFormulario extends Component
{
    public $usuarios;

    public $formulario = [
        'login' => '',
        'cpf' => '',
        'name' => '',
        'password' => '',
    ];

    public $senhaConfirmada;
    public $confirmandoExclusaoId = null;

    protected $rules = [
        'formulario.login' => 'required|string|unique:users,login|min:4|max:50',
        'formulario.cpf' => 'required|string|size:11|unique:users,cpf',
        'formulario.name' => 'required|string|min:3|max:100',
        'formulario.password' => 'required|string|min:6|max:50',
    ];

    protected $messages = [
        'formulario.login.required' => 'O campo Login é obrigatório.',
        'formulario.login.unique' => 'Este login já está em uso.',
        'formulario.login.min' => 'O login deve ter pelo menos 4 caracteres.',
        'formulario.login.max' => 'O login pode ter no máximo 50 caracteres.',

        'formulario.cpf.required' => 'O campo CPF é obrigatório.',
        'formulario.cpf.unique' => 'Este CPF já está cadastrado.',
        'formulario.cpf.size' => 'O CPF deve conter exatamente 11 dígitos numéricos.',

        'formulario.name.required' => 'O campo Nome é obrigatório.',
        'formulario.name.min' => 'O nome deve ter pelo menos 3 caracteres.',
        'formulario.name.max' => 'O nome pode ter no máximo 100 caracteres.',

        'formulario.password.required' => 'A senha é obrigatória.',
        'formulario.password.min' => 'A senha deve ter pelo menos 6 caracteres.',
        'formulario.password.max' => 'A senha pode ter no máximo 50 caracteres.',
    ];


    public function mount()
    {
        $this->carregarUsuarios();
    }

    public function carregarUsuarios()
    {
        $this->usuarios = User::orderBy('name')->get();
    }

    public function salvar()
    {
        $this->validate();

        if ($this->formulario['password'] !== $this->senhaConfirmada) {
            $this->dispatch('mostrarMensagem', 'A senha e a confirmação não conferem.', 'warning');
            return;
        }

        User::create([
            'login' => $this->formulario['login'],
            'cpf' => preg_replace('/\D/', '', $this->formulario['cpf']),
            'name' => $this->formulario['name'],
            'password' => Hash::make($this->formulario['password']),
        ]);

        $this->dispatch('mostrarMensagem', 'Usuário cadastrado com sucesso!', 'success');

        $this->reset(['formulario', 'senhaConfirmada']);
        $this->carregarUsuarios();

    }

    public function confirmarExclusao($id)
    {
        $this->confirmandoExclusaoId = $id;
    }

    public function cancelarExclusao()
    {
        $this->confirmandoExclusaoId = null;
    }

    public function excluirUsuario($id)
    {
        User::findOrFail($id)->delete();

        $this->dispatch('mostrarMensagem', 'Usuário excluído com sucesso!', 'success');

        $this->carregarUsuarios();
        $this->confirmandoExclusaoId = null;
    }

    public function render()
    {
        return view('livewire.usuarios.usuario-formulario');
    }
}
