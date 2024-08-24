<?php

namespace App\Livewire\Product;

use App\Models\Product;
use Livewire\Component;
use App\Models\Category;
use Livewire\Attributes\On;

class CreateProduct extends Component
{
    public $name;
    public $cost;
    public $price;
    public $category;

    public function save()
    {
        $product = new Product();
        $newCode = $product->newCode($this->category);

        $validate = $this->validate([
            'name' => 'required|unique:products,name',
            'price' => 'required|numeric',
        ]);

        Product::create([
            'name' => $this->name,
            'code' => $newCode,
            'cost' => 0,
            'price' => $this->price,
            'category' => $this->category ?? null
        ]);

        session()->flash('success', 'Product created successfully');

        $this->dispatch('ProductCreated');

        $this->reset();
    }

    #[On('ProductCreated')]
    public function render()
    {
        return view('livewire.product.create-product', [
            'categories' => Category::all(),
        ]);
    }
}
