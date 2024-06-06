<?php

namespace App\Livewire\Journal;

use Carbon\Carbon;
use App\Models\Journal;
use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\ChartOfAccount;

class CashBankBalanceTable extends Component
{
    public $end_date;

    #[On('TransferCreated')]
    public function render()
    {
        $journal = new Journal();
        // $startDate = Carbon::now()->startOfDay();
        $endDate = Carbon::now()->endOfDay();

        $userWarehouseId = Auth()->user()->warehouse_id;

        $transactions = $journal->with(['debt', 'cred'])
            ->selectRaw('debt_code, cred_code, SUM(amount) as total, warehouse_id')
            ->whereBetween('date_issued', [Carbon::create(0000, 1, 1, 0, 0, 0)->startOfDay(), $endDate])
            ->groupBy('debt_code', 'cred_code', 'warehouse_id')
            ->get();

        $chartOfAccounts = ChartOfAccount::with(['account', 'warehouse'])->get();

        foreach ($chartOfAccounts as $value) {
            $debit = $transactions->where('debt_code', $value->acc_code)->sum('total');
            $credit = $transactions->where('cred_code', $value->acc_code)->sum('total');

            // @ts-ignore
            $value->balance = ($value->account->status == "D") ? ($value->st_balance + $debit - $credit) : ($value->st_balance + $credit - $debit);
        }

        return view('livewire.journal.cash-bank-balance-table', [
            'accounts' => $chartOfAccounts->where('warehouse_id', $userWarehouseId),
        ]);
    }
}
