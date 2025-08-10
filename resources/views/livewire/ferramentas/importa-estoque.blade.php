<div>
    <div class="max-w-4xl mx-auto p-6 space-y-6">
        <h1 class="text-xl font-semibold">Importa Estoque</h1>

        {{-- Mensagens globais (nosso padrão) --}}
        <livewire:alerta-mensagem />

        {{-- Formulário --}}
        <form wire:submit.prevent="gerarPlanilha" enctype="multipart/form-data" class="space-y-4">

            {{-- Seletor de arquivos --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Selecione os XMLs de NF-e
                </label>

                <input
                    type="file"
                    multiple
                    wire:model="arquivos"
                    accept=".xml"
                    class="w-full border border-gray-300 rounded px-3 py-2 text-sm bg-white"
                >

                {{-- Erros de validação --}}
                @error('arquivos')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
                @error('arquivos.*')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror

                {{-- Info arquivos selecionados --}}
                <div class="text-xs text-gray-600 mt-2">
                <span wire:loading.remove wire:target="arquivos">
                    @if (is_array($arquivos) && count($arquivos) > 0)
                        {{ count($arquivos) }} arquivo(s) selecionado(s).
                    @else
                        Nenhum arquivo selecionado.
                    @endif
                </span>
                    <span wire:loading wire:target="arquivos">Carregando arquivos…</span>
                </div>
            </div>

            {{-- Ações --}}
            <div class="flex items-center gap-3">
                <button
                    type="submit"
                    class="px-4 py-2 rounded shadow text-white bg-green-600 hover:bg-green-700 disabled:opacity-50"
                    wire:loading.attr="disabled"
                    wire:target="gerarPlanilha,arquivos"

                >
                <span wire:loading.remove wire:target="gerarPlanilha,arquivos">
                    Gerar Planilha Excel
                </span>
                <span wire:loading wire:target="gerarPlanilha">
                    Gerando…
                </span>
                </button>

                <button
                    type="button"
                    class="px-4 py-2 rounded shadow bg-gray-200 hover:bg-gray-300 text-gray-800"
                    wire:click="$set('arquivos', [])"
                    wire:loading.attr="disabled"
                    wire:target="arquivos"
                >
                    Limpar seleção
                </button>
            </div>
        </form>
    </div>

</div>
