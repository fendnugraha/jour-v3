<?php

namespace App\Livewire\Store\Sales;

use App\Models\Sale;
use Livewire\Component;

class Detail extends Component
{
    public $id;

    public function mount($id)
    {
        $this->id = $id;
    }

    public function delete($id)
    {
        $sale = Sale::find($id);
        $sale->delete();

        $this->dispatch('SaleCreated', $sale->invoice);
    }
    public function render()
    {
        $sale = Sale::where('invoice', $this->id)->get();
        $total = collect($sale)->sum(fn($item) => $item['cost'] * $item['quantity']);
        return view('livewire.store.sales.detail', [
            'sale' => $sale,
            'total' => $total
        ]);
    }
}
