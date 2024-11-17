<?php

namespace App\Livewire\Journal;

use App\Models\Sale;
use App\Models\Journal;
use App\Models\Product;
use Livewire\Component;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class CreateVoucher extends Component
{
    public $date_issued;
    public $product_id;
    public $qty = 1;
    public $price;
    public $description;

    public function mount()
    {
        $this->date_issued = date('Y-m-d H:i');
    }

    #[On('VoucherCreated')]
    public function resetDateIssued()
    {
        $this->date_issued = date('Y-m-d H:i');
    }

    /*************  ✨ Codeium Command ⭐  *************/
    /**
     * Retrieves and sets the price of the selected product based on product_id.
     * Updates the price attribute with the corresponding product's price.
     */
    /******  623a9dd8-99dd-47c3-9da4-3af106338db6  *******/
    public function getPrice()
    {
        $this->price = Product::find($this->product_id)->price;
    }

    public function save()
    {
        $user = Auth::user();
        $this->validate([
            'qty' => 'required|numeric',
            'price' => 'required|numeric',
            'product_id' => 'required',
        ]);

        // $modal = $this->modal * $this->qty;
        $price = $this->price * $this->qty;
        $cost = Product::find($this->product_id)->cost;
        $modal = $cost * $this->qty;

        $description = $this->description ?? "Penjualan Voucher & SP";
        $fee = $price - $modal;
        $invoice = Journal::invoice_journal();

        try {
            DB::beginTransaction();
            $journal = new journal([
                'date_issued' => $this->date_issued,
                'invoice' => $invoice,
                'debt_code' => "10600-001",
                'cred_code' => "10600-001",
                'amount' => $modal,
                'fee_amount' => $fee,
                'description' => $description,
                'trx_type' => 'Penjualan',
                'user_id' => $user->id,
                'warehouse_id' => $user->warehouse_id
            ]);
            $journal->save();

            $sale = new Sale([
                'date_issued' => $this->date_issued,
                'invoice' => $invoice,
                'product_id' => $this->product_id,
                'quantity' => $this->qty,
                'price' => $this->price,
                'cost' => $cost,
                'warehouse_id' => $user->warehouse_id,
                'user_id' => $user->id
            ]);
            $sale->save();

            $sold = Product::find($this->product_id)->sold + $this->qty;
            Product::find($this->product_id)->update(['sold' => $sold]);

            DB::commit();

            session()->flash('success', 'Voucher Created Successfully');
        } catch (\Exception $e) {
            DB::rollBack();

            session()->flash('error', $e->getMessage());
        }

        $this->dispatch('VoucherCreated', $journal->id);

        $this->reset();
    }
    public function render()
    {
        return view('livewire.journal.create-voucher', [
            'products' => Product::where('category', 'Voucher & SP')->get(),
        ]);
    }
}
