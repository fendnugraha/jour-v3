<div>
    <table class="table-auto w-full text-xs mb-2">
        <thead class="bg-slate-500 text-white">
            <tr>
                <th class="p-3" colspan="2">Saldo Akhir</th>
            </tr>
        </thead>

        <tbody class="">
            @foreach ($accounts as $account)
            <tr class="border border-slate-100 odd:bg-white even:bg-slate-50">
                <td class="p-2">{{ $account->acc_name }}</td>
                <td class="p-2 text-right">{{ number_format($account->balance) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

</div>