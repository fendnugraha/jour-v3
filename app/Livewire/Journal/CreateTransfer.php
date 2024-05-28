<?php

namespace App\Livewire\Journal;

use App\Models\Journal;
use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\ChartOfAccount;
use Illuminate\Support\Facades\Auth;

class CreateTransfer extends Component
{
    public $date_issued;
    public $cred_code;
    public $amount;
    public $fee_amount;
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
            'cred_code' => 'required',
            'amount' => 'required',
            'fee_amount' => 'required',
        ]);

        $warehouse = Auth()->user()->warehouse;
        $account = $warehouse->ChartOfAccount->acc_code;

        $journal->invoice = $journal->invoice_journal();
        $journal->date_issued = $this->date_issued;
        $journal->debt_code = $account;
        $journal->cred_code = $this->cred_code;
        $journal->amount = $this->amount;
        $journal->fee_amount = $this->fee_amount;
        $journal->trx_type = 'Transfer';
        $journal->description = $this->description ?? 'Transfer uang';
        $journal->user_id = Auth()->user()->id;
        $journal->warehouse_id = Auth()->user()->warehouse_id;
        $journal->save();

        $this->dispatch('TransferCreated', $journal->id);

        $this->reset();
    }

    public function render()
    {
        return view('livewire.journal.create-transfer', [
            'credits' => ChartOfAccount::where('warehouse_id', Auth::user()->warehouse_id)->get(),
        ]);
    }
}
