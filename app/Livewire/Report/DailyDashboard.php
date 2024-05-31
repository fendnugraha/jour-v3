<?php

namespace App\Livewire\Report;

use Carbon\Carbon;
use App\Models\Journal;
use Livewire\Component;
use App\Models\ChartOfAccount;

class DailyDashboard extends Component
{
    public $warehouse_id;

    public function render()
    {
        $startDate = Carbon::now()->startOfDay();
        $endDate = Carbon::now()->endOfDay();

        // Retrieve transactions grouped by debt and credit codes
        $transactions = Journal::with(['debt', 'cred'])
            ->selectRaw('debt_code, cred_code, SUM(amount) as total, warehouse_id')
            ->whereBetween('date_issued', [Carbon::create(0000, 1, 1, 0, 0, 0)->startOfDay(), $endDate])
            ->groupBy('debt_code', 'cred_code', 'warehouse_id')
            ->get();


        // Retrieve chart of accounts with related data
        $chartOfAccounts = ChartOfAccount::with(['account', 'warehouse'])
            ->where(function ($query) {
                if ($this->warehouse_id == 1) {
                    $query->orderBy('acc_code', 'asc');
                } else {
                    $query->where('warehouse_id', $this->warehouse_id)
                        ->orderBy('acc_code', 'asc');
                }
            })
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

        $trx = Journal::whereBetween('date_issued', [$startDate, $endDate])
            ->where(fn ($query) => $this->warehouse_id == 1 ?
                $query : $query->where('warehouse_id', $this->warehouse_id))
            ->get();

        $salesCount = $trx->whereIn('trx_type', ['Transfer Uang', 'Tarik Tunai', 'Deposit', 'Voucher & SP'])->Count();

        return view(
            'livewire.report.daily-dashboard',
            [
                'totalCash' => $chartOfAccounts->where('account_id', 1)->sum('balance'),
                'totalBank' => $chartOfAccounts->where('account_id', 2)->sum('balance'),
                'totalTransfer' => $trx->where('trx_type', 'Transfer Uang')->sum('amount'),
                'totalCashWithdrawal' => $trx->where('trx_type', 'Tarik Tunai')->sum('amount'),
                'totalCashDeposit' => $trx->where('trx_type', 'Deposit')->sum('amount'),
                'totalVoucher' => $trx->where('trx_type', 'Voucher & SP')->sum('amount'),
                'totalExpense' => $trx->where('trx_type', 'Pengeluaran')->sum('fee_amount'),
                'totalFee' => $trx->where('fee_amount', '>', 0)->sum('fee_amount'),
                'profit' => $trx->sum('fee_amount'),
                'salesCount' => $salesCount
            ]
        );
    }
}
