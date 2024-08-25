<?php

namespace App\Livewire\Store\Purchase;

use App\Models\Sale;
use Livewire\Component;

class Report extends Component
{
    public function render()
    {
        $purchases = Sale::selectRaw('invoice, warehouse_id, MAX(date_issued) as date_issued, SUM(cost * quantity) as total')
            ->where('invoice', 'like', '%PO.BK%')
            ->groupBy('invoice', 'warehouse_id')
            ->get();

        return view('livewire.store.purchase.report', [
            'purchases' => $purchases
        ]);
    }
}
