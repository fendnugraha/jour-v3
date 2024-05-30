<?php

namespace App\Livewire\Report;

use Carbon\Carbon;
use App\Models\Journal;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\ChartOfAccount;

class TransferFromHqTable extends Component
{
    use WithPagination;

    public $searchIncrease;
    public $searchDecrease;

    public function render()
    {
        $journals = new Journal();
        $chartOfAccounts = ChartOfAccount::where('warehouse_id', auth()->user()->warehouse_id)->get();
        $startDate = Carbon::now()->startOfDay();
        $endDate = Carbon::now()->endOfDay();

        $journal = $journals->whereBetween('date_issued', [$startDate, $endDate])->where('trx_type', 'Mutasi Kas')->get();

        $penambahan = $journals->where('trx_type', 'Mutasi Kas')
            ->whereIn('debt_code', $chartOfAccounts->pluck('acc_code'))
            ->whereBetween('date_issued', [$startDate, $endDate])
            ->whereHas('debt', function ($query) {
                $query->where('acc_name', 'like', '%' . $this->searchIncrease . '%');
            })->paginate(5);

        $pengembalian = $journals->where('trx_type', 'Mutasi Kas')
            ->whereIn('cred_code', $chartOfAccounts->pluck('acc_code'))
            ->whereBetween('date_issued', [$startDate, $endDate])
            ->whereHas('cred', function ($query) {
                $query->where('acc_name', 'like', '%' . $this->searchDecrease . '%');
            })->paginate(5);

        return view('livewire.report.transfer-from-hq-table', [
            'journal' => $journal,
            'accounts' => $chartOfAccounts,
            'increase' => $penambahan,
            'decrease' => $pengembalian,
        ]);
    }
}
