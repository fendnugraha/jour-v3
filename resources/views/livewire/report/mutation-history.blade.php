<div class="bg-white p-2 rounded-lg">
    <h4 class="text-blue-950 text-lg font-bold mb-3">History Mutasi Saldo</h4>
    <div class="grid grid-cols-1 sm:grid-cols-4 gap-1 mb-2">
        <div class="bg-sky-700 p-2 sm:p-4 rounded-xl text-white">
            <h5 class="sm:text-sm">Saldo Awal</h5>
            <span class="sm:text-2xl font-bold">{{ Number::format($initBalance) }}</span>
        </div>
        <div class="bg-sky-700 p-2 sm:p-4 rounded-xl text-white">
            <h5 class="sm:text-sm">Debet</h5>
            <span class="sm:text-2xl font-bold">{{ Number::format($debt_total) }}</span>
        </div>
        <div class="bg-sky-700 p-2 sm:p-4 rounded-xl text-white">
            <h5 class="sm:text-sm">Credit</h5>
            <span class="sm:text-2xl font-bold">{{ Number::format($cred_total) }}</span>
        </div>
        <div class="bg-sky-700 p-2 sm:p-4 rounded-xl text-white">
            <h5 class="sm:text-sm">Saldo Akhir</h5>
            <span class="sm:text-2xl font-bold">{{ Number::format($endBalance) }}</span>
        </div>
    </div>
    <div class="flex flex-col sm:flex-row justify-start items-center mb-1 gap-2">
        <div class="w-full">
            <label for="">Akun</label>
            <select wire:model.live="account" class="w-full text-sm border rounded-lg p-2">
                <option value="">-- Pilih Akun --</option>
                @foreach ($accounts as $c)
                <option value="{{ $c->acc_code }}">{{ $c->acc_name }}</option>
                @endforeach
            </select>
        </div>
        <div class="flex gap-2">
            <div>
                <label for="">Dari </label><input type="datetime-local" wire:model.live="startDate"
                    class="text-sm w-full border rounded-lg p-2">
            </div>
            <div>
                <label for="">Sampai </label><input type="datetime-local" wire:model.live="endDate"
                    class="text-sm w-full border rounded-lg p-2">
            </div>
        </div>
        <div class="">
            <label for="">Page </label>
            <select wire:model.live="perPage" class="w-full text-sm border rounded-lg p-2">
                <option value="5">5</option>
                <option value="10">10</option>
                <option value="25">25</option>
                <option value="50">50</option>
                <option value="100">100</option>
            </select>
        </div>
    </div>
    <table class="table-auto w-full text-xs mb-2">
        <thead class="bg-white text-blue-950">
            <tr class="border-y">
                <th class="p-2 hidden sm:table-cell">Waktu</th>
                <th class="p-2 hidden sm:table-cell">Invoice</th>
                <th class="p-2">Keterangan</th>
                <th class="p-2">Debet</th>
                <th class="p-2">Kredit</th>
                <th class="p-2">Saldo</th>
            </tr>
        </thead>

        <tbody>
            @php
            $balance = 0;
            @endphp
            @foreach ($journals as $x)
            @php
            $debt_amount = $x->debt_code == $account ? $x->amount : 0;
            $cred_amount = $x->cred_code == $account ? $x->amount : 0;
            $x->debt->account->status == 'D' ? $balance += $debt_amount - $cred_amount : $balance += $cred_amount -
            $debt_amount;
            @endphp
            <tr class="border border-slate-100 odd:bg-white even:bg-blue-50">
                <td class="p-2 hidden sm:table-cell">{{ $x->created_at }}</td>
                <td class="p-2 hidden sm:table-cell">{{ $x->invoice }}</td>
                <td>
                    <span class="text-sky-900 block sm:hidden">{{ $x->created_at }}</span>
                    <span class="text-sky-900 font-bold block sm:hidden">{{ $x->invoice ?? ''}}</span>
                    <span class="text-amber-500 font-bold">{{ $x->warehouse->name}}</span>
                    <span class="text-slate-800 font-bold hidden sm:inline">{{ $x->user->name}}</span>
                    <br>
                    Note: {{ $x->description }}
                    <br>
                    @if ($x->trx_type !== 'Mutasi Kas' && $x->trx_type !== 'Pengeluaran')
                    <span class="text-blue-600 font-bold block">Fee (Admin): {{ $x->fee_amount == 0 ? 'Gratis' :
                        number_format($x->fee_amount)
                        }}
                    </span>

                    @endif

                    <span class="text-sky-900 font-bold">{{ $x->debt->acc_name ?? ''}} x {{ $x->cred->acc_name ??
                        ''}}</span>
                </td>
                <td class="text-right p-2">{{ $debt_amount == 0 ? '' : Number::format($debt_amount) }}</td>
                <td class="text-right p-2">{{ $cred_amount == 0 ? '' : Number::format($cred_amount) }}</td>
                <td class="text-right p-2">{{ Number::format($initBalance + $balance) }}</td>

            </tr>
            @endforeach
    </table>

    {{ $journals->links(data: ['scrollTo' => false]) }}

    <div wire:loading class="italic text-xs col-span-2">
        loading data ...
    </div>
</div>