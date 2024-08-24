<?php

namespace App\Livewire\Store\Purchase;

use App\Models\Product;
use Livewire\Component;
use Livewire\Attributes\On;

class PurchaseCart extends Component
{
    public $purchaseCart = [];

    public function mount()
    {
        $this->purchaseCart = session()->get('purchaseCart', []);
    }

    #[On('addToPurchase')]
    public function addToPurchase($productId)
    {
        dd("success");
        if (isset($this->purchaseCart[$productId])) {
            $this->purchaseCart[$productId]['quantity']++;
        } else {
            $product = Product::find($productId);
            $this->purchaseCart[$productId] = [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->cost,
                'quantity' => 1,
            ];
        }

        $this->updateSession();
    }

    public function render()
    {
        return view('livewire.store.purchase.purchase-cart');
    }
}
