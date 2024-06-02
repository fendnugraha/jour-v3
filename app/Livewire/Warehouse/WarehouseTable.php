<?php

namespace App\Livewire\Warehouse;

use App\Models\Journal;
use Livewire\Component;
use App\Models\Warehouse;
use Livewire\Attributes\On;
use Livewire\WithPagination;

class WarehouseTable extends Component
{
    use WithPagination;

    public $search = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function delete($warehouse_id)
    {
        $warehouse = Warehouse::find($warehouse_id);

        $journalExists = Journal::where('warehouse_id', $warehouse_id)->exists();
        // dd($journalExists);
        if ($journalExists || $warehouse_id == 1) {
            session()->flash('error', 'Warehouse Cannot be Deleted!');
        } else {
            $warehouse->delete();
            session()->flash('success', 'Warehouse Deleted Successfully');
        }

        $this->dispatch('WarehouseDeleted', $warehouse->id);
    }

    #[On('WarehouseCreated', 'WarehouseDeleted')]
    public function render()
    {
        $warehouses = Warehouse::with('ChartOfAccount')
            ->where('name', 'like', '%' . $this->search . '%')
            ->orWhere('address', 'like', '%' . $this->search . '%')
            ->orWhere('code', 'like', '%' . $this->search . '%')
            ->paginate(10);
        return view(
            'livewire.warehouse.warehouse-table',
            [
                'warehouses' => $warehouses,
            ]
        );
    }
}
