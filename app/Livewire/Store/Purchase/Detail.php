<?php

namespace App\Livewire\Store\Purchase;

use App\Models\Sale;
use Livewire\Component;

class Detail extends Component
{
    public $id;

    public function mount($id)
    {
        $this->id = $id;
    }

    public function render()
    {
        $purchase = Sale::where('invoice', $this->id)->get();
        $total = collect($purchase)->sum(fn($item) => $item['cost'] * $item['quantity']);
        return view('livewire.store.purchase.detail', [
            'purchase' => $purchase,
            'total' => $total
        ]);
    }
}
