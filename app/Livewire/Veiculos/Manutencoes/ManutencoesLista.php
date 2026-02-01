<?php

namespace App\Livewire\Veiculos\Manutencoes;

use App\Models\Manutencao;
use App\Models\Veiculo;
use Carbon\Carbon;
use Livewire\Component;

class ManutencoesLista extends Component
{
    public Veiculo $veiculo;

    // Filtros
    public ?string $data_inicio = null;
    public ?string $data_fim = null;
    public string $categoria = ''; // vazio = todas
    public string $busca = '';

    protected $listeners = [
        'manutencaoSalva' => '$refresh',
    ];

    public function mount(Veiculo $veiculo): void
    {
        $this->veiculo = $veiculo;

        // Sugestão prática: já abrir com "mês atual"
        // Se você quiser começar sem nada, é só comentar essas 2 linhas.
        $hoje = now();
        $this->data_inicio = $hoje->copy()->startOfMonth()->toDateString();
        $this->data_fim = $hoje->copy()->endOfMonth()->toDateString();
    }

    public function limparFiltros(): void
    {
        $this->categoria = '';
        $this->busca = '';

        // Mantém o comportamento padrão do mês atual
        $hoje = now();
        $this->data_inicio = $hoje->copy()->startOfMonth()->toDateString();
        $this->data_fim = $hoje->copy()->endOfMonth()->toDateString();
    }

    private function queryManutencoes()
    {
        $query = Manutencao::query()
            ->where('veiculo_id', $this->veiculo->id);

        // Período (se preenchido)
        if ($this->data_inicio && $this->data_fim) {
            $inicio = Carbon::parse($this->data_inicio)->toDateString();
            $fim = Carbon::parse($this->data_fim)->toDateString();

            // evita range invertido
            if ($inicio > $fim) {
                [$inicio, $fim] = [$fim, $inicio];
            }

            $query->whereBetween('data', [$inicio, $fim]);
        } elseif ($this->data_inicio) {
            $query->whereDate('data', '>=', Carbon::parse($this->data_inicio)->toDateString());
        } elseif ($this->data_fim) {
            $query->whereDate('data', '<=', Carbon::parse($this->data_fim)->toDateString());
        }

        // Categoria
        if ($this->categoria !== '') {
            $query->where('categoria', $this->categoria);
        }

        // Busca livre (descrição, fornecedor, doc)
        $busca = trim($this->busca);
        if ($busca !== '') {
            $like = '%' . $busca . '%';
            $query->where(function ($q) use ($like) {
                $q->where('descricao', 'like', $like)
                    ->orWhere('fornecedor', 'like', $like)
                    ->orWhere('tipo_documento', 'like', $like)
                    ->orWhere('numero_documento', 'like', $like);
            });
        }

        return $query
            ->orderByDesc('data')
            ->orderByDesc('id');
    }

    // já existia no seu fluxo
    public function editar(int $manutencaoId): void
    {
        $this->dispatch('abrirModalEditarManutencao', manutencaoId: $manutencaoId);
    }

    public function excluir(int $manutencaoId): void
    {
        $m = Manutencao::query()
            ->where('veiculo_id', $this->veiculo->id)
            ->findOrFail($manutencaoId);

        $m->delete();

        $this->dispatch('mostrarMensagem', 'Manutenção excluída com sucesso!');
        $this->dispatch('$refresh');
    }

    public function render()
    {
        return view('livewire.veiculos.manutencoes.manutencoes-lista', [
            'manutencoes' => $this->queryManutencoes()->get(),
        ]);
    }
}
