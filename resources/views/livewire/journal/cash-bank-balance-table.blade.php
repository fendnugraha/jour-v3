<div>
    <h4 class="text-lg font-bold mb-2 text-right">Total: {{ number_format($accounts->sum('balance')) }}</h4>
    <table class="table-auto w-full text-xs mb-2">

        <tbody class="">
            @foreach ($accounts as $account)
            <tr class="border border-slate-100 bg-slate-200">
                <td class="font-bold p-2" colspan="2">{{ $account->acc_name }}</td>
            </tr>
            <tr>
                <td class="p-2 text-right text-lg font-bold bg-white text-amber-500" colspan="2">{{
                    number_format($account->balance) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

</div>