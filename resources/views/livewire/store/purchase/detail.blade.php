<div>
    <a href="{{ route('store.purchase.report') }}" class="text-blue-950">Kembali</a>

    <h1 class="text-xl font-bold mt-6">Detail PO {{ $id }}</h1>
    <small>Total: {{ Number::format($total) }}</small>
    <table class="min-w-full overflow-x-auto my-6">
        <thead class="bg-white text-blue-950">
            <tr class="border-b">
                <th class="text-center p-3">No</th>
                <th class="text-center p-3">Nama Barang</th>
                <th class="text-center p-3">Qty</th>
                <th class="text-center p-3">Harga</th>
                <th class="text-center p-3">Total</th>
            </tr>
        </thead>

        @foreach ($purchase as $x)
        <tbody>
            <tr class="border border-slate-100 odd:bg-white even:bg-blue-50">
                <td class="text-center p-2">{{ $loop->iteration }}</td>
                <td class="p-2">{{ $x->product->name }}</td>
                <td class="text-right p-2">{{ $x->quantity }}</td>
                <td class="text-right p-2">{{ Number::format($x->cost) }}</td>
                <td class="text-right p-2">{{ Number::format($x->cost * $x->quantity) }}</td>
            </tr>
        </tbody>
        @endforeach

    </table>

</div>