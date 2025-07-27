<div>
    <div class="mb-4 flex gap-2">

        <input
            type="text"
            wire:model.live.debounce.500ms="search"
            placeholder="Buscar representante, contato, telefone ou email..."
            class="w-full px-4 py-2 border border-gray-300 rounded shadow-sm focus:outline-none focus:ring-1 focus:ring-yellow-100 focus:border-yellow-400 placeholder-gray-400"
        />
    </div>

    <div class="overflow-x-auto rounded-lg shadow-md">
        <table class="min-w-full text-sm text-left text-gray-700">
            <thead class="bg-gray-100 text-gray-700 uppercase text-xs border-b border-gray-300">
            <tr>
                <th class="px-4 py-3 whitespace-nowrap">Nome</th>
                <th class="px-4 py-3 whitespace-nowrap">Contatos</th>
                <th class="px-4 py-3 whitespace-nowrap">Ações</th>
            </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
            @foreach ($representantes as $representante)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-4 py-3 align-top font-semibold text-gray-900">
                        {{ $representante->nome ?? '' }}
                    </td>
                    <td class="px-4 py-3 align-top space-y-2">
                        @foreach ($representante->representante_contatos as $contato)
                            <div class="p-3 bg-white border border-gray-200 rounded-lg shadow-sm">
                                <div class="font-medium text-gray-900">{{ $contato->nome ?? '—' }}</div>
                                <div class="text-sm text-gray-600 flex items-center gap-1">
                                    📞 {{ formatarTelefone($contato->telefone ?? '') }}
                                </div>
                                <div class="text-sm text-gray-600 flex items-center gap-1">
                                    ✉️ {{ $contato->email ?? '—' }}
                                </div>
                            </div>
                        @endforeach
                    </td>
                    <td class="px-4 py-3 align-top">
                        <div class="flex flex-wrap gap-2">

                            <div class="flex flex-col gap-2">
                                @if ($confirmandoExclusaoId === $representante->id)
                                    <div class="bg-red-100 text-red-800 p-2 rounded shadow text-sm">
                                        <p>Tem certeza que deseja excluir?</p>
                                        <div class="flex gap-2 mt-2">
                                            <button wire:click="excluirRepresentante({{ $representante->id }})"
                                                    class="px-2 py-1 bg-red-600 text-white rounded hover:bg-red-700 text-xs">
                                                Confirmar
                                            </button>
                                            <button wire:click="cancelarExclusao"
                                                    class="px-2 py-1 bg-gray-300 text-gray-800 rounded hover:bg-gray-400 text-xs">
                                                Cancelar
                                            </button>
                                        </div>

                                    </div>
                                @else
                                    <div class="flex gap-2">
                                        <button wire:click="editar({{ $representante->id }})" class="bg-gray-600 text-white px-3 py-1 rounded hover:bg-yellow-400 hover:text-black text-xs transition">
                                            Editar
                                        </button>
                                        <button wire:click="confirmarExclusao({{ $representante->id }})"
                                                class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600 text-xs transition">
                                            Excluir
                                        </button>
                                    </div>
                                @endif
                            </div>

                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

    </div>

    @if ($representantes instanceof \Illuminate\Pagination\LengthAwarePaginator)
        {{ $representantes->links('components.pagination.custom') }}
    @endif

</div>
