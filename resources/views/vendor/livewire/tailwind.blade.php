@if ($paginator->hasPages())
<nav role="navigation" aria-label="Pagination Navigation" class="flex justify-between">
    <span>
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
        <span
            class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default leading-5 rounded-md">
            {!! __('pagination.previous') !!}
        </span>
        @else
        <button wire:click="previousPage" wire:loading.attr="disabled"
            class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 rounded-md hover:text-gray-500 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150">
            {!! __('pagination.previous') !!}
        </button>
        @endif
    </span>

    <span>
        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
        {{-- "Three Dots" Separator --}}
        @if (is_string($element))
        <span
            class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-gray-700 bg-white border border-gray-300 cursor-default leading-5 rounded-md">{{
            $element }}</span>
        @endif

        {{-- Array Of Links --}}
        @if (is_array($element))
        @foreach ($element as $page => $url)
        @if ($page == $paginator->currentPage())
        <span aria-current="page">
            <span
                class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-white bg-blue-500 border border-blue-500 cursor-default leading-5 rounded-md">{{
                $page }}</span>
        </span>
        @else
        <button wire:click="gotoPage({{ $page }})"
            class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 rounded-md hover:text-gray-500 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150">
            {{ $page }}
        </button>
        @endif
        @endforeach
        @endif
        @endforeach
    </span>

    <span>
        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
        <button wire:click="nextPage" wire:loading.attr="disabled"
            class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 rounded-md hover:text-gray-500 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150">
            {!! __('pagination.next') !!}
        </button>
        @else
        <span
            class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default leading-5 rounded-md">
            {!! __('pagination.next') !!}
        </span>
        @endif
    </span>
</nav>
@endif