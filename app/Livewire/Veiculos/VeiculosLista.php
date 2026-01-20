<?php

namespace App\Livewire\Veiculos;

use App\Models\Veiculo;
use Livewire\Component;
use Livewire\WithPagination;

class VeiculosLista extends Component
{
    use WithPagination;

    public $placa = '';
    public $proprietario = '';
    public $vinculo = '';

    protected $queryString = [
        'placa' => ['except' => ''],
        'proprietario' => ['except' => ''],
        'vinculo' => ['except' => ''],
    ];

    public function updated($property): void
    {
        if (in_array($property, ['placa', 'proprietario', 'vinculo'])) {
            $this->resetPage();
        }
    }

    public function limparFiltros(): void
    {
        $this->reset(['placa', 'proprietario', 'vinculo']);
        $this->resetPage();
    }

    private function baseQuery()
    {
        $query = Veiculo::query();

        if ($this->placa !== '') {
            $placa = strtoupper(trim($this->placa));
            $query->where('placa', 'like', "%{$placa}%");
        }

        if ($this->proprietario !== '') {
            $prop = strtoupper(trim($this->proprietario));
            $query->where('proprietario_nome', 'like', "%{$prop}%");
        }

        if ($this->vinculo !== '') {
            $query->where('vinculo', $this->vinculo);
        }

        return $query;
    }

    public function excluir(int $id): void
    {
        $veiculo = Veiculo::find($id);

        if (!$veiculo) {
            $this->dispatch('mostrarMensagem', 'Veículo não encontrado.', 'error');
            return;
        }

        $veiculo->delete();

        $this->dispatch('mostrarMensagem', 'Veículo excluído com sucesso.', 'success');

        // Se a exclusão deixar a página atual vazia, volta uma página
        $paginado = $this->baseQuery()
            ->orderBy('id', 'desc')
            ->paginate(10, ['*'], 'page', $this->getPage());

        if ($paginado->count() === 0 && $this->getPage() > 1) {
            $this->previousPage();
        }
    }

    public function render()
    {
        $veiculos = $this->baseQuery()
            ->orderBy('id', 'desc') 
            ->paginate(10);

        return view('livewire.veiculos.veiculos-lista', [
            'veiculos' => $veiculos,
        ]);
    }
}