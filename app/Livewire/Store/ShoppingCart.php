<?php

namespace App\Livewire\Store;

use Livewire\Component;

class ShoppingCart extends Component
{
    public $cart = [];

    public function addToCart($productId)
    {
        // Add item to the cart
        if (isset($this->cart[$productId])) {
            $this->cart[$productId]['quantity']++;
        } else {
            // You can fetch the product details from the database here
            $this->cart[$productId] = [
                'id' => $productId,
                'name' => 'Product ' . $productId,
                'price' => 100, // Replace with actual product price
                'quantity' => 1,
            ];
        }
    }

    public function removeFromCart($productId)
    {
        unset($this->cart[$productId]);
    }

    public function updateQuantity($productId, $quantity)
    {
        if ($quantity > 0) {
            $this->cart[$productId]['quantity'] = $quantity;
        } else {
            $this->removeFromCart($productId);
        }
    }

    public function render()
    {
        return view('livewire.store.shopping-cart');
    }
}
