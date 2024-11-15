<?php

namespace App\Livewire\Journal;

use App\Models\Journal;
use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\ChartOfAccount;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CreateTransfer extends Component
{
    public $date_issued;
    public $cred_code;
    public $amount;
    public $fee_amount;
    public $description;
    public $is_credit;
    public $custName;

    #[On('TransferCreated')]
    public function mount()
    {
        $this->date_issued = date('Y-m-d H:i');
    }

    public function resetFeeAmount()
    {
        if ($this->is_credit) {
            $this->fee_amount = 0;
        }
    }

    public function save()
    {
        // Ambil data user untuk menghindari pemanggilan Auth() berulang kali
        $user = Auth::user();
        $warehouse = $user->warehouse;
        $account = $warehouse->ChartOfAccount->acc_code;

        // Validasi input
        $this->validate([
            'date_issued' => 'required|date',
            'cred_code' => 'required|string',
            'amount' => 'required|numeric|min:0',
            'fee_amount' => 'required|numeric|min:0',
            'custName' => 'required|regex:/^[a-zA-Z0-9\s]+$/|min:3|max:255',
        ]);

        // Menentukan deskripsi jurnal
        $description = $this->description ? $this->description . ' - ' . strtoupper($this->custName) : 'Kirim Uang - ' . strtoupper($this->custName);

        // Mulai transaksi untuk memastikan semua perubahan terjadi atau tidak sama sekali
        DB::transaction(function () use ($user, $account, $description) {
            // Inisialisasi objek Journal
            $journal = new Journal();
            $journal->invoice = $journal->invoice_journal();  // Menggunakan metode statis untuk invoice
            $journal->date_issued = $this->date_issued;
            $journal->debt_code = $account;
            $journal->cred_code = $this->cred_code;
            $journal->amount = $this->amount;
            $journal->fee_amount = $this->fee_amount;
            $journal->trx_type = 'Transfer Uang';
            $journal->description = $description;
            $journal->user_id = $user->id;
            $journal->warehouse_id = $user->warehouse_id;

            // Simpan jurnal
            $journal->save();

            // Dispatch event TransferCreated
            $this->dispatch('TransferCreated', $journal->id);
        });

        // Flash session dan reset form setelah jurnal disimpan
        session()->flash('success', 'Journal created successfully');
        $this->reset(['date_issued', 'cred_code', 'amount', 'fee_amount', 'custName', 'description']);
    }


    public function render()
    {
        return view('livewire.journal.create-transfer', [
            'credits' => ChartOfAccount::where('account_id', 2)->where('warehouse_id', Auth::user()->warehouse_id)->get(),
        ]);
    }
}
