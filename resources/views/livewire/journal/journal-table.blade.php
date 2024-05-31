<div class="bg-white rounded-lg p-2">
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
    <div wire:loading class="bg-slate-500/80 text-xs italic text-white p-2 rounded-lg absolute bottom-0 left-3 z-50">
        Loading, please wait ...
    </div>
    <div class="grid grid-cols-4 gap-2">
        <select wire:model.live.debounce.500ms="is_taken" class="w-full border rounded-lg p-2 col-span-1">
            <option value="">Semua</option>
            <option value="1">Sudah diambil</option>
            <option value="2">Belum diambil</option>
        </select>
        <input type="text" wire:model.live.debounce.500ms="search" placeholder="Search .."
            class="w-full border rounded-lg p-2 mb-1 col-span-3">
    </div>
    <div class="min-w-full overflow-x-auto">
        <table class="table-auto w-full text-xs mb-2">
            <thead class="bg-white text-blue-950">
                <tr class="border-b">
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
                        <span class="font-bold">{{ $journal->cred_code == $cash ? $journal->debt->acc_name :
                            $journal->cred->acc_name
                            }}</span>
                        <span class="italic font-bold text-slate-600">{{ $journal->status == 2 ? '(Belum diambil)' : ''
                            }}</span>
                    </td>
                    <td class="text-right p-2">{{ number_format($journal->amount) }}</td>
                    <td class="text-right p-2">{{ number_format($journal->fee_amount) }}</td>
                    <td class="text-center p-2">
                        <div class="flex justify-center flex-col gap-1">
                            <a href="/setting/journal/{{ $journal->id }}/edit"
                                class="text-slate-800 font-bold bg-yellow-400 py-1 px-3 rounded-lg hover:bg-yellow-300"><i
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

        {{ $journals->links() }}
    </div>
</div>