<div class="rounded-xl border border-gray-100 overflow-x-auto">
    <div class="mb-4 rounded-xl border border-gray-100 bg-white p-4">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-3">
            <div>
                <label class="text-xs text-gray-600">Data início</label>
                <input type="date"
                    wire:model.live="data_inicio"
                    class="mt-1 w-full rounded-lg border-gray-300 focus:border-gray-900 focus:ring-gray-900">
            </div>

            <div>
                <label class="text-xs text-gray-600">Data fim</label>
                <input type="date"
                    wire:model.live="data_fim"
                    class="mt-1 w-full rounded-lg border-gray-300 focus:border-gray-900 focus:ring-gray-900">
            </div>

            <div>
                <label class="text-xs text-gray-600">Categoria</label>
                <select wire:model.live="categoria"
                        class="mt-1 w-full rounded-lg border-gray-300 focus:border-gray-900 focus:ring-gray-900">
                    <option value="">Todas</option>
                    <option value="PECAS">Peças</option>
                    <option value="SERVICO_EXTERNO">Serviço Externo</option>
                    <option value="SERVICO_INTERNO">Serviço Interno</option>
                </select>
            </div>

            <div>
                <label class="text-xs text-gray-600">Busca</label>
                <input type="text"
                    wire:model.live.debounce.400ms="busca"
                    placeholder="Descrição, fornecedor, NF/OS..."
                    class="mt-1 w-full rounded-lg border-gray-300 focus:border-gray-900 focus:ring-gray-900">
            </div>
        </div>

        <div class="mt-3 flex items-center justify-end">
            <button type="button"
                    wire:click="limparFiltros"
                    class="px-3 py-2 rounded-lg border border-gray-300 text-sm hover:bg-gray-50">
                Limpar
            </button>
        </div>
    </div>
    <table class="min-w-full text-sm">
        <thead class="bg-gray-50 text-gray-600">
            <tr>
                <th class="text-left py-3 px-4">Data</th>
                <th class="text-left py-3 px-4">Tipo</th>
                <th class="text-left py-3 px-4">Descrição</th>
                <th class="text-left py-3 px-4">Fornecedor / Documento</th>
                <th class="text-left py-3 px-4">KM</th>
                <th class="text-right py-3 px-4">Valor</th>
                <th class="text-right py-3 px-4">Ações</th>
            </tr>
        </thead>

        <tbody class="text-gray-700 divide-y divide-gray-100">
            @forelse($manutencoes as $m)
                <tr class="hover:bg-gray-50">
                    <td class="py-3 px-4 whitespace-nowrap">
                        {{ $m->data?->format('d/m/Y') }}
                    </td>

                    <td class="py-3 px-4 whitespace-nowrap">
                        <span class="inline-flex items-center px-2 py-1 rounded-lg text-xs border border-gray-200 bg-white">
                            {{ \App\Models\Manutencao::categorias()[$m->categoria] ?? $m->categoria }}
                        </span>
                    </td>

                    <td class="py-3 px-4">
                        {{ $m->descricao }}
                    </td>

                    <td class="py-3 px-4">
                        @if($m->fornecedor)
                            <div class="text-sm text-gray-700">
                                {{ $m->fornecedor }}
                            </div>
                        @endif

                        @if($m->tipo_documento || $m->numero_documento)
                            <div class="text-xs text-gray-500">
                                {{ $m->tipo_documento ?? 'Doc' }}:
                                {{ $m->numero_documento ?? '—' }}
                            </div>
                        @endif

                        @if(!$m->fornecedor && !$m->tipo_documento && !$m->numero_documento)
                            <span class="text-gray-400 text-sm">—</span>
                        @endif
                    </td>

                    <td class="py-3 px-4 whitespace-nowrap">
                        {{ $m->km ? number_format($m->km, 0, ',', '.') : '-' }}
                    </td>

                    <td class="py-3 px-4 text-right whitespace-nowrap">
                        R$ {{ number_format((float) $m->valor_total, 2, ',', '.') }}
                    </td>

                    <td class="py-3 px-4 text-right whitespace-nowrap">
                        <div class="inline-flex items-center gap-2">
                            <button
                                type="button"
                                wire:click="editar({{ $m->id }})"
                                class="px-3 py-1.5 rounded-lg border border-gray-300 hover:bg-gray-50 text-sm"
                            >
                                Editar
                            </button>

                            <button
                                type="button"
                                wire:click="excluir({{ $m->id }})"
                                wire:confirm="Tem certeza que deseja excluir esta manutenção?"
                                class="px-3 py-1.5 rounded-lg border border-red-200 text-red-700 hover:bg-red-50 text-sm"
                            >
                                Excluir
                            </button>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td class="py-3 px-4" colspan="7">
                        <span class="text-gray-400">Sem registros por enquanto.</span>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
