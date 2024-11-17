<?php

namespace App\Livewire\Journal;

use App\Models\Journal;
use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\ChartOfAccount;
use Illuminate\Support\Facades\Auth;

class CreateExpense extends Component
{
    public $date_issued;
    public $debt_code;
    public $cred_code;
    public $amount;
    public $description;

    #[On('ExpenseCreated')]
    public function mount()
    {
        $this->date_issued = date('Y-m-d H:i');
    }

    #[On('ExpenseCreated')]
    public function resetDateIssued()
    {
        $this->date_issued = date('Y-m-d H:i');
    }

    public function save()
    {
        $user = Auth::user();

        $this->validate([
            'date_issued' => 'required',
            'debt_code' => 'required',
            'amount' => 'required',
            'description' => 'required',
        ]);

        $warehouse = $user->warehouse;
        $account = $warehouse->ChartOfAccount->acc_code;

        $journal = new Journal([
            'invoice' => Journal::invoice_journal(),
            'date_issued' => $this->date_issued,
            'debt_code' => $this->debt_code,
            'cred_code' => $account,
            'amount' => 0,
            'fee_amount' => -$this->amount,
            'trx_type' => 'Pengeluaran',
            'description' => $this->description,
            'user_id' => $user->id,
            'warehouse_id' => $user->warehouse_id
        ]);

        $journal->save();

        session()->flash('success', 'Journal created successfully');

        $this->dispatch('ExpenseCreated', $journal->id);

        $this->reset();
    }
    public function render()
    {
        return view('livewire.journal.create-expense', [
            'expenses' => ChartOfAccount::whereIn('account_id', range(33, 45))->get(),
        ]);
    }
}
