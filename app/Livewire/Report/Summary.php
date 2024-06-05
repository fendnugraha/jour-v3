<?php

namespace App\Livewire\Report;

use App\Models\Journal;
use App\Models\Sale;
use App\Models\Warehouse;
use Carbon\Carbon;
use Livewire\Component;

class Summary extends Component
{
    public $startDate;
    public $endDate;

    public function mount()
    {
        $this->startDate = date('Y-m-d H:i');
        $this->endDate = date('Y-m-d H:i');
    }

    public function render(Warehouse $warehouse)
    {
        $journal = new Journal();
        $startDate = Carbon::parse($this->startDate)->startOfDay();
        $endDate = Carbon::parse($this->endDate)->endOfDay();

        $revenue = $journal->with('warehouse')->selectRaw('SUM(amount) as total, warehouse_id, SUM(fee_amount) as sumfee')
            ->whereBetween('date_issued', [$startDate, $endDate])
            ->groupBy('warehouse_id')
            ->orderBy('sumfee', 'desc')
            ->get();

        return view('livewire.report.summary', [
            'revenue' => $revenue
        ]);
    }
}
