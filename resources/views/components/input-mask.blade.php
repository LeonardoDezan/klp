@props([
    'label' => null,
    'name',
    'model',
    'mask' => null,
    'type' => 'text',
])

<div class="mb-4"
     x-data="{
        getCpfCnpjMask(value) {
            const digits = (value || '').replace(/\D/g, '');
            return digits.length > 11
                ? '99.999.999/9999-99'
                : '999.999.999-99';
        }
     }"
>
    @if($label)
        <label for="{{ $name }}" class="block text-sm font-medium text-gray-700 mb-1">
            {{ $label }}
        </label>
    @endif

    <input
        type="{{ $type ?? 'text' }}"
        name="{{ $name }}"
        id="{{ $name }}"
        wire:model.defer="{{ $model }}"

        @if(($type ?? 'text') !== 'time')
            @if($mask === 'cpf_cnpj')
                x-mask:dynamic="(value) => getCpfCnpjMask(value)"
            @elseif($mask)
                x-mask="{{ $mask }}"
            @endif
        @endif

        {{ $attributes->merge([
            'class' => 'w-full px-3 py-2 rounded border border-gray-300 focus:outline-none focus:ring-2 focus:ring-yellow-400 bg-white text-sm'
        ]) }}
    >

    @error((string) $model)
        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
    @enderror
</div>
