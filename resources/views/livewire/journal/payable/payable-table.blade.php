<div class="bg-white p-2 rounded-lg relative">
    <h4 class=" text-blue-950 text-lg font-bold mb-6">Hutang</h4>
    <div class="flex items-center mb-3 gap-3">
        <div class="">
            <x-modal modalName="addPayable" modalTitle="Form Input Hutang">
                <livewire:journal.payable.create-payable />
            </x-modal>
            <button x-data x-on:click="$dispatch('open-modal', {'modalName': 'addPayable'})"
                class="bg-sky-950 text-white p-2 text-sm shadow-300 justify-center items-center rounded-lg hover:bg-sky-800 transition duration-300 ease-out w-40">
                <i class="fa-solid fa-plus"></i> Hutang
            </button>
        </div>
        <div class="">
            <x-modal modalName="addContact" modalTitle="Form Tambah Contact">
                <livewire:contact.create-contact />
            </x-modal>
            <button x-data x-on:click="$dispatch('open-modal', {'modalName': 'addContact'})"
                class="bg-sky-950 text-white p-2 text-sm shadow-300 flex justify-center items-center rounded-lg hover:bg-sky-800 transition duration-300 ease-out w-40">
                <i class="fa-solid fa-plus"></i> Contact
            </button>
        </div>
    </div>
    <div class="grid grid-cols-2 gap-2">
        <div>
            <div class="flex justify-between items-center mb-3 gap-3">

                <input type="text" wire:model="search" class="w-full text-sm border rounded-lg p-2"
                    placeholder="Search ..">
                <select wire:model="perPage" class="w-text-sm border rounded-lg p-2 w-20">
                    <option value="5">5</option>
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
            </div>
            <table class="table-auto w-full text-xs mb-2">
                <thead class="bg-white text-blue-950">
                    <tr class="border-b">
                        <th class="text-center p-4">Contact</th>
                        <th class="text-center">Tagihan</th>
                        <th class="text-center">Terbayar</th>
                        <th class="text-center">Sisa</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($payables as $payable)
                    @php
                    $lunas = $payable->terbayar > 0 && $payable->sisa == 0 ? '<span
                        class="text-white font-bold bg-green-500 px-2 py-1 rounded-lg"><i class="fa-solid fa-check"></i>
                        Lunas</span>' :
                    Number::format($payable->sisa);
                    @endphp
                    <tr class="border border-slate-100 odd:bg-white even:bg-blue-50 hover:bg-slate-600 hover:text-white cursor-pointer"
                        wire:click="setContactId({{ $payable->contact->id }})"
                        wire:key="payable-{{ $payable->contact->id }}">
                        <td class="p-3">{{
                            $payable->contact->name }}</td>
                        <td class="p-3 text-right">{{ Number::format($payable->tagihan) }}</td>
                        <td class="p-3 text-right">{{ Number::format($payable->terbayar) }}</td>
                        <td class="p-3 text-center">{!! $lunas !!}</td>
                        <td class="p-3 text-center">

                            <button x-data x-on:click="$dispatch('open-modal', {'modalName': 'payablePayment'})"
                                class="bg-orange-600 text-white text-xs shadow-300 flex justify-center items-center rounded-lg hover:bg-orange-500 transition duration-300 ease-out disabled:opacity-50 px-2 py-1 disabled:cursor-not-allowed"
                                {{ $payable->sisa == 0 ? 'disabled' : '' }}>
                                Bayar
                            </button>
                        </td>

                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr class="border-y border-slate-100 odd:bg-white even:bg-blue-50 font-bold">
                        <td class="p-2">Total</td>
                        <td class="text-right p-2 text-red-500">{{
                            Number::format($totalPayable->sum('tagihan')) }}</td>
                        <td class="text-right p-2 text-red-500">{{
                            Number::format($totalPayable->sum('terbayar')) }}</td>
                        <td class="text-right p-2">{!! $totalPayable->sum('tagihan') == $totalPayable->sum('terbayar') ?
                            '<span class="text-green-500 font-bold"><i class="fa-solid fa-check"></i> Lunas</span>' :
                            Number::format($totalPayable->sum('sisa'))
                            !!}
                        </td>
                    </tr>
                </tfoot>
            </table>

            {{ $payables->links() }}

            {{-- Modal pembayaran --}}
            <x-modal modalName="payablePayment" modalTitle="Form Pemabayaran Hutang">
                <form wire:submit="save">
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-1 mb-2 items-center">
                        <label for="date_issued" class="block ">Tanggal</label>
                        <div class="col-span-2">
                            <input type="datetime-local" wire:model="date_issued"
                                class="w-full border rounded-lg p-2 @error('date_issued') border-red-500 @enderror">
                            @error('date_issued') <small class="text-red-500">{{ $message }}</small> @enderror
                        </div>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-1 mb-2 items-center">
                        <label for="invoice" class="block ">No. Faktur</label>
                        <div class="col-span-2">
                            <select class="w-full border rounded-lg p-2" wire:model="invoice">
                                <option value="">--Pilih Faktur--</option>
                                @foreach ($payablesContacts->groupBy('invoice') as $i)
                                <option value="{{ $i->first()->invoice }}" {{ $i->sum('bill_amount') ==
                                    $i->sum('payment_amount') ? 'hidden' : '' }}>{{ $i->first()->invoice }} Rp. {{
                                    Number::format($i->sum('bill_amount')-$i->sum('payment_amount')) }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-1 mb-2 items-center">
                        <label for="cred_code" class="block ">Rekening</label>
                        <div class="col-span-2">
                            <select wire:model="cred_code"
                                class="w-full border rounded-lg p-2 @error('cred_code') border-red-500 @enderror">
                                <option value="">--Pilih Rekening--</option>
                                @foreach ($credits as $credit)
                                <option value="{{ $credit->acc_code }}">{{ $credit->acc_name }}</option>
                                @endforeach
                            </select>
                            @error('cred_code') <small class="text-red-500">{{ $message }}</small> @enderror
                        </div>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-1 mb-2 items-center">
                        <label for="amount" class="block ">Jumlah</label>
                        <div class="col-span-2">
                            <input type="number" wire:model="amount"
                                class="w-full border rounded-lg p-2 @error('amount') border-red-500 @enderror"
                                placeholder="Rp">
                            @error('amount') <small class="text-red-500">{{ $message }}</small> @enderror
                        </div>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-1 mb-2 items-center">
                        <label for="description" class="block ">Catatan</label>
                        <div class="col-span-2">
                            <textarea wire:model="description"
                                class="w-full border rounded-lg p-2 @error('description') border-red-500 @enderror"
                                placeholder="Catatan"></textarea>
                            @error('description') <small class="text-red-500">{{ $message }}</small> @enderror
                        </div>
                    </div>

                    <button type="submit" class="border rounded-lg p-2 bg-blue-500 text-white">Simpan</button>
                </form>
            </x-modal>
        </div>


        <div>
            @if ($payablesContacts->count() > 0)

            <h4 class="text-blue-950 text-lg font-bold mb-3">Rincian Hutang <span class="text-orange-500">{{
                    $payablesContacts->count() > 0 ?
                    $payablesContacts->first()->contact->name : '' }}</span>. Sisa: {!!
                $totalPayableContact->sum('bill_amount') ==
                $totalPayableContact->sum('payment_amount') ?
                '<span class="text-green-500 font-bold"><i class="fa-solid fa-check"></i> Lunas</span>' :
                Number::format($totalPayableContact->sum('bill_amount') -
                $totalPayableContact->sum('payment_amount'))
                !!}</h4>

            <div class="flex justify-between items-center mb-3 gap-3">

                <input type="text" wire:model.live.debounce.500ms="searchPageContact"
                    class="w-full text-sm border rounded-lg p-2" placeholder="Search ..">
                <select wire:model.live="perPageContact" class="w-text-sm border rounded-lg p-2 w-20">
                    <option value="5">5</option>
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
            </div>
            <table class="table-auto w-full text-xs mb-2">
                <thead class="bg-white text-blue-950">
                    <tr class="border-b">
                        <th class="text-center p-4">Keterangan</th>
                        <th class="text-center">Tagihan</th>
                        <th class="text-center">Terbayar</th>
                        <th class="text-center">Sisa</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($payablesContacts as $pc)
                    <tr class="border border-slate-100 odd:bg-white even:bg-blue-50">
                        <td class="p-3" wire:key="payable-{{ $pc->id }}">
                            <span class="text-slate-500 block">{{ $pc->created_at }}</span>
                            <span class="block font-bold">{{ $pc->invoice }}</span>
                            {{
                            $pc->description }}
                        </td>
                        <td class="p-3 text-right">{{ $pc->bill_amount == 0 ? '' : Number::format($pc->bill_amount)
                            }}
                        </td>
                        <td class="p-3 text-right">{{ $pc->payment_amount == 0 ? '' :
                            Number::format($pc->payment_amount)
                            }}</td>
                        <td class="p-3 text-right">
                            <button wire:click="deletePayableContact({{ $pc->id }})"
                                class="rounded-lg py-2 px-3 bg-red-500 text-white"><i class="fa-solid fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr class="border-y border-slate-100 odd:bg-white even:bg-blue-50 font-bold">
                        <td class="p-2">Total</td>
                        <td class="text-right p-2 text-red-500">{{
                            Number::format($totalPayableContact->sum('bill_amount')) }}</td>
                        <td class="text-right p-2 text-red-500">{{
                            Number::format($totalPayableContact->sum('payment_amount')) }}</td>
                        <td class="text-right p-2">{!! $totalPayableContact->sum('bill_amount') ==
                            $totalPayableContact->sum('payment_amount') ?
                            '<span class="text-green-500 font-bold"><i class="fa-solid fa-check"></i> Lunas</span>' :
                            Number::format($totalPayableContact->sum('bill_amount') -
                            $totalPayableContact->sum('payment_amount'))
                            !!}
                        </td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>

            {{ $payablesContacts->onEachSide(0)->links(data: ['scrollTo' => false]) }}
            @endif

        </div>
    </div>

    <div class="absolute inset-0 flex items-center justify-center" wire:loading>
        <!-- Container for the loading message -->
        <div class="bg-white/50 h-full w-full flex items-center justify-center gap-2">
            <!-- Loading text -->
            <i class="fa-solid fa-spinner animate-spin text-blue-950 text-3xl"></i>
            <p class="text-blue-950 text-sm font-bold">
                Loading data, please wait...
            </p>
        </div>
    </div>
    @if(session('success'))
    <x-notification class="bg-green-500 text-white mb-3">
        <strong><i class="fas fa-check-circle"></i> Success!!</strong>
    </x-notification>
    @elseif (session('error'))
    <x-notification class="bg-red-500 text-white mb-3">
        <strong>Error!!</strong> {{
        session('error') }}
    </x-notification>
    @endif
</div>