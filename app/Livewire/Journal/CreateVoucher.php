<?php

namespace App\Livewire\Journal;

use App\Models\Sale;
use App\Models\Journal;
use App\Models\Product;
use Livewire\Component;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\DB;


class CreateVoucher extends Component
{
    public $date_issued;
    public $product_id;
    public $qty;
    public $price;
    public $description;

    #[On('TransferCreated')]
    public function mount()
    {
        $this->date_issued = date('Y-m-d H:i');
    }

    public function getPrice()
    {
        $this->price = Product::find($this->product_id)->price;
    }

    public function save()
    {
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
        $invoice = new Journal();
        $invoice->invoice = $invoice->invoice_journal();

        try {
            DB::beginTransaction();
            $journal = new journal();
            $journal->date_issued = $this->date_issued;
            $journal->invoice = $invoice->invoice;
            $journal->debt_code = "10600-001";
            $journal->cred_code = "10600-001";
            $journal->amount = $modal;
            $journal->fee_amount = $fee;
            $journal->description = $description;
            $journal->trx_type = 'Voucher & SP';
            $journal->user_id = Auth()->user()->id;
            $journal->warehouse_id = Auth()->user()->warehouse_id;
            $journal->save();

            $sale = new Sale();
            $sale->date_issued = $this->date_issued;
            $sale->invoice = $invoice->invoice;
            $sale->product_id = $this->product_id;
            $sale->quantity = $this->qty;
            $sale->price = $this->price;
            $sale->cost = $cost;
            $sale->warehouse_id = Auth()->user()->warehouse_id;
            $sale->user_id = Auth()->user()->id;
            $sale->save();

            $sold = Product::find($this->product_id)->sold + $this->qty;
            Product::find($this->product_id)->update(['sold' => $sold]);

            DB::commit();

            session()->flash('success', 'Voucher Created Successfully');
        } catch (\Exception $e) {
            DB::rollBack();

            session()->flash('error', $e->getMessage());
        }

        $this->dispatch('TransferCreated', $journal->id);

        $this->reset();
    }
    public function render()
    {
        return view('livewire.journal.create-voucher', [
            'products' => Product::all(),
        ]);
    }
}
