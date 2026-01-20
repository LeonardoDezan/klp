<div>
    @props([
    'action',                  // ex: salvar, atualizar, excluir
    'text' => 'Salvar',
    'type' => 'submit',         // submit (padrão) ou button
    'loadingText' => 'Processando...',
])

<button
    type="{{ $type }}"
    @if($type === 'button')
        wire:click="{{ $action }}"
    @endif
    wire:loading.attr="disabled"
    wire:target="{{ $action }}"
    {{ $attributes->merge([
        'class' => '
            bg-blue-600 hover:bg-blue-700 text-white
            px-6 py-2 rounded-lg
            disabled:opacity-50 disabled:cursor-not-allowed
        '
    ]) }}
>
    <span wire:loading.remove wire:target="{{ $action }}">
        {{ $text }}
    </span>

    <span wire:loading wire:target="{{ $action }}">
        {{ $loadingText }}
    </span>
</button>

</div>