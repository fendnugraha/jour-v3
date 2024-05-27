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
    public $search = '';

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
        $ChartOfAccount = ChartOfAccount::with('account')
            ->where('acc_name', 'like', '%' . $this->search . '%')
            ->orWhere('acc_code', 'like', '%' . $this->search . '%')
            ->orderBy('acc_code', 'asc')->paginate(10);
        return view(
            'livewire.account.block',
            [
                'accounts' => $ChartOfAccount
            ]
        );
    }
}
