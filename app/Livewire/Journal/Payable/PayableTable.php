<?php

namespace App\Livewire\Journal\Payable;

use App\Models\Payable;
use Livewire\Component;
use Livewire\Attributes\On;

class PayableTable extends Component
{
    public $perPage = 10;
    public $search = '';

    #[On('TransferCreated')]
    public function render()
    {
        $payables = Payable::with('contact')->selectRaw('contact_id, SUM(bill_amount) as tagihan, SUM(payment_amount) as terbayar, SUM(bill_amount) - SUM(payment_amount) as sisa')
            ->whereHas('contact', function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })
            ->groupBy('contact_id')
            ->paginate($this->perPage, ['*'], 'payables');

        return view('livewire.journal.payable.payable-table', [
            'payables' => $payables
        ]);
    }
}
