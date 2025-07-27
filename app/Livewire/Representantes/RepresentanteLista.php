<?php

namespace App\Livewire\Representantes;

use App\Models\Representante;
use Livewire\Component;
use Livewire\WithPagination;

class RepresentanteLista extends Component
{
    use WithPagination;

    public $perPage = 5;
    public $search = '';
    public $confirmandoExclusaoId = null;


    protected $updatesQueryString = ['search', 'page'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    // ----- Index -----
    public function render()
    {

        $representantes = $this->buscarRepresentantes();

        return view('livewire.representantes.representante-lista', [
            'representantes' => $representantes,
        ]);


    }

    // ----- Buscar representantes -----
    private function buscarRepresentantes()
    {
        return Representante::with('representante_contatos')
            ->when($this->search, function ($query) {
                $query->where('nome', 'like', '%' . $this->search . '%')
                    ->orWhereHas('representante_contatos', function ($q) {
                        $q->where('nome', 'like', '%' . $this->search . '%')
                            ->orWhere('telefone', 'like', '%' . $this->search . '%')
                            ->orWhere('email', 'like', '%' . $this->search . '%');
                    });
            })
            ->orderBy('nome')
            ->paginate($this->perPage);
    }

    // ----- Editar representantes -----
    public function editar($id)
    {
        return redirect()->route('representantes.editar', ['id' => $id]);
    }

    // ----- Deletar representantes -----
    public function confirmarExclusao($id)
    {
        $this->confirmandoExclusaoId = $id;
    }

    public function cancelarExclusao()
    {
        $this->confirmandoExclusaoId = null;
    }

    public function excluirRepresentante()
    {
        $representante = Representante::with('representante_contatos')->findOrFail($this->confirmandoExclusaoId);
        $representante->delete();

        $this->confirmandoExclusaoId = null;
        $this->dispatch('mostrarMensagem', 'Representante excluído com sucesso.');

        $this->gotoPage(1);
    }
}

