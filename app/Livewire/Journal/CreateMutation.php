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
        $user = Auth::user();

        // Validasi input
        $this->validate([
            'date_issued' => 'required|date',
            'debt_code' => 'required|string',
            'cred_code' => 'required|string',
            'amount' => 'required|numeric',
        ]);

        // Buat jurnal pertama untuk Mutasi Kas
        $journal = new Journal([
            'invoice' => Journal::invoice_journal(),
            'date_issued' => $this->date_issued,
            'debt_code' => $this->debt_code,
            'cred_code' => $this->cred_code,
            'amount' => $this->amount,
            'fee_amount' => 0,
            'trx_type' => 'Mutasi Kas',
            'description' => $this->description ?? 'Penambahan saldo kas & bank ke rekening cabang',
            'user_id' => $user->id,
            'warehouse_id' => $user->warehouse_id,
        ]);

        $journal->save();

        // Jika ada biaya admin, buat jurnal untuk pengeluaran biaya admin
        if ($this->adminFee > 0) {
            $adminFeeJournal = new Journal([
                'invoice' => $journal->invoice_journal(),  // Gunakan invoice yang berbeda atau buat baru jika perlu
                'date_issued' => $this->date_issued,
                'debt_code' => $user->warehouse->ChartOfAccount->acc_code,  // Debet ke akun kas atau biaya admin
                'cred_code' => $this->cred_code,
                'amount' => $this->adminFee,
                'fee_amount' => -$this->adminFee,  // Biaya admin sebagai pengeluaran
                'trx_type' => 'Pengeluaran',
                'description' => $this->description ?? 'Biaya admin Mutasi Saldo Kas',
                'user_id' => $user->id,
                'warehouse_id' => $user->warehouse_id,
            ]);
            $adminFeeJournal->save();
        }

        // Flash session dan reset form setelah jurnal disimpan
        session()->flash('success', 'Journal created successfully');

        // Dispatch event TransferCreated untuk memberitahukan perubahan
        $this->dispatch('TransferCreated', $journal->id);

        // Reset input form setelah simpan
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
