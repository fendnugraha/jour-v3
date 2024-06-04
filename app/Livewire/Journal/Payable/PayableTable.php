<?php

namespace App\Livewire\Journal\Payable;

use App\Models\Contact;
use App\Models\Payable;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use App\Models\ChartOfAccount;

class PayableTable extends Component
{
    use WithPagination;

    public $date_issued;
    public $perPage = 5;
    public $search = '';
    public $contact_id = '';
    public $perPageContact = 5;
    public $amount = 0;
    public $invoice;

    public function mount()
    {
        $this->date_issued = date('Y-m-d H:i');
    }

    public function setContactId($contact_id)
    {
        $this->contact_id = $contact_id;
        $this->updateLimitPage('payablesContact');
    }

    public function getInvoiceValue($invoice)
    {
        $sisa = Payable::selectRaw('SUM(bill_amount) - SUM(payment_amount) as sisa')->where('invoice', $this->invoice)->groupBy('invoice')->first()->sisa;
        dd($sisa);
    }

    public function updateLimitPage($pageName = 'page')
    {
        $this->resetPage(pageName: $pageName);
    }

    #[On('TransferCreated')]
    public function render()
    {
        $payable = Payable::with('contact')->selectRaw('contact_id, SUM(bill_amount) as tagihan, SUM(payment_amount) as terbayar, SUM(bill_amount) - SUM(payment_amount) as sisa')
            ->whereHas('contact', function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })
            ->groupBy('contact_id');

        $payablesContact = Payable::with('contact')->where('contact_id', $this->contact_id)->orderBy('date_issued', 'desc');

        $contacts = Contact::whereIn('id', $payable->pluck('contact_id'))->orderBy('name')->get();
        return view('livewire.journal.payable.payable-table', [
            'payables' => $payable->paginate($this->perPage, ['*'], 'payables'),
            'payablesContacts' => $payablesContact->paginate($this->perPageContact, ['*'], 'payablesContact'),
            'contacts' => $contacts,
            'credits' => ChartOfAccount::whereIn('account_id', [1, 2])->orderBy('acc_code')->get(),
            'totalPayable' => $payable->get(),
            'totalPayableContact' => $payablesContact->where('contact_id', $this->contact_id)->get(),
        ]);
    }
}
