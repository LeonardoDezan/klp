<?php

namespace App\Livewire\Veiculos\Manutencoes;

use App\Models\Manutencao;
use App\Models\Veiculo;
use Livewire\Component;

class ManutencaoModal extends Component
{
    public Veiculo $veiculo;

    public bool $aberto = false;
    public bool $modoEdicao = false;

    public ?string $data = null;
    public string $categoria = 'PECAS';
    public ?string $descricao = null;
    public ?int $km = null;
    public $valor_total = null;
    public ?string $fornecedor = null;
    public ?int $manutencaoId = null;
    public ?string $tipo_documento = null;     // ex: NF, OS, RECIBO
    public ?string $numero_documento = null;   // ex: 12345 / OS-2026-001


    protected $listeners = [
        'abrirModalManutencao' => 'abrir',
        'abrirModalEditarManutencao' => 'abrirEditar',
    ];

    protected function rules(): array
    {
        return [
            'data' => ['required', 'date'],
            'categoria' => ['required', 'in:PECAS,SERVICO_EXTERNO,SERVICO_INTERNO'],
            'descricao' => ['required', 'string', 'min:3'],
            'km' => ['nullable', 'integer', 'min:0'],
            'valor_total' => ['required', 'numeric', 'min:0'],
            'fornecedor' => ['nullable', 'string', 'max:255'],
            'tipo_documento' => ['nullable', 'string', 'max:30'],
            'numero_documento' => ['nullable', 'string', 'max:60'],
        ];
    }

    public function mount(Veiculo $veiculo): void
    {
        $this->veiculo = $veiculo;
    }

    public function abrir(): void
    {
        $this->resetValidation();
        $this->data = now()->toDateString();
        $this->categoria = 'PECAS';
        $this->aberto = true;
    }

    public function fechar(): void
    {
        $this->aberto = false;
        $this->reset(['data', 'categoria', 'descricao', 'km', 'valor_total', 'fornecedor']);
        $this->resetValidation();
    }

    public function salvar(): void
    {
        $this->validate();

        if ($this->modoEdicao && $this->manutencaoId) {
            $m = Manutencao::query()
                ->where('veiculo_id', $this->veiculo->id)
                ->findOrFail($this->manutencaoId);

            $m->update([
                'data' => $this->data,
                'categoria' => $this->categoria,
                'descricao' => $this->descricao,
                'km' => $this->km ?: null,
                'valor_total' => $this->valor_total,
                'fornecedor' => $this->fornecedor ?: null,
                'tipo_documento' => $this->tipo_documento ?: null,
                'numero_documento' => $this->numero_documento ?: null,
            ]);

            $this->dispatch('mostrarMensagem', 'Manutenção atualizada com sucesso!');
        } else {
            Manutencao::create([
                'veiculo_id' => $this->veiculo->id,
                'data' => $this->data,
                'categoria' => $this->categoria,
                'descricao' => $this->descricao,
                'km' => $this->km ?: null,
                'valor_total' => $this->valor_total,
                'fornecedor' => $this->fornecedor ?: null,
                'tipo_documento' => $this->tipo_documento ?: null,
                'numero_documento' => $this->numero_documento ?: null,
            ]);

            $this->dispatch('mostrarMensagem', 'Manutenção registrada com sucesso!');
        }

        // Atualiza a listagem
        $this->dispatch('manutencaoSalva');

        $this->fechar();
    }

    public function abrirCriar(): void
    {
        $this->resetValidation();
        $this->reset([
        'manutencaoId', 
        'modoEdicao', 
        'data', 
        'categoria', 
        'descricao', 
        'km', 
        'valor_total', 
        'fornecedor',
        'tipo_documento',
        'numero_documento',
        ]);

        $this->data = now()->toDateString();
        $this->categoria = 'PECAS';
        $this->modoEdicao = false;
        $this->aberto = true;
    }

    public function abrirEditar(int $manutencaoId): void
    {
        $m = Manutencao::query()
            ->where('veiculo_id', $this->veiculo->id)
            ->findOrFail($manutencaoId);

        $this->resetValidation();

        $this->manutencaoId = $m->id;
        $this->modoEdicao = true;

        $this->data = $m->data?->toDateString();
        $this->categoria = $m->categoria;
        $this->descricao = $m->descricao;
        $this->km = $m->km;
        $this->valor_total = $m->valor_total;
        $this->fornecedor = $m->fornecedor;
        $this->tipo_documento = $m->tipo_documento;
    $this->numero_documento = $m->numero_documento;

        $this->aberto = true;
    }

    public function render()
    {
        return view('livewire.veiculos.manutencoes.manutencao-modal');
    }
}
