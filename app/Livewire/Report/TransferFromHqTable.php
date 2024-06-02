<?php

namespace App\Livewire\Report;

use Carbon\Carbon;
use App\Models\Journal;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use App\Models\ChartOfAccount;
use App\Models\Warehouse;

class TransferFromHqTable extends Component
{
    use WithPagination;

    public $balance;
    public $warehouse_id;
    public $startDate;
    public $endDate;

    public $searchIncrease;
    public $searchDecrease;

    public function mount()
    {
        $this->endDate = date('Y-m-d H:i');
    }
    #[On('TransferCreated')]
    public function render()
    {
        $journals = new Journal();
        $chartOfAccounts = ChartOfAccount::with(['account', 'warehouse'])->where('warehouse_id', $this->warehouse_id)->get();
        $startDate = Carbon::parse($this->endDate)->startOfDay();
        $endDate = Carbon::parse($this->endDate)->endOfDay();

        $transactions = $journals->with(['debt', 'cred'])
            ->selectRaw('debt_code, cred_code, SUM(amount) as total, warehouse_id')
            ->whereBetween('date_issued', [Carbon::create(0000, 1, 1, 0, 0, 0)->startOfDay(), $endDate])
            ->groupBy('debt_code', 'cred_code', 'warehouse_id')
            ->get();

        // $chartOfAccounts = ChartOfAccount::with(['account', 'warehouse'])->get();

        foreach ($chartOfAccounts as $value) {
            $debit = $transactions->where('debt_code', $value->acc_code)->sum('total');
            $credit = $transactions->where('cred_code', $value->acc_code)->sum('total');

            // @ts-ignore
            $value->balance = ($value->account->status == "D") ? ($value->st_balance + $debit - $credit) : ($value->st_balance + $credit - $debit);
        }

        $journal = $journals->whereBetween('date_issued', [$startDate, $endDate])->where('trx_type', 'Mutasi Kas')->get();

        $penambahan = $journals->where('trx_type', 'Mutasi Kas')
            ->whereIn('debt_code', $chartOfAccounts->pluck('acc_code'))
            ->whereBetween('date_issued', [$startDate, $endDate])
            ->whereHas('debt', function ($query) {
                $query->where('acc_name', 'like', '%' . $this->searchIncrease . '%');
            })->orderBy('id', 'desc')->paginate(5, ['*'], 'increase');

        $pengembalian = $journals->where('trx_type', 'Mutasi Kas')
            ->whereIn('cred_code', $chartOfAccounts->pluck('acc_code'))
            ->whereBetween('date_issued', [$startDate, $endDate])
            ->whereHas('cred', function ($query) {
                $query->where('acc_name', 'like', '%' . $this->searchDecrease . '%');
            })->orderBy('id', 'desc')->paginate(5, ['*'], 'decrease');
        // dd($startDate, $endDate);
        return view('livewire.report.transfer-from-hq-table', [
            'journal' => $journal,
            'accounts' => $chartOfAccounts,
            'increase' => $penambahan,
            'decrease' => $pengembalian,
            'warehouse' => Warehouse::all(),
        ]);
    }
}
