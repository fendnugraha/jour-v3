<?php

namespace App\Livewire\Store;

use App\Models\Sale;
use App\Models\Journal;
use App\Models\Product;
use Livewire\Component;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\DB;

class ShoppingCart extends Component
{
    public $cart = [];
    public $payment = 0;
    public function mount()
    {
        // Load the cart from the session when the component is mounted
        $this->cart = session()->get('cart', []);
        $this->payment = collect($this->cart)->sum(fn($item) => $item['price'] * $item['quantity']);
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

    public function updatePrice($productId, $price)
    {
        $this->cart[$productId]['price'] = $price;
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

    public function storeCart()
    {
        // Create a new invoice journal
        $invoice = new Journal();
        $invoice->invoice = $invoice->sales_journal();
        // $invoice->save(); // Save the invoice before using it

        try {
            DB::beginTransaction();

            foreach ($this->cart as $item) {
                $product = Product::find($item['id']);
                if (!$product) {
                    continue; // Skip if the product is not found
                }

                $cost = $product->cost;
                $price = $item['price'] * $item['quantity'];
                $cost = $product->cost;
                $modal = $cost * $item['quantity'];
                $fee = $price - $modal;

                // Create a new journal entry
                $journal = new Journal();
                $journal->date_issued = date('Y-m-d H:i');
                $journal->invoice = $invoice->invoice; // Ensure $invoice is defined
                $journal->debt_code = "10600-001";
                $journal->cred_code = "10600-001";
                $journal->amount = $modal; // Ensure $modal is defined
                $journal->fee_amount = $fee; // Ensure $fee is defined
                $journal->description = "Penjualan Barang";
                $journal->trx_type = 'Accessories';
                $journal->user_id = Auth()->user()->id;
                $journal->warehouse_id = Auth()->user()->warehouse_id;
                $journal->save();

                // Create a new sale record
                $sale = new Sale();
                $sale->date_issued = date('Y-m-d H:i');
                $sale->invoice = $invoice->invoice; // Ensure $invoice is defined
                $sale->product_id = $product->id;
                $sale->quantity = -$item['quantity'];
                $sale->price = $item['price'];
                $sale->cost = $cost;
                $sale->warehouse_id = Auth()->user()->warehouse_id;
                $sale->user_id = Auth()->user()->id;
                $sale->save();

                $product_log = Sale::where('product_id', $product->id)->sum('quantity');
                $end_Stock = $product->stock + $product_log;
                Product::where('id', $product->id)->update([
                    'end_Stock' => $end_Stock
                ]);
            }

            DB::commit();
            session()->flash('success', 'Transaction created successfully.');
            $this->clearCart();
        } catch (\Exception $e) {
            DB::rollBack();
            // Log::error('Transaction failed: ' . $e->getMessage());
            session()->flash('error', 'Transaction failed.' . $e->getMessage());
        }

        $this->dispatch('salesCreated', $invoice->id);
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
