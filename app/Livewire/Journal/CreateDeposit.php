<?php

namespace App\Livewire\Journal;

use App\Models\Journal;
use Livewire\Component;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Auth;

class CreateDeposit extends Component
{
    public $date_issued;
    public $cost;
    public $price;
    public $description;

    public function mount()
    {
        $this->date_issued = date('Y-m-d H:i');
    }

    #[On('DepositCreated')]
    public function resetDateIssued()
    {
        $this->date_issued = date('Y-m-d H:i');
    }

    public function save()
    {
        $user = Auth::user();
        $this->validate([
            'cost' => 'required|numeric',
            'price' => 'required|numeric',
        ]);

        // $modal = $this->modal * $this->qty;
        $price = $this->price;
        $cost = $this->cost;

        $description = $this->description ?? "Penjualan Pulsa Dll";
        $fee = $price - $cost;
        $invoice = Journal::invoice_journal();

        $journal = new journal([
            'date_issued' => $this->date_issued,
            'invoice' => $invoice,
            'debt_code' => "10600-001",
            'cred_code' => "10600-001",
            'amount' => $cost,
            'fee_amount' => $fee,
            'description' => $description,
            'trx_type' => 'Deposit',
            'user_id' => $user->id,
            'warehouse_id' => $user->warehouse_id
        ]);

        $journal->save();

        session()->flash('success', 'Journal created successfully.');

        $this->dispatch('DepositCreated', $journal->id);

        $this->reset();
    }
    public function render()
    {
        return view('livewire.journal.create-deposit');
    }
}
