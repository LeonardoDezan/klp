<?php


namespace App\Livewire\Motoristas;

use App\Models\Motorista;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public string $busca = '';
    public ?string $vinculo = null; // funcionario|agregado|terceiro|null
    public bool $somenteAtivos = true;
    public ?int $confirmandoExclusaoId = null;

    protected $queryString = [
        'busca' => ['except' => ''],
        'vinculo' => ['except' => null],
        'somenteAtivos' => ['except' => true],
        'page' => ['except' => 1],
    ];

    public function updatingBusca() { $this->resetPage(); }
    public function updatingVinculo() { $this->resetPage(); }
    public function updatingSomenteAtivos() { $this->resetPage(); }

    public function toggleAtivo(int $id): void
    {
        $m = Motorista::findOrFail($id);
        $m->ativo = ! $m->ativo;
        $m->save();

        $this->dispatch('mostrarMensagem', [
            'tipo' => 'success',
            'mensagem' => $m->ativo ? 'Motorista ativado.' : 'Motorista inativado.',
        ]);
    }

    public function confirmarExclusao(int $id): void
    {
        $this->confirmandoExclusaoId = $id;
    }

    public function cancelarExclusao(): void
    {
        $this->confirmandoExclusaoId = null;
    }

    public function excluir(int $id): void
    {
        $m = Motorista::findOrFail($id);
        $nome = $m->nome_completo;
        $m->delete();
        $this->confirmandoExclusaoId = null;

        $this->dispatch('mostrarMensagem', [
            'tipo' => 'success',
            'mensagem' => "Motorista '{$nome}' excluído com sucesso.",
        ]);
    }

    public function render()
    {
        $query = Motorista::query()
            ->when($this->somenteAtivos, fn($q) => $q->where('ativo', true))
            ->when($this->vinculo, fn($q) => $q->where('vinculo', $this->vinculo))
            ->when($this->busca, fn($q) => $q->busca($this->busca))
            ->with([
                'seguros' => fn($q) => $q->orderBy('validade_em', 'desc'),
            ])
            ->orderBy('nome_completo');

        $motoristas = $query->paginate(9); // 3 colunas por página (ajuste como preferir)

        return view('livewire.motoristas.index', [
            'motoristas' => $motoristas,
        ]);
    }
}
