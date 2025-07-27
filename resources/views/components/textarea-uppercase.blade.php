<div class="mb-4">
    @if($label)
        <label for="{{ $name }}" class="block text-sm font-medium text-gray-700 mb-1">
            {{ $label }}
        </label>
    @endif

    <textarea
        name="{{ $name }}"
        id="{{ $name }}"
        rows="{{ $rows }}"
        wire:model.defer="{{ $model }}"
        oninput="this.value = this.value.toUpperCase();"
        class="w-full px-3 py-2 rounded border border-gray-300 focus:outline-none focus:ring-2 focus:ring-yellow-400 bg-white text-sm resize-none"
    ></textarea>

    @error($model)
    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
    @enderror
</div>
