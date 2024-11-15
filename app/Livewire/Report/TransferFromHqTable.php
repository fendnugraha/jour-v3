<?php

namespace App\Livewire\Report;

use Carbon\Carbon;
use App\Models\Journal;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use App\Models\ChartOfAccount;
use App\Models\Warehouse;

class TransferFromHqTable extends Component
{
    use WithPagination;

    public $balance;
    public $warehouse_id;
    public $startDate;
    public $endDate;
    public $perPage = 5;

    public $searchHistory;
    public $searchDecrease;
    public $warehouse;

    public function mount()
    {
        $this->endDate = date('Y-m-d H:i');
    }

    public function updateLimitPage($pageName = 'page')
    {
        $this->resetPage(pageName: $pageName);
    }

    #[On('TransferCreated')]
    public function updateData()
    {
        // Perbarui data yang diperlukan ketika event terjadi
        $this->resetPage(); // Reset pagination jika diperlukan
    }

    public function render()
    {
        // Ambil data chartOfAccounts
        $chartOfAccounts = $this->getChartOfAccounts();

        // Tentukan start dan end date
        $startDate = Carbon::parse($this->endDate)->startOfDay();
        $endDate = Carbon::parse($this->endDate)->endOfDay();

        // Ambil transaksi yang dikelompokkan
        $transactions = $this->getGroupedTransactions($endDate);

        // Hitung saldo untuk setiap akun
        $this->calculateAccountBalances($chartOfAccounts, $transactions);

        // Ambil jurnal untuk periode yang ditentukan
        $journal = $this->getJournalForPeriod($startDate, $endDate);

        // Ambil history transaksi dengan filter dan pencarian
        $history = $this->getHistory($startDate, $endDate, $chartOfAccounts);

        return view('livewire.report.transfer-from-hq-table', [
            'journal' => $journal,
            'accounts' => $chartOfAccounts,
            'history' => $history,
            'whAccounts' => $chartOfAccounts->pluck('acc_code'),
            'warehouse' => $this->warehouse
        ]);
    }

    // Mendapatkan data ChartOfAccount
    private function getChartOfAccounts()
    {
        return ChartOfAccount::with(['account', 'warehouse'])
            ->where('warehouse_id', $this->warehouse_id)
            ->get();
    }

    // Mendapatkan transaksi yang dikelompokkan
    private function getGroupedTransactions($endDate)
    {
        return Journal::with(['debt', 'cred'])
            ->selectRaw('debt_code, cred_code, SUM(amount) as total, warehouse_id')
            ->whereBetween('date_issued', [Carbon::create(0000, 1, 1, 0, 0, 0)->startOfDay(), $endDate])
            ->groupBy('debt_code', 'cred_code', 'warehouse_id')
            ->get();
    }

    // Menghitung saldo untuk setiap akun
    private function calculateAccountBalances($chartOfAccounts, $transactions)
    {
        foreach ($chartOfAccounts as $value) {
            $debit = $transactions->where('debt_code', $value->acc_code)->sum('total');
            $credit = $transactions->where('cred_code', $value->acc_code)->sum('total');

            // @ts-ignore
            $value->balance = ($value->account->status == "D") ? ($value->st_balance + $debit - $credit) : ($value->st_balance + $credit - $debit);
        }
    }

    // Mendapatkan jurnal untuk periode yang ditentukan
    private function getJournalForPeriod($startDate, $endDate)
    {
        return Journal::whereBetween('date_issued', [$startDate, $endDate])
            ->where('trx_type', 'Mutasi Kas')
            ->get();
    }

    // Mendapatkan history dengan filter dan pencarian
    private function getHistory($startDate, $endDate, $chartOfAccounts)
    {
        return Journal::with(['debt', 'cred'])
            ->where('trx_type', 'Mutasi Kas')
            ->whereBetween('date_issued', [$startDate, $endDate])
            ->where(function ($query) use ($chartOfAccounts) {
                $query->whereIn('debt_code', $chartOfAccounts->pluck('acc_code'))
                    ->orWhereIn('cred_code', $chartOfAccounts->pluck('acc_code'));
            })
            ->FilterMutation(['searchHistory' => $this->searchHistory])
            ->orderBy('id', 'desc')
            ->paginate($this->perPage, ['*'], 'history');
    }
}
