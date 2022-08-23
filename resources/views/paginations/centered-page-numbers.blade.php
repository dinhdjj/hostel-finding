@if ($paginator->hasPages())
    <nav class="flex items-center justify-between border-t border-gray-200 px-4 sm:px-0">
        {{-- Previous Page Link --}}
        <div class="-mt-px flex w-0 flex-1">
            @if ($paginator->onFirstPage())
            @else
                <a href="{{ $paginator->previousPageUrl() }}"
                    class="inline-flex items-center border-t-2 border-transparent pt-4 pr-1 text-sm font-medium text-gray-500 hover:border-gray-300 hover:text-gray-700">
                    <x-heroicon-s-arrow-narrow-left class="mr-3 h-5 w-5 text-gray-400" />
                    Trang trước
                </a>
            @endif
        </div>

        {{-- Pagination Elements --}}
        <div class="hidden md:-mt-px md:flex">
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <span
                        class="inline-flex items-center border-t-2 border-transparent px-4 pt-4 text-sm font-medium text-gray-500">
                        {{ $element }}
                    </span>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <a aria-current="page" href="#"
                                class="inline-flex items-center border-t-2 border-primary-500 px-4 pt-4 text-sm font-medium text-primary-600"
                                aria-current="page"> {{ $page }} </a>
                        @else
                            <a href="{{ $url }}"
                                class="inline-flex items-center border-t-2 border-transparent px-4 pt-4 text-sm font-medium text-gray-500 hover:border-gray-300 hover:text-gray-700"
                                aria-label="{{ __('Go to page :page', ['page' => $page]) }}">
                                {{ $page }}
                            </a>
                        @endif
                    @endforeach
                @endif
            @endforeach
        </div>

        {{-- Next Page Link --}}
        <div class="-mt-px flex w-0 flex-1 justify-end">
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}"
                    class="inline-flex items-center border-t-2 border-transparent pt-4 pl-1 text-sm font-medium text-gray-500 hover:border-gray-300 hover:text-gray-700">
                    <span> Trang sau </span>
                    <x-heroicon-s-arrow-narrow-right class="ml-3 h-5 w-5 text-gray-400" />
                </a>
            @else
            @endif
        </div>
    </nav>
@endif
