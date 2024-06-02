<?php

namespace App\Livewire\Report;

use Carbon\Carbon;
use App\Models\Sale;
use App\Models\Warehouse;
use Livewire\Component;
use Livewire\WithPagination;

class SoldVoucherTable extends Component
{
    use WithPagination;

    public $search;
    public $searchGroup;
    public $warehouse_id;
    public $endDate;
    public $perPage = 5;

    public function mount()
    {
        $this->endDate = date('Y-m-d H:i');
    }

    public function render()
    {
        $startDate = Carbon::parse($this->endDate)->startOfDay();
        $endDate = Carbon::parse($this->endDate)->endOfDay();

        // Retrieve sales data
        $sales = Sale::with('product')
            ->whereBetween('date_issued', [$startDate, $endDate])
            ->where(function ($query) {
                if ($this->warehouse_id > 1) {
                    $query->where('warehouse_id', $this->warehouse_id);
                }
            })
            ->whereHas('product', function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })
            ->paginate(5, ['*'], 'sales');

        // Group sales data by product_id
        $salesGroup = Sale::selectRaw('product_id, SUM(quantity) as quantity, SUM(quantity*cost) as total_cost, SUM(quantity*price) as total_price')
            ->where(function ($query) use ($startDate, $endDate) {
                if ($this->warehouse_id > 1) {
                    $query->where('warehouse_id', $this->warehouse_id)
                        ->whereBetween('date_issued', [$startDate, $endDate]);
                } else {
                    $query->whereBetween('date_issued', [$startDate, $endDate]);
                }
            })
            ->whereHas('product', function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })
            ->groupBy('product_id');

        $total = Sale::whereBetween('date_issued', [$startDate, $endDate])
            ->where(function ($query) {
                if ($this->warehouse_id > 1) {
                    $query->where('warehouse_id', $this->warehouse_id);
                }
            })
            ->selectRaw('product_id, SUM(price*quantity) as total_price, SUM(cost*quantity) as total_cost')
            ->groupBy('product_id')
            ->get();

        return view('livewire.report.sold-voucher-table', [
            'sales' => $sales,
            'salesGroups' => $salesGroup->paginate($this->perPage, ['*'], 'salesGroup'),
            'warehouse' => Warehouse::all(),
            'total' => $total
        ]);
    }
}
