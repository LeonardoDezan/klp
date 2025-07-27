<div
    x-data="{
        visivel: @entangle('visivel'),
        tipo: @entangle('tipo'),
    }"
    x-show="visivel"
    x-transition
    @click.away="visivel = false"
    class="fixed top-4 right-4 z-50 flex items-center justify-between px-4 py-3 rounded shadow-md text-white text-sm w-auto max-w-sm"
    :class="{
        'bg-green-600': tipo === 'success',
        'bg-red-600': tipo === 'error',
        'bg-yellow-500': tipo === 'warning',
        'bg-blue-600': tipo === 'info'
    }"
    style="display: none;"
>
    <span>{{ $mensagem }}</span>

    <button
        wire:click="ocultarMensagem"
        class="ml-4 text-white font-bold focus:outline-none"
        title="Fechar"
    >
        &times;
    </button>
</div>

