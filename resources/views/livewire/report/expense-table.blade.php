<div class="bg-white p-2 rounded-lg">
    <h4 class=" text-red-700 text-lg font-bold mb-3">Pengeluaran (Biaya Operasional)</h4>
    <input type="text" wire:model.live.debounce.500ms="search" placeholder="Search .."
        class="w-full border rounded-lg p-2 mb-1">
    <table class="table-auto w-full text-xs mb-2">
        <thead class="bg-white text-blue-950">
            <tr>
                <th class="text-center p-3">Waktu</th>
                <th class="text-center p-3 hidden sm:block">Invoice</th>
                <th class="text-center">Keterangan</th>
                <th class="text-center">Jumlah</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($expenses as $x)

            <tr class="border border-slate-100 odd:bg-white even:bg-blue-50">
                <td class="p-2">{{ $x->created_at }}</td>
                <td class="p-2 hidden sm:block">{{ $x->invoice }}</td>
                <td class="p-2"><span class="font-bold block sm:hidden">{{ $x->invoice }}</span> {{ $x->description }}
                </td>
                <td class="text-right p-2">{{ Number::format(-$x->fee_amount) }}</td>
            </tr>
            @endforeach

        </tbody>
    </table>

    {{ $expenses->links(data: ['scrollTo' => false]) }}
</div>