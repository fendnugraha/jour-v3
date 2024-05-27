<div>
    @if(session('success'))
    <div class="bg-green-500 text-white p-2 rounded-lg mb-3"><strong>Success!!</strong> {{ session('success') }}</div>
    @endif
    <div>
        <input type="text" class="w-full border rounded-lg p-2 mb-3" wire:model.live.debounce.500ms="search"
            placeholder="Search ..">
    </div>
    <table id="dataTable" class="table-auto w-full font-light mb-3 text-xs">
        <thead>
            <tr class="bg-slate-500 text-white">
                <th class="p-4">ID</th>
                <th>Code</th>
                <th>Name</th>
                <th>Type</th>
                <th>Starting Balance</th>
                <th class="text-center">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($accounts as $account)
            <tr class="border border-slate-200">
                <td class="p-3">{{ $account->id }}</td>
                <td>{{ $account->acc_code }}</td>
                <td>{{ $account->acc_name }}</td>
                <td>{{ $account->account->name }}</td>
                <td class="text-right">{{ number_format($account->st_balance, 2) }}</td>
                <td class="text-center">
                    <a href="/setting/account/{{ $account->id }}/edit"
                        class="text-slate-800 font-bold bg-yellow-400 py-2 px-5 rounded-lg hover:bg-yellow-300">Edit</a>
                    <button wire:click="delete({{ $account->id }})" wire:loading.attr="disabled"
                        wire:confirm="Are you sure?"
                        class="text-white font-bold bg-red-400 py-2 px-5 rounded-lg hover:bg-red-300">Delete</button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $accounts->links() }}
</div>