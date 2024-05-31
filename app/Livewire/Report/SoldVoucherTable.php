<?php

namespace App\Livewire\Report;

use Carbon\Carbon;
use App\Models\Sale;
use Livewire\Component;
use Livewire\WithPagination;

class SoldVoucherTable extends Component
{
    use WithPagination;

    public $search;
    public $searchGroup;
    public $warehouse_id;
    public $endDate;

    public function render()
    {
        $startDate = Carbon::parse($this->endDate)->startOfDay();
        $endDate = Carbon::parse($this->endDate)->endOfDay();

        $userWarehouseId = $this->warehouse_id;

        $sales = Sale::with('product')
            ->whereBetween('date_issued', [$startDate, $endDate])
            ->where(fn ($query) => $this->warehouse_id !== 1 ? $query->where('warehouse_id', $userWarehouseId) : $query)
            ->whereHas('product', function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })->paginate(5, ['*'], 'sales');

        $salesGroup = $sales->groupBy('product_id');

        return view('livewire.report.sold-voucher-table', [
            'sales' => $sales,
            'salesGroup' => $salesGroup,
        ]);
    }
}
