<div>
    <div class="max-w-2xl mx-auto p-4 bg-gray-50 shadow rounded-lg">

        {{-- Aviso de erros --}}
        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded mb-4">
                <strong>⚠️ Há erros no formulário. Corrija-os para continuar.</strong>
            </div>
        @endif

        {{-- Alerta de sucesso --}}
        <livewire:alerta-mensagem />

        <form wire:submit.prevent="save" class="space-y-4">

            {{-- Nome do Representante --}}
            <x-input-uppercase label="Nome da Representação" name="nome" model="nome" />

            {{-- Observação --}}
            <x-textarea-uppercase label="Observações" name="observacao" model="observacao"/>

            {{-- Contatos --}}
            <div>
                <h3 class="font-semibold mb-2">Contatos</h3>

                @foreach ($contatos as $index => $contato)
                    <div class="border p-3 mb-2 rounded bg-gray-50 space-y-2">

                        {{-- Nome do Contato --}}
                        <x-input-uppercase
                            label="Nome do Contato"
                            name="contatos.{{ $index }}.nome"
                            model="contatos.{{ $index }}.nome"
                            :error="$errors->first('contatos.' . $index . '.nome')"
                        />

                        {{-- Email do Contato --}}
                        <x-input-uppercase
                            type="email"
                            label="Email"
                            name="contatos.{{ $index }}.email"
                            model="contatos.{{ $index }}.email"
                            :error="$errors->first('contatos.' . $index . '.email')"
                        />

                        {{-- Telefone com máscara --}}
                        <x-input-mask
                            label="Telefone"
                            name="contatos.{{ $index }}.telefone"
                            model="contatos.{{ $index }}.telefone"
                            mask="(99) 99999-9999"
                        />

                        {{-- Remover contato --}}
                        <button
                            type="button"
                            wire:click="removeContato({{ $index }})"
                            class="text-red-500 mt-1 text-sm hover:underline"
                        >
                            Remover
                        </button>
                    </div>
                @endforeach

                <button
                    type="button"
                    wire:click="addContato"
                    class="text-sm text-blue-500 hover:underline"
                >
                    + Adicionar Contato
                </button>
            </div>

            <button
                type="submit"
                class="bg-yellow-400 text-black px-4 py-2 rounded hover:bg-yellow-500"
            >
                Salvar
            </button>
        </form>
    </div>
</div>
