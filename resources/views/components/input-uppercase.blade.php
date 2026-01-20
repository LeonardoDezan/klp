@props([
    'label' => null,
    'model',
    'name',
    'type' => 'text',
    'placeholder' => '',
    'required' => false,
])

<div class="w-full">
    @if ($label)
        <label for="{{ $name }}" class="block text-sm font-medium text-gray-700 mb-1">
            {{ $label }}
            @if ($required)
                <span class="text-red-500">*</span>
            @endif
        </label>
    @endif

    <input
        id="{{ $name }}"
        name="{{ $name }}"
        type="{{ $type }}"
        placeholder="{{ $placeholder }}"
        wire:model.defer="{{ $model }}"
        oninput="this.value = this.value.toUpperCase();"
        {{ $required ? 'required' : '' }}
        {{ $attributes->merge([
            'class' => 'w-full px-3 py-2 rounded border border-gray-300 focus:outline-none focus:ring-2 focus:ring-yellow-400 bg-white text-sm'
        ]) }}
    >

    @error((string) $model)
        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
    @enderror
</div>
