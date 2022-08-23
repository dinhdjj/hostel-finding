<x-guest-layout>

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
</x-guest-layout>
