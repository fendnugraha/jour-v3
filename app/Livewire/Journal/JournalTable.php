<?php

namespace App\Livewire\Journal;

use App\Models\Journal;
use Livewire\Component;

class JournalTable extends Component
{
    public function render()
    {
        $Journal = Journal::where('invoice', 'like', '%' . request('search') . '%')->paginate(10);
        return view('livewire.journal.journal-table', [
            'journals' => $Journal
        ]);
    }
}
