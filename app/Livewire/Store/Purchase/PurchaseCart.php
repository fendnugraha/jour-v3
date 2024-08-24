<?php

namespace App\Livewire\Store\Purchase;

use App\Models\Sale;
use App\Models\Journal;
use App\Models\Product;
use Livewire\Component;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\DB;

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
        $this->purchaseCart = [];
        session()->forget('purchaseCart');
    }

    public function storeCart()
    {
        $invoice = new Journal();
        $invoice->invoice = $invoice->purchase_journal();

        try {
            DB::beginTransaction();
            foreach ($this->purchaseCart as $item) {
                $product = Product::find($item['id']);
                if (!$product) {
                    continue; // Skip if the product is not found
                }

                $initial_stock = $product->end_stock;
                $initial_cost = $product->cost;
                $initTotal = $initial_stock * $initial_cost;

                $sale = new Sale();
                $sale->date_issued = date('Y-m-d H:i');
                $sale->invoice = $invoice->invoice; // Ensure $invoice is defined
                $sale->product_id = $product->id;
                $sale->quantity = $item['quantity'];
                $sale->price = 0;
                $sale->cost = $item['price'];
                $sale->warehouse_id = Auth()->user()->warehouse_id;
                $sale->user_id = Auth()->user()->id;
                $sale->save();

                $newStock = $item['quantity'];
                $newCost = $item['price'];
                $newTotal = $newStock * $newCost;

                $updatedCost = ($initTotal + $newTotal) / ($initial_stock + $newStock);

                $product_log = Sale::where('product_id', $product->id)->sum('quantity');
                $end_Stock = $product->stock + $product_log;
                Product::where('id', $product->id)->update([
                    'end_Stock' => $end_Stock,
                    'cost' => $updatedCost,
                ]);
            }

            DB::commit();

            $this->clearCart();
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e->getMessage());
        }

        $this->dispatch('PurchaseCreated', $invoice->id);
    }
    public function render()
    {
        return view('livewire.store.purchase.purchase-cart', [
            'total' => collect($this->purchaseCart)->sum(fn($item) => $item['price'] * $item['quantity']),
        ]);
    }
}
