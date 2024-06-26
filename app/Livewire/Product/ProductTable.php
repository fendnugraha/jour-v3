<?php

namespace App\Livewire\Product;

use App\Models\Sale;
use App\Models\Product;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithPagination;

class ProductTable extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 10;

    public function delete($id)
    {
        $product = Product::find($id);

        $salesExists = Sale::where('product_id', $id)->exists();
        if ($salesExists) {
            session()->flash('error', 'Product Cannot be Deleted!');
        } else {
            $product->delete();
            session()->flash('success', 'Product Deleted Successfully');
        }

        $this->dispatch('ProductDeleted');
    }

    #[On('ProductCreated', 'ProductDeleted')]
    public function render()
    {
        $products = Product::where('name', 'like', '%' . $this->search . '%')
            ->orWhere('cost', 'like', '%' . $this->search . '%')
            ->orWhere('price', 'like', '%' . $this->search . '%')
            ->orWhere('sold', 'like', '%' . $this->search . '%')
            ->orderBy('name', 'asc')
            ->paginate($this->perPage);
        return view('livewire.product.product-table', [
            'products' => $products
        ]);
    }
}
