<?php

namespace App\Livewire\Journal\Payable;

use App\Models\Contact;
use App\Models\Payable;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use App\Models\ChartOfAccount;
use App\Models\Journal;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class PayableTable extends Component
{
    use WithPagination;

    public $date_issued;
    public $amount = 0;
    public $description;
    public $contact_id = '';
    public $debt_code;
    public $cred_code;
    public $perPage = 5;
    public $search = '';
    public $perPageContact = 5;
    public $invoice;

    #[On('TransferCreated')]
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
        return $sisa;
    }

    public function getPayableData($invoice)
    {
        $pay_nth = Payable::where('invoice', $invoice)->where('payment_nth', 0)->first();
        return $pay_nth;
    }

    public function updateLimitPage($pageName = 'page')
    {
        $this->resetPage(pageName: $pageName);
    }

    public function save()
    {
        // dd($this->getInvoiceValue($this->invoice));
        $sisa = $this->getInvoiceValue($this->invoice);
        if ($sisa < $this->amount) {
            session()->flash('error', 'Jumlah pembayaran melebihi sisa tagihan');
            return;
        }

        $this->validate([
            'date_issued' => 'required',
            'cred_code' => 'required',
            'amount' => 'required',
            'description' => 'required',
            'contact_id' => 'required',
        ]);

        $payment_nth = Payable::selectRaw('MAX(payment_nth) as payment_nth')->where('invoice', $this->invoice)->first()->payment_nth + 1;
        $payment_status = $this->getInvoiceValue($this->invoice) == 0 ? 1 : 0;

        try {
            DB::transaction(function () use ($payment_nth, $payment_status) {
                Payable::create([
                    'date_issued' => Carbon::parse($this->date_issued),
                    'due_date' => $this->getPayableData($this->invoice)->due_date,
                    'invoice' => $this->invoice,
                    'description' => $this->description,
                    'bill_amount' => 0,
                    'payment_amount' => $this->amount,
                    'payment_status' => $payment_status,
                    'payment_nth' => $payment_nth,
                    'contact_id' => $this->contact_id,
                    'account_code' => $this->cred_code
                ]);

                Journal::create([
                    'date_issued' => Carbon::parse($this->date_issued),
                    'invoice' => $this->invoice,
                    'description' => $this->description,
                    'debt_code' => $this->getPayableData($this->invoice)->account_code,
                    'cred_code' => $this->cred_code,
                    'amount' => $this->amount,
                    'fee_amount' => 0,
                    'status' => 1,
                    'rcv_pay' => 'Payable',
                    'payment_status' => $payment_status,
                    'payment_nth' => $payment_nth,
                    'user_id' => auth()->user()->id,
                    'warehouse_id' => 1
                ]);
            });

            DB::commit();
            $this->dispatch('TransferCreated', $this->invoice);

            $this->reset();
            session()->flash('success', 'Payable created successfully');
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
            session()->flash('error', $th->getMessage());
        }
    }

    public function deletePayableContact($id)
    {
        $payable = Payable::find($id);
        $invoice = $payable->invoice;

        $checkData = Payable::where('invoice', $invoice)->get();
        // dd($checkData->count());

        if ($payable->payment_status == 1) {
            session()->flash('error', 'Hutang sudah terbayar');
            return;
        }


        if ($payable->payment_status == 0 && $payable->payment_nth == 0 && $checkData->count() > 1) {
            session()->flash('error', 'Sudah terjadi pembayaran');
            return;
        }

        Journal::where('invoice', $invoice)->where('payment_status', $payable->payment_status)->where('payment_nth', $payable->payment_nth)->delete();
        $payable->delete();
        $this->dispatch('TransferCreated', $invoice);
        session()->flash('success', 'Payable deleted successfully');
    }

    public function render()
    {
        $payable = Payable::with('contact')->selectRaw('contact_id, SUM(bill_amount) as tagihan, SUM(payment_amount) as terbayar, SUM(bill_amount) - SUM(payment_amount) as sisa')
            ->whereHas('contact', function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })
            ->groupBy('contact_id');

        $payablesContact = Payable::with('contact')->where('contact_id', $this->contact_id)->orderBy('date_issued', 'desc')->paginate($this->perPageContact, ['*'], 'payablesContact');

        $payableInvoice = Payable::with('contact')->where('contact_id', $this->contact_id)->orderBy('date_issued', 'desc')->get();

        $contacts = Contact::whereIn('id', $payable->pluck('contact_id'))->orderBy('name')->get();
        return view('livewire.journal.payable.payable-table', [
            'payables' => $payable->paginate($this->perPage, ['*'], 'payables'),
            'payablesContacts' => $payablesContact,
            'payableInvoice' => $payableInvoice,
            'contacts' => $contacts,
            'credits' => ChartOfAccount::whereIn('account_id', [1, 2])->orderBy('acc_code')->get(),
            'totalPayable' => Payable::selectRaw('contact_id, SUM(bill_amount) as tagihan, SUM(payment_amount) as terbayar, SUM(bill_amount) - SUM(payment_amount) as sisa')->groupBy('contact_id')->get(),
            'totalPayableContact' => Payable::where('contact_id', $this->contact_id)->get(),
        ]);
    }
}
