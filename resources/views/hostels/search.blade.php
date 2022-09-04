<x-guest-layout class="h-screen w-screen overflow-auto md:table md:overflow-hidden">
    <x-slot name="head">
        <title>Tìm kiếm</title>

        <x-social-meta title="Nhà trọ quanh đây" description="Một trải nghiệm hoàn toàn mới về việc tìm nhà trọ"
            image="https://images.unsplash.com/photo-1596276020587-8044fe049813?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=939&q=80" />
    </x-slot>

    <x-header.search class="border-b md:table-cell" />

    <div class="md:table-row md:h-full">
        <livewire:hostel.search />
    </div>
</x-guest-layout>
