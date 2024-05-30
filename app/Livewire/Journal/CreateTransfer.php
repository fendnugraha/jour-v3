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

    public function fee($amount)
    {
        if ($amount > 50000 && $amount <= 2500000) { {
                $this->fee_amount = 5000;
            }
        } else if ($amount > 2500000 && $amount <= 5000000) { {
                $this->fee_amount = 10000;
            }
        } else if ($amount > 5000000 && $amount <= 10000000) { {
                $this->fee_amount = 20000;
            }
        } else if ($amount > 10000000 && $amount <= 25000000) { {
                $this->fee_amount = 30000;
            }
        } else if ($amount > 25000000) { {
                $this->fee_amount = 40000;
            }
        } else {
            $this->fee_amount = 0;
        }

        $this->dispatch('updateFee', $this->fee_amount);
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
        $journal->trx_type = 'Transfer Uang';
        $journal->description = $this->description ?? 'Transfer uang antar bank';
        $journal->user_id = Auth()->user()->id;
        $journal->warehouse_id = Auth()->user()->warehouse_id;
        $journal->save();

        session()->flash('success', 'Journal created successfully');

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
