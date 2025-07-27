<?php

namespace App\Livewire\Ferramentas;

use Livewire\Component;
use Livewire\WithFileUploads;

class Romaneios extends Component
{
    use WithFileUploads;

    public array $relatorios = [];
    public $arquivos = [];

    public function importar()
    {
        $this->validate([
            'arquivos.*' => 'required|file|mimes:xml|max:2048',
        ]);

        $this->relatorios = [];

        foreach ($this->arquivos as $arquivo) {
            $conteudoXml = file_get_contents($arquivo->getRealPath());
            $xml = simplexml_load_string($conteudoXml);

            if (!$xml || !isset($xml->NFe)) continue;

            $ide = $xml->NFe->infNFe->ide ?? null;
            $dest = $xml->NFe->infNFe->dest ?? null;
            $ender = $dest->enderDest ?? null;

            $relatorio = [
                'nNF' => (string) $ide->nNF,
                'cnpj' => (string) $dest->CNPJ,
                'xNome' => (string) $dest->xNome,
                'xLgr' => (string) $ender->xLgr,
                'xMun' => (string) $ender->xMun,
                'produtos' => [],
            ];

            foreach ($xml->NFe->infNFe->det as $detalhe) {
                $relatorio['produtos'][] = [
                    'nItem' => (int) $detalhe['nItem'],
                    'xProd' => (string) $detalhe->prod->xProd,
                    'qCom' => (float) $detalhe->prod->qCom,
                ];
            }

            $this->relatorios[] = $relatorio;
        }
    }

    public function render()
    {
        return view('livewire.ferramentas.romaneios');
    }
}
