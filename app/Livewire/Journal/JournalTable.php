<?php

namespace App\Livewire\Journal;

use App\Models\Sale;
use App\Models\Journal;
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
    public $endDate;

    public function mount()
    {
        $this->endDate = date('Y-m-d H:i');
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

        $this->dispatch('JournalDeleted', $journal->id);
    }

    #[On('TransferCreated', 'JournalDeleted')]
    public function render()
    {
        $startDate = Carbon::parse($this->endDate)->startOfDay();
        $endDate = Carbon::parse($this->endDate)->endOfDay();
        $warehouse = Auth::user()->warehouse;
        $Journal = Journal::with('debt', 'cred', 'sale.product')
            ->whereBetween('date_issued', [$startDate, $endDate])
            ->where('warehouse_id', $warehouse->id)
            ->where('status', 'like', '%' . $this->is_taken . '%')
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
            ->paginate(5);

        return view('livewire.journal.journal-table', [
            'journals' => $Journal,
            'cash' => $warehouse->ChartOfAccount->acc_code
        ]);
    }
}
