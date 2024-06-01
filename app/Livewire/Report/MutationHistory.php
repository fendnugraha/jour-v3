<?php

namespace App\Livewire\Report;

use Carbon\Carbon;
use App\Models\Journal;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\ChartOfAccount;

class MutationHistory extends Component
{
    use WithPagination;
    public $startDate;
    public $endDate;
    public $warehouse_id;
    public $account;

    public function mount()
    {
        $this->account = '10100-001';
        $this->startDate = date('Y-m-d H:i');
        $this->endDate = date('Y-m-d H:i');
    }

    public function render()
    {
        $journal = new Journal();
        $startDate = Carbon::parse($this->endDate)->startOfDay();
        $endDate = Carbon::parse($this->endDate)->endOfDay();

        $chartOfAccounts = ChartOfAccount::where(fn ($query) => $this->warehouse_id > 1 ? $query->where('warehouse_id', $this->warehouse_id) : $query)->get();
        $journal = new Journal();
        $journals = $journal->with('debt.account', 'cred.account', 'warehouse', 'user')->where('debt_code', $this->account)
            ->whereBetween('date_issued', [$startDate, $endDate])
            ->orWhere('cred_code', $this->account)
            ->WhereBetween('date_issued', [$startDate, $endDate])
            ->orderBy('date_issued', 'asc')
            ->paginate(10);

        $total = $journal->with('debt.account', 'cred.account', 'warehouse', 'user')->where('debt_code', $this->account)
            ->whereBetween('date_issued', [$startDate, $endDate])
            ->orWhere('cred_code', $this->account)
            ->WhereBetween('date_issued', [$startDate, $endDate])
            ->orderBy('date_issued', 'asc')
            ->get();

        $initBalanceDate = Carbon::parse($startDate)->subDay(1)->endOfDay();

        $debt_total = $total->where('debt_code', $this->account)->sum('amount');
        $cred_total = $total->where('cred_code', $this->account)->sum('amount');

        return view('livewire.report.mutation-history', [
            'accounts' => $chartOfAccounts,
            'journals' => $journals,
            'initBalance' => $journal->endBalanceBetweenDate($this->account, '0000-00-00', $initBalanceDate),
            'endBalance' => $journal->endBalanceBetweenDate($this->account, '0000-00-00', $endDate),
            'debt_total' => $debt_total,
            'cred_total' => $cred_total
        ]);
    }
}
