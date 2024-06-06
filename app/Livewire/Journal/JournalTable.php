<?php

namespace App\Livewire\Journal;

use App\Models\Sale;
use App\Models\Journal;
use App\Models\Warehouse;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithPagination;
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

    public function mount()
    {
        $this->startDate = date('Y-m-d H:i');
        $this->endDate = date('Y-m-d H:i');
    }

    public function updateLimitPage()
    {
        $this->resetPage();
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

        $warehouse = Auth::user()->warehouse;
        $Journal = Journal::with('debt.account', 'cred.account', 'sale.product')
            ->whereBetween('date_issued', [$startDate, $endDate])
            ->where(fn ($query) => $this->warehouse_id !== "" ? $query->where('warehouse_id', $this->warehouse_id) : $query)
            ->where('status', 'like', '%' . $this->is_taken . '%')
            ->where(fn ($query) => $this->is_free ? $query->where('fee_amount', 0) : $query)
            ->where(function ($query) {
                $query->where('invoice', 'like', '%' . $this->search . '%')
                    ->orWhere('description', 'like', '%' . $this->search . '%')
                    ->orWhere('cred_code', 'like', '%' . $this->search . '%')
                    ->orWhere('debt_code', 'like', '%' . $this->search . '%')
                    ->orWhere('date_issued', 'like', '%' . $this->search . '%')
                    ->orWhere('trx_type', 'like', '%' . $this->search . '%')
                    ->orWhere('status', 'like', '%' . $this->search . '%')
                    ->orWhere('amount', 'like', '%' . $this->search . '%')
                    ->orWhere('fee_amount', 'like', '%' . $this->search . '%')
                    ->orWhereHas('debt', function ($query) {
                        $query->where('acc_name', 'like', '%' . $this->search . '%');
                    })
                    ->orWhereHas('cred', function ($query) {
                        $query->where('acc_name', 'like', '%' . $this->search . '%');
                    });
            })
            ->orderBy('id', 'desc')
            ->paginate($this->perPage, ['*'], 'journalPage');

        return view('livewire.journal.journal-table', [
            'journals' => $Journal,
            'cash' => $warehouse->ChartOfAccount->acc_code,
            'warehouses' => Warehouse::all(),
        ]);
    }
}
