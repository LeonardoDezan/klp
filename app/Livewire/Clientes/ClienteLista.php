<?php

namespace App\Livewire\Clientes;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Cliente;

class ClienteLista extends Component
{
    use WithPagination;

    public $search = '';
    public $confirmandoExclusaoId = null;



    public function updatingSearch()
    {
        $this->resetPage(); // Sempre volta para a página 1 ao digitar
    }

    public function render()
    {
        $clientes = $this->buscarClientes();
        return view('livewire.clientes.cliente-lista', compact('clientes'));
    }

    //----- Buscar Clietes -----
    private function buscarClientes()
    {
        return Cliente::with(['contatos', 'representantes.representante_contatos'])
            ->when($this->search, function ($query) {
                $query->where(function ($sub) {
                    $sub->where('razao_social', 'like', "%{$this->search}%")
                        ->orWhere('nome_fantasia', 'like', "%{$this->search}%")
                        ->orWhere('cidade', 'like', "%{$this->search}%")
                        ->orWhere('documento', 'like', "%{$this->search}%")
                        ->orWhere('endereco', 'like', "%{$this->search}%");
                });

            })
            ->orderBy('razao_social')
            ->paginate(10);

    }

    public function editar($clienteId)
    {
        $this->dispatch('editarCliente', id: $clienteId);
    }

    public function confirmarExclusao($id)
    {
        $this->confirmandoExclusaoId = $id;
    }

    public function cancelarExclusao()
    {
        $this->confirmandoExclusaoId = null;
    }

    public function excluirCliente($id)
    {
        Cliente::findOrFail($id)->delete();
        session()->flash('sucesso', 'Cliente excluído com sucesso!');
        $this->confirmandoExclusaoId = null;
    }



}
