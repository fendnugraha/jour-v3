<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Warehouse;
use App\Models\ChartOfAccount;

class CreateWarehouse extends Component
{
    public $code;
    public $name;
    public $address;
    public $cashAccount;

    public function save()
    {
        $this->validate([
            'code' => 'required',
            'name' => 'required',
            'address' => 'required',
            'cashAccount' => 'required',
        ]);

        // Create and save the warehouse
        $warehouse = Warehouse::create([
            'code' => $this->code,
            'name' => $this->name,
            'address' => $this->address,
            'chart_of_account_id' => $this->cashAccount
        ]);

        // Update the related ChartOfAccount with the warehouse ID
        ChartOfAccount::where('id', $this->cashAccount)->update(['warehouse_id' => $warehouse->id]);

        // Flash success message
        session()->flash('success', 'Gudang berhasil ditambahkan');

        // Reset the form inputs
        $this->reset();
    }


    public function render()
    {
        $cashAccounts = ChartOfAccount::where('account_id', 1)->where('warehouse_id', 0)->get();
        return view('livewire.create-warehouse', [
            'cashAccounts' => $cashAccounts
        ]);
    }
}
