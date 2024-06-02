<x-layouts.app>
    <x-slot:title>{{ $title }}</x-slot:title>
    <div class="grid grid-cols-1 sm:grid-cols-5 gap-2 mb-3 w-full">
        <x-modal
            class="bg-blue-800 h-full text-white sm:text-xs p-2 shadow-300 flex justify-center items-center rounded-xl hover:bg-blue-700 transition duration-300 ease-out w-full">
            <x-slot name="buttonTitle">
                Transfer uang
            </x-slot>
            <x-slot name="modalTitle">
                Form Transfer Uang
            </x-slot>
            <livewire:journal.create-transfer />
        </x-modal>
        <x-modal
            class="bg-blue-800 h-full text-white sm:text-xs p-2 shadow-300 flex justify-center items-center rounded-xl hover:bg-blue-700 transition duration-300 ease-out w-full">
            <x-slot name="buttonTitle">
                Tarik tunai
            </x-slot>
            <x-slot name="modalTitle">
                Form Tarik Tunai
            </x-slot>
            <livewire:journal.create-cash-withdrawal />
        </x-modal>
        <x-dropdown-button
            class="inline-flex justify-center items-center px-4 py-2 border border-transparent rounded-xl shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 w-full">
            <x-slot name="trigger">Voucher & Deposit</x-slot>
            <ul class="w-full flex gap-2 flex-col">
                <li class="hover:text-slate-800 hover:bg-slate-200 p-2">
                    <x-modal class="w-full text-start">
                        <x-slot name="buttonTitle">
                            Voucher & Kartu
                        </x-slot>
                        <x-slot name="modalTitle">
                            Form Voucher & Kartu
                        </x-slot>
                        <livewire:journal.create-voucher />
                    </x-modal>
                </li>
                <li class="hover:text-slate-800 hover:bg-slate-200 p-2">
                    <x-modal class="w-full text-start">
                        <x-slot name="buttonTitle">
                            Deposit
                        </x-slot>
                        <x-slot name="modalTitle">
                            Form Penjualan Pulsa Dll
                        </x-slot>
                        <livewire:journal.create-deposit />
                    </x-modal>
                </li>
            </ul>
        </x-dropdown-button>
        <x-dropdown-button
            class="inline-flex justify-center items-center px-4 py-2 border border-transparent rounded-xl shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 w-full">
            <x-slot name="trigger">Pengeluaran (Biaya)</x-slot>
            <ul class="w-full flex gap-2 flex-col">
                <li class="hover:text-slate-800 hover:bg-slate-200 p-2">
                    <x-modal class="w-full text-start">
                        <x-slot name="buttonTitle">
                            Pengembalian saldo Kas & Bank
                        </x-slot>
                        <x-slot name="modalTitle">
                            Form Pengembalian Saldo Kas & Bank
                        </x-slot>
                        <livewire:journal.create-refund />
                    </x-modal>
                </li>
                <li class="hover:text-slate-800 hover:bg-slate-200 p-2">
                    <x-modal class="w-full text-start">
                        <x-slot name="buttonTitle">
                            Biaya operasional
                        </x-slot>
                        <x-slot name="modalTitle">
                            Form Biaya Operasional
                        </x-slot>
                        <livewire:journal.create-expense />
                    </x-modal>
                </li>
                <li class="hover:text-slate-800 hover:bg-slate-200 p-2">
                    <x-modal class="w-full text-start">
                        <x-slot name="buttonTitle">
                            Biaya admin bank
                        </x-slot>
                        <x-slot name="modalTitle">
                            Form Biaya Admin Bank
                        </x-slot>
                        <livewire:journal.create-admin-fee />
                    </x-modal>
                </li>
            </ul>
        </x-dropdown-button>
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
        @livewire('report.mutation-history', ['warehouse_id' => Auth()->user()->warehouse_id])
    </div>
</x-layouts.app>