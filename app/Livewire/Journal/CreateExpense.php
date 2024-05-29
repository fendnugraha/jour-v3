<?php

namespace App\Livewire\Journal;

use App\Models\Journal;
use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\ChartOfAccount;

class CreateExpense extends Component
{
    public $date_issued;
    public $debt_code;
    public $cred_code;
    public $amount;
    public $description;

    #[On('TransferCreated')]
    public function mount()
    {
        $this->date_issued = date('Y-m-d H:i');
    }

    public function save()
    {
        $journal = new Journal();

        $this->validate([
            'date_issued' => 'required',
            'debt_code' => 'required',
            'amount' => 'required',
            'description' => 'required',
        ]);

        $warehouse = Auth()->user()->warehouse;
        $account = $warehouse->ChartOfAccount->acc_code;

        $journal->invoice = $journal->invoice_journal();
        $journal->date_issued = $this->date_issued;
        $journal->debt_code = $this->debt_code;
        $journal->cred_code = $account;
        $journal->amount = 0;
        $journal->fee_amount = $this->amount;
        $journal->trx_type = 'Pengeluaran';
        $journal->description = $this->description;
        $journal->user_id = Auth()->user()->id;
        $journal->warehouse_id = Auth()->user()->warehouse_id;
        $journal->save();

        session()->flash('success', 'Journal created successfully');

        $this->dispatch('TransferCreated', $journal->id);

        $this->reset();
    }
    public function render()
    {
        return view('livewire.journal.create-expense', [
            'expenses' => ChartOfAccount::whereIn('account_id', range(33, 45))->get(),
        ]);
    }
}
