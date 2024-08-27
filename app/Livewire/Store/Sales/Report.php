<?php

namespace App\Livewire\Store\Sales;

use Carbon\Carbon;
use App\Models\Sale;
use Livewire\Component;
use App\Models\Warehouse;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class Report extends Component
{
    use WithPagination;

    public $warehouse_id;
    public $startDate;
    public $endDate;


    public function mount()
    {
        $this->warehouse_id = Auth::user()->warehouse_id;
        $this->startDate = date('Y-m-d H:i');
        $this->endDate = date('Y-m-d H:i');
    }
    public function render()
    {
        $sales = Sale::selectRaw('invoice, warehouse_id, MAX(date_issued) as date_issued, SUM(price * -quantity) as total')
            ->where('warehouse_id', $this->warehouse_id)
            ->whereBetween('date_issued', [Carbon::parse($this->startDate)->startOfDay(), Carbon::parse($this->endDate)->endOfDay()])
            ->where('invoice', 'like', '%SO.BK%')->groupBy('invoice', 'warehouse_id')->paginate(5, ['*'], 'sales');
        return view('livewire.store.sales.report', [
            'sales' => $sales,
            'warehouses' => Warehouse::all(),
        ]);
    }
}
