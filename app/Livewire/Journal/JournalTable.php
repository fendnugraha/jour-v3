<?php

namespace App\Livewire\Journal;

use App\Models\Journal;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithPagination;

class JournalTable extends Component
{
    use WithPagination;

    public $search = '';

    #[On('TransferCreated')]
    public function render()
    {
        $Journal = Journal::with('debt', 'cred')->where('invoice', 'like', '%' . $this->search . '%')
            ->orWhere('description', 'like', '%' . $this->search . '%')
            ->orWhere('cred_code', 'like', '%' . $this->search . '%')
            ->orWhere('debt_code', 'like', '%' . $this->search . '%')
            ->orWhere('date_issued', 'like', '%' . $this->search . '%')
            ->orWhere('trx_type', 'like', '%' . $this->search . '%')
            ->orWhere('status', 'like', '%' . $this->search . '%')
            ->orWhereHas('debt', function ($query) {
                $query->where('acc_name', 'like', '%' . $this->search . '%');
            })
            ->orWhereHas('cred', function ($query) {
                $query->where('acc_name', 'like', '%' . $this->search . '%');
            })
            ->orderBy('id', 'desc')->Paginate(10);
        return view('livewire.journal.journal-table', [
            'journals' => $Journal
        ]);
    }
}
