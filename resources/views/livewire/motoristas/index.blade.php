<div class="max-w-6xl mx-auto p-4">
    <livewire:alerta-mensagem />

    {{-- Filtros / Ações --}}
    <div class="flex flex-col sm:flex-row sm:items-end gap-3 mb-4">
        <div class="flex-1">
            <label class="block text-xs text-gray-600 mb-1">Buscar</label>
            <input type="text" wire:model.debounce.400ms="busca"
                   placeholder="Nome, CPF, RG ou telefone"
                   class="w-full px-3 py-2 rounded border border-gray-300 focus:outline-none focus:ring-2 focus:ring-yellow-400 text-sm">
        </div>

        <div>
            <label class="block text-xs text-gray-600 mb-1">Vínculo</label>
            <select wire:model="vinculo"
                    class="px-3 py-2 rounded border border-gray-300 focus:outline-none focus:ring-2 focus:ring-yellow-400 text-sm">
                <option value="">Todos</option>
                <option value="funcionario">Funcionário</option>
                <option value="agregado">Agregado</option>
                <option value="terceiro">Terceiro</option>
            </select>
        </div>

        <div class="flex items-center gap-2">
            <input id="somenteAtivos" type="checkbox" wire:model="somenteAtivos"
                   class="rounded border-gray-300 text-yellow-500 focus:ring-yellow-400">
            <label for="somenteAtivos" class="text-sm text-gray-700 select-none">Somente ativos</label>
        </div>

        <a href="{{ route('motoristas.create') }}"
           class="inline-flex items-center justify-center px-4 py-2 rounded bg-blue-600 hover:bg-blue-700 text-white text-sm">
            + Novo motorista
        </a>
    </div>

    {{-- Grid de Cards --}}
    @if ($motoristas->count())
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach ($motoristas as $m)
                <div class="bg-white rounded-xl shadow p-4 border border-gray-100 flex flex-col">
                    {{-- Cabeçalho do card --}}
                    <div class="flex items-start justify-between gap-3">
                        <div>
                            <h3 class="text-base font-semibold text-gray-800">
                                {{ $m->nome_completo }}
                            </h3>
                            <p class="text-xs text-gray-500 mt-0.5">
                                CPF:
                                {{ preg_replace('/(\d{3})(\d{3})(\d{3})(\d{2})/', '$1.$2.$3-$4', $m->cpf) }}
                                @if($m->rg)
                                    &middot; RG: {{ $m->rg }}
                                @endif
                            </p>
                        </div>

                        {{-- Status (toggle) --}}
                        <button wire:click="toggleAtivo({{ $m->id }})"
                                class="px-2 py-1 rounded text-[11px] font-medium
                                {{ $m->ativo ? 'bg-green-100 text-green-700' : 'bg-gray-200 text-gray-700' }}">
                            {{ $m->ativo ? 'Ativo' : 'Inativo' }}
                        </button>
                    </div>

                    {{-- Informações principais --}}
                    <dl class="mt-3 grid grid-cols-1 gap-2 text-sm text-gray-700">
                        <div class="flex items-center justify-between">
                            <dt class="text-gray-500">Vínculo</dt>
                            <dd class="px-2 py-0.5 rounded-full text-xs capitalize
                                @switch($m->vinculo)
                                    @case('funcionario') bg-blue-50 text-blue-700 @break
                                    @case('agregado') bg-purple-50 text-purple-700 @break
                                    @case('terceiro') bg-amber-50 text-amber-700 @break
                                    @default bg-gray-100 text-gray-600
                                @endswitch">
                                {{ $m->vinculo }}
                            </dd>
                        </div>

                        @if($m->telefone || $m->telefone_referencia)
                            <div class="flex items-center justify-between">
                                <dt class="text-gray-500">Telefone</dt>
                                <dd>
                                    @if($m->telefone)
                                        <span class="whitespace-nowrap">{{ $m->telefone }}</span>
                                    @endif
                                    @if($m->telefone_referencia)
                                        <span class="text-gray-400 mx-1">•</span>
                                        <span class="whitespace-nowrap">{{ $m->telefone_referencia }}</span>
                                    @endif
                                </dd>
                            </div>
                        @endif

                        @if($m->nome_referencia)
                            <div class="flex items-center justify-between">
                                <dt class="text-gray-500">Referência</dt>
                                <dd class="text-right">{{ $m->nome_referencia }}</dd>
                            </div>
                        @endif

                        @if($m->cidade_nascimento || $m->uf_nascimento)
                            <div class="flex items-center justify-between">
                                <dt class="text-gray-500">Nascimento (cidade/UF)</dt>
                                <dd class="text-right">
                                    {{ $m->cidade_nascimento }}{{ $m->cidade_nascimento && $m->uf_nascimento ? ' - ' : '' }}{{ $m->uf_nascimento }}
                                </dd>
                            </div>
                        @endif

                        @if($m->data_nascimento)
                            <div class="flex items-center justify-between">
                                <dt class="text-gray-500">Data de nascimento</dt>
                                <dd class="text-right">{{ optional($m->data_nascimento)->format('d/m/Y') }}</dd>
                            </div>
                        @endif

                        @if($m->data_validade_cnh)
                            <div class="flex items-center justify-between">
                                <dt class="text-gray-500">Validade CNH</dt>
                                <dd class="text-right">{{ optional($m->data_validade_cnh)->format('d/m/Y') }}</dd>
                            </div>
                        @endif

                        @if($m->chave_pix)
                            <div class="flex items-center justify-between">
                                <dt class="text-gray-500">Chave PIX</dt>
                                <dd class="text-right truncate max-w-[180px]" title="{{ $m->chave_pix }}">{{ $m->chave_pix }}</dd>
                            </div>
                        @endif

                        @if($m->data_admissao)
                            <div class="flex items-center justify-between">
                                <dt class="text-gray-500">Admissão</dt>
                                <dd class="text-right">{{ optional($m->data_admissao)->format('d/m/Y') }}</dd>
                            </div>
                        @endif

                        @if(!is_null($m->salario))
                            <div class="flex items-center justify-between">
                                <dt class="text-gray-500">Salário</dt>
                                <dd class="text-right">R$ {{ number_format($m->salario, 2, ',', '.') }}</dd>
                            </div>
                        @endif
                    </dl>

                    {{-- Seguros (múltiplos) --}}
                    <div class="mt-4">
                        <h4 class="text-xs font-semibold text-gray-600 uppercase tracking-wide">Seguros</h4>
                        @if($m->seguros->count())
                            <ul class="mt-1 space-y-1">
                                @foreach($m->seguros as $seg)
                                    <li class="flex items-center justify-between text-sm">
                                        <span class="text-gray-700">{{ $seg->gerenciadora_risco }}</span>
                                        <span class="text-gray-500">{{ optional($seg->validade_em)->format('d/m/Y') }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <p class="text-xs text-gray-400 mt-1">Nenhum seguro cadastrado.</p>
                        @endif
                    </div>

                    {{-- Ações --}}
                    <div class="mt-4 flex items-center justify-end gap-2">
                        @if ($confirmandoExclusaoId === $m->id)
                            <div class="bg-red-50 border border-red-200 text-red-700 p-2 rounded w-full">
                                <p class="text-xs">Tem certeza que deseja excluir <b>{{ $m->nome_completo }}</b>?</p>
                                <div class="flex gap-2 mt-2 justify-end">
                                    <button wire:click="excluir({{ $m->id }})"
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
                            <a href="#"
                               class="px-3 py-1.5 rounded bg-yellow-100 text-yellow-800 hover:bg-yellow-200 text-xs">
                                Editar
                            </a>
                            <button wire:click="confirmarExclusao({{ $m->id }})"
                                    class="px-3 py-1.5 rounded bg-red-100 text-red-700 hover:bg-red-200 text-xs">
                                Excluir
                            </button>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-4">
            {{ $motoristas->onEachSide(1)->links() }}
        </div>
    @else
        <div class="bg-white rounded-xl shadow p-6 text-center text-gray-500">
            Nenhum motorista encontrado.
        </div>
    @endif
</div>
