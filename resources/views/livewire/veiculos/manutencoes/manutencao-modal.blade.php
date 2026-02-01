<div> 
   @if($aberto)
        <div class="fixed inset-0 z-50 flex items-center justify-center">
            <div class="absolute inset-0 bg-black/40" wire:click="fechar"></div>

            <div class="relative w-full max-w-xl mx-4 bg-white rounded-2xl shadow-xl p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-800">Nova manutenção</h3>
                    <button type="button" wire:click="fechar" class="text-gray-500 hover:text-gray-800">✕</button>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                    <div>
                        <label class="text-sm text-gray-600">Tipo documento</label>
                        <select wire:model.defer="tipo_documento"
                                class="mt-1 w-full rounded-lg border-gray-300 focus:border-gray-900 focus:ring-gray-900">
                            <option value="">Selecione</option>
                            <option value="NF">NF</option>
                            <option value="OS">OS</option>
                            <option value="RECIBO">RECIBO</option>
                        </select>
                        @error('tipo_documento') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="text-sm text-gray-600">Número</label>
                        <input type="text" wire:model.defer="numero_documento"
                            class="mt-1 w-full rounded-lg border-gray-300 focus:border-gray-900 focus:ring-gray-900" />
                        @error('numero_documento') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="text-sm text-gray-600">Data</label>
                        <input type="date" wire:model.defer="data"
                            class="mt-1 w-full rounded-lg border-gray-300 focus:border-gray-900 focus:ring-gray-900" />
                        @error('data') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="text-sm text-gray-600">Categoria</label>
                        <select wire:model.defer="categoria"
                                class="mt-1 w-full rounded-lg border-gray-300 focus:border-gray-900 focus:ring-gray-900">
                            <option value="PECAS">Peças</option>
                            <option value="SERVICO_EXTERNO">Serviço Externo</option>
                            <option value="SERVICO_INTERNO">Serviço Interno</option>
                        </select>
                        @error('categoria') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label class="text-sm text-gray-600">Descrição</label>
                        <textarea rows="3" wire:model.defer="descricao"
                                class="mt-1 w-full rounded-lg border-gray-300 focus:border-gray-900 focus:ring-gray-900"></textarea>
                        @error('descricao') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="text-sm text-gray-600">KM</label>
                        <input type="number" wire:model.defer="km"
                            class="mt-1 w-full rounded-lg border-gray-300 focus:border-gray-900 focus:ring-gray-900" />
                        @error('km') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="text-sm text-gray-600">Valor total</label>
                        <input type="number" step="0.01" wire:model.defer="valor_total"
                            class="mt-1 w-full rounded-lg border-gray-300 focus:border-gray-900 focus:ring-gray-900" />
                        @error('valor_total') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label class="text-sm text-gray-600">Fornecedor</label>
                        <input type="text" wire:model.defer="fornecedor"
                            class="mt-1 w-full rounded-lg border-gray-300 focus:border-gray-900 focus:ring-gray-900" />
                        @error('fornecedor') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="flex items-center justify-end gap-2 mt-6">
                    <button type="button" wire:click="fechar"
                            class="px-4 py-2 rounded-lg border border-gray-300 text-sm hover:bg-gray-50">
                        Cancelar
                    </button>

                    <button type="button" wire:click="salvar"
                            wire:loading.attr="disabled"
                            wire:target="salvar"
                            class="px-4 py-2 rounded-lg bg-gray-900 text-white text-sm hover:bg-gray-800 disabled:opacity-50">
                        <span wire:loading.remove wire:target="salvar">Salvar</span>
                        <span wire:loading wire:target="salvar">Salvando...</span>
                    </button>
                </div>
            </div>
        </div>
    @endif

</div>