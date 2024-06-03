<?php

namespace App\Livewire\Report;

use Carbon\Carbon;
use App\Models\Journal;
use Livewire\Component;
use App\Models\ChartOfAccount;
use App\Models\Warehouse;
use Livewire\WithPagination;

class WarehouseBalance extends Component
{
    use WithPagination;

    public $endDate;
    public $search;
    public $perPage = 10;

    public function mount()
    {
        $this->endDate = date('Y-m-d H:i');
    }
    public function render()
    {
        $journal = new Journal();
        $endDate = Carbon::parse($this->endDate)->endOfDay();

        $transactions = $journal
            ->with('warehouse')
            ->selectRaw('debt_code, cred_code, SUM(amount) as total')
            ->whereBetween('date_issued', [Carbon::create(0000, 1, 1, 0, 0, 0)->startOfDay(), $endDate])
            ->groupBy('debt_code', 'cred_code')
            ->get();

        $chartOfAccounts = ChartOfAccount::with(['account'])->get();

        foreach ($chartOfAccounts as $value) {
            $debit = $transactions->where('debt_code', $value->acc_code)->sum('total');
            $credit = $transactions->where('cred_code', $value->acc_code)->sum('total');

            // @ts-ignore
            $value->balance = ($value->account->status == "D") ? ($value->st_balance + $debit - $credit) : ($value->st_balance + $credit - $debit);
        }

        $sumtotalCash = $chartOfAccounts->whereIn('account_id', ['1']);
        $sumtotalBank = $chartOfAccounts->whereIn('account_id', ['2']);

        $warehouse = Warehouse::where('name', 'like', '%' . $this->search . '%')
            ->orWhere('code', 'like', '%' . $this->search . '%')
            ->orderBy('name', 'asc')
            ->paginate($this->perPage, ['*'], 'warehouseBalance');

        return view('livewire.report.warehouse-balance', [
            'accounts' => $chartOfAccounts,
            'warehouses' => $warehouse,
            'sumtotalCash' => $sumtotalCash,
            'sumtotalBank' => $sumtotalBank
        ]);
    }
}
