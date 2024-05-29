<?php

namespace App\Livewire\Journal;

use App\Models\Journal;
use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\ChartOfAccount;

class CreateRefund extends Component
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
            'cred_code' => 'required',
            'amount' => 'required',
        ]);

        $warehouse = Auth()->user()->warehouse;
        $account = $warehouse->ChartOfAccount->acc_code;

        $journal->invoice = $journal->invoice_journal();
        $journal->date_issued = $this->date_issued;
        $journal->debt_code = $this->debt_code;
        $journal->cred_code = $this->cred_code;
        $journal->amount = $this->amount;
        $journal->fee_amount = 0;
        $journal->trx_type = 'Mutasi Kas';
        $journal->description = $this->description ?? 'Pengembalian saldo kas & bank ke rekening pusat';
        $journal->user_id = Auth()->user()->id;
        $journal->warehouse_id = Auth()->user()->warehouse_id;
        $journal->save();

        session()->flash('success', 'Journal created successfully');

        $this->dispatch('TransferCreated', $journal->id);

        $this->reset();
    }
    public function render()
    {
        $charts = ChartOfAccount::whereIn('account_id', [1, 2])->get();
        return view('livewire.journal.create-refund', [
            'branches' => $charts->where('warehouse_id', Auth()->user()->warehouse_id),
            'hq' => $charts->where('warehouse_id', 0),

        ]);
    }
}
