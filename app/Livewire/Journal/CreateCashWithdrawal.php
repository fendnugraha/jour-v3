<?php

namespace App\Livewire\Journal;

use App\Models\Journal;
use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\ChartOfAccount;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class CreateCashWithdrawal extends Component
{
    public $date_issued;
    public $debt_code;
    public $amount;
    public $fee_amount;
    public $description;
    public $is_taken;

    #[On('TransferCreated')]
    public function mount()
    {
        $this->date_issued = date('Y-m-d H:i');
    }
    public function save()
    {
        DB::transaction(function () {
            $this->validate([
                'date_issued' => 'required|date',
                'debt_code' => 'required|string',
                'amount' => 'required|numeric|min:0',
                'fee_amount' => 'required|numeric|min:0',
            ]);

            $user = Auth::user();
            $warehouse = $user->warehouse;
            $account = $warehouse->ChartOfAccount->acc_code;

            $status = $this->is_taken ? 2 : 1;

            $journal = new Journal([
                'invoice' => Journal::invoice_journal(), // Ganti dengan metode statis jika cocok
                'date_issued' => $this->date_issued,
                'debt_code' => $this->debt_code,
                'cred_code' => $account,
                'amount' => $this->amount,
                'fee_amount' => $this->fee_amount,
                'trx_type' => 'Tarik Tunai',
                'status' => $status,
                'description' => $this->description ?? 'Penarikan tunai',
                'user_id' => $user->id,
                'warehouse_id' => $user->warehouse_id,
            ]);
            $journal->save();

            $this->dispatch('TransferCreated', $journal->id);

            session()->flash('success', 'Journal created successfully');
            Log::info('Journal created: ', $journal->toArray());

            $this->reset(['date_issued', 'debt_code', 'amount', 'fee_amount', 'description']);
        });
    }

    public function render()
    {
        return view(
            'livewire.journal.create-cash-withdrawal',
            [
                'credits' => ChartOfAccount::where('account_id', 2)->where('warehouse_id', Auth::user()->warehouse_id)->get(),
            ]
        );
    }
}
