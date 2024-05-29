<?php

namespace App\Livewire\Journal;

use App\Models\Journal;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithPagination;

class JournalTable extends Component
{
    use WithPagination;

    public $search = '';

    #[On('TransferCreated')]
    public function render()
    {
        $warehouse = Auth::user()->warehouse;
        $Journal = Journal::with('debt', 'cred', 'sale.product')->where('warehouse_id', $warehouse->id)->where('invoice', 'like', '%' . $this->search . '%')
            ->orWhere('description', 'like', '%' . $this->search . '%')->where('warehouse_id', $warehouse->id)
            ->orWhere('cred_code', 'like', '%' . $this->search . '%')->where('warehouse_id', $warehouse->id)
            ->orWhere('debt_code', 'like', '%' . $this->search . '%')->where('warehouse_id', $warehouse->id)
            ->orWhere('date_issued', 'like', '%' . $this->search . '%')->where('warehouse_id', $warehouse->id)
            ->orWhere('trx_type', 'like', '%' . $this->search . '%')->where('warehouse_id', $warehouse->id)
            ->orWhere('status', 'like', '%' . $this->search . '%')->where('warehouse_id', $warehouse->id)
            ->orWhereHas('debt', function ($query) {
                $query->where('acc_name', 'like', '%' . $this->search . '%');
            })->where('warehouse_id', $warehouse->id)
            ->orWhereHas('cred', function ($query) {
                $query->where('acc_name', 'like', '%' . $this->search . '%');
            })->where('warehouse_id', $warehouse->id)
            ->orderBy('id', 'desc')->Paginate(10);
        return view('livewire.journal.journal-table', [
            'journals' => $Journal,
            'cash' => $warehouse->ChartOfAccount->acc_code
        ]);
    }
}
