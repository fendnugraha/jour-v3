<div>
    @if(session('success'))
    <div class="bg-green-500 text-white p-2 rounded-lg mb-3"><strong>Success!!</strong> {{ session('success') }}</div>
    @elseif (session('error'))
    <div class="bg-red-500 text-white p-2 rounded-lg mb-3"><strong>Error!!</strong> {{ session('error') }}</div>
    @endif
    <div>
        <input type="text" wire:model.live.debounce.500ms="search" placeholder="Search .."
            class="w-full border rounded-lg p-2 mb-3">
    </div>
    <table class="table-auto w-full text-xs">
        <thead>
            <tr class="bg-slate-500 text-white">
                <th class="border border-slate-200 p-3">ID</th>
                <th class="border border-slate-200 p-3">Code</th>
                <th class="border border-slate-200">Name</th>
                <th class="border border-slate-200">Address</th>
                <th class="border border-slate-200">Cash Account</th>
                <th class="border border-slate-200">Created At</th>
                <th class="border border-slate-200">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($warehouses as $warehouse)
            <tr>
                <td class="border border-slate-200 p-2">{{ $warehouse->id }}</td>
                <td class="border border-slate-200 p-2">{{ $warehouse->code }}</td>
                <td class="border border-slate-200 p-2">{{ $warehouse->name }}</td>
                <td class="border border-slate-200 p-2">{{ $warehouse->address }}</td>
                <td class="border border-slate-200 p-2">{{ $warehouse->ChartOfAccount->acc_name }}</td>
                <td class="border border-slate-200 p-2 text-center">{{ $warehouse->created_at }}</td>
                <td class="border border-slate-200 p-2 text-center">
                    <a href="/setting/warehouse/{{ $warehouse->id }}/edit"
                        class="text-slate-800 font-bold bg-yellow-400 py-2 px-5 rounded-lg hover:bg-yellow-300">Edit</a>
                    <button wire:click="delete({{ $warehouse->id }})" wire:loading.attr="disabled"
                        wire:confirm="Apakah anda yakin menghapus data ini?"
                        class="text-white font-bold bg-red-400 py-2 px-5 rounded-lg hover:bg-red-300">
                        Delete
                    </button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>