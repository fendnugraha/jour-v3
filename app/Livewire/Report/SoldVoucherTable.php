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

    public function render()
    {
        $startDate = Carbon::now()->startOfDay();
        $endDate = Carbon::now()->endOfDay();

        $userWarehouseId = Auth()->user()->warehouse_id;

        $sales = Sale::with('product')
            ->whereBetween('date_issued', [$startDate, $endDate])
            ->where('warehouse_id', $userWarehouseId)
            ->whereHas('product', function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })->paginate(5);

        $salesGroup = $sales->groupBy('product_id');

        return view('livewire.report.sold-voucher-table', [
            'sales' => $sales,
            'salesGroup' => $salesGroup,
        ]);
    }
}
