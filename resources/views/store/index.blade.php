<x-layouts.app>
    <x-slot:title>{{ $title }}</x-slot:title>
    <div>
        <div class="grid grid-cols-4 gap-2">
            <div class="col-span-3">
                <livewire:store.product-table />
            </div>
            <div class="col-span-1 p-2 rounded-md bg-white">
                <livewire:store.shopping-cart />
            </div>

        </div>
    </div>
</x-layouts.app>