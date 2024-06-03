<?php

namespace App\Livewire\Journal\Payable;

use App\Models\Payable;
use Livewire\Component;

class EditPayable extends Component
{
    public $id;
    public Payable $payable;

    public function mount($id)
    {
        $this->id = Payable::find($id);
    }

    public function render()
    {
        return view('livewire.journal.payable.edit-payable', [
            'payable' => $this->payable->find($this->id),
        ]);
    }
}
