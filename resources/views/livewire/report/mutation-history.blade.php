<div class="bg-white p-2 rounded-lg">
    <h4 class="text-blue-950 text-lg font-bold mb-3">History Mutasi Saldo</h4>
    <div class="grid grid-cols-1 sm:grid-cols-4 gap-1">
        <div class="bg-sky-700 p-4 rounded-xl text-white">
            <h5>Saldo Awal</h5>
            <span class="text-2xl font-bold">{{ Number::format($initBalance) }}</span>
        </div>
        <div class="bg-sky-700 p-4 rounded-xl text-white">
            <h5>Debet</h5>
            <span class="text-2xl font-bold">{{ Number::format($debt_total) }}</span>
        </div>
        <div class="bg-sky-700 p-4 rounded-xl text-white">
            <h5>Credit</h5>
            <span class="text-2xl font-bold">{{ Number::format($cred_total) }}</span>
        </div>
        <div class="bg-sky-700 p-4 rounded-xl text-white">
            <h5>Saldo Awal</h5>
            <span class="text-2xl font-bold">{{ Number::format($endBalance) }}</span>
        </div>
    </div>
    <div class="flex justify-start items-center mb-1 gap-2">
        <div>
            <label for="">Akun</label>
            <select wire:model.live="account" class="w-full text-sm border rounded-lg p-2">
                <option value="">-- Pilih Akun --</option>
                @foreach ($accounts as $c)
                <option value="{{ $c->acc_code }}">{{ $c->acc_name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label for="">Dari </label><input type="datetime-local" wire:model.live="startDate"
                class="text-sm w-full border rounded-lg p-2">
        </div>
        <div>
            <label for="">Sampai </label><input type="datetime-local" wire:model.live="endDate"
                class="text-sm w-full border rounded-lg p-2">
        </div>
    </div>
    <table class="table-auto w-full text-xs mb-2">
        <thead class="bg-white text-blue-950">
            <tr class="border-b">
                <th class="p-2">Waktu</th>
                <th class="p-2">Invoice</th>
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
                <td class="p-2">{{ $x->created_at }}</td>
                <td class="p-2">{{ $x->invoice }}</td>
                <td class="p-2">{{ $x->description }}</td>
                <td class="text-right p-2">{{ Number::format($debt_amount) }}</td>
                <td class="text-right p-2">{{ Number::format($cred_amount) }}</td>
                <td class="text-right p-2">{{ Number::format($initBalance + $balance) }}</td>

            </tr>
            @endforeach
    </table>

    {{ $journals->links(data: ['scrollTo' => false]) }}
</div>