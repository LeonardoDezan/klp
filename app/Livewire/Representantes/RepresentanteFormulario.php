<?php

namespace App\Livewire\Representantes;

use Livewire\Component;
use App\Models\Representante;

class RepresentanteFormulario extends Component
{
    public $representanteId  = null; // identificar edição
    public $nome = '';
    public $observacao = '';
    public $contatos = [
        ['nome' => '', 'telefone' => '', 'email' => '']
    ];


    public function rules()
    {
        return [
            'nome' => 'required|string|max:255',
            'contatos.*.nome' => 'required|string|max:255',
            'contatos.*.email' => 'email|max:255',
            'contatos.*.telefone' => 'required|string|max:20',
            'observacao' => '',
        ];
    }

    public function messages()
    {
        return [
            'nome.required' => 'O campo nome é obrigatório.',
            'contatos.*.nome.required' => 'O nome do contato é obrigatório.',
            'contatos.*.email.email' => 'O email informado não é válido.',
            'contatos.*.telefone.required' => 'O telefone do contato é obrigatório.',
        ];
    }

    public function addContato()
    {
        $this->contatos[] = ['nome' => '', 'telefone' => '', 'email' => ''];
    }

    public function removeContato($index)
    {
        unset($this->contatos[$index]);
        $this->contatos = array_values($this->contatos);
    }

    public function save()
    {
        try {
            $this->validate();
        } catch (ValidationException $e) {
            $this->dispatch('mostrarMensagem', 'Erro ao cadastrar, verificar campos.', 'error');
            throw $e;
        }

        if ($this->representanteId) {
            $representante = Representante::findOrFail($this->representanteId);

            $representante->update([
                'nome' => $this->nome,
                'observacao' => $this->observacao,
            ]);

            $representante->representante_contatos()->delete();
            $mensagem = 'Representante atualizado com sucesso!';
        } else {
            $representante = Representante::create([
                'nome' => $this->nome,
                'observacao' => $this->observacao,
            ]);
            $mensagem = 'Representante cadastrado com sucesso!';
        }

        foreach ($this->contatos as $contato) {
            $representante->representante_contatos()->create($contato);
        }

        $this->dispatch('mostrarMensagem', $mensagem);
        $this->resetForm();
    }

    public function mount($id = null)
    {
        if ($id) {
            $representante = Representante::with('representante_contatos')->findOrFail($id);

            // CORREÇÃO AQUI:
            $this->representanteId = $representante->id;

            $this->nome = $representante->nome;
            $this->observacao = $representante->observacao;
            $this->contatos = $representante->representante_contatos->toArray();
        }
    }
    public function resetForm()
    {
        $this->representanteId = null;
        $this->nome = '';
        $this->observacao = '';
        $this->contatos = [
            ['nome' => '', 'telefone' => '', 'email' => '']
        ];
    }

    public function render()
    {
        return view('livewire.representantes.representante-formulario');
    }
}
