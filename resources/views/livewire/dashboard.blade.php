<div>
    <div class="w-full" wire:poll.{{ $pollSeconds }}s>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            {{-- Card: Clientes totais cadastrados --}}
            <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
                <div class="text-sm text-gray-500">Clientes (total)</div>
                <div class="mt-2 text-3xl font-semibold text-gray-900">
                    {{ number_format($this->totalClientes, 0, ',', '.') }}
                </div>
                <div class="mt-3 text-xs text-gray-400">Total de clientes cadastrados</div>
            </div>

            {{-- Card: Clientes nos últimos 30 dias --}}
            <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
                <div class="text-sm text-gray-500">Clientes (últimos 30 dias)</div>
                <div class="mt-2 text-3xl font-semibold text-gray-900">
                    {{ number_format($this->clientesUltimos30Dias, 0, ',', '.') }}
                </div>
                <div class="mt-3 text-xs text-gray-400">Novos clientes cadastrados nos últimos 30 dias</div>
            </div>
        </div>

        {{-- Estado de carregamento Livewire --}}
        <div wire:loading.delay.long class="mt-4 text-xs text-gray-400">
            Atualizando dados…
        </div>
    </div>

</div>
