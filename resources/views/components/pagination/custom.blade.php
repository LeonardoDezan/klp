@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center justify-center mt-4 space-x-2 text-sm">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <span class="px-3 py-1 bg-gray-200 text-gray-500 rounded cursor-not-allowed">
                &laquo; Anterior
            </span>
        @else
            <button wire:click="previousPage" class="px-3 py-1 bg-white border border-gray-300 rounded hover:bg-gray-100 transition">
                &laquo; Anterior
            </button>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <span class="px-3 py-1 text-gray-500">...</span>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span class="px-3 py-1 bg-yellow-400 text-gray-900 rounded font-semibold">{{ $page }}</span>
                    @else
                        <button wire:click="gotoPage({{ $page }})" class="px-3 py-1 bg-white border border-gray-300 rounded hover:bg-gray-100 transition">
                            {{ $page }}
                        </button>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <button wire:click="nextPage" class="px-3 py-1 bg-white border border-gray-300 rounded hover:bg-gray-100 transition">
                Próxima &raquo;
            </button>
        @else
            <span class="px-3 py-1 bg-gray-200 text-gray-500 rounded cursor-not-allowed">
                Próxima &raquo;
            </span>
        @endif
    </nav>
@endif
