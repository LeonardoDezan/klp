<?php

namespace App\Livewire\Clientes;

use Illuminate\Support\Arr;
use Illuminate\Validation\ValidationException;
use Livewire\Component;
use App\Models\Cliente;
use App\Models\Representante;
use Livewire\WithFileUploads;

class ClienteFormulario extends Component
{
    use WithFileUploads;

    protected $listeners = ['editarCliente'];

    public $cliente = [];
    public $clienteId = null;
    public $contatos = [[]];
    public $representantesSelecionados = [[]];
    public $todosRepresentantes = [];
    public $modoEdicao = false;
    public $arquivoXml;



//    -----METODOS-----

    public function mount($clienteId = null)
    {
        $this->todosRepresentantes = Representante::orderBy('nome')->get();

        $this->clienteId = $clienteId;

        if ($clienteId) {
            $cliente = Cliente::with(['contatos', 'representantes'])->findOrFail($clienteId);

            $this->cliente = $cliente->toArray();

            foreach ([
                         'inicio_semana', 'parada_semana', 'retorno_semana', 'fim_semana',
                         'inicio_sabado', 'parada_sabado', 'retorno_sabado', 'fim_sabado'
                     ] as $campo) {
                if (!empty($this->cliente[$campo])) {
                    $this->cliente[$campo] = date('H:i', strtotime($this->cliente[$campo]));
                }
            }

            $this->contatos = $cliente->contatos->map(function ($contato) {
                return $contato->only(['nome', 'cargo', 'telefone']);
            })->toArray();

            $this->representantesSelecionados = $cliente->representantes->pluck('id')->toArray();
        } else {
            $this->contatos = [[]];
            $this->representantesSelecionados = [[]];
        }
    }

    public function render()
    {
        return view('livewire.clientes.cliente-formulario');
    }

    public function adicionarRepresentante()
    {
        $this->representantesSelecionados[] = [];
    }

    public function removerRepresentante($index)
    {
        unset($this->representantesSelecionados[$index]);
        $this->representantesSelecionados = array_values($this->representantesSelecionados);
    }

    public function adicionarContato()
    {
        $this->contatos[] = [];
    }

    public function removerContato($index)
    {
        unset($this->contatos[$index]);
        $this->contatos = array_values($this->contatos);
    }

    protected function rules()
    {
        $clienteId = $this->cliente['id'] ?? 'null';

        return [
            'cliente.razao_social' => 'required|string|max:255',
            'cliente.documento' => 'required|string|max:20|unique:clientes,documento,' . $clienteId,
            'cliente.nome_fantasia' => 'nullable|string|max:255',
            'cliente.endereco' => 'required|string|max:255',
            'cliente.bairro' => 'required|string|max:255',
            'cliente.cidade' => 'required|string|max:255',
            'cliente.uf' => 'required|string|size:2',
            'cliente.tipos_veiculos' => 'nullable|string|max:255',
            'cliente.agendamento' => 'nullable|in:Sim,Não',
            'cliente.informacoes_descarga' => 'nullable|string',
            'cliente.observacoes' => 'nullable|string',
            'representantesSelecionados' => 'array',
            'representantesSelecionados.*' => 'nullable|exists:representantes,id',
            'cliente.inicio_semana' => 'nullable|date_format:H:i',
            'cliente.parada_semana' => 'nullable|date_format:H:i',
            'cliente.retorno_semana' => 'nullable|date_format:H:i',
            'cliente.fim_semana' => 'nullable|date_format:H:i',
            'cliente.inicio_sabado' => 'nullable|date_format:H:i',
            'cliente.parada_sabado' => 'nullable|date_format:H:i',
            'cliente.retorno_sabado' => 'nullable|date_format:H:i',
            'cliente.fim_sabado' => 'nullable|date_format:H:i',
            'cliente.localizacao' => 'nullable|string',
        ];
    }

    protected $messages = [
        'cliente.razao_social.required' => 'O campo Razão Social é obrigatório.',
        'cliente.documento.required' => 'O campo CNPJ ou CPF é obrigatório.',
        'cliente.documento.unique' => 'Este documento já está cadastrado.',
        'cliente.endereco.required' => 'O campo Endereço é obrigatório.',
        'cliente.bairro.required' => 'O campo Bairro é obrigatório.',
        'cliente.cidade.required' => 'O campo Cidade é obrigatório.',
        'cliente.uf.required' => 'O campo UF é obrigatório.',
        'cliente.uf.size' => 'O UF deve conter exatamente 2 letras.',
        'cliente.agendamento.in' => 'O valor de Agendamento deve ser "Sim" ou "Não".',
        'representantesSelecionados.array' => 'A seleção de representantes está inválida.',
        'representantesSelecionados.*.exists' => 'Um dos representantes selecionados não foi encontrado.',
    ];

    public function updated($property)
    {
        $this->validateOnly($property);
    }

    public function salvar()
    {
        try {
            $this->validate($this->rules());
        } catch (ValidationException $e) {
            $this->dispatch('mostrarMensagem', 'Erro ao cadastrar, verificar campos.', 'error');
            throw $e; // mantém os erros nos campos visíveis
        }

        if ($this->clienteId) {
            $cliente = Cliente::findOrFail($this->clienteId);
            $sucesso = $cliente->update($this->cliente);
        } else {
            $cliente = Cliente::create($this->cliente);
            $sucesso = $cliente ? true : false;
        }

        if ($sucesso) {
            if ($this->clienteId) {
                $cliente->contatos()->delete();
            }

            foreach ($this->contatos as $contato) {
                if (!empty($contato['nome']) || !empty($contato['telefone'])) {
                    $cliente->contatos()->create(Arr::except($contato, ['cliente_id']));
                }
            }

            $ids = collect($this->representantesSelecionados)->filter()->unique()->toArray();
            $cliente->representantes()->sync($ids);

            $this->dispatch('mostrarMensagem', 'Cliente salvo com sucesso!', 'success');
            $this->reset();
        } else {
            $this->dispatch('mostrarMensagem', 'Erro ao cadastrar, verificar campos.', 'error');
        }
    }

    public function editarCliente($id)
    {
        $this->modoEdicao = true;

        $cliente = Cliente::with(['contatos', 'representantes'])->findOrFail($id);

        $this->cliente = $cliente->toArray();

        $this->contatos = $cliente->contatos->map(fn($c) => [
            'nome' => $c->nome,
            'cargo' => $c->cargo,
            'telefone' => $c->telefone,
        ])->toArray();

        $this->representantesSelecionados = $cliente->representantes->pluck('id')->toArray();
    }

    public function carregarXml()
    {
        $this->validate([
            'arquivoXml' => 'required|file|mimes:xml|max:2048',
        ]);

        $conteudo = file_get_contents($this->arquivoXml->getRealPath());
        $xml = simplexml_load_string($conteudo);

        $xml->registerXPathNamespace('nfe', 'http://www.portalfiscal.inf.br/nfe');
        $dest = $xml->xpath('//nfe:dest')[0] ?? null;

        if (!$dest) {
            $this->dispatch('mostrarMensagem', 'Não foi possível encontrar os dados do cliente no XML.', 'error');

            return;
        }

        $cnpj = preg_replace('/\D/', '', (string) $dest->CNPJ);

        if (Cliente::where('documento', $cnpj)->exists()) {
            $this->dispatch('mostrarMensagem', 'Já existe um cliente cadastrado com esse CNPJ.', 'warning');
        }

        $this->cliente['razao_social'] = (string) $dest->xNome;
        $this->cliente['documento'] = $cnpj;

        $ender = $dest->enderDest;

        if ($ender) {
            $logradouro = (string) $ender->xLgr;
            $numero = (string) $ender->nro;
            $this->cliente['endereco'] = trim("$logradouro, $numero");

            $this->cliente['bairro'] = (string) $ender->xBairro;
            $this->cliente['cidade'] = (string) $ender->xMun;
            $this->cliente['uf'] = (string) $ender->UF;
        }
        $this->reset('arquivoXml');

        $this->dispatch('mostrarMensagem', 'Dados do cliente carregados com sucesso.', 'success');

    }

}
