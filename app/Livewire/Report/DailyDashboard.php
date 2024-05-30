<?php

namespace App\Livewire\Report;

use Carbon\Carbon;
use App\Models\Journal;
use Livewire\Component;
use App\Models\ChartOfAccount;

class DailyDashboard extends Component
{
    public function render()
    {
        $startDate = Carbon::now()->startOfDay();
        $endDate = Carbon::now()->endOfDay();
        $warehouse_id = Auth()->user()->warehouse_id;

        // Retrieve transactions grouped by debt and credit codes
        $transactions = Journal::with(['debt', 'cred'])
            ->selectRaw('debt_code, cred_code, SUM(amount) as total, warehouse_id')
            ->whereBetween('date_issued', [Carbon::create(0000, 1, 1, 0, 0, 0)->startOfDay(), $endDate])
            ->groupBy('debt_code', 'cred_code', 'warehouse_id')
            ->get();

        // Retrieve chart of accounts with related data
        $chartOfAccounts = ChartOfAccount::with(['account', 'warehouse'])
            ->orderBy('acc_code', 'asc')
            ->get();

        // Calculate balances for each account
        foreach ($chartOfAccounts as $value) {
            $debit = $transactions->where('debt_code', $value->acc_code)->sum('total');
            $credit = $transactions->where('cred_code', $value->acc_code)->sum('total');

            $balance = ($value->account->status == "D")
                ? ($value->st_balance + $debit - $credit)
                : ($value->st_balance + $credit - $debit);

            $value->balance = $balance;
        }

        return view(
            'livewire.report.daily-dashboard',
            [
                'totalCash' => $chartOfAccounts->where('account_id', 1)->where('warehouse_id', $warehouse_id)->sum('balance'),
            ]
        );
    }
}
