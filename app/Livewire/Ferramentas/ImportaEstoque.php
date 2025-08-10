<?php

namespace App\Livewire\Ferramentas;

use Livewire\Component;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use SimpleXMLElement;

class ImportaEstoque extends Component
{
    use WithFileUploads;

    /** @var TemporaryUploadedFile[] */
    public array $arquivos = [];

    protected $rules = [
        'arquivos'   => 'required|array|max:100',
        'arquivos.*' => 'file|mimes:xml|max:5120',
    ];

    protected $messages = [
        'arquivos.required' => 'Selecione pelo menos um XML.',
        'arquivos.max'      => 'Você selecionou arquivos demais (máximo: 99).',
        'arquivos.*.mimes'  => 'Apenas arquivos .xml são permitidos.',
        'arquivos.*.max'    => 'Um dos XMLs ultrapassa o tamanho permitido.',
    ];

    public function gerarPlanilha()
    {
        $this->validate();

        $linhas = [];

        foreach ($this->arquivos as $arquivo) {
            $conteudo = @file_get_contents($arquivo->getRealPath());
            if ($conteudo === false) {
                continue;
            }

            $xml = @simplexml_load_string($conteudo);
            if (!$xml) {
                continue;
            }

            $inf = $this->resolverInfNFe($xml);
            if (!$inf) {
                continue;
            }

            // ✅ 1 linha POR NOTA
            $linhas[] = $this->mapearLinhaPorNota($inf);
        }

        // Remove linhas completamente vazias, se houver
        $linhas = array_values(array_filter($linhas, fn($l) => !empty(array_filter($l, fn($v) => $v !== '' && $v !== null))));

        if (empty($linhas)) {
            $this->dispatch('mostrarMensagem', [
                'tipo' => 'erro',
                'mensagem' => 'Nenhum dado de nota encontrado para exportar.',
            ]);
            return;
        }

        // Exporta mantendo os headings na ordem definida pelas chaves
        $export = new class($linhas) implements FromCollection, WithHeadings {
            public function __construct(private array $linhas) {}
            public function collection(): Collection { return collect($this->linhas); }
            public function headings(): array { return array_keys($this->linhas[0]); }
        };

        return Excel::download($export, 'importa-estoque.xlsx');
    }

    private function resolverInfNFe(SimpleXMLElement $xml): ?SimpleXMLElement
    {
        if (isset($xml->NFe->infNFe)) return $xml->NFe->infNFe;
        if (isset($xml->NFe->infNfe)) return $xml->NFe->infNfe; // alguns fornecedores
        if (isset($xml->nfeProc->NFe->infNFe)) return $xml->nfeProc->NFe->infNFe;

        $xml->registerXPathNamespace('nfe', 'http://www.portalfiscal.inf.br/nfe');
        $hit = $xml->xpath('//nfe:infNFe');
        return ($hit && isset($hit[0])) ? $hit[0] : null;
    }

    /**
     * Mapeia uma linha por nota, no EXATO layout solicitado:
     * [NF, Destinatário Nome, xMun, (vazio), xLgr, qVol, pesoB]
     */
    private function mapearLinhaPorNota(SimpleXMLElement $inf): array
    {
        $dest = $inf->dest ?? null;
        $enderDest = $dest?->enderDest ?? null;

        // Somatório de volumes (se houverem vários <vol>)
        $qVolTotal = '';
        $pesoBTotal = '';
        if (isset($inf->transp) && isset($inf->transp->vol)) {
            $qVol = 0.0;
            $peso = 0.0;
            foreach ($inf->transp->vol as $vol) {
                // Convertendo por truncamento para inteiro no final (conforme solicitado)
                $qVol += is_numeric((string)($vol->qVol ?? '')) ? floatval((string)$vol->qVol) : 0.0;
                $peso += is_numeric((string)($vol->pesoB ?? '')) ? floatval((string)$vol->pesoB) : 0.0;
            }
            // Trunca para inteiro (sem arredondar)
            $qVolTotal = $this->toIntOrEmpty($qVol);
            $pesoBTotal = $this->toIntOrEmpty($peso);
        }

        // NF (nNF) também como inteiro (truncado), se numérico
        $nf = $this->toIntOrString(($inf->ide->nNF ?? ''));

        // Cidade e Logradouro (strings)
        $xMun = (string) ($enderDest->xMun ?? '');
        $xLgr = (string) ($enderDest->xLgr ?? '');
        $destNome = (string) ($dest->xNome ?? '');

        // ⚠️ Ordem EXATA das colunas pedidas:
        return [
            'NF'                 => $nf,
            'Destinatário Nome'  => $destNome,
            'Cidade'               => $xMun,
            ''                   => '',      // coluna em branco
            'Endereço'               => $xLgr,
            'Quantidade'               => $qVolTotal,
            'Peso'              => $pesoBTotal,
        ];
    }

    /**
     * Converte para inteiro por truncamento; se 0 e não havia valor, retorna ''.
     */
    private function toIntOrEmpty($value): string|int
    {
        if ($value === null || $value === '') return '';
        $num = (int) floatval($value); // truncamento
        return ($num === 0 && !is_numeric($value)) ? '' : $num;
        // mantém 0 quando veio de número válido; caso contrário, vazio
    }

    /**
     * Para NF: se for numérico, devolve int truncado; senão devolve string original.
     */
    private function toIntOrString($value): string|int
    {
        $str = (string) $value;
        if ($str === '') return '';
        if (is_numeric($str)) return (int) floatval($str);
        return $str;
    }

    public function render()
    {
        return view('livewire.ferramentas.importa-estoque');
    }
}
