<?php

namespace App\Livewire\Store;

use App\Models\Product;
use Livewire\Component;
use Livewire\Attributes\On;

class ProductTable extends Component
{
    public $search = '';
    public function addToCart(Product $product): void
    {
        $this->dispatch('addToCart', $product->id);
    }

    #[On('salesCreated')]
    public function updateList($product = null)
    {
        // dd("success");
    }

    public function render()
    {
        $products = Product::where('category', '!=', 'Voucher & SP')
            ->where('name', 'like', '%' . $this->search . '%')->paginate(8);

        return view('livewire.store.product-table', [
            'products' => $products,
        ]);
    }
}
