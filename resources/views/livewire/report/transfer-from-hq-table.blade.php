<div class="mb-6">
    <div class="bg-white p-2 rounded-lg">
        <div class="flex justify-between items-center mb-3">
            <h4 class=" text-blue-950 text-lg font-bold">Mutasi Saldo</h4>
            <x-modal class="bg-blue-950 text-sm text-white rounded-lg py-1 px-3">
                <x-slot name="buttonTitle">
                    <i class="fa-solid fa-plus"></i> Mutasi saldo
                </x-slot>
                <x-slot name="modalTitle">
                    Form Mutasi Saldo
                </x-slot>
                <livewire:journal.create-mutation />
            </x-modal>
        </div>
        <table class="table-auto w-full text-xs mb-2">
            <thead class="bg-white text-blue-950">
                <tr>
                    <th class="text-left p-3">Nama Akun</th>
                    <th class="text-center">Penambahan</th>
                    <th class="text-center">Pengembalian</th>
                    <th class="text-center">Saldo Akhir</th>
                    <th class="text-center">Sisa</th>
                </tr>
            </thead>

            <tbody>
                @php
                $tPenambahan = 0;
                $tPengembalian = 0;
                $sisa = 0;
                @endphp
                @foreach ($accounts as $a)
                @php
                $penambahan = $journal->where('debt_code', $a->acc_code)->sum('amount');
                $pengembalian = $journal->where('cred_code', $a->acc_code)->sum('amount');

                $tPenambahan += $penambahan;
                $tPengembalian += $pengembalian;
                $sisa += $penambahan - $pengembalian;
                @endphp
                <tr class="border border-slate-100 odd:bg-white even:bg-blue-50">
                    <td class="p-2">{{ $a->acc_name }}</td>
                    <td class="text-right p-2">{{ number_format($penambahan) }}</td>
                    <td class="text-right p-2 text-red-500">{{ number_format($pengembalian) }}</td>
                    <td class="text-right p-2 text-blue-500 font-bold">{{ Number::format($a->balance) }}</td>
                    <td class="text-right p-2">{{ number_format($penambahan - $pengembalian) }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr class="border border-slate-100 odd:bg-white even:bg-blue-50 font-bold">
                    <td class="p-2">Total</td>
                    <td class="text-right p-2">{{ number_format($tPenambahan) }}</td>
                    <td class="text-right p-2 text-red-500">{{ number_format($tPengembalian) }}</td>
                    <td class="text-right p-2 text-red-500">{{ number_format($accounts->sum('balance')) }}</td>
                    <td class="text-right p-2">{{ number_format($sisa) }}</td>
                </tr>
            </tfoot>
        </table>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 mt-6">
        <div class="bg-white p-2 rounded-lg">
            <h4 class=" text-green-700 text-lg font-bold mb-3">Mutasi Masuk</h4>
            <input type="text" wire:model.live.debounce.500ms="searchIncrease" placeholder="Search .."
                class="w-full border rounded-lg p-2 mb-1">
            <table class="table-auto w-full text-xs mb-2">
                <thead class="bg-white text-blue-950">
                    <tr>
                        <th class="text-left p-3">Nama Akun</th>
                        <th class="text-center">Jumlah</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($increase as $m)
                    <tr class="border border-slate-100 odd:bg-white even:bg-blue-50">
                        <td class="p-2">{{ $m->debt->acc_name }}</td>
                        <td class="text-right p-2">{{ number_format($m->amount) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            {{ $increase->links(data: ['scrollTo' => false]) }}
        </div>
        <div class="bg-white p-2 rounded-lg">
            <h4 class=" text-red-600 text-lg font-bold mb-3">Mutasi Keluar</h4>
            <input type="text" wire:model.live.debounce.500ms="searchDecrease" placeholder="Search .."
                class="w-full border rounded-lg p-2 mb-1">
            <table class="table-auto w-full text-xs mb-2">
                <thead class="bg-white text-blue-950">
                    <tr>
                        <th class="text-left p-3">Nama Akun</th>
                        <th class="text-center">Jumlah</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($decrease as $d)
                    <tr class="border border-slate-100 odd:bg-white even:bg-blue-50">
                        <td class="p-2">{{ $d->cred->acc_name }}</td>
                        <td class="text-right p-2">{{ number_format($d->amount) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            {{ $decrease->links(data: ['scrollTo' => false]) }}
        </div>
    </div>
</div>