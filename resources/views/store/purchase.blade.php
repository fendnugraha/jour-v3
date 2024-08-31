<x-layouts.app>
    <x-slot:title>{{ $title }}</x-slot:title>
    <div>
        <div class="grid grid-cols-1 sm:grid-cols-4 gap-2">
            <div class="col-span-1 sm:col-span-3">
                <livewire:store.purchase.purchase />
            </div>
            <div class="col-span-1 p-2 rounded-md bg-white">
                <livewire:store.purchase.purchase-cart />
            </div>

        </div>
    </div>
</x-layouts.app>