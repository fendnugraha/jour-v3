<?php

namespace App\Livewire\Store\Purchase;

use App\Models\Product;
use Livewire\Component;
use Livewire\Attributes\On;

class Purchase extends Component
{
    public $search;

    public function addToPurchase(Product $product): void
    {
        $this->dispatch('addToPurchase', $product->id);
    }

    #[On('PurchaseCreated')]
    public function render()
    {
        $products = Product::where('category', '!=', 'Voucher & SP')->where('name', 'like', '%' . $this->search . '%')->paginate(8);
        return view('livewire.store.purchase.purchase', [
            'products' => $products,
        ]);
    }
}
