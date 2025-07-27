<div class="max-w-3xl mx-auto p-4 bg-white rounded shadow space-y-6">
    <livewire:alerta-mensagem />

    {{-- Formulário --}}
    <h2 class="text-lg font-semibold">Cadastrar novo usuário</h2>
    <form wire:submit.prevent="salvar" class="space-y-4">
        <x-input-uppercase label="Login" model="formulario.login" name="login" placeholder="Digite um Login" required />
        <div>
            <label for="cpf" class="block text-sm font-medium text-gray-700">CPF</label>
            <input
                maxlength="11"
                type="text"
                id="cpf"
                wire:model.defer="formulario.cpf"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                placeholder="Somente Números"
            >
            @error('formulario.cpf') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>
        <x-input-uppercase label="Nome" model="formulario.name" name="name" placeholder="Nome Completo" required />
        <x-input-uppercase label="Senha" model="formulario.password" name="password" type="password" required />
        <x-input-uppercase label="Confirmar Senha" model="senhaConfirmada" name="senhaConfirmada" type="password" required />

        <button class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded w-full">
            Salvar Usuário
        </button>
    </form>

    {{-- Lista de usuários --}}
    <h2 class="text-lg font-semibold">Usuários cadastrados</h2>
    <ul class="divide-y border rounded">
        @forelse ($usuarios as $usuario)
            <li class="p-3 flex justify-between items-center">
                <div>
                    <p class="font-medium">{{ $usuario->name }}</p>
                    <p class="text-sm text-gray-500">Login: {{ $usuario->login }} | CPF: {{ $usuario->cpf }}</p>
                </div>

                @if ($confirmandoExclusaoId === $usuario->id)
                    <div class="flex gap-2">
                        <button wire:click="excluirUsuario({{ $usuario->id }})"
                                class="px-2 py-1 text-white bg-red-600 rounded text-sm hover:bg-red-700">
                            Confirmar
                        </button>
                        <button wire:click="cancelarExclusao"
                                class="px-2 py-1 bg-gray-300 text-gray-800 rounded text-sm hover:bg-gray-400">
                            Cancelar
                        </button>
                    </div>
                @else
                    <button wire:click="confirmarExclusao({{ $usuario->id }})"
                            class="text-red-500 hover:text-red-700 text-sm">
                        Excluir
                    </button>
                @endif
            </li>
        @empty
            <li class="p-3 text-center text-gray-500">Nenhum usuário cadastrado</li>
        @endforelse
    </ul>
</div>
