<div>
    <table class="table-auto w-full text-xs mb-2">
        <thead class="bg-slate-500 text-white">
            <tr>
                <th class="p-3 text-left">Saldo Akhir</th>
                <th class="text-right text-lg font-bold">{{ number_format($accounts->sum('balance')) }}</th>
            </tr>
        </thead>

        <tbody class="">
            @foreach ($accounts as $account)
            <tr class="border border-slate-100 bg-slate-200">
                <td class="p-2" colspan="2">{{ $account->acc_name }}</td>
            </tr>
            <tr>
                <td class="p-2 text-right text-lg font-bold bg-white" colspan="2">{{
                    number_format($account->balance) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

</div>