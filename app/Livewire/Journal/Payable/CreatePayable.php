<?php

namespace App\Livewire\Journal\Payable;

use Carbon\Carbon;
use App\Models\Contact;
use App\Models\Journal;
use App\Models\Payable;
use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\ChartOfAccount;
use Illuminate\Support\Facades\DB;

class CreatePayable extends Component
{
    public $date_issued;
    public $amount;
    public $description;
    public $contact;
    public $debt_code;
    public $cred_code;

    public function mount()
    {
        $this->date_issued = date('Y-m-d H:i');
    }
    public function save()
    {
        $dateIssued = Carbon::parse($this->date_issued);
        $pay = new Payable();
        $invoice_number = $pay->invoice_payable($this->contact);

        $this->validate([
            'date_issued' => 'required',
            'amount' => 'required|numeric',
            'description' => 'required|max:160',
            'contact' => 'required',
            'debt_code' => 'required',
            'cred_code' => 'required',
        ]);

        try {
            DB::transaction(function () use ($invoice_number, $dateIssued) {
                Payable::create([
                    'date_issued' => $dateIssued,
                    'due_date' => $dateIssued->copy()->addDays(30),
                    'invoice' => $invoice_number,
                    'description' => $this->description,
                    'bill_amount' => $this->amount,
                    'payment_amount' => 0,
                    'payment_status' => 0,
                    'payment_nth' => 0,
                    'contact_id' => $this->contact,
                    'account_code' => $this->cred_code
                ]);

                Journal::create([
                    'date_issued' => $dateIssued,
                    'invoice' => $invoice_number,
                    'description' => $this->description,
                    'debt_code' => $this->debt_code,
                    'cred_code' => $this->cred_code,
                    'amount' => $this->amount,
                    'fee_amount' => 0,
                    'status' => 1,
                    'rcv_pay' => 'Payable',
                    'payment_status' => 0,
                    'payment_nth' => 0,
                    'user_id' => auth()->user()->id,
                    'warehouse_id' => 1
                ]);
            });
            DB::commit();
            session()->flash('success', 'Payable created successfully');

            $this->dispatch('TransferCreated', $invoice_number);

            $this->reset();
        } catch (\Throwable $th) {
            DB::rollBack();
            session()->flash('error', $th->getMessage());
        }
    }

    #[On('TransferCreated')]
    public function resetDateIssued()
    {
        $this->date_issued = date('Y-m-d H:i');
    }

    public function render()
    {
        return view('livewire.journal.payable.create-payable', [
            'contacts' => Contact::orderBy('name')->get(),
            'payAccounts' => ChartOfAccount::where('account_id', 19)->orderBy('acc_code')->get(),
            'accounts' => ChartOfAccount::whereIn('account_id', [1, 2, 6])->orderBy('acc_code')->get()
        ]);
    }
}
