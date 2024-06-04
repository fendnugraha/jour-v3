<?php

namespace App\Livewire\Report;

use Carbon\Carbon;
use App\Models\Journal;
use Livewire\Component;
use App\Models\Warehouse;
use Livewire\WithPagination;

class ExpenseTable extends Component
{
    use WithPagination;

    public $search = '';
    public $warehouse_id;
    public $startDate;
    public $endDate;

    public function mount()
    {
        $this->startDate = date('Y-m-d H:i');
        $this->endDate = date('Y-m-d H:i');
    }

    public function render()
    {
        $startDate = Carbon::parse($this->endDate)->startOfDay();
        $endDate = Carbon::parse($this->endDate)->endOfDay();

        $journals = Journal::where('trx_type', 'Pengeluaran')
            ->whereBetween('date_issued', [$startDate, $endDate])
            ->where(fn ($query) => $this->warehouse_id > 1 ? $query->where('warehouse_id', $this->warehouse_id) : $query)
            ->where(fn ($query) => $query
                ->where('description', 'like', '%' . $this->search . '%')
                ->orWhere('invoice', 'like', '%' . $this->search . '%')
                ->orWhere('fee_amount', 'like', '%' . $this->search . '%'))
            ->orderBy('id', 'desc')
            ->paginate(5, ['*'], 'expenses');

        return view(
            'livewire.report.expense-table',
            [
                'expenses' => $journals,
                'warehouse' => Warehouse::all()
            ]
        );
    }
}
