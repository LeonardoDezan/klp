<div class="w-full max-w-md bg-white p-8 rounded-xl shadow-lg">
    <div class="flex flex-col items-center gap-2 mb-2">
        <img src="{{ asset('storage/logo-klp.png') }}"
             alt="Logo KLP"
             class="h-52">
    </div>

    <form wire:submit.prevent="autenticar" class="space-y-4">
        <div>
            <label class="block text-sm font-medium">Login</label>
            <input type="text" wire:model.defer="login"
                   class="w-full border border-gray-300 rounded px-3 py-2 shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            @error('login') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium">CPF</label>
            <input type="text" wire:model.defer="cpf" maxlength="11"
                   class="w-full border border-gray-300 rounded px-3 py-2 shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            @error('cpf') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium">Senha</label>
            <input type="password" wire:model.defer="password"
                   class="w-full border border-gray-300 rounded px-3 py-2 shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            @error('password') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>

        @if ($erro)
            <div class="text-red-600 text-sm text-center font-semibold">
                {{ $erro }}
            </div>
        @endif

        <button type="submit"
                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 rounded transition">
            Entrar
        </button>
    </form>
</div>
