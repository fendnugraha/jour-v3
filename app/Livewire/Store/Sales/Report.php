<?php

namespace App\Livewire\Store\Sales;

use App\Models\Sale;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Report extends Component
{
    public $warehouse_id;

    public function mount()
    {
        $this->warehouse_id = Auth::user()->warehouse_id;
    }
    public function render()
    {
        $sales = Sale::selectRaw('invoice, warehouse_id, MAX(date_issued) as date_issued, SUM(price * -quantity) as total')->where('invoice', 'like', '%SO.BK%')->groupBy('invoice', 'warehouse_id')->get();
        return view('livewire.store.sales.report', [
            'sales' => $sales
        ]);
    }
}
