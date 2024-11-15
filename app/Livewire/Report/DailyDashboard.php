<?php

namespace App\Livewire\Report;

use Carbon\Carbon;
use App\Models\Journal;
use Livewire\Component;
use App\Models\Warehouse;
use App\Models\ChartOfAccount;
use Illuminate\Support\Facades\Auth;

class DailyDashboard extends Component
{
    public $warehouse_id;
    public $startDate;
    public $endDate;

    public function mount()
    {
        $this->warehouse_id = Auth::user()->warehouse_id;
        $this->startDate = date('Y-m-d H:i');
        $this->endDate = date('Y-m-d H:i');
    }
    public function render()
    {
        $startDate = Carbon::parse($this->startDate)->startOfDay();
        $endDate = Carbon::parse($this->endDate)->endOfDay();

        // Ambil transaksi
        $transactions = $this->getTransactions($startDate, $endDate);

        // Ambil chart of accounts dengan data terkait
        $chartOfAccounts = $this->getChartOfAccounts();

        // Hitung saldo untuk setiap akun
        $this->calculateBalances($chartOfAccounts, $transactions);

        // Ambil transaksi untuk salesCount
        $trx = $this->getTrxForSalesCount($startDate, $endDate);

        // Hitung salesCount
        $salesCount = $this->getSalesCount($trx);

        return view(
            'livewire.report.daily-dashboard',
            [
                'totalCash' => $chartOfAccounts->where('account_id', 1)->sum('balance'),
                'totalBank' => $chartOfAccounts->where('account_id', 2)->sum('balance'),
                'totalTransfer' => $trx->where('trx_type', 'Transfer Uang')->sum('amount'),
                'totalCashWithdrawal' => $trx->where('trx_type', 'Tarik Tunai')->sum('amount'),
                'totalCashDeposit' => $trx->where('trx_type', 'Deposit')->sum('amount'),
                'totalVoucher' => $trx->where('trx_type', 'Voucher & SP')->sum('amount'),
                'totalAccessories' => $trx->where('trx_type', 'Accessories')->sum('amount'),
                'totalExpense' => $trx->where('trx_type', 'Pengeluaran')->sum('fee_amount'),
                'totalFee' => $trx->where('fee_amount', '>', 0)->sum('fee_amount'),
                'profit' => $trx->sum('fee_amount'),
                'salesCount' => $salesCount,
                'warehouses' => Warehouse::all(),
            ]
        );
    }

    // Mendapatkan transaksi
    private function getTransactions($startDate, $endDate)
    {
        return Journal::with(['debt', 'cred'])
            ->selectRaw('debt_code, cred_code, SUM(amount) as total, warehouse_id')
            ->whereBetween('date_issued', [Carbon::create(0000, 1, 1, 0, 0, 0)->startOfDay(), $endDate])
            ->groupBy('debt_code', 'cred_code', 'warehouse_id')
            ->get();
    }

    // Mendapatkan chart of accounts
    private function getChartOfAccounts()
    {
        return ChartOfAccount::with(['account', 'warehouse'])
            ->where(function ($query) {
                if ($this->warehouse_id == "") {
                    $query->orderBy('acc_code', 'asc');
                } else {
                    $query->where('warehouse_id', $this->warehouse_id)
                        ->orderBy('acc_code', 'asc');
                }
            })
            ->get();
    }

    // Menghitung saldo untuk setiap akun
    private function calculateBalances($chartOfAccounts, $transactions)
    {
        foreach ($chartOfAccounts as $value) {
            $debit = $transactions->where('debt_code', $value->acc_code)->sum('total');
            $credit = $transactions->where('cred_code', $value->acc_code)->sum('total');

            $balance = ($value->account->status == "D")
                ? ($value->st_balance + $debit - $credit)
                : ($value->st_balance + $credit - $debit);

            $value->balance = $balance;
        }
    }

    // Mendapatkan transaksi untuk salesCount
    private function getTrxForSalesCount($startDate, $endDate)
    {
        return Journal::whereBetween('date_issued', [$startDate, $endDate])
            ->where(fn($query) => $this->warehouse_id == "" ?
                $query : $query->where('warehouse_id', $this->warehouse_id))
            ->get();
    }

    // Menghitung salesCount
    private function getSalesCount($trx)
    {
        return $trx->whereIn('trx_type', ['Transfer Uang', 'Tarik Tunai', 'Deposit', 'Voucher & SP'])->count();
    }
}
