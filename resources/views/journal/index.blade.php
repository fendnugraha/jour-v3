<x-layouts.app>
    <x-slot:title>{{ $title }}</x-slot:title>
    <x-modal modalName="transferUang" modalTitle="Form Transfer Uang">
        <livewire:journal.create-transfer />
    </x-modal>
    <x-modal modalName="tarikTunai" modalTitle="Form Penarikan Tunai">
        <livewire:journal.create-cash-withdrawal />
    </x-modal>
    <x-modal modalName="voucher" modalTitle="Form Penjualan Voucher">
        <livewire:journal.create-voucher />
    </x-modal>
    <x-modal modalName="deposit" modalTitle="Form Penjualan Deposit">
        <livewire:journal.create-deposit />
    </x-modal>
    <x-modal modalName="formExpense" modalTitle="Form Biaya Operasional">
        <livewire:journal.create-expense />
    </x-modal>
    <x-modal modalName="refund" modalTitle="Mutasi Saldo ke Pusat">
        <livewire:journal.create-refund />
    </x-modal>
    <x-modal modalName="adminFee" modalTitle="Form Biaya Admin Bank">
        <livewire:journal.create-admin-fee />
    </x-modal>
    <div class="hidden sm:grid grid-cols-1 sm:grid-cols-5 gap-2 mb-3 w-full">
        <div>

            <button x-data x-on:click="$dispatch('open-modal', {'modalName': 'transferUang'})"
                class="bg-sky-950 text-white sm:p-2 p-6 text-xl sm:text-sm shadow-300 flex justify-center items-center rounded-xl hover:bg-sky-800 transition duration-300 ease-out w-full">
                Transfer Uang
            </button>
        </div>
        <div>

            <button x-data x-on:click="$dispatch('open-modal', {'modalName': 'tarikTunai'})"
                class="bg-sky-950 text-white sm:p-2 p-6 text-xl sm:text-sm shadow-300 flex justify-center items-center rounded-xl hover:bg-sky-800 transition duration-300 ease-out w-full">
                Tarik Tunai
            </button>
        </div>

        <div>
            <x-dropdown-button dropdownTitle="Voucher & Deposit" dropdownName="report"
                class="bg-green-600 hover:bg-green-500 text-white sm:p-2 p-6 text-xl sm:text-sm">
                <div>
                    <ul class="text-sm flex flex-col">
                        <li class="py-2 px-4 hover:bg-slate-100 transition border-b">

                            <button x-data x-on:click="$dispatch('open-modal', {'modalName': 'voucher'})"
                                class="w-full text-left">
                                Voucher & SP
                            </button>
                        </li>
                        <li class="py-2 px-4 hover:bg-slate-100 transition">

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
                class="bg-red-600 hover:bg-red-500 text-white sm:p-2 p-6 text-xl sm:text-sm">
                <div>
                    <ul class="text-sm flex flex-col">
                        <li class="py-2 px-4 hover:bg-slate-100 transition border-b">

                            <button x-data x-on:click="$dispatch('open-modal', {'modalName': 'refund'})"
                                class="w-full text-left">
                                Pengembalian Saldo Kas & Bank
                            </button>
                        </li>
                        <li class="py-2 px-4 hover:bg-slate-100 transition border-b">

                            <button x-data x-on:click="$dispatch('open-modal', {'modalName': 'formExpense'})"
                                class="w-full text-left">
                                Biaya Operasional
                            </button>
                        </li>
                        <li class="py-2 px-4 hover:bg-slate-100 transition">

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

            <livewire:journal.cash-bank-balance-table />
        </div>
    </div>
    <div>

        {{--
        <livewire:report.mutation-history :warehouse_id="Auth()->user()->warehouse_id" /> --}}
    </div>
    <div x-data="{ voucherOpen: false, pengeluaranOpen: false }"
        class="fixed left-0 bottom-0 w-screen z-[80] sm:hidden">
        <div x-show="voucherOpen" class="bg-white w-full flex" @click.away="voucherOpen = false">
            <button x-data x-on:click="$dispatch('open-modal', {'modalName': 'voucher'})"
                class="w-full p-3 bg-sky-800 text-white text-xs hover:bg-sky-700">
                Voucher
            </button>
            <button x-data x-on:click="$dispatch('open-modal', {'modalName': 'deposit'})"
                class="w-full p-3 bg-sky-800 text-white text-xs hover:bg-sky-700">
                Deposit
            </button>
        </div>
        <div x-show="pengeluaranOpen" class="bg-white w-full flex" @click.away="pengeluaranOpen = false">
            <button x-data x-on:click="$dispatch('open-modal', {'modalName': 'refund'})"
                class="w-full p-3 bg-sky-800 text-white text-xs hover:bg-sky-700">
                Pengembalian Saldo
            </button>
            <button x-data x-on:click="$dispatch('open-modal', {'modalName': 'formExpense'})"
                class="w-full p-3 bg-sky-800 text-white text-xs hover:bg-sky-700">
                B. Operasional
            </button>
            <button x-data x-on:click="$dispatch('open-modal', {'modalName': 'adminFee'})"
                class="w-full p-3 bg-sky-800 text-white text-xs hover:bg-sky-700">
                B. Admin Bank
            </button>
        </div>
        <div class="flex justify-between text-white">
            <button x-data x-on:click="$dispatch('open-modal', {'modalName': 'transferUang'})"
                class="flex flex-col items-center justify-evenly w-full bg-sky-950 hover:bg-sky-800 p-2 transition duration-300 ease-out">
                <h1 class="font-bold text-2xl"><i class="fa-solid fa-circle-arrow-up"></i></h1>
                <h4 class="text-xs">Transfer</h4>
            </button>
            <button x-data x-on:click="$dispatch('open-modal', {'modalName': 'tarikTunai'})"
                class="flex flex-col items-center justify-evenly w-full bg-sky-950 hover:bg-sky-800 p-2 transition duration-300 ease-out">
                <h1 class="font-bold text-2xl"><i class="fa-solid fa-circle-arrow-down"></i></h1>
                <h4 class="text-xs">Transfer</h4>
            </button>
            <button @click="voucherOpen = !voucherOpen"
                class="flex flex-col items-center justify-evenly w-full bg-sky-950 hover:bg-sky-800 p-2">
                <h1 class="font-bold text-2xl"><i class="fa-solid fa-ticket"></i></h1>
                <h4 class="text-xs">Voucher</h4>
            </button>
            <button @click="pengeluaranOpen = !pengeluaranOpen"
                class="flex flex-col items-center justify-evenly w-full bg-sky-950 hover:bg-sky-800 p-2">
                <h1 class="font-bold text-2xl"><i class="fa-solid fa-file-invoice-dollar"></i></h1>
                <h4 class="text-xs">Pengeluaran</h4>
            </button>
        </div>
    </div>
</x-layouts.app>