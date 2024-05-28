<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        return view('setting.product.index', [
            'title' => 'Product Page',
        ]);
    }

    public function edit($id)
    {
        $product = Product::find($id);
        return view('setting.product.edit', [
            'title' => 'Edit Product' . ' ' . $product->name,
            'product' => $product
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|max:255|min:5|unique:products,name,' . $id,
            'cost' => 'required|numeric',
            'price' => 'required|numeric',
        ]);

        $product = Product::find($id);
        $product->update([
            'name' => $request->name,
            'cost' => $request->cost,
            'price' => $request->price,
        ]);
        return redirect('/setting/product')->with('success', 'Product Updated');
    }
}
