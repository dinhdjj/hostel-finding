<x-guest-layout>
    <x-slot name="head">
        <title>Trang chủ</title>

        <x-social-meta title="Nhà trọ quanh đây" description="Một trải nghiệm hoàn toàn mới về việc tìm nhà trọ"
            image="https://images.unsplash.com/photo-1596276020587-8044fe049813?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=939&q=80" />
    </x-slot>

    <x-header.search class="fixed z-50 mb-4 w-full shadow" />

    <x-container class="pt-32">
        <div class="no-scrollbar overflow-auto">
            <div class="flex min-w-max gap-2">
                @foreach ($trendingCategories as $category)
                    <button class="rounded-xl bg-gray-100 px-4 py-2 text-lg text-gray-600">
                        {{ $category->name }}
                    </button>
                @endforeach
            </div>
        </div>

        <div class="no-scrollbar mt-4 overflow-auto">
            <div class="flex min-w-max gap-2">
                @foreach ($trendingAmenities as $amenity)
                    <button class="rounded-xl bg-gray-100 px-4 py-2 text-lg text-gray-600">
                        {{ $amenity->name }}
                    </button>
                @endforeach
            </div>
        </div>

        <h2 class="mt-6 mb-4 text-2xl font-semibold tracking-tight text-gray-700 sm:text-3xl sm:tracking-tight">
            Nhà trọ gần bạn
        </h2>

        <div class="grid gap-x-6 gap-y-8 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
            @foreach ($nearestHostels as $hostel)
                <x-hostel.card :hostel="$hostel" />
            @endforeach
        </div>

        <div x-data class="mt-6 flex justify-center">
            {{-- See more action --}}
            <button class="rounded-full bg-white px-8 py-4 font-bold text-primary-600 shadow"
                @click="document.getElementById('header-search-button')?.click()">
                Xem thêm
            </button>
        </div>
    </x-container>

    <x-footer.simple class="mt-12" />
</x-guest-layout>
