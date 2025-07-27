<div class="max-w-5xl mx-auto p-6 space-y-6">
    {{-- Formulário de Upload --}}
    <form wire:submit.prevent="importar" enctype="multipart/form-data" class="space-y-4">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Importar XMLs</label>
            <input type="file" multiple wire:model="arquivos"
                   class="w-full border border-gray-300 rounded px-3 py-2 text-sm"
                   accept=".xml">
        </div>

        <button type="submit"
                class="bg-blue-600 text-white px-4 py-2 rounded shadow hover:bg-blue-700 transition">
            Importar XMLs
        </button>
    </form>

    {{-- Exibição dos relatórios --}}
    @if (count($relatorios) > 0)
        <div class="pt-6">
            @foreach ($relatorios as $relatorio)
                <div class="border border-gray-300 rounded-md bg-white shadow p-6 mb-8 print:break-after-page">
                    <h2 class="text-xl font-bold text-gray-800 mb-2">Nota Fiscal: {{ $relatorio['nNF'] }}</h2>
                    <div class="text-sm text-gray-700 space-y-1">
                        <p><strong>CNPJ:</strong> {{ $relatorio['cnpj'] }}</p>
                        <p><strong>Nome:</strong> {{ $relatorio['xNome'] }}</p>
                        <p><strong>Endereço:</strong> {{ $relatorio['xLgr'] }}</p>
                        <p><strong>Cidade:</strong> {{ $relatorio['xMun'] }}</p>
                    </div>

                    <h3 class="mt-4 font-semibold">Produtos:</h3>
                    <table class="w-full text-sm mt-2 border">
                        <thead>
                        <tr class="bg-gray-100 text-left">
                            <th class="p-2 border">Item</th>
                            <th class="p-2 border">Descrição</th>
                            <th class="p-2 border">Quantidade</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($relatorio['produtos'] as $produto)
                            <tr>
                                <td class="p-2 border">{{ $produto['nItem'] }}</td>
                                <td class="p-2 border">{{ $produto['xProd'] }}</td>
                                <td class="p-2 border">{{ $produto['qCom'] }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @endforeach
        </div>
    @else
        <p class="text-gray-600">Nenhum relatório disponível.</p>
    @endif
</div>
