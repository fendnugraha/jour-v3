<div>
    <a href="{{ route('store.purchase') }}" wire:navigate
        class="text-sm font-medium text-blue-600 dark:text-blue-500 hover:underline">Kembali</a>
    <table class="w-full mt-6 text-sm text-left text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">
                    #
                </th>
                <th scope="col" class="px-6 py-3">
                    Date
                </th>
                <th scope="col" class="px-6 py-3">
                    Invoice
                </th>
                <th scope="col" class="px-6 py-3">
                    Total
                </th>
                <th scope="col" class="px-6 py-3">
                    Action
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($purchases as $purchase)
            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    {{ $loop->iteration }}
                </th>
                <td class="px-6 py-4">
                    {{ $purchase->date_issued }}
                </td>
                <td class="px-6 py-4">
                    {{ $purchase->invoice }}
                </td>
                <td class="px-6 py-4">
                    {{ number_format($purchase->total) }}
                </td>
                <td class="px-6 py-4">
                    <a href="{{ route('store.purchase.detail', ['id' => $purchase->invoice]) }}"
                        class="text-slate-800 font-bold bg-yellow-400 py-2 px-5 rounded-lg hover:bg-yellow-300">Detail</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>