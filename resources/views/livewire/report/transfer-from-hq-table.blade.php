<div class="mb-6 relative">
    <div class="bg-white p-2 rounded-lg ">
        <h4 class=" text-blue-950 text-lg font-bold py-3">Mutasi Saldo</h4>
        @can('admin')
        <div class="flex gap-2 flex-col sm:flex-row w-full sm:w-auto">
            <div>
                <input type="datetime-local" wire:model.live="endDate" class="w-full text-sm border rounded-lg p-2">
            </div>
            <div class="w-full">
                <select wire:model.live="warehouse_id" class="sm:w-1/2 w-full text-sm border rounded-lg p-2"
                    wire:change="updateLimitPage">
                    @foreach ($warehouse as $c)
                    <option value="{{ $c->id }}">{{ $c->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="hidden sm:block">
                <x-modal modalName="mutasiSaldo" modalTitle="Mutasi Saldo Kas & Bank">
                    <livewire:journal.create-mutation />
                </x-modal>
                <button x-data x-on:click="$dispatch('open-modal', {'modalName': 'mutasiSaldo'})"
                    class="bg-blue-950 text-white rounded-lg py-1 px-3 min-w-40">
                    <i class="fa-solid fa-plus"></i> Mutasi Saldo
                </button>
            </div>
        </div>
        @endcan
        <table class="table-auto w-full text-xs mb-2">
            <thead class="bg-white text-blue-950">
                <tr class="border-b">
                    <th class="text-left p-3"><button wire:click="$refresh"
                            class="bg-sky-950 text-white px-2 py-1 text-sm shadow-300 justify-center items-center rounded-full hover:bg-sky-800 transition duration-300 ease-out"><i
                                class="fa-solid fa-arrows-rotate"></i></button> &nbsp;Nama Akun</th>
                    <th class="text-center">Saldo Akhir</th>
                    <th class="text-center">Masuk</th>
                    <th class="text-center">keluar</th>
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
    <div class="bg-white p-2 rounded-lg mt-3">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
            <h4 class=" text-green-700 text-lg font-bold mb-3">History Mutasi Saldo</h4>
            <div class="flex justify-start items-center mb-1 gap-2">
                <input type="text" wire:model.live.debounce.1500ms="searchHistory" placeholder="Search .."
                    class="w-full text-sm border rounded-lg p-2" wire:change="updateLimitPage('history')">
                <select wire:model.live="perPage" class="text-sm border rounded-lg p-2 w-40"
                    wire:change="updateLimitPage('history')">
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
                <tr class="border-b">
                    <th class="text-left p-3">Nama Akun</th>
                    <th class="text-center">Masuk (Debet)</th>
                    <th class="text-center">Keluar (Credit)</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($history as $m)
                @php
                $debtAmount = $whAccounts->contains($m->debt_code) ? number_format($m->amount) : '';
                $credAmount = $whAccounts->contains($m->cred_code) ? number_format($m->amount) : '';
                @endphp
                <tr class="border-b border-slate-100 odd:bg-white even:bg-blue-50">
                    <td class="p-2"><span class="font-bold text-slate-700">{{ $m->date_issued }} | {{
                            $m->invoice
                            }}</span><br>{{
                        $m->cred->acc_name . ' --> ' . $m->debt->acc_name }}
                    </td>
                    <td class="text-right p-3">{{ $debtAmount }}</td>
                    <td class="text-right p-3">{{ $credAmount }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        {{ $history->onEachSide(0)->links(data: ['scrollTo'=> false]) }}
    </div>

    <div class="absolute inset-0 flex items-center justify-center" wire:loading>
        <!-- Container for the loading message -->
        <div class="bg-slate-50/10 backdrop-blur-sm h-full w-full flex items-center justify-center gap-2">
            <!-- Loading text -->
            <i class="fa-solid fa-spinner animate-spin text-blue-950 text-3xl"></i>
            <p class="text-blue-950 text-sm font-bold">
                Loading data, please wait...
            </p>
        </div>
    </div>
</div>