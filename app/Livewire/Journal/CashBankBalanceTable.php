<?php

namespace App\Livewire\Journal;

use Carbon\Carbon;
use App\Models\Journal;
use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\ChartOfAccount;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class CashBankBalanceTable extends Component
{
    public $end_date;
    public $chartOfAccounts = [];

    #[On('TransferCreated')]
    public function refreshData()
    {
        $journal = new Journal();
        $endDate = Carbon::now()->endOfDay();

        $transactions = $journal->with(['debt', 'cred'])
            ->selectRaw('debt_code, cred_code, SUM(amount) as total, warehouse_id')
            ->whereBetween('date_issued', [Carbon::create(0000, 1, 1, 0, 0, 0)->startOfDay(), $endDate])
            ->where('warehouse_id', Auth::user()->warehouse_id) // Tambahkan filter di query
            ->groupBy('debt_code', 'cred_code', 'warehouse_id')
            ->get();

        $chartOfAccounts = ChartOfAccount::with(['account', 'warehouse'])->get();

        foreach ($chartOfAccounts as $value) {
            $debit = $transactions->where('debt_code', $value->acc_code)->sum('total');
            $credit = $transactions->where('cred_code', $value->acc_code)->sum('total');

            $value->balance = ($value->account->status == "D")
                ? ($value->st_balance + $debit - $credit)
                : ($value->st_balance + $credit - $debit);
        }

        // Simpan data untuk digunakan di render()
        $this->chartOfAccounts = $chartOfAccounts;
    }

    public function mount()
    {
        $this->refreshData(); // Muat data pertama kali
    }

    public function render()
    {
        $userWarehouseId = Auth::user()->warehouse_id;

        return view('livewire.journal.cash-bank-balance-table', [
            'accounts' => collect($this->chartOfAccounts),
        ]);
    }
}
