<?php

namespace App\Livewire\Veiculos;

use App\Models\Veiculo;
use Livewire\Component;

class VeiculoShow extends Component
{
    public Veiculo $veiculo;

    public string $aba = 'manutencoes';

    public function mount(Veiculo $veiculo): void
    {
        
        $this->veiculo = $veiculo;

    }

    public function trocarAba(string $aba): void
    {
        // Segurança: evita receber qualquer aba inválida
        $abasValidas = ['manutencoes']; // depois você adiciona: 'abastecimentos', 'multas', 'gastos', etc.

        $this->aba = in_array($aba, $abasValidas, true) ? $aba : 'manutencoes';
    }

    public function render()
    {
        return view('livewire.veiculos.veiculo-show');
    }
}
