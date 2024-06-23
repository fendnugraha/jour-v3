<?php

namespace App\Livewire\Journal;

use Carbon\Carbon;
use App\Models\Sale;
use App\Models\Journal;
use Livewire\Component;
use App\Models\Warehouse;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use App\Models\ChartOfAccount;
use Illuminate\Support\Facades\DB;
use Livewire\WithoutUrlPagination;
use Illuminate\Support\Facades\Auth;

class JournalTable extends Component
{
    use WithPagination, WithoutUrlPagination;

    public $search = '';
    public $is_taken = '';
    public $startDate;
    public $endDate;
    public $is_free;
    public $warehouse_id;
    public $perPage = 5;
    public $account;

    public function mount()
    {
        $this->startDate = date('Y-m-d H:i');
        $this->endDate = date('Y-m-d H:i');
        $this->account = "";
    }

    public function updateLimitPage($pageName = 'page')
    {
        $this->resetPage(pageName: $pageName);
    }

    public function delete($id)
    {
        $journal = journal::find($id);
        try {
            DB::beginTransaction();

            $journal->delete();
            Sale::where('invoice', $journal->invoice)->delete();

            DB::commit();
            session()->flash('success', 'Transaction deleted successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Transaction failed.');
        }

        $this->dispatch('TransferCreated', $journal->id);
    }

    #[On('TransferCreated')]
    public function render()
    {
        $startDate = Carbon::parse($this->startDate)->startOfDay();
        $endDate = Carbon::parse($this->endDate)->endOfDay();

        $Journal = new Journal();

        $warehouseChart = ChartOfAccount::where('warehouse_id', Auth::user()->warehouse_id)->pluck('acc_code');
        // dd($warehouseChart);

        $warehouse = Auth::user()->warehouse;
        $transaction = $Journal->with('debt', 'cred', 'sale.product')
            ->whereBetween('date_issued', [$startDate, $endDate])
            ->where(fn ($query) => $this->warehouse_id !== "" ? $query->whereIn('debt_code', $warehouseChart)->orWhereIn('cred_code', $warehouseChart)->orWhere('warehouse_id', $this->warehouse_id) : $query)
            ->where('status', 'like', '%' . $this->is_taken . '%')
            ->where(fn ($query) => $this->is_free ? $query->where('fee_amount', 0) : $query)
            ->where(fn ($query) => $this->account !== "" ? $query->where('debt_code', $this->account)->orWhere('cred_code', $this->account) : $query)
            ->FilterJournals(['search' => $this->search, 'account' => $this->account])
            ->orderBy('id', 'desc')
            ->paginate($this->perPage, ['*'], 'journalPage');

        $initBalanceDate = Carbon::parse($startDate)->subDay(1)->endOfDay();
        $debt_total = $this->account == "" ? 0 : $transaction->where('debt_code', $this->account)->sum('amount');
        $cred_total = $this->account == "" ? 0 : $transaction->where('cred_code', $this->account)->sum('amount');

        return view('livewire.journal.journal-table', [
            'journals' => $transaction,
            'cash' => $warehouse->ChartOfAccount->acc_code,
            'warehouses' => Warehouse::all(),
            'credits' => ChartOfAccount::whereIn('account_id', [1, 2])->where('warehouse_id', Auth()->user()->warehouse_id)->get(),
            'debt_total' => $debt_total,
            'cred_total' => $cred_total,
            'initBalance' => $this->account == "" ? 0 : $Journal->endBalanceBetweenDate($this->account, '0000-00-00', $initBalanceDate),
            'endBalance' => $this->account == "" ? 0 : $Journal->endBalanceBetweenDate($this->account, '0000-00-00', $endDate),
        ]);
    }
}
