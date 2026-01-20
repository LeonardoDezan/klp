<div class="space-y-6">

    {{-- Filtros --}}
    <div class="bg-gray-50 border border-gray-200 rounded-xl p-4 space-y-4">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Placa</label>
                <input
                    type="text"
                    wire:model.live="placa"
                    class="w-full px-3 py-2 rounded border border-gray-300 focus:outline-none focus:ring-2 focus:ring-yellow-400 bg-white text-sm"
                    placeholder="Ex: ABC1D23"
                >
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Proprietário</label>
                <input
                    type="text"
                    wire:model.live="proprietario"
                    class="w-full px-3 py-2 rounded border border-gray-300 focus:outline-none focus:ring-2 focus:ring-yellow-400 bg-white text-sm"
                    placeholder="Nome do proprietário"
                >
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Vínculo</label>
                <select
                    wire:model.live="vinculo"
                    class="w-full px-3 py-2 rounded border border-gray-300 focus:outline-none focus:ring-2 focus:ring-yellow-400 bg-white text-sm"
                >
                    <option value="">Todos</option>
                    <option value="proprio">Próprio</option>
                    <option value="agregado">Agregado</option>
                    <option value="terceiro">Terceiro</option>
                </select>
            </div>

        </div>

        <div class="flex justify-end">
            <button
                type="button"
                wire:click="limparFiltros"
                class="px-4 py-2 rounded-lg border border-gray-300 hover:bg-white text-sm"
            >
                Limpar filtros
            </button>
        </div>
    </div>

    {{-- Tabela --}}
    <div class="overflow-x-auto border border-gray-200 rounded-xl">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr class="text-left text-sm font-medium text-gray-700">
                    <th class="px-4 py-3">Placa</th>
                    <th class="px-4 py-3">Renavam</th>
                    <th class="px-4 py-3">Proprietário</th>
                    <th class="px-4 py-3">Documento</th>
                    <th class="px-4 py-3">Vínculo</th>
                    <th class="px-4 py-3">Chassi</th>
                    <th class="px-4 py-3">Tipo</th>
                    <th class="px-4 py-3 text-right">Ações</th>
                </tr>
            </thead>

            <tbody class="bg-white divide-y divide-gray-100 text-sm">
                @forelse ($veiculos as $v)
                    @php
                        // Formatar CPF/CNPJ somente para exibição
                        $doc = $v->proprietario_documento ? preg_replace('/\D/', '', $v->proprietario_documento) : '';
                        if (strlen($doc) === 11) {
                            $docFormatado = preg_replace('/(\d{3})(\d{3})(\d{3})(\d{2})/', '$1.$2.$3-$4', $doc);
                        } elseif (strlen($doc) === 14) {
                            $docFormatado = preg_replace('/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/', '$1.$2.$3/$4-$5', $doc);
                        } else {
                            $docFormatado = $v->proprietario_documento ?? '-';
                        }
                    @endphp

                    <tr>
                        <td class="px-4 py-3 font-semibold">{{ $v->placa }}</td>
                        <td class="px-4 py-3">{{ $v->renavam ?? '-' }}</td>
                        <td class="px-4 py-3">{{ $v->proprietario_nome }}</td>
                        <td class="px-4 py-3">{{ $docFormatado ?: '-' }}</td>
                        <td class="px-4 py-3 uppercase">{{ $v->vinculo }}</td>
                        <td class="px-4 py-3">{{ $v->chassi ?? '-' }}</td>
                        <td class="px-4 py-3">{{ $v->tipo }}</td>

                        {{-- Ações --}}
                        <td class="px-4 py-3">
                            <div class="flex justify-end gap-2">

                                <a
                                    href="{{ route('veiculos.show', ['veiculo' => $v->id]) }}"
                                    class="px-3 py-1.5 rounded-lg border border-gray-300 hover:bg-gray-50 text-sm"
                                >
                                    Ver
                                </a>

                                <a
                                    href="{{ route('veiculos.edit', $v->id) }}"
                                    class="px-3 py-1.5 rounded-lg bg-blue-600 hover:bg-blue-700 text-white text-sm"
                                >
                                    Editar
                                </a>

                                {{-- Excluir (ação Livewire) --}}
                                <x-button-action
                                    action="excluir({{ $v->id }})"
                                    text="Excluir"
                                    type="button"
                                    class="bg-red-600 hover:bg-red-700 px-3 py-1.5"
                                    onclick="return confirm('Confirma a exclusão deste veículo?');"
                                />
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="px-4 py-6 text-center text-gray-500">
                            Nenhum veículo encontrado com os filtros atuais.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Paginação --}}
    <div>
        {{ $veiculos->links() }}
    </div>

</div>
