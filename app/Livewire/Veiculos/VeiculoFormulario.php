<?php

namespace App\Livewire\Veiculos;

use App\Models\Veiculo;
use Illuminate\Validation\Rule;
use Livewire\Component;

class VeiculoFormulario extends Component
{
    public ?int $veiculoId = null;

    public $placa;
    public $renavam;
    public $proprietario_nome;
    public $proprietario_documento;
    public $vinculo;
    public $chassi;
    public $tipo;

    public function mount(?int $veiculoId = null): void
    {
        $this->veiculoId = $veiculoId;

        if ($this->veiculoId) {
            $veiculo = Veiculo::findOrFail($this->veiculoId);

            $this->placa = $veiculo->placa;
            $this->renavam = $veiculo->renavam;
            $this->proprietario_nome = $veiculo->proprietario_nome;
            $this->proprietario_documento = $veiculo->proprietario_documento; // (números)
            $this->vinculo = $veiculo->vinculo;
            $this->chassi = $veiculo->chassi;
            $this->tipo = $veiculo->tipo;
        }
    }

    protected function rules(): array
    {
        return [
            'placa' => [
                'required',
                'string',
                'max:10',
                Rule::unique('veiculos', 'placa')->ignore($this->veiculoId),
            ],
            'renavam' => ['nullable', 'string', 'max:20'],

            'proprietario_nome' => ['required', 'string', 'max:150'],
            'proprietario_documento' => ['nullable', 'string', 'max:20'],

            'vinculo' => ['required', Rule::in(['proprio', 'agregado', 'terceiro'])],

            'chassi' => ['nullable', 'string', 'max:30'],
            'tipo' => ['required', 'string', 'max:50'],
        ];
    }

    protected function messages(): array
    {
        return [
            'placa.required' => 'Informe a placa.',
            'placa.unique' => 'Essa placa já está cadastrada.',
            'proprietario_nome.required' => 'Informe o nome do proprietário.',
            'vinculo.required' => 'Selecione o vínculo.',
            'tipo.required' => 'Informe o tipo do veículo.',
        ];
    }

    public function salvar(): void
    {
        // Padronização
        $this->placa = strtoupper(trim((string) $this->placa));
        $this->renavam = $this->renavam ? strtoupper(trim((string) $this->renavam)) : null;

        $this->proprietario_nome = strtoupper(trim((string) $this->proprietario_nome));

        // Documento: salvar somente números
        $this->proprietario_documento = $this->proprietario_documento
            ? preg_replace('/\D/', '', (string) $this->proprietario_documento)
            : null;

        $this->vinculo = $this->vinculo ? trim((string) $this->vinculo) : null;

        $this->chassi = $this->chassi ? strtoupper(trim((string) $this->chassi)) : null;
        $this->tipo = strtoupper(trim((string) $this->tipo));

        $dados = $this->validate();

        if ($this->veiculoId) {
            Veiculo::findOrFail($this->veiculoId)->update($dados);

            $this->dispatch('mostrarMensagem', 'Veículo atualizado com sucesso.', 'success');
            $this->resetErrorBag();
            $this->resetValidation();
            return;
        }

        Veiculo::create($dados);

        $this->dispatch('mostrarMensagem', 'Veículo cadastrado com sucesso.', 'success');
        $this->resetErrorBag();
        $this->resetValidation();
        $this->reset();
    }

    public function render()
    {
        return view('livewire.veiculos.veiculo-formulario');
    }
}
