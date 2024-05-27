<?php

namespace App\Livewire\User;

use App\Models\User;
use App\Models\Journal;
use Livewire\Component;
use Livewire\Attributes\On;

class UserTable extends Component
{
    public $search = '';
    public $showNotification = true;
    public function delete($id)
    {
        $user = User::find($id);

        $journalExists = Journal::where('user_id', $id)->exists();
        if ($journalExists) {
            session()->flash('error', 'User Cannot be Deleted!');
        } else {
            $user->delete();
            session()->flash('success', 'User Deleted Successfully');
        }

        $this->dispatch('UserDeleted', $user->id);
    }

    public function resetNotificationState()
    {
        $this->showNotification = true;
    }

    #[On('UserCreated', 'UserDeleted')]
    public function render()
    {
        $users = User::with('warehouse')
            ->where('name', 'like', '%' . $this->search . '%')
            ->orWhere('email', 'like', '%' . $this->search . '%')
            ->orWhere('role', 'like', '%' . $this->search . '%')
            ->orWhereHas('warehouse', function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })
            ->paginate(10);
        return view(
            'livewire.user.user-table',
            [
                'users' => $users
            ]
        );
    }
}
