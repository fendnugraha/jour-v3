<div class="bg-white rounded-lg p-2 mb-3">
    @if(session('success'))
    <x-notification>
        <x-slot name="classes">bg-green-500 text-white absolute bottom-3 left-4</x-slot>
        <strong>Success!!</strong> {{ session('success') }}
    </x-notification>
    @elseif (session('error'))
    <x-notification>
        <x-slot name="classes">bg-red-500 text-white absolute bottom-3 left-4</x-slot>
        <strong>Error!!</strong> {{
        session('error') }}
    </x-notification>
    @endif
    <div class="flex gap-2 justify-between mb-3">
        <div class="flex gap-2">
            <x-modal modalName="addProduct" modalTitle="Form Tambah Produk">
                <livewire:product.create-product />
            </x-modal>
            <button x-data x-on:click="$dispatch('open-modal', {'modalName': 'addProduct'})" bg-sky-950 text-w
                class="bg-blue-950 text-white rounded-lg py-1 px-3 h-full">
                <i class="fa-solid fa-plus"></i> Tambah produk
            </button>
            <x-modal modalName="addCategory" modalTitle="Form Tambah Kategori">
                <form wire:submit="addCategory">
                    <div class="mb-6">
                        <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                            Nama Kategori
                        </label>
                        <input type="text" placeholder="Nama Kategori" wire:model="name"
                            class="w-full border rounded-lg p-2" name="name">

                    </div>
                    <div>
                        <button type="submit" class="w-full bg-blue-500 text-white p-2 rounded-lg">Simpan</button>
                    </div>
                </form>
            </x-modal>
            <button x-data x-on:click="$dispatch('open-modal', {'modalName': 'addCategory'})" bg-sky-950 text-w
                class="bg-blue-950 text-white rounded-lg py-1 px-3 h-full">
                <i class="fa-solid fa-plus"></i> Tambah Kategori
            </button>
            <div>
                <input type="text" wire:model.live.debounce.500ms="search" placeholder="Search .."
                    class="w-full text-sm border rounded-lg p-2">

            </div>
            <div>
                <select wire:model.live="perPage" class="text-sm border rounded-lg p-2">
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
            </div>
        </div>
        <a href="/setting" class="bg-red-700 py-2 px-6 text-sm rounded-lg text-white hover:bg-sky-700">
            Kembali
        </a>
    </div>
    <table class="table-auto w-full text-xs mb-2">
        <thead class="bg-white text-blue-950">
            <tr class="border-b">
                <th class="p-4">ID</th>
                <th>Name</th>
                <th>Harga Modal</th>
                <th>Harga Jual</th>
                <th>Kategori</th>
                <th>Terjual</th>
                <th>Action</th>

            </tr>
        </thead>

        <tbody class="bg-white">
            @foreach ($products as $product)
            @if ($product->status == 1)
            @php $status = '<sup class="text-green-600 font-bold">Active</sup>' @endphp
            @else
            @php $status = '<sup class="text-red-600 font-bold">Inactive</sup>' @endphp
            @endif
            <tr class="border border-slate-100 odd:bg-white even:bg-blue-50">
                <td class="p-3 text-center">{{ $product->id }}</td>
                <td>{{ $product->name }}</td>
                <td class="text-right p-3">{{ number_format($product->cost, 2) }}</td>
                <td class="text-right p-3">{{ number_format($product->price, 2) }}</td>
                <td class="text-right p-3">{{ ucwords($product->category) }}</td>
                <td class="text-right p-3">{{ number_format($product->sold) }} Pcs</td>
                <td class="text-center">
                    <a href="/setting/product/{{ $product->id }}/edit"
                        class="text-slate-800 font-bold bg-yellow-400 py-1 px-3 rounded-lg hover:bg-yellow-300">Edit</a>
                    <button wire:click="delete({{ $product->id }})" wire:loading.attr="disabled"
                        wire:confirm="Apakah anda yakin menghapus data ini?"
                        class="text-white font-bold bg-red-400 py-1 px-3 rounded-lg hover:bg-red-300">Delete</button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{ $products->links() }}

</div>