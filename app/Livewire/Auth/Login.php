<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class Login extends Component
{
    public $login;
    public $cpf;
    public $password;
    public $erro = '';

    public function autenticar()
    {
        $this->validate([
            'login' => 'required|string',
            'cpf' => 'required|string',
            'password' => 'required|string',
        ]);

        $usuario = User::where('login', $this->login)
            ->where('cpf', preg_replace('/\D/', '', $this->cpf))
            ->first();

        if ($usuario && Hash::check($this->password, $usuario->password)) {
            Auth::login($usuario);
            session()->regenerate();
            return redirect()->intended('/dashboard');
        }

        $this->erro = 'Credenciais inválidas. Verifique os dados e tente novamente.';
    }

    public function render()
    {
        return view('livewire.auth.login')->layout('layouts.guest');
    }
}
