<div class="bg-white p-2 rounded-lg">
    <div class="flex justify-between items-center mb-3 flex-col sm:flex-row gap-2">
        <h4 class=" text-red-700 text-lg font-bold">Pengeluaran (Biaya Operasional)</h4>
        <div class="flex justify-start items-center mb-1 gap-2">
            <div>
                <input type="datetime-local" wire:model.live="endDate" class="w-full text-sm border rounded-lg p-2">
            </div>
            <div>
                @can('admin')
                <select wire:model.live="warehouse_id" class="w-full text-sm border rounded-lg p-2">
                    @foreach ($warehouse as $c)
                    <option value="{{ $c->id }}">{{ $c->name }}</option>
                    @endforeach
                </select>
                @endcan
            </div>
        </div>
    </div>
    <input type="text" wire:model.live.debounce.500ms="search" placeholder="Search .."
        class="w-full border rounded-lg p-2 mb-1 text-sm">
    <table class="table-auto w-full text-xs mb-2">
        <thead class="bg-white text-blue-950">
            <tr class="border-b">
                <th class="text-center p-3">Waktu</th>
                <th class="text-center p-3 hidden sm:table-cell">Invoice</th>
                <th class="text-center p-3 hidden sm:table-cell">Category</th>
                <th class="text-center">Keterangan</th>
                <th class="text-center">Jumlah</th>
                <th class="text-center">Cabang</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($expenses as $x)

            <tr class="border border-slate-100 odd:bg-white even:bg-blue-50">
                <td class="p-2">{{ $x->created_at }}</td>
                <td class="p-2 hidden sm:table-cell">{{ $x->invoice }}</td>
                <td class="p-2 hidden sm:table-cell">{{ $x->debt->acc_name }}</td>
                <td class="p-2"><span class="font-bold block sm:hidden">{{ $x->invoice }}</span> {{ $x->description }}
                    <span class="font-bold block sm:hidden">{{ $x->debt->acc_name }}</span>
                </td>
                <td class="text-right p-2">{{ Number::format(-$x->fee_amount) }}</td>
                <td class="text-center p-2">{{ $x->warehouse->name }}</td>
            </tr>
            @endforeach

        </tbody>
    </table>

    {{ $expenses->links(data: ['scrollTo' => false]) }}
</div>