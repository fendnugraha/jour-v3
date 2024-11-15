<?php

namespace App\Livewire\Journal;

use App\Models\Journal;
use Livewire\Component;
use App\Models\Warehouse;
use Livewire\Attributes\On;
use App\Models\ChartOfAccount;
use Illuminate\Support\Facades\Auth;

class CreateMutation extends Component
{
    public $date_issued;
    public $debt_code;
    public $cred_code;
    public $amount;
    public $description;
    public $cabang;
    public $adminFee;

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

        $journal->invoice = $journal->invoice_journal();
        $journal->date_issued = $this->date_issued;
        $journal->debt_code = $this->debt_code;
        $journal->cred_code = $this->cred_code;
        $journal->amount = $this->amount;
        $journal->fee_amount = 0;
        $journal->trx_type = 'Mutasi Kas';
        $journal->description = $this->description ?? 'Penambahan saldo kas & bank ke rekening cabang';
        $journal->user_id = Auth::user()->id;
        $journal->warehouse_id = Auth::user()->warehouse_id;
        $journal->save();

        if ($this->adminFee > 0) {
            $journal = new Journal();

            $journal->invoice = $journal->invoice_journal();
            $journal->date_issued = $this->date_issued;
            $journal->debt_code = Auth::user()->warehouse->ChartOfAccount->acc_code;
            $journal->cred_code = $this->cred_code;
            $journal->amount = $this->adminFee;
            $journal->fee_amount = -$this->adminFee;
            $journal->trx_type = 'Pengeluaran';
            $journal->description = $this->description ?? 'Biaya admin Mutasi Saldo Kas';
            $journal->user_id = Auth::user()->id;
            $journal->warehouse_id = Auth::user()->warehouse_id;
            $journal->save();
        }

        session()->flash('success', 'Journal created successfully');

        $this->dispatch('TransferCreated', $journal->id);

        $this->reset();
    }

    public function render()
    {
        $warehouse = Warehouse::where('status', 1)->get();
        $chartOfAccounts = ChartOfAccount::whereIn('account_id', [1, 2])->get();

        $cabang = $chartOfAccounts;
        $hq = $chartOfAccounts->where('warehouse_id', 1);

        return view('livewire.journal.create-mutation', [
            'warehouse' => $warehouse,
            'hq' => $hq,
            'akunCabang' => $cabang
        ]);
    }
}
