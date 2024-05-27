<?php

namespace App\Livewire\Warehouse;

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

    #[On('WarehouseCreated', 'WarehouseDeleted')]
    public function render()
    {
        $warehouses = Warehouse::with('ChartOfAccount')->where('name', 'like', '%' . $this->search . '%')->paginate(10);
        return view(
            'livewire.warehouse.warehouse-table',
            [
                'warehouses' => $warehouses,
            ]
        );
    }
}
