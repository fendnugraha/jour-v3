<x-layouts.app>
    <x-slot:title>{{ $title }}</x-slot:title>
    <div class="grid grid-cols-4 gap-4 mb-3">
        <x-modal
            class="bg-cyan-500 text-white p-2 shadow-300 flex justify-center items-center rounded-xl hover:bg-cyan-400 transition duration-300 ease-out w-full">
            <x-slot name="buttonTitle">
                Tambah Produk
            </x-slot>
            <x-slot name="modalTitle">
                Form Tambah Produk
            </x-slot>
            <livewire:product.create-product />
        </x-modal>
        <a href="/setting"
            class="bg-red-500 text-white p-2 shadow-300 flex justify-center items-center rounded-xl hover:bg-red-400 transition duration-300 ease-out">
            Kembali
        </a>
    </div>
    <livewire:product.product-table />
</x-layouts.app>