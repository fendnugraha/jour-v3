<?php

namespace App\Livewire\Report;

use Carbon\Carbon;
use App\Models\Journal;
use Livewire\Component;
use Livewire\WithPagination;

class ExpenseTable extends Component
{
    use WithPagination;

    public $search = '';

    public function render()
    {
        $journals = Journal::where('trx_type', 'Pengeluaran')
            ->whereBetween('date_issued', [Carbon::now()->startOfDay(), Carbon::now()->endOfDay()])
            ->where(fn ($query) => $query
                ->where('description', 'like', '%' . $this->search . '%')
                ->orWhere('invoice', 'like', '%' . $this->search . '%')
                ->orWhere('fee_amount', 'like', '%' . $this->search . '%'))
            ->orderBy('id', 'desc')
            ->paginate(5);
        return view(
            'livewire.report.expense-table',
            [
                'expenses' => $journals
            ]
        );
    }
}
