<?php

namespace App\Livewire\Journal;

use App\Models\Journal;
use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\ChartOfAccount;
use Illuminate\Support\Facades\Auth;

class CreateCashWithdrawal extends Component
{
    public $date_issued;
    public $debt_code;
    public $amount;
    public $fee_amount;
    public $description;
    public $is_taken;
    public $credits;

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
            'fee_amount' => 'required',
        ]);

        $warehouse = Auth()->user()->warehouse;
        $account = $warehouse->ChartOfAccount->acc_code;

        $status = $this->is_taken ? 2 : 1;
        $journal->invoice = $journal->invoice_journal();
        $journal->date_issued = $this->date_issued;
        $journal->debt_code = $this->debt_code;
        $journal->cred_code = $account;
        $journal->amount = $this->amount;
        $journal->fee_amount = $this->fee_amount;
        $journal->trx_type = 'Tarik Tunai';
        $journal->status = $status;
        $journal->description = $this->description ?? 'Penarikan tunai';
        $journal->user_id = Auth()->user()->id;
        $journal->warehouse_id = Auth()->user()->warehouse_id;
        $journal->save();

        session()->flash('success', 'Journal created successfully');

        $this->dispatch('TransferCreated', $journal);

        $this->reset();
    }

    public function render()
    {
        return view(
            'livewire.journal.create-cash-withdrawal',
            [
                // 'credits' => ChartOfAccount::where('account_id', 2)->where('warehouse_id', Auth::user()->warehouse_id)->get(),
            ]
        );
    }
}
