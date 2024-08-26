<div>
    <a href="{{ route('store.index') }}" wire:navigate
        class="text-sm font-medium text-blue-600 dark:text-blue-500 hover:underline">Kembali</a>
    <div>
        <table class="w-full mt-6 text-sm text-left text-gray-500 dark:text-gray-400">
            <thead>
                <tr class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <th class="px-6 py-3">Waktu</th>
                    <th>No. Invoice</th>
                    <th>Total</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($sales as $s)
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                    <td class="p-3">{{ $s->date_issued }}</td>
                    <td>{{ $s->invoice }}</td>
                    <td>Rp. {{ number_format($s->total) }}</td>
                    <td><a href="{{ route('store.sales.detail', ['id' => $s->invoice]) }}"
                            class="text-slate-800 font-bold bg-yellow-400 py-2 px-5 rounded-lg hover:bg-yellow-300">Detail
                    </td>
                </tr>
                @endforeach

            </tbody>
        </table>
    </div>
</div>