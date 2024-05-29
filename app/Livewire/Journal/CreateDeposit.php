<?php

namespace App\Livewire\Journal;

use App\Models\Journal;
use Livewire\Component;
use Livewire\Attributes\On;

class CreateDeposit extends Component
{
    public $date_issued;
    public $cost;
    public $price;
    public $description;

    #[On('TransferCreated')]
    public function mount()
    {
        $this->date_issued = date('Y-m-d H:i');
    }

    public function save()
    {
        $this->validate([
            'cost' => 'required|numeric',
            'price' => 'required|numeric',
        ]);

        // $modal = $this->modal * $this->qty;
        $price = $this->price;
        $cost = $this->cost;

        $description = $this->description ?? "Penjualan Pulsa Dll";
        $fee = $price - $cost;
        $invoice = new Journal();
        $invoice->invoice = $invoice->invoice_journal();

        $journal = new journal();
        $journal->date_issued = $this->date_issued;
        $journal->invoice = $invoice->invoice;
        $journal->debt_code = "10600-001";
        $journal->cred_code = "10600-001";
        $journal->amount = $cost;
        $journal->fee_amount = $fee;
        $journal->description = $description;
        $journal->trx_type = 'Deposit';
        $journal->user_id = Auth()->user()->id;
        $journal->warehouse_id = Auth()->user()->warehouse_id;
        $journal->save();

        session()->flash('success', 'Journal created successfully.');

        $this->dispatch('TransferCreated', $journal->id);

        $this->reset();
    }
    public function render()
    {
        return view('livewire.journal.create-deposit');
    }
}
