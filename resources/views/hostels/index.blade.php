<x-guest-layout>
    <x-slot name="head">
        <title>Trang chủ</title>

        <x-social-meta title="Nhà trọ quanh đây" description="Một trải nghiệm hoàn toàn mới về việc tìm nhà trọ"
            image="https://images.unsplash.com/photo-1596276020587-8044fe049813?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=939&q=80" />
    </x-slot>

    <x-header.search class="mb-4 shadow" />

    <x-container>
        <h2 class="py-4 text-2xl font-semibold tracking-tight text-gray-700 sm:text-3xl sm:tracking-tight">
            Nhà trọ nổi bật
        </h2>

        <div class="grid gap-x-6 gap-y-8 py-4 md:grid-cols-2 xl:grid-cols-4">
            @foreach ($trendingHostel as $hostel)
                <x-hostel.card :hostel="$hostel" />
            @endforeach
        </div>

        <div class="py-6">
            {{ $trendingHostel->links('paginations.centered-page-numbers') }}
        </div>

    </x-container>

    <x-footer.simple class="mt-12" />
</x-guest-layout>
