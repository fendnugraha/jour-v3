<?php

namespace App\Http\Controllers;

use App\Models\ChartOfAccount;
use Illuminate\Http\Request;

class ChartOfAccountController extends Controller
{
    public function index()
    {

        return view(
            'setting.account.index',
            [
                'title' => 'Chart Of Account',
                'accounts' => ChartOfAccount::with('account')->get(),
            ]
        );
    }

    public function edit($id)
    {
        $account = ChartOfAccount::find($id);
        return view(
            'setting.account.edit',
            [
                'title' => 'Edit Account' . ' ' . $account->acc_name,
                'account' => $account,
            ]
        );
    }

    public function update(Request $request, $id)
    {
        $ChartOfAccount = ChartOfAccount::find($id);

        $request->validate([
            'name' => 'required|max:60|min:5|unique:chart_of_accounts,acc_name,' . $ChartOfAccount->id,
            'st_balance' => 'numeric',
        ]);

        $ChartOfAccount->update([
            'acc_name' => $request->name,
            'st_balance' => $request->st_balance,
        ]);

        return redirect('/setting/account')->with('success', 'Account Updated Successfully!');
    }
}
