<?php

namespace App\Livewire\Journal;

use App\Models\Journal;
use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\ChartOfAccount;
use Illuminate\Support\Facades\Auth;

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
        $user = Auth::user();

        $this->validate([
            'date_issued' => 'required',
            'debt_code' => 'required',
            'cred_code' => 'required',
            'amount' => 'required',
        ]);

        $journal = new Journal([
            'invoice' => Journal::invoice_journal(),
            'date_issued' => $this->date_issued,
            'debt_code' => $this->debt_code,
            'cred_code' => $this->cred_code,
            'amount' => $this->amount,
            'fee_amount' => 0,
            'trx_type' => 'Mutasi Kas',
            'description' => $this->description ?? 'Pengembalian saldo kas & bank ke rekening pusat',
            'user_id' => $user->id,
            'warehouse_id' => $user->warehouse_id,
        ]);

        $journal->save();

        session()->flash('success', 'Journal created successfully');

        $this->dispatch('TransferCreated', $journal->id);

        $this->reset();
    }
    public function render()
    {
        $charts = ChartOfAccount::whereIn('account_id', [1, 2])->get();
        return view('livewire.journal.create-refund', [
            'branches' => $charts->where('warehouse_id', Auth::user()->warehouse_id),
            'hq' => $charts->where('warehouse_id', 1),

        ]);
    }
}
