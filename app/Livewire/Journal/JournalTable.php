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
        $Journal = Journal::where('invoice', 'like', '%' . $this->search . '%')->orderBy('id', 'desc')->Paginate(10);
        return view('livewire.journal.journal-table', [
            'journals' => $Journal
        ]);
    }
}
