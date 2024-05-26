<?php

namespace App\Livewire\Account;

use App\Models\Journal;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use App\Models\ChartOfAccount;

class Block extends Component
{
    use WithPagination;

    public ChartOfAccount $account;

    public function delete($id)
    {
        $account = ChartOfAccount::findOrFail($id);
        if ($account) {
            $journalExists = Journal::where('debt_code', $account->acc_code)
                ->orWhere('cred_code', $account->acc_code)
                ->exists();
            if ($journalExists) {
                session()->flash('error', 'Account Cannot be Deleted!');
            } else {
                $account->delete();
                $this->dispatch('AccountDeleted', ['id' => $account->id]);
                session()->flash('success', 'Account Deleted Successfully!');
            }
        }
    }


    #[On('AccountCreated', 'AccountDeleted')]
    public function render()
    {
        return view(
            'livewire.account.block',
            [
                'accounts' => ChartOfAccount::with('account')->orderBy('acc_code', 'asc')->paginate(10),
            ]
        );
    }
}
