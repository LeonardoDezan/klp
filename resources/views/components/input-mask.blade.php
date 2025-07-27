<div class="mb-4" x-data>
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
        @if(($type ?? 'text') !== 'time') x-mask="{{ $mask }}" @endif
        class="w-full px-3 py-2 rounded border border-gray-300 focus:outline-none focus:ring-2 focus:ring-yellow-400 bg-white text-sm"
    >

    @error($model)
    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
    @enderror
</div>
