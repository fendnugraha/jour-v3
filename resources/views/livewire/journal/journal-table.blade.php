<div class="bg-white rounded-lg p-2 mb-3 relative">
    @if(session('success'))
    <x-notification>
        <x-slot name="classes">bg-green-500 text-white absolute bottom-1 left-4 z-50</x-slot>
        <strong>Success!!</strong> {{ session('success') }}
    </x-notification>
    @elseif (session('error'))
    <x-notification>
        <x-slot name="classes">bg-red-500 text-white absolute bottom-1 left-4 z-50</x-slot>
        <strong>Error!!</strong> {{
        session('error') }}
    </x-notification>
    @endif
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
    <div class="flex gap-2 flex-col sm:flex-row items-center mb-2">
        <div class="w-full flex gap-2">
            <input type="datetime-local" wire:model.live="startDate" class="text-sm border rounded-lg p-2 w-full">
            <input type="datetime-local" wire:model.live="endDate" class="text-sm border rounded-lg p-2 w-full">
        </div>
        <div class="w-full flex gap-2">
            <select wire:model.live.debounce.500ms="is_taken" class="border rounded-lg p-2 w-full">
                <option value="">Semua</option>
                <option value="1">Sudah diambil</option>
                <option value="2">Belum diambil</option>
            </select>
            <select wire:model.live.debounce.500ms="is_free" class="border rounded-lg p-2 w-full">
                <option value="">Semua</option>
                <option value="1">No admin</option>
            </select>
        </div>
    </div>
    <div class="flex justify-start items-center mb-1 gap-2">
        <input type="text" wire:model.live.debounce.500ms="search" placeholder="Search .."
            class="w-full border text-sm rounded-lg p-2">
        @can('admin')
        <select wire:model.live="warehouse_id" class="w-full text-sm border rounded-lg p-2">
            <option value="">-- Semua --</option>
            @foreach ($warehouses as $c)
            <option value="{{ $c->id }}">{{ $c->name }}</option>
            @endforeach
        </select>
        @endcan
        <select wire:model.live="perPage" wire:change="resetPage" class="text-sm border rounded-lg p-2 w-40">
            <option value="5">5</option>
            <option value="10">10</option>
            <option value="25">25</option>
            <option value="50">50</option>
            <option value="100">100</option>
        </select>
    </div>
    <div class="min-w-full overflow-x-auto">
        <table class="table-auto w-full text-xs mb-2">
            <thead class="bg-white text-blue-950">
                <tr class="border-b-2">
                    <th class="p-4">ID</th>
                    <th>Waktu</th>
                    <th>Keterangan</th>
                    <th>Jumlah</th>
                    <th>Fee admin</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody class="">
                @foreach ($journals as $journal)
                @php
                $hidden = ($journal->trx_type == 'Pengeluaran' || $journal->trx_type == 'Mutasi Kas' ||
                $journal->trx_type == 'Voucher & SP' || $journal->trx_type == 'Deposit') ? 'hidden' : '';
                @endphp
                <tr class="border-b border-slate-100 {{ $journal->debt_code == $cash ? 'text-green-600' : ($journal->cred_code == $cash ? 'text-red-600' : 'text-slate-500') }}
                {{ $journal->status == 2 ? 'bg-yellow-200' : 'odd:bg-white even:bg-blue-50 ' }}">
                    <td class="p-2">{{ $journal->id }}</td>
                    <td>{{ $journal->date_issued }}</td>
                    <td class="p-2">
                        <span class="font-bold">{{ $journal->invoice
                            }} {{
                            $journal->trx_type
                            }}</span> <br>
                        {{ $journal->description }} {{ $journal->sale ? $journal->sale->product->name . ' - ' .
                        $journal->sale->quantity . ' Pcs x Rp' . number_format($journal->sale->price) . '' : '' }}<br>
                        <span class="font-bold">{{ ($journal->cred_code == $cash && $journal->trx_type !== 'Mutasi Kas')
                            ? $journal->debt->acc_name
                            : (($journal->debt_code == $cash && $journal->trx_type !== 'Mutasi Kas')
                            ? $journal->cred->acc_name
                            : $journal->cred->acc_name . ' -> ' . $journal->debt->acc_name)
                            }}</span>
                        <span class="italic font-bold text-slate-600">{{ $journal->status == 2 ? '(Belum diambil)' : ''
                            }}</span>
                    </td>
                    <td class="text-right p-2">{{ number_format($journal->amount) }}</td>
                    <td class="text-right p-2">{{ number_format($journal->fee_amount) }}</td>
                    <td class="text-center p-2">
                        <div class="flex justify-center flex-col gap-1">
                            <a href="{{ route('journal.edit', $journal->id) }}"
                                class="text-slate-800 font-bold bg-yellow-400 py-1 px-3 rounded-lg hover:bg-yellow-300 {{ $hidden }}"><i
                                    class="fa-solid fa-pen-to-square"></i></a>
                            <button wire:click="delete({{ $journal->id }})" wire:loading.attr="disabled"
                                wire:confirm="Apakah anda yakin menghapus data ini?"
                                class="text-white font-bold bg-red-400 py-1 px-3 rounded-lg hover:bg-red-300"><i
                                    class="fa-solid fa-trash"></i></button>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        {{ $journals->onEachSide(0)->links(data: ['scrollTo' => false]) }}
    </div>
</div>