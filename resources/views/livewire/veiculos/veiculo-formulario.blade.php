<div class="max-w-4xl">

    <form wire:submit.prevent="salvar" class="space-y-10">

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

            <x-input-uppercase
                label="Placa"
                name="placa"
                model="placa"
                class="w-full"
                required="true"
                maxlength="7"
                placeholder="Digite a placa"
            />

            <x-input-uppercase
                label="Renavam"
                name="renavam"
                model="renavam"
                class="w-full"
                maxlength="11"
            />

            <x-input-uppercase
                label="Proprietário (nome)"
                name="proprietario_nome"
                model="proprietario_nome"
                class="w-full"
                required="true"
            />

            <x-input-mask
                label="CNPJ/CPF do proprietário"
                name="proprietario_documento"
                model="proprietario_documento"
                mask="cpf_cnpj"
            />

            <div>
                <label class="block text-sm font-medium text-gray-700">
                    Vínculo <span class="text-red-500">*</span>
                </label>

                <select
                    wire:model.defer="vinculo"
                    name="vinculo"
                    class="w-full px-3 py-2 rounded border border-gray-300 focus:outline-none focus:ring-2 focus:ring-yellow-400 bg-white text-sm mt-1"
                >
                    <option value="">Selecione</option>
                    <option value="proprio">Próprio</option>
                    <option value="agregado">Agregado</option>
                    <option value="terceiro">Terceiro</option>
                </select>

                @error('vinculo')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <x-input-uppercase
                label="Chassi"
                name="chassi"
                model="chassi"
                class="w-full"
                maxlength="17"
            />

            <x-input-uppercase
                label="Tipo do veículo"
                name="tipo"
                model="tipo"
                class="w-full"
                required="true"
            />

        </div>

        <div class="flex justify-end pt-6 border-t border-gray-200">
            <x-button-action
                action="salvar"
                text="{{ $veiculoId ? 'Atualizar veículo' : 'Salvar veículo' }}"
            />
        </div>

    </form>
</div>
