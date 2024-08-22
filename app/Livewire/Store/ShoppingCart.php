<?php

namespace App\Livewire\Store;

use App\Models\Product;
use Livewire\Component;
use Livewire\Attributes\On;

class ShoppingCart extends Component
{
    public $cart = [];
    public function mount()
    {
        // Load the cart from the session when the component is mounted
        $this->cart = session()->get('cart', []);
    }

    #[On('addToCart')]
    public function addToCart($productId)
    {
        if (isset($this->cart[$productId])) {
            $this->cart[$productId]['quantity']++;
        } else {
            // Store product details as an associative array
            $product = Product::find($productId);

            $this->cart[$productId] = [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => 1,
            ];
        }

        $this->updateSession();
    }

    public function removeFromCart($productId)
    {
        unset($this->cart[$productId]);
        $this->updateSession();
    }

    public function updateQuantity($productId, $quantity)
    {
        if ($quantity > 0) {
            $this->cart[$productId]['quantity'] = $quantity;
        } else {
            $this->removeFromCart($productId);
        }

        $this->updateSession();
    }

    private function updateSession()
    {
        // Save the cart back to the session
        session()->put('cart', $this->cart);
    }

    public function clearCart()
    {
        $this->cart = []; // Clear the cart array
        session()->forget('cart'); // Remove the cart data from the session
    }

    public function render()
    {
        // dd($this->cart);
        return view('livewire.store.shopping-cart', [
            'total' => collect($this->cart)->sum(fn($item) => $item['price'] * $item['quantity']),
            'totalQuantity' => collect($this->cart)->sum(fn($item) => $item['quantity']),
            'totalCost' => collect($this->cart)->sum(fn($item) => $item['price'] * $item['quantity']),
            'totalGrand' => collect($this->cart)->sum(fn($item) => $item['price'] * $item['quantity']),
            'totalPaid' => collect($this->cart)->sum(fn($item) => $item['price'] * $item['quantity']),
        ]);
    }
}
