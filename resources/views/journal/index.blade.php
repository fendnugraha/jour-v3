<x-layouts.app>
    <x-slot:title>{{ $title }}</x-slot:title>
    <div class="grid grid-cols-1 sm:grid-cols-5 gap-2 mb-3 w-full">
        <div>
            <x-modal modalName="transferUang" modalTitle="Form Transfer Uang">
                <livewire:journal.create-transfer />
            </x-modal>
            <button x-data x-on:click="$dispatch('open-modal', {'modalName': 'transferUang'})"
                class="bg-sky-950 text-white p-2 text-sm shadow-300 flex justify-center items-center rounded-xl hover:bg-sky-800 transition duration-300 ease-out w-full">
                Transfer Uang
            </button>
        </div>
        <div>
            <x-modal modalName="tarikTunai" modalTitle="Form Penarikan Tunai">
                <livewire:journal.create-cash-withdrawal />
            </x-modal>
            <button x-data x-on:click="$dispatch('open-modal', {'modalName': 'tarikTunai'})"
                class="bg-sky-950 text-white p-2 text-sm shadow-300 flex justify-center items-center rounded-xl hover:bg-sky-800 transition duration-300 ease-out w-full">
                Tarik Tunai
            </button>
        </div>
        <div>
            <x-dropdown-button dropdownTitle="Voucher & Deposit" dropdownName="report"
                class="bg-green-600 hover:bg-green-500 text-white text-sm">
                <div>
                    <ul class="text-sm flex flex-col">
                        <li class="py-2 px-4 hover:bg-slate-50">
                            <x-modal modalName="voucher" modalTitle="Form Penjualan Voucher">
                                <livewire:journal.create-voucher />
                            </x-modal>
                            <button x-data x-on:click="$dispatch('open-modal', {'modalName': 'voucher'})"
                                class="w-full text-left">
                                Voucher & SP
                            </button>
                        </li>
                        <li class="py-2 px-4 hover:bg-slate-50">
                            <x-modal modalName="deposit" modalTitle="Form Penjualan Deposit">
                                <livewire:journal.create-deposit />
                            </x-modal>
                            <button x-data x-on:click="$dispatch('open-modal', {'modalName': 'deposit'})"
                                class="w-full text-left">
                                Deposit (Pulsa dll)
                            </button>
                        </li>
                    </ul>
                </div>
            </x-dropdown-button>

        </div>
        <div>
            <x-dropdown-button dropdownTitle="Pengeluaran (Biaya)" dropdownName="journal"
                class="bg-red-600 hover:bg-red-500 text-white text-sm">
                <div>
                    <ul class="text-sm flex flex-col">
                        <li class="py-2 px-4 hover:bg-slate-50">
                            <x-modal modalName="refund" modalTitle="Mutasi Saldo ke Pusat">
                                <livewire:journal.create-refund />
                            </x-modal>
                            <button x-data x-on:click="$dispatch('open-modal', {'modalName': 'refund'})"
                                class="w-full text-left">
                                Pengembalian Saldo Kas & Bank
                            </button>
                        </li>
                        <li class="py-2 px-4 hover:bg-slate-50">
                            <x-modal modalName="formExpense" modalTitle="Form Biaya Operasional">
                                <livewire:journal.create-expense />
                            </x-modal>
                            <button x-data x-on:click="$dispatch('open-modal', {'modalName': 'formExpense'})"
                                class="w-full text-left">
                                Biaya Operasional
                            </button>
                        </li>
                        <li class="py-2 px-4 hover:bg-slate-50">
                            <x-modal modalName="adminFee" modalTitle="Form Biaya Admin Bank">
                                <livewire:journal.create-admin-fee />
                            </x-modal>
                            <button x-data x-on:click="$dispatch('open-modal', {'modalName': 'adminFee'})"
                                class="w-full text-left">
                                Biaya Admin Bank
                            </button>
                        </li>
                    </ul>
                </div>
            </x-dropdown-button>
        </div>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-4 gap-2 mb-3">
        <div class="sm:col-span-3 order-2 sm:order-1">
            @livewire('journal.journal-table', ['warehouse_id' => Auth()->user()->warehouse_id])
        </div>
        <div class="order-1 sm:order-2">
            <livewire:journal.cash-bank-balance-table lazy />
        </div>
    </div>
    <div>
        <livewire:report.mutation-history :warehouse_id="Auth()->user()->warehouse_id" lazy />
    </div>
</x-layouts.app>