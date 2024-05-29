<div>
    @if(session('success'))
    <x-notification>
        <x-slot name="classes">bg-green-500 text-white absolute bottom-3 left-4</x-slot>
        <strong>Success!!</strong> {{ session('success') }}
    </x-notification>
    @elseif (session('error'))
    <x-notification>
        <x-slot name="classes">bg-red-500 text-white absolute bottom-3 left-4</x-slot>
        <strong>Error!!</strong> {{
        session('error') }}
    </x-notification>
    @endif

    <div>
        <input type="text" wire:model.live.debounce.500ms="search" placeholder="Search .."
            class="w-full border rounded-lg p-2 mb-1">
    </div>
    <table class="table-auto w-full text-xs mb-2">
        <thead class="bg-slate-500 text-white">
            <tr>
                <th class="p-4">ID</th>
                <th>Waktu</th>
                <th>Keterangan</th>
                <th>Jumlah</th>
                <th>Fee admin</th>
                <th>Action</th>

            </tr>
        </thead>

        <tbody class="bg-white">
            @foreach ($journals as $journal)
            <tr class="border border-slate-200">
                <td class="p-3">{{ $journal->id }}</td>
                <td>{{ $journal->date_issued }}</td>
                <td>{{ $journal->description }} <br> {{ $journal->debt->acc_name }} x {{ $journal->cred->acc_name }}
                </td>
                <td class="text-right">{{ number_format($journal->amount, 2) }}</td>
                <td class="text-right">{{ number_format($journal->fee_amount, 2) }}</td>
                <td class="text-center">
                    <a href="/setting/journal/{{ $journal->id }}/edit"
                        class="text-slate-800 font-bold bg-yellow-400 py-1 px-3 rounded-lg hover:bg-yellow-300">Edit</a>
                    <button wire:click="delete({{ $journal->id }})" wire:loading.attr="disabled"
                        wire:confirm="Apakah anda yakin menghapus data ini?"
                        class="text-white font-bold bg-red-400 py-1 px-3 rounded-lg hover:bg-red-300">Delete</button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{ $journals->links() }}
</div>