<?php

namespace App\Livewire;

use Livewire\Component;

class AlertaMensagem extends Component
{
    public $mensagem = '';
    public $tipo = 'success';
    public $visivel = false;

    protected $listeners = ['mostrarMensagem'];

    public function mostrarMensagem($mensagem, $tipo = 'success')
    {
        $this->mensagem = $mensagem;
        $this->tipo = $tipo;
        $this->visivel = true;
    }

    public function ocultarMensagem()
    {
        $this->visivel = false;
    }

    public function render()
    {
        return view('livewire.alerta-mensagem');
    }
}
