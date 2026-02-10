<?php

namespace App\Livewire\Ferramentas;

use App\Models\Cliente;
use Livewire\Component;
use Livewire\WithFileUploads;

class FichaClientes extends Component
{
    use WithFileUploads;

    public array $arquivos = [];
    public array $fichas = []; // somente não cadastrados
    public int $totalXml = 0;
    public int $totalNaoCadastrados = 0;

    public function limpar(): void
    {
        $this->reset(['arquivos', 'fichas', 'totalXml', 'totalNaoCadastrados']);
    }

    public function processar(): void
    {
        $this->validate([
            'arquivos' => ['required', 'array', 'min:1'],
            'arquivos.*' => ['file', 'mimes:xml', 'max:5120'], // 5MB por arquivo (ajuste se quiser)
        ]);

        $this->fichas = [];
        $this->totalXml = count($this->arquivos);

        $dedupe = []; // documento => true

        foreach ($this->arquivos as $arquivo) {
            $xmlContent = file_get_contents($arquivo->getRealPath());
            if (!$xmlContent) {
                continue;
            }

            $dados = $this->extrairDestinatarioNfe($xmlContent);
            if (!$dados || empty($dados['documento'])) {
                continue;
            }

            $documento = $this->somenteNumeros($dados['documento']);

            // deduplicar por documento (um cliente pode aparecer em vários XML)
            if (isset($dedupe[$documento])) {
                continue;
            }
            $dedupe[$documento] = true;

            // verifica se já existe no banco
            $existe = Cliente::query()
                ->where('documento', $documento) // ideal: documento salvo só números
                ->exists();

            if ($existe) {
                continue; // você só quer ficha dos NÃO cadastrados
            }

            $this->fichas[] = [
                'documento' => $documento,
                'razao_social' => $dados['razao_social'] ?? '',
                'nome_fantasia' => $dados['nome_fantasia'] ?? '',
                'endereco' => $dados['endereco'] ?? '',
                'numero' => $dados['numero'] ?? '',
                'bairro' => $dados['bairro'] ?? '',
                'cidade' => $dados['cidade'] ?? '',
                'uf' => $dados['uf'] ?? '',
                'cep' => $dados['cep'] ?? '',
                // campos em branco para preenchimento manual
                'responsavel' => '',
                'telefone' => '',
                'email' => '',
                'observacoes' => '',
            ];
        }

        $this->totalNaoCadastrados = count($this->fichas);

        // seu padrão de mensagens (sem redirect)
        $this->dispatch('mostrarMensagem', 'Processamento concluído. Fichas geradas: ' . $this->totalNaoCadastrados);
    }

    private function somenteNumeros(?string $valor): string
    {
        return preg_replace('/\D/', '', (string) $valor);
    }

    /**
     * Extrai dados do destinatário (dest) de uma NF-e.
     * Funciona para XML com ou sem namespace declarado no root.
     */
    private function extrairDestinatarioNfe(string $xmlContent): ?array
    {
        libxml_use_internal_errors(true);
        $xml = simplexml_load_string($xmlContent);
        if (!$xml) return null;

        // tenta achar o nó infNFe mesmo com namespaces
        $infNFe = $xml->xpath('//*[local-name()="infNFe"]');
        if (!$infNFe || !isset($infNFe[0])) return null;

        $infNFe = $infNFe[0];

        $dest = $infNFe->xpath('.//*[local-name()="dest"]');
        if (!$dest || !isset($dest[0])) return null;
        $dest = $dest[0];

        $cnpj = (string) ($dest->xpath('.//*[local-name()="CNPJ"]')[0] ?? '');
        $cpf  = (string) ($dest->xpath('.//*[local-name()="CPF"]')[0] ?? '');

        $documento = $cnpj ?: $cpf;

        $razao = (string) ($dest->xpath('.//*[local-name()="xNome"]')[0] ?? '');

        $ender = $dest->xpath('.//*[local-name()="enderDest"]');
        $ender = $ender[0] ?? null;

        $xLgr = $ender ? (string) ($ender->xpath('.//*[local-name()="xLgr"]')[0] ?? '') : '';
        $nro  = $ender ? (string) ($ender->xpath('.//*[local-name()="nro"]')[0] ?? '') : '';
        $bair = $ender ? (string) ($ender->xpath('.//*[local-name()="xBairro"]')[0] ?? '') : '';
        $mun  = $ender ? (string) ($ender->xpath('.//*[local-name()="xMun"]')[0] ?? '') : '';
        $uf   = $ender ? (string) ($ender->xpath('.//*[local-name()="UF"]')[0] ?? '') : '';
        $cep  = $ender ? (string) ($ender->xpath('.//*[local-name()="CEP"]')[0] ?? '') : '';

        return [
            'documento' => $documento,
            'razao_social' => $razao,
            'nome_fantasia' => '', // NF-e geralmente não traz
            'endereco' => $xLgr,
            'numero' => $nro,
            'bairro' => $bair,
            'cidade' => $mun,
            'uf' => $uf,
            'cep' => $cep,
        ];
    }

    public function render()
    {
        return view('livewire.ferramentas.ficha-clientes');
    }
}
