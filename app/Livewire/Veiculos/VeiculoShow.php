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
        $this->aba = $aba;
    }

    public function render()
    {
        return view('livewire.veiculos.veiculo-show');
    }
}