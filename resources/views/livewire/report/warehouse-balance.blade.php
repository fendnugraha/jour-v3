<div class="bg-white p-2 rounded-lg mb-3 relative">
    <h4 class=" text-blue-950 text-lg font-bold mb-6">Saldo Kas dan Bank Cabang</h4>
    <div class="flex justify-between items-center mb-3 flex-col sm:flex-row gap-2">
        <input type="text" wire:model.live.debounce.500ms="search" placeholder="Search .."
            class="w-full text-sm border rounded-lg p-2">
        <input type="datetime-local" wire:model.live="endDate" class="w-1/2 text-sm border rounded-lg p-2 ">
        <select wire:model.live="perPage" class="text-sm border rounded-lg p-2 w-40">
            <option value="10">10</option>
            <option value="25">25</option>
            <option value="50">50</option>
            <option value="100">100</option>
        </select>
    </div>
    <table class="table-auto w-full text-xs mb-2">
        <thead class="bg-white text-blue-950">
            <tr class="border-b">
                <th class="text-center p-3">Cabang (Konter)</th>
                <th class="text-center">Kas Tunai</th>
                <th class="text-center">Saldo Bank</th>
                <th class="text-center">Jumlah</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($warehouses as $w)
            @php
            $cash = $sumtotalCash->where('warehouse_id', $w->id)->sum('balance');
            $bank = $sumtotalBank->where('warehouse_id', $w->id)->sum('balance');
            @endphp
            <tr
                class="border-b border-slate-100 odd:bg-white even:bg-blue-50 hover:bg-slate-600 hover:text-white cursor-pointer">
                <td class="p-2">{{ $w->name }}</td>
                <td class="p-2 text-right">{{ Number::format($cash) }}</td>
                <td class="p-2 text-right">{{ Number::format($bank) }}</td>
                <td class="p-2 text-right font-bold">{{ Number::format($cash + $bank) }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr class="border-y border-slate-100 odd:bg-white even:bg-blue-50 font-bold">
                <td class="p-2">Total</td>
                <td class="text-right p-2 text-red-500">{{ Number::format($sumtotalCash->sum('balance')) }}</td>
                <td class="text-right p-2 text-red-500">{{ Number::format($sumtotalBank->sum('balance')) }}</td>
                <td class="text-right p-2">{{ Number::format($sumtotalCash->sum('balance') +
                    $sumtotalBank->sum('balance'))
                    }}</td>
            </tr>
        </tfoot>
    </table>
    {{ $warehouses->onEachSide(0)->links(data: ['scrollTo' => false]) }}

    <div class="absolute inset-0 flex items-center justify-center" wire:loading>
        <!-- Container for the loading message -->
        <div class="bg-white/50 h-full w-full flex items-center justify-center gap-2">
            <!-- Loading text -->
            <i class="fa-solid fa-spinner animate-spin text-blue-950 text-3xl"></i>
            <p class="text-blue-950 text-sm font-bold">
                Loading data, please wait...
            </p>
        </div>
    </div>
</div>