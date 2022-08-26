@php
$livewire ??= false;
@endphp

@if ($paginator->hasPages())
    <nav class="flex items-center justify-between border-t border-gray-200 px-4 sm:px-0">
        {{-- Previous Page Link --}}
        <div class="-mt-px flex w-0 flex-1">
            @if ($paginator->onFirstPage())
            @else
                @if ($livewire)
                    <button wire:click="previousPage" wire:loading.attr="disabled"
                        class="inline-flex items-center border-t-2 border-transparent pt-4 pr-1 text-sm font-medium text-gray-500 hover:border-gray-300 hover:text-gray-700">
                        <x-heroicon-s-arrow-narrow-left class="mr-3 h-5 w-5 text-gray-400" />
                        Trang trước
                    </button>
                @else
                    <a href="{{ $paginator->previousPageUrl() }}"
                        class="inline-flex items-center border-t-2 border-transparent pt-4 pr-1 text-sm font-medium text-gray-500 hover:border-gray-300 hover:text-gray-700">
                        <x-heroicon-s-arrow-narrow-left class="mr-3 h-5 w-5 text-gray-400" />
                        Trang trước
                    </a>
                @endif
            @endif
        </div>

        {{-- Next Page Link --}}
        <div class="-mt-px flex w-0 flex-1 justify-end">
            @if ($paginator->hasMorePages())
                @if ($livewire)
                    <button wire:click="nextPage" wire:loading.attr="disabled"
                        class="inline-flex items-center border-t-2 border-transparent pt-4 pl-1 text-sm font-medium text-gray-500 hover:border-gray-300 hover:text-gray-700">
                        <span> Trang sau </span>
                        <x-heroicon-s-arrow-narrow-right class="ml-3 h-5 w-5 text-gray-400" />
                    </button>
                @else
                    <a href="{{ $paginator->nextPageUrl() }}"
                        class="inline-flex items-center border-t-2 border-transparent pt-4 pl-1 text-sm font-medium text-gray-500 hover:border-gray-300 hover:text-gray-700">
                        <span> Trang sau </span>
                        <x-heroicon-s-arrow-narrow-right class="ml-3 h-5 w-5 text-gray-400" />
                    </a>
                @endif
            @else
            @endif
        </div>
    </nav>
@endif
