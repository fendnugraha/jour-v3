<?php

namespace App\Livewire\Warehouse;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\ChartOfAccount;
use Livewire\Attributes\On;

class WhBankList extends Component
{
    use WithPagination;

    public $search;
    public $warehouse;

    public function updateBankList($account_id, $warehouse_id)
    {
        $checkAccount = ChartOfAccount::where('id', $account_id)->where('warehouse_id', $warehouse_id)->exists();

        if ($checkAccount) {
            ChartOfAccount::where('id', $account_id)->where('warehouse_id', $warehouse_id)->update([
                'warehouse_id' => 0
            ]);
        } else {
            ChartOfAccount::where('id', $account_id)->update([
                'warehouse_id' => $warehouse_id
            ]);
        }

        $this->dispatch('WarehouseBankUpdated', $warehouse_id);
    }

    #[On('WarehouseBankUpdated')]
    public function render()
    {
        $banks = ChartOfAccount::where('account_id', 2)->where('acc_name', 'like', '%' . $this->search . '%')->paginate(5);
        return view('livewire.warehouse.wh-bank-list', [
            'banks' => $banks
        ]);
    }
}
