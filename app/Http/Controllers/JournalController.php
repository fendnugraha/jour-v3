<?php

namespace App\Http\Controllers;

use App\Models\Journal;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use App\Models\ChartOfAccount;

class JournalController extends Controller
{

    public function index()
    {
        return view('journal.index', [
            'title' => 'Jurnal',
            'credits' => ChartOfAccount::where('account_id', 2)->where('warehouse_id', Auth()->user()->warehouse_id)->get(),
        ]);
    }

    public function edit($id)
    {
        $journal = Journal::find($id);

        return view('journal.edit', [
            'title' => 'Edit Transaction',
            'active' => 'reports',
            'account' => ChartOfAccount::with(['account'])->where('warehouse_id', Auth()->user()->warehouse_id)->orderBy('acc_code', 'asc')->get(),
            'journal' => $journal,
            'warehouse_cash' => $journal->warehouse->chartofaccount->acc_code,
        ]);
    }

    public function update(Request $request, $id)
    {
        // dd($request->all());
        $request->validate([
            'debt_code' => 'required',
            'cred_code' => 'required',
            'description' => 'required|max:160',
            'amount' => 'required|numeric',
            'fee_amount' => 'required|numeric',
        ]);

        $status = $request->status == 1 ? 1 : 2;

        $accountTrace = Journal::find($id);
        $accountTrace->date_issued = $request->date_issued;
        $accountTrace->debt_code = $request->debt_code;
        $accountTrace->cred_code = $request->cred_code;
        $accountTrace->amount = $request->amount;
        $accountTrace->fee_amount = $request->fee_amount;
        $accountTrace->status = $status;
        $accountTrace->description = $request->description;
        $accountTrace->save();
        return redirect('/journal')->with('success', 'Data Updated Successfully');
    }

    public function dailyReport()
    {
        return view('report.index', [
            'title' => 'Daily Report',
            'warehouse' => Warehouse::all(),

        ]);
    }

    public function administrator()
    {
        return view('report.administrator', [
            'title' => 'Administrator',
        ]);
    }
}
