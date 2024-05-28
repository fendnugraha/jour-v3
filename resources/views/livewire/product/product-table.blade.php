<div>
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
    <div>
        <input type="text" wire:model.live.debounce.500ms="search" placeholder="Search .."
            class="w-full border rounded-lg p-2 mb-3">
    </div>
    <table class="table-auto w-full text-xs mb-2">
        <thead class="bg-slate-500 text-white">
            <tr>
                <th class="p-4">ID</th>
                <th>Name</th>
                <th>Harga Modal</th>
                <th>Harga Jual</th>
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
            <tr class="border border-slate-200">
                <td class="p-3">{{ $product->id }}</td>
                <td>{{ $product->name }}</td>
                <td class="text-right">{{ number_format($product->cost, 2) }}</td>
                <td class="text-right">{{ number_format($product->price, 2) }}</td>
                <td class="text-right">{{ number_format($product->sold, 2) }}</td>
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