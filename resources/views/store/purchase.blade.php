<x-layouts.app>
    <x-slot:title>{{ $title }}</x-slot:title>
    <div>
        <div class="grid grid-cols-2 gap-2">
            <div class="col-span-1">
                <livewire:store.purchase.purchase />
            </div>
            <div class="col-span-1 p-2 rounded-md bg-white">
                <h1 class="text-xl font-bold"><i class="fa-solid fa-cart-shopping"></i> Purchase Order <span
                        class="text-slate-300 text-md">({{ 0 }}
                        items)</span></h1>
            </div>

        </div>
    </div>
</x-layouts.app>