<div class="max-w-5xl mx-auto p-6 space-y-6">

    {{-- CSS para impressão --}}
    <style>
        @media print {
            /* Oculta tudo fora da área de impressão */
            body * {
                visibility: hidden;
            }

            .print-area, .print-area * {
                visibility: visible;
            }

            .print-area {
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                padding: 0;
                margin: 0;
            }

            /* Evita que cada relatório quebre no meio */
            .relatorio-item {
                page-break-inside: avoid;
                break-inside: avoid;
                margin-bottom: 20px;
            }

            table {
                width: 100%;
                border-collapse: collapse;
                font-size: 12pt;
            }

            th, td {
                border: 1px solid black;
                padding: 6px;
            }

            th {
                background-color: #f0f0f0;
            }

            h2, h3, strong {
                color: black !important;
            }

            .text-gray-700, .text-gray-800, .text-gray-600 {
                color: black !important;
            }

            .no-print {
                display: none !important;
            }
        }
    </style>

    {{-- Formulário de Upload --}}
    <form wire:submit.prevent="importar" enctype="multipart/form-data" class="space-y-4 no-print">
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

    {{-- Botão de impressão --}}
    @if (count($relatorios) > 0)
        <div class="no-print">
            <button onclick="window.print()" class="bg-green-600 text-white px-4 py-2 rounded shadow hover:bg-green-700 transition">
                Imprimir Relatórios
            </button>
        </div>
    @endif

    {{-- Exibição dos relatórios --}}
    @if (count($relatorios) > 0)
        <div class="pt-6 print-area">
            @foreach ($relatorios as $relatorio)
                <div class="relatorio-item border border-gray-300 rounded-md bg-white shadow p-6 mb-8">
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



