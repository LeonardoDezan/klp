<div class="bg-white p-6 rounded-xl shadow max-w-4xl mx-auto space-y-6">
    {{--  Formulario de Importação de XML  --}}
    <form wire:submit.prevent="carregarXml" enctype="multipart/form-data" class="flex flex-col sm:flex-row items-start sm:items-center gap-2 sm:gap-4">
        <input
            type="file"
            wire:model="arquivoXml"
            accept=".xml"
            class="block text-sm text-gray-700
               border border-gray-300 rounded-md shadow-sm
               focus:border-blue-500 focus:ring-blue-500"
        >

        <button
            type="submit"
            class="px-4 py-2 bg-blue-600 hover:bg-blue-700
               text-white font-semibold rounded-md shadow-sm
               transition duration-150 ease-in-out"
        >
            Importar XML
        </button>
    </form>
    {{--  Formulario de Cadastro  --}}
    <form wire:submit.prevent="salvar" class="space-y-6">
        @csrf

        {{--  Dados da Empresa --}}
        <div>
            <h2 class="text-lg font-bold text-gray-800 mb-2 border-b border-gray-300 pb-1"> Dados da Empresa</h2>

            <div class="grid md:grid-cols-2 gap-4">
                <x-input-uppercase label="Razão Social *" name="razao_social" model="cliente.razao_social" />

                <x-input-uppercase label="Nome Fantasia" name="nome_fantasia" model="cliente.nome_fantasia" />

                <x-input-mask label="CNPJ/CPF *" name="documento" model="cliente.documento" mask="99.999.999/9999-99" />

            </div>
        </div>

        {{--  Endereço --}}
        <div>
            <h2 class="text-lg font-bold text-gray-800 mb-2 border-b border-gray-300 pb-1">📍 Endereço</h2>

            <div class="grid md:grid-cols-2 gap-4">
                <x-input-uppercase label="Endereço" name="endereco" model="cliente.endereco" />
                <x-input-uppercase label="Bairro" name="bairro" model="cliente.bairro" />
                <x-input-uppercase label="Cidade" name="cidade" model="cliente.cidade" />
                <x-select label="UF" name="uf" model="cliente.uf" :options="[
                        'AC' => 'AC', 'AL' => 'AL', 'AP' => 'AP', 'AM' => 'AM',
                        'BA' => 'BA', 'CE' => 'CE', 'DF' => 'DF', 'ES' => 'ES',
                        'GO' => 'GO', 'MA' => 'MA', 'MT' => 'MT', 'MS' => 'MS',
                        'MG' => 'MG', 'PA' => 'PA', 'PB' => 'PB', 'PR' => 'PR',
                        'PE' => 'PE', 'PI' => 'PI', 'RJ' => 'RJ', 'RN' => 'RN',
                        'RS' => 'RS', 'RO' => 'RO', 'RR' => 'RR', 'SC' => 'SC',
                        'SP' => 'SP', 'SE' => 'SE', 'TO' => 'TO']" />
            </div>
            <div class="mb-4">
                <label for="cliente-localizacao" class="block text-sm font-medium text-gray-700">Link de Localização</label>
                <input
                    type="url"
                    id="cliente-localizacao"
                    wire:model="cliente.localizacao"
                    placeholder="https://maps.google.com/..."
                    class="w-full px-3 py-2 rounded border border-gray-300 focus:outline-none focus:ring-2 focus:ring-yellow-400 bg-white text-sm"
                >
                @error('cliente.localizacao')
                <span class="text-red-500 text-xs">{{ $message }}</span>
                @enderror
            </div>

        </div>

        {{-- 🚛 Operação --}}
        <div>
            <h2 class="text-lg font-bold text-gray-800 mb-2 border-b border-gray-300 pb-1">🚛 Operação</h2>

            <div class="grid md:grid-cols-2 gap-4">
                <x-input-uppercase label="Tipos de Veículos" name="tipos_veiculos" model="cliente.tipos_veiculos" />


                <x-select label="Agendamento" name="agendamento" model="cliente.agendamento"
                          :options="['Sim' => 'Sim', 'Não' => 'Não']" />

                {{-- 🚧 Horário de Funcionamento --}}
                <div class="bg-white p-4 rounded-xl border border-gray-200 space-y-4">
                    <h2 class="text-lg font-bold text-gray-800 border-b border-gray-300 pb-1">
                        🚧 Horário de Funcionamento
                    </h2>

                    {{-- Segunda a Sexta --}}
                    <div>
                        <p class="font-semibold text-gray-800 mb-2">Segunda a Sexta-feira</p>
                        <div class="grid md:grid-cols-4 gap-4">
                            <x-input-time label="Início" model="cliente.inicio_semana" />
                            <x-input-time label="Parada" model="cliente.parada_semana" />
                            <x-input-time label="Retorno" model="cliente.retorno_semana" />
                            <x-input-time label="Fim" model="cliente.fim_semana" />
                        </div>
                    </div>

                    {{-- Sábado --}}
                    <div>
                        <p class="font-semibold text-gray-800 mb-2">Sábado</p>
                        <div class="grid md:grid-cols-4 gap-4">
                            <x-input-time label="Início" model="cliente.inicio_sabado" />
                            <x-input-time label="Parada" model="cliente.parada_sabado" />
                            <x-input-time label="Retorno" model="cliente.retorno_sabado" />
                            <x-input-time label="Fim" model="cliente.fim_sabado" />
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- 📦 Descarga e Observações --}}
        <div class="grid md:grid-cols-2 gap-4">
            <x-textarea-uppercase label="Informações de Descarga" name="informacoes_descarga" model="cliente.informacoes_descarga" rows="4" />
            <x-textarea-uppercase label="Observações" name="observacoes" model="cliente.observacoes" rows="4" />
        </div>

        {{-- 👥 representantes dinâmicos --}}
        <div>
            <h2 class="text-lg font-bold text-gray-800 mb-2 border-b border-gray-300 pb-1">👥 Representantes</h2>

            @foreach ($representantesSelecionados as $index => $linha)
                <div class="flex items-center gap-2 mb-2">
                    <select wire:model.defer="representantesSelecionados.{{ $index }}"
                            class="flex-1 border border-gray-400 rounded bg-gray-50 px-3 py-2">
                        <option value="">Selecione um representante</option>
                        @foreach($todosRepresentantes as $rep)
                            <option value="{{ $rep->id }}">{{ $rep->nome }}</option>
                        @endforeach
                    </select>

                    @if(count($representantesSelecionados) > 1)
                        <button type="button" wire:click="removerRepresentante({{ $index }})"
                                class="text-red-600 hover:text-red-800 text-sm">
                            ✖
                        </button>
                    @endif
                </div>
            @endforeach

            <button type="button" wire:click="adicionarRepresentante"
                    class="text-sm text-blue-600 hover:text-blue-800">
                + Adicionar Representante
            </button>
        </div>

        {{-- 👤 Contatos do Cliente --}}
        <div>
            <h2 class="text-lg font-bold text-gray-800 mb-2 border-b border-gray-300 pb-1">👤 Contatos do Cliente</h2>

            @foreach ($contatos as $index => $contato)
                <div class="grid md:grid-cols-4 gap-4 mb-2">
                    <x-input-uppercase label="Nome" model="contatos.{{ $index }}.nome" name="contatos_{{ $index }}_nome" />
                    <x-input-uppercase label="Cargo" model="contatos.{{ $index }}.cargo" name="contatos_{{ $index }}_cargo" />
                    <x-input-mask label="Telefone" model="contatos.{{ $index }}.telefone" name="contatos_{{ $index }}_telefone" mask="(99) 99999-9999" />
                    <x-input-uppercase label="Email" model="contatos.{{ $index }}.email" name="contatos_{{ $index }}_email" />
                </div>

                @if (count($contatos) > 1)
                    <div class="mb-4">
                        <button type="button" wire:click="removerContato({{ $index }})"
                                class="text-red-600 hover:text-red-800 text-sm">
                            ✖ Remover Contato
                        </button>
                    </div>
                @endif
            @endforeach

            <button type="button" wire:click="adicionarContato"
                    class="text-sm text-blue-600 hover:text-blue-800">
                + Adicionar Contato
            </button>
        </div>

        {{--  Botão Salvar --}}
        <div class="pt-4">
            <button type="submit"
                    class="bg-yellow-400 text-black px-4 py-2 rounded hover:bg-yellow-500">
                {{ $cliente['id'] ?? null ? 'Editar Cliente' : 'Salvar Cliente' }}
            </button>
        </div>

    </form>
</div>

