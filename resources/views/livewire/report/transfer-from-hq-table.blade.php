<div class="mb-6 relative">
    <div class="bg-white p-2 rounded-lg ">
        <div class="flex justify-between items-center mb-3 flex-col sm:flex-row gap-2">
            <h4 class=" text-blue-950 text-lg font-bold">Mutasi Saldo</h4>
            <div class="flex gap-2 flex-col sm:flex-row w-full sm:w-auto">
                @can('admin')
                <div>
                    <input type="datetime-local" wire:model.live="endDate" class="w-full text-sm border rounded-lg p-2">
                </div>
                <div>
                    <select wire:model.live="warehouse_id" class="w-full text-sm border rounded-lg p-2">
                        @foreach ($warehouse as $c)
                        <option value="{{ $c->id }}">{{ $c->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <x-modal modalName="mutasiSaldo" modalTitle="Mutasi Saldo Kas & Bank">
                        <livewire:journal.create-mutation />
                    </x-modal>
                    <button x-data x-on:click="$dispatch('open-modal', {'modalName': 'mutasiSaldo'})"
                        class="bg-blue-950 text-white rounded-lg py-1 px-3 ">
                        <i class="fa-solid fa-plus"></i> Mutasi Saldo
                    </button>
                </div>
                @endcan
            </div>
        </div>
        <table class="table-auto w-full text-xs mb-2">
            <thead class="bg-white text-blue-950">
                <tr class="border-b">
                    <th class="text-left p-3">Nama Akun</th>
                    <th class="text-center">Saldo Akhir</th>
                    <th class="text-center">Mutasi Masuk</th>
                    <th class="text-center">Mutasi keluar</th>
                    <th class="text-center">Sisa</th>
                </tr>
            </thead>

            <tbody>
                @php
                $tPenambahan = 0;
                $tPengembalian = 0;
                $sisa = 0;
                $tsisa = 0;
                @endphp
                @foreach ($accounts as $a)
                @php
                $penambahan = $journal->where('debt_code', $a->acc_code)->sum('amount');
                $pengembalian = $journal->where('cred_code', $a->acc_code)->sum('amount');
                $sisa = $penambahan - $pengembalian;
                $tPenambahan += $penambahan;
                $tPengembalian += $pengembalian;
                $tsisa += $penambahan - $pengembalian;
                @endphp
                <tr class="border-b border-slate-100 odd:bg-white even:bg-blue-50">
                    <td class="p-2">{{ $a->acc_name }}</td>
                    <td class="text-right p-2 text-blue-500 font-bold">{{ Number::format($a->balance) }}</td>
                    <td class="text-right p-2">{{ number_format($penambahan) }}</td>
                    <td class="text-right p-2 text-red-500">{{ number_format($pengembalian) }}</td>
                    <td class="text-right p-2"></td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr class="border-y border-slate-100 odd:bg-white even:bg-blue-50 font-bold">
                    <td class="p-2">Total</td>
                    <td class="text-right p-2 text-red-500">{{ number_format($accounts->sum('balance')) }}</td>
                    <td class="text-right p-2">{{ number_format($tPenambahan) }}</td>
                    <td class="text-right p-2 text-red-500">{{ number_format($tPengembalian) }}</td>
                    <td class="text-right p-2">{!! $tsisa == 0 ? '<div class="text-green-500 font-bold"><i
                                class="fa-solid fa-check"></i> <span class="hidden sm:inline">Completed</span></div>
                        ' :
                        Number::format($tsisa) !!}</td>
                </tr>
            </tfoot>
        </table>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 mt-3">
        <div class="bg-white p-2 rounded-lg">
            <h4 class=" text-green-700 text-lg font-bold mb-3">Mutasi Masuk</h4>
            <input type="text" wire:model.live.debounce.500ms="searchIncrease" placeholder="Search .."
                class="w-full text-sm border rounded-lg p-2 mb-1">
            <table class="table-auto w-full text-xs mb-2">
                <thead class="bg-white text-blue-950">
                    <tr class="border-b">
                        <th class="text-left p-3">Nama Akun</th>
                        <th class="text-center">Jumlah</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($increase as $m)
                    <tr class="border-b border-slate-100 odd:bg-white even:bg-blue-50">
                        <td class="p-2"><span class="font-bold text-sky-800">{{ $m->date_issued }}</span> <span
                                class="font-bold text-slate-700">{{
                                $m->invoice
                                }}</span><br>{{
                            $m->debt->acc_name . ' <- ' . $m->cred->acc_name }}
                        </td>
                        <td class="text-right p-2">{{ number_format($m->amount) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            {{ $increase->onEachSide(0)->links(data: [' scrollTo'=> false]) }}
        </div>
        <div class="bg-white p-2 rounded-lg">
            <h4 class=" text-red-600 text-lg font-bold mb-3">Mutasi Keluar</h4>
            <input type="text" wire:model.live.debounce.500ms="searchDecrease" placeholder="Search .."
                class="w-full text-sm border rounded-lg p-2 mb-1">
            <table class="table-auto w-full text-xs mb-2">
                <thead class="bg-white text-blue-950">
                    <tr class="border-b">
                        <th class="text-left p-3">Nama Akun</th>
                        <th class="text-center">Jumlah</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($decrease as $d)
                    <tr class="border-b border-slate-100 odd:bg-white even:bg-blue-50">
                        <td class="p-2"><span class="font-bold text-sky-800">{{ $d->date_issued }}</span> <span
                                class="font-bold text-slate-700"> {{ $d->invoice
                                }}</span><br>{{
                            $d->cred->acc_name . ' -> ' . $d->debt->acc_name }}</td>
                        <td class="text-right p-2">{{ number_format($d->amount) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            {{ $decrease->onEachSide(0)->links(data: ['scrollTo' => false]) }}
        </div>

    </div>
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