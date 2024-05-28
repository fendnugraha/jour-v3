<?php

namespace App\Livewire\Product;

use App\Models\Product;
use Livewire\Component;

class CreateProduct extends Component
{
    public $name;
    public $cost;
    public $price;

    public function save()
    {
        $validate = $this->validate([
            'name' => 'required|unique:products,name',
            'cost' => 'required|numeric',
            'price' => 'required|numeric',
        ]);

        Product::create($validate);

        session()->flash('success', 'Product created successfully');

        $this->dispatch('ProductCreated');

        $this->reset();
    }
    public function render()
    {
        return view('livewire.product.create-product');
    }
}
