<div>
    <div class="mb-6">
        <input
            type="text"
            wire:model.live.debounce.500ms="search"
            placeholder="Buscar por razão social, nome fantasia, cidade, CNPJ ou endereço..."
            class="w-full px-4 py-2 border border-gray-300 rounded shadow-sm focus:outline-none focus:ring-2 focus:ring-yellow-400"
        />
    </div>
    <div>
        @forelse ($clientes as $cliente)
            <div class="bg-white rounded-xl shadow-sm p-4 mb-4 border border-gray-200 relative">

                {{-- Botões de ação --}}
                <div class="absolute top-4 right-4 flex space-x-2">

                    <div class="flex flex-col gap-2">
                        @if ($confirmandoExclusaoId === $cliente->id)
                            <div class="bg-red-100 text-red-800 p-2 rounded shadow text-xs">
                                <p>Tem certeza que deseja excluir?</p>
                                <div class="flex gap-2 mt-2">
                                    <button wire:click="excluirCliente({{ $cliente->id }})"
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
                                <a href="{{ route('clientes.editar', $cliente->id) }}"
                                   class="bg-blue-600 hover:bg-blue-500 text-white text-xs px-3 py-1 rounded shadow">
                                    ✎ Editar
                                </a>
                                <button wire:click="confirmarExclusao({{ $cliente->id }})"
                                        class="bg-red-600 hover:bg-red-500 text-white text-xs px-3 py-1 rounded shadow">
                                    🗑 Excluir
                                </button>
                            </div>
                        @endif
                    </div>


                </div>

                {{-- Razão Social --}}
                <h2 class="text-xl font-bold text-gray-900 mb-2 pr-24">
                    {{ $cliente->razao_social }}
                </h2>

                {{-- GRID responsivo: 1 coluna em mobile, 2 colunas em md+ --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-gray-700">

                    {{-- COLUNA ESQUERDA – dados principais --}}
                    <div class="space-y-1 order-1 md:order-1">
                        <p><strong>Endereço:</strong> {{ $cliente->endereco ?? '–' }}</p>
                        <p><strong>Cidade:</strong> {{ $cliente->cidade }} - {{ $cliente->uf }}</p>
                        <p>
                            <strong>Localização:</strong>
                            @if (!empty($cliente->localizacao))
                                <a href="{{ $cliente->localizacao }}" target="_blank" class="text-blue-600 underline text-sm">
                                    Ver no mapa
                                </a>
                            @else
                                <span class="text-gray-400 italic">Não informado</span>
                            @endif
                        </p>
                        <p><strong>Tipos de Veículo:</strong> {{ $cliente->tipos_veiculos }}</p>
                        <p><strong>Segunda a Sexta:</strong>
                            {{ $cliente->inicio_semana ? \Carbon\Carbon::parse($cliente->inicio_semana)->format('H:i') : '–' }}
                            às
                            {{ $cliente->parada_semana ? \Carbon\Carbon::parse($cliente->parada_semana)->format('H:i') : '–' }}
                            |
                            {{ $cliente->retorno_semana ? \Carbon\Carbon::parse($cliente->retorno_semana)->format('H:i') : '–' }}
                            às
                            {{ $cliente->fim_semana ? \Carbon\Carbon::parse($cliente->fim_semana)->format('H:i') : '–' }}
                        </p>

                        <p><strong>Sábado:</strong>
                            {{ $cliente->inicio_sabado ? \Carbon\Carbon::parse($cliente->inicio_sabado)->format('H:i') : '–' }}
                            às
                            {{ $cliente->parada_sabado ? \Carbon\Carbon::parse($cliente->parada_sabado)->format('H:i') : '–' }}
                            |
                            {{ $cliente->retorno_sabado ? \Carbon\Carbon::parse($cliente->retorno_sabado)->format('H:i') : '–' }}
                            às
                            {{ $cliente->fim_sabado ? \Carbon\Carbon::parse($cliente->fim_sabado)->format('H:i') : '–' }}
                        </p>
                        <p><strong>Agendamento:</strong> {{ $cliente->agendamento }}</p>
                        <p><strong>Informações de Descarga:</strong> {{ $cliente->informacoes_descarga }}</p>
                        <p><strong>Observações Gerais:</strong> {{ $cliente->observacoes }}</p>
                    </div>

                    {{-- COLUNA DIREITA – representantes e contatos --}}
                    <div class="space-y-1 order-2 md:order-2">

                        {{-- representantes e seus contatos --}}
                        @if($cliente->representantes->isNotEmpty())
                            <div>
                                <p class="font-semibold text-sm text-gray-800">Representantes:</p>
                                @foreach ($cliente->representantes as $representante)
                                    <div class="ml-2 mt-1">
                                        <p class="text-sm text-gray-900 font-medium">{{ $representante->nome }}</p>

                                        @if($representante->representante_contatos->isNotEmpty())
                                            <ul class="list-disc pl-4 text-sm text-gray-600">
                                                @foreach ($representante->representante_contatos as $contato)
                                                    <li>
                                                        {{ $contato->nome }}
                                                        @if($contato->cargo) ({{ $contato->cargo }}) @endif
                                                        @if($contato->telefone) – {{ $contato->telefone }} @endif
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        {{-- Contatos do cliente --}}
                        @if($cliente->contatos->isNotEmpty())
                            <div>
                                <p class="font-semibold text-sm text-gray-800">Contatos do Cliente:</p>
                                <ul class="list-disc pl-4 text-sm text-gray-600">
                                    @foreach ($cliente->contatos as $contato)
                                        <li>
                                            {{ $contato->nome }}
                                            @if($contato->cargo) ({{ $contato->cargo }}) @endif
                                            @if($contato->telefone) – {{ $contato->telefone }} @endif
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="text-gray-600">Nenhum cliente encontrado.</div>
        @endforelse
    </div>
    <div class="mt-4">
        {{ $clientes->links('components.pagination.custom') }}
    </div>
</div>

