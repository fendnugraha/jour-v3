<div class="bg-white p-2 rounded-lg mb-3 relative">
    <div class="mb-6 flex justify-between flex-col sm:flex-row gap-2">
        <div class="flex justify-start items-center gap-2">
            <h4 class=" text-blue-950 text-lg font-bold">Ringkasan Transaksi</h4>
            <button wire:click="$refresh"
                class="bg-sky-950 text-white px-2 py-1 text-sm shadow-300 justify-center items-center rounded-full hover:bg-sky-800 transition duration-300 ease-out"><i
                    class="fa-solid fa-arrows-rotate"></i></button>
        </div>
        <div class="flex justify-start items-center gap-2">
            <div class="flex flex-col sm:flex-row justify-start gap-2 items-center w-full">
                <label for="from">Dari</label>
                <input type="datetime-local" wire:model.live="startDate" class="w-full text-sm border rounded-lg p-2">
            </div>
            <div class="flex flex-col sm:flex-row justify-start gap-2 items-center w-full">
                <label for="to">Sampai</label>
                <input type="datetime-local" wire:model.live="endDate" class="w-full text-sm border rounded-lg p-2">
            </div>
        </div>
    </div>
    <table class="table-auto w-full text-xs mb-2">
        <thead class="bg-blue-50 text-blue-950">
            <tr>
                <th class="p-3">Cabang</th>
                <th class="p-3">Transfer</th>
                <th class="p-3">Tarik Tunai</th>
                <th class="p-3">Voucher & SP</th>
                <th class="p-3">Deposit (Pulsa dll)</th>
                <th class="p-3">Transaksi</th>
                <th class="p-3">Pengeluaran (Biaya)</th>
                <th class="p-3">Laba Bersih</th>
            </tr>
        </thead>
        <tbody>
            @php
            $rvTransfer = 0;
            $rvTarikTunai = 0;
            $rvVcr = 0;
            $rvdeposit = 0;
            $rvLaba = 0;
            $rvBiaya = 0;
            $rvLaba = 0;
            $totaltrx = 0;
            @endphp
            @foreach ($revenue as $w)
            @php
            $rv = $w->whereBetween('date_issued', [\Carbon\Carbon::parse($startDate)->startOfDay(),
            \Carbon\Carbon::parse($endDate)->endOfDay()])->where('warehouse_id', $w->warehouse_id)->get();

            $rvTransfer += $rv->where('trx_type', 'Transfer Uang')->sum('amount');
            $rvTarikTunai += $rv->where('trx_type', 'Tarik Tunai')->sum('amount');
            $rvVcr += $rv->where('trx_type', 'Voucher & SP')->sum('amount');
            $rvdeposit += $rv->where('trx_type', 'Deposit')->sum('amount');
            $rvLaba += $w->sumfee;
            $rvBiaya += $rv->where('trx_type', 'Pengeluaran')->sum('fee_amount');
            $totaltrx += $rv->count();
            @endphp
            <tr
                class="border border-slate-100 odd:bg-white even:bg-blue-50 hover:bg-slate-600 hover:text-white cursor-pointer">
                <td class="p-2">{{ $w->warehouse->name }}</td>
                <td class="p-2 text-right">{{ number_format($rv->where('trx_type', 'Transfer Uang')->sum('amount')) }}
                </td>
                <td class="p-2 text-right">{{ number_format($rv->where('trx_type', 'Tarik Tunai')->sum('amount')) }}
                </td>
                <td class="p-2 text-right">{{ number_format($rv->where('trx_type', 'Voucher & SP')->sum('amount')) }}
                </td>
                <td class="p-2 text-right">{{ number_format($rv->where('trx_type', 'Deposit')->sum('amount')) }}</td>
                <td class="p-2 text-right">{{ number_format($rv->count()) }}</td>
                <td class="p-2 text-right text-red-600">
                    {{ number_format(-$rv->where('trx_type', 'Pengeluaran')->sum('fee_amount')) }}
                </td>
                <td class="text-green-600 font-bold p-2 text-right">{{ number_format($w->sumfee) }}</td>
            </tr>

            @endforeach
        </tbody>
        <tfoot class="table-warning">
            <tr>
                <th class="p-3">Total</th>
                <th class="text-right p-3">{{ number_format($rvTransfer) }}</th>
                <th class="text-right p-3">{{ number_format($rvTarikTunai) }}</th>
                <th class="text-right p-3">{{ number_format($rvVcr) }}</th>
                <th class="text-right p-3">{{ number_format($rvdeposit) }}</th>
                <th class="text-right p-3">{{ number_format($totaltrx) }}</th>
                <th class="text-right p-3">{{ number_format(-$rvBiaya) }}</th>
                <th class="text-right p-3">{{ number_format($revenue->sum('sumfee')) }}</th>
            </tr>
        </tfoot>
    </table>
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