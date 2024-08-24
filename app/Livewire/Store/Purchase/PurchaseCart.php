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

    public function removeFromCart($productId)
    {
        unset($this->purchaseCart[$productId]);
        $this->updateSession();
    }

    public function updateQuantity($productId, $quantity)
    {
        if ($quantity > 0) {
            $this->purchaseCart[$productId]['quantity'] = $quantity;
        } else {
            $this->removeFromCart($productId);
        }

        $this->updateSession();
    }

    public function updatePrice($productId, $price)
    {
        $this->purchaseCart[$productId]['price'] = $price;
        $this->updateSession();
    }

    public function updateSession()
    {
        session()->put('purchaseCart', $this->purchaseCart);
    }

    public function clearCart()
    {
        session()->forget('purchaseCart');
    }
    public function render()
    {
        return view('livewire.store.purchase.purchase-cart', [
            'total' => collect($this->purchaseCart)->sum(fn($item) => $item['price'] * $item['quantity']),
        ]);
    }
}
