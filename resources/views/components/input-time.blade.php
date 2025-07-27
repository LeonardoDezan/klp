@props([
    'label' => null,
    'model' => null,
])

<div class="mb-4">
    @if($label)
        <label class="block text-sm font-medium text-gray-700 mb-1">
            {{ $label }}
        </label>
    @endif

    <input
            type="time"
            wire:model.defer="{{ $model }}"
            class="w-full px-2 py-1 rounded border border-gray-300 focus:outline-none focus:ring-2 focus:ring-yellow-400 bg-white text-sm"
    >

    @error($model)
    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
    @enderror
</div>
