<div class="max-w-7xl mx-auto px-6 py-6 space-y-6">

    {{-- Cabeçalho do veículo --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">

            <div>
                <h1 class="text-2xl font-semibold text-gray-800">
                    Veículo {{ $veiculo->placa ?? '---' }}
                </h1>

                <p class="text-sm text-gray-500 mt-1">
                    {{ $veiculo->marca ?? '' }} {{ $veiculo->modelo ?? '' }}
                    @if(!empty($veiculo->ano)) • {{ $veiculo->ano }} @endif
                    @if(!empty($veiculo->tipo)) • Tipo: {{ strtoupper($veiculo->tipo) }} @endif
                    @if(!empty($veiculo->status)) • Status: {{ ucfirst($veiculo->status) }} @endif
                </p>
            </div>

            <div class="md:text-right">
                <span class="text-sm text-gray-500">Quilometragem atual</span>
                <div class="text-3xl font-semibold text-gray-800">
                    {{ number_format($veiculo->km_atual ?? 0, 0, ',', '.') }} km
                </div>
            </div>
        </div>

        {{-- Ações rápidas (opcional) --}}
        <div class="mt-5 flex flex-wrap gap-2">
            <a href="{{ route('veiculos.index') }}"
               class="px-4 py-2 rounded-lg border border-gray-200 text-sm text-gray-700 hover:bg-gray-50 transition">
                Voltar
            </a>

            <a href="{{ route('veiculos.edit', $veiculo) }}"
               class="px-4 py-2 rounded-lg bg-gray-900 text-sm text-white hover:bg-gray-800 transition">
                Editar veículo
            </a>
        </div>
    </div>

    {{-- Cards resumo --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4">
            <p class="text-sm text-gray-500">Manutenções</p>
            <p class="text-2xl font-semibold text-gray-800 mt-1">0</p>
            <p class="text-xs text-gray-400 mt-1">Últimos 30 dias</p>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4">
            <p class="text-sm text-gray-500">Despesas fixas</p>
            <p class="text-2xl font-semibold text-gray-800 mt-1">0</p>
            <p class="text-xs text-gray-400 mt-1">Ativas</p>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4">
            <p class="text-sm text-gray-500">Despesas variáveis</p>
            <p class="text-2xl font-semibold text-gray-800 mt-1">0</p>
            <p class="text-xs text-gray-400 mt-1">Mês atual</p>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4">
            <p class="text-sm text-gray-500">Abastecimentos</p>
            <p class="text-2xl font-semibold text-gray-800 mt-1">0</p>
            <p class="text-xs text-gray-400 mt-1">Mês atual</p>
        </div>
    </div>

    {{-- Abas --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100">
        <div class="flex flex-wrap gap-2 p-3 border-b border-gray-100">

            <button
                wire:click="trocarAba('manutencoes')"
                class="px-4 py-2 rounded-lg text-sm border transition
                {{ $aba === 'manutencoes'
                    ? 'bg-gray-900 text-white border-gray-900'
                    : 'bg-white text-gray-700 border-gray-200 hover:bg-gray-50' }}">
                Manutenções
            </button>

            <button
                wire:click="trocarAba('fixas')"
                class="px-4 py-2 rounded-lg text-sm border transition
                {{ $aba === 'fixas'
                    ? 'bg-gray-900 text-white border-gray-900'
                    : 'bg-white text-gray-700 border-gray-200 hover:bg-gray-50' }}">
                Despesas Fixas
            </button>

            <button
                wire:click="trocarAba('variaveis')"
                class="px-4 py-2 rounded-lg text-sm border transition
                {{ $aba === 'variaveis'
                    ? 'bg-gray-900 text-white border-gray-900'
                    : 'bg-white text-gray-700 border-gray-200 hover:bg-gray-50' }}">
                Despesas Variáveis
            </button>

            <button
                wire:click="trocarAba('abastecimentos')"
                class="px-4 py-2 rounded-lg text-sm border transition
                {{ $aba === 'abastecimentos'
                    ? 'bg-gray-900 text-white border-gray-900'
                    : 'bg-white text-gray-700 border-gray-200 hover:bg-gray-50' }}">
                Abastecimentos
            </button>
        </div>

        <div class="p-5">

            {{-- MANUTENÇÕES --}}
        @if($aba === 'manutencoes')
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-semibold text-gray-800">Manutenções</h2>

                <button
                    type="button"
                    wire:click="$dispatch('abrirModalManutencao')"
                    class="px-4 py-2 rounded-lg bg-gray-900 text-white text-sm hover:bg-gray-800 transition"
                >
                    Nova manutenção
                </button>
            </div>

            <livewire:veiculos.manutencoes.manutencoes-lista :veiculo="$veiculo" :key="'manutencoes-'.$veiculo->id" />

            <livewire:veiculos.manutencoes.manutencao-modal :veiculo="$veiculo" :key="'manutencao-modal-'.$veiculo->id" />
        @endif             

            {{-- FIXAS --}}
            @if($aba === 'fixas')
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-semibold text-gray-800">Despesas Fixas</h2>
                    <button class="px-4 py-2 rounded-lg bg-gray-900 text-white text-sm hover:bg-gray-800 transition">
                        Nova despesa fixa
                    </button>
                </div>

                <div class="rounded-xl border border-gray-100 overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead class="bg-gray-50 text-gray-600">
                            <tr>
                                <th class="text-left py-3 px-4">Tipo</th>
                                <th class="text-left py-3 px-4">Periodicidade</th>
                                <th class="text-left py-3 px-4">Início</th>
                                <th class="text-right py-3 px-4">Valor</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-700">
                            <tr>
                                <td class="py-3 px-4" colspan="4">
                                    <span class="text-gray-400">Sem registros por enquanto.</span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            @endif

            {{-- VARIÁVEIS --}}
            @if($aba === 'variaveis')
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-semibold text-gray-800">Despesas Variáveis</h2>
                    <button class="px-4 py-2 rounded-lg bg-gray-900 text-white text-sm hover:bg-gray-800 transition">
                        Nova despesa variável
                    </button>
                </div>

                <div class="rounded-xl border border-gray-100 overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead class="bg-gray-50 text-gray-600">
                            <tr>
                                <th class="text-left py-3 px-4">Data</th>
                                <th class="text-left py-3 px-4">Tipo</th>
                                <th class="text-left py-3 px-4">Descrição</th>
                                <th class="text-right py-3 px-4">Valor</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-700">
                            <tr>
                                <td class="py-3 px-4" colspan="4">
                                    <span class="text-gray-400">Sem registros por enquanto.</span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            @endif

            {{-- ABASTECIMENTOS --}}
            @if($aba === 'abastecimentos')
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-semibold text-gray-800">Abastecimentos</h2>
                    <button class="px-4 py-2 rounded-lg bg-gray-900 text-white text-sm hover:bg-gray-800 transition">
                        Novo abastecimento
                    </button>
                </div>

                <div class="rounded-xl border border-gray-100 overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead class="bg-gray-50 text-gray-600">
                            <tr>
                                <th class="text-left py-3 px-4">Data</th>
                                <th class="text-left py-3 px-4">Origem</th>
                                <th class="text-right py-3 px-4">Litros</th>
                                <th class="text-right py-3 px-4">Preço/L</th>
                                <th class="text-right py-3 px-4">Total</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-700">
                            <tr>
                                <td class="py-3 px-4" colspan="5">
                                    <span class="text-gray-400">Sem registros por enquanto.</span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            @endif

        </div>
    </div>
</div>

