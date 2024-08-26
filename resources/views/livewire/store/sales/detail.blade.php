<div>
    <a href="{{ route('store.sales.report') }}" class="text-blue-950">Kembali</a>

    <h1 class="text-xl font-bold mt-6">Penjualan {{ $id }}</h1>
    <small>Total: {{ Number::format($total) }}</small>
    <table class="min-w-full overflow-x-auto my-6">
        <thead class="bg-white text-blue-950">
            <tr class="border-b">
                <th class="text-center p-3">No</th>
                <th class="text-center p-3">Nama Barang</th>
                <th class="text-center p-3">Qty</th>
                <th class="text-center p-3">Harga</th>
                <th class="text-center p-3">Total</th>
                <th class="text-center p-3">Action</th>
            </tr>
        </thead>

        @foreach ($sale as $x)
        <tbody>
            <tr class="border border-slate-100 odd:bg-white even:bg-blue-50 text-xs">
                <td class="text-center p-2">{{ $loop->iteration }}</td>
                <td class="p-2">{{ $x->product->name }}</td>
                <td class="text-right p-2">{{ -$x->quantity }}</td>
                <td class="text-right p-2">{{ Number::format($x->price) }}</td>
                <td class="text-right p-2">{{ Number::format($x->price * -$x->quantity) }}</td>
                <td class="text-center p-2">
                    <button wire:click="edit({{ $x->id }})"
                        class="text-white font-bold bg-blue-500 py-1 px-3 rounded-lg hover:bg-blue-400"><i
                            class="fa-solid fa-pen-to-square"></i></button>
                    <button wire:click="delete({{ $x->id }})" wire:confirm="Apakah anda yakin?"
                        class="text-white font-bold bg-red-500 py-1 px-3 rounded-lg hover:bg-red-400"><i
                            class="fa-solid fa-trash"></i></button>
                </td>
            </tr>
        </tbody>
        @endforeach

    </table>

</div>