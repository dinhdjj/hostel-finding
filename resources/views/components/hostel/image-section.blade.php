@props(['hostel'])

<div
    {{ $attributes->class('relative grid h-96 grid-cols-1 grid-rows-1 gap-2 overflow-hidden rounded-md shadow-sm md:grid-cols-2 md:rounded-2xl') }}>
    <div class="h-full bg-cover bg-center">
        {{ $hostel->getFirstMedia()->img()->attributes(['class' => 'h-full object-cover object-center']) }}
    </div>
    <div class="relative md:grid">
        <div class="hidden grid-cols-2 grid-rows-2 gap-2 overflow-hidden rounded-md md:grid">
            @foreach ($hostel->getMedia() as $index => $item)
                @if ($index > 0 && $index < 5)
                    <div>
                        {{ $item->img()->attributes(['class' => 'object-cover h-full w-full object-center']) }}
                    </div>
                @endif
            @endforeach
        </div>
        <div x-data="{ open: false }"
            class="text-gray-500focus:outline-none absolute right-2 bottom-1 mb-2 mr-2 rounded-md bg-white">
            <button x-ref="modal1_button" @click="open = true"
                class="px-4 py-2 text-sm font-medium leading-5 text-gray-700 transition duration-150 ease-in-out">
                <span>Show More</span>
            </button>
            <div x-cloak role="dialog" aria-labelledby="modal1_label" aria-modal="true" tabindex="0" x-show="open"
                @click="open = false; $refs.modal1_button.focus()"
                @click.away="open = false; $refs.modal1_button.focus()"
                class="fixed inset-0 z-[99999] overflow-auto bg-white">
                <h3 class="text-center text-xl font-semibold text-gray-800">
                    Tất cả các ảnh
                </h3>
                <div class="flex py-4">
                    <div class="mx-auto space-y-2 bg-white px-20 pt-10">
                        @foreach ($hostel->getMedia() as $item)
                            {{ $item->img()->attributes(['class' => 'object-cover object-center rounded']) }}
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
