<x-layouts.app>
    <x-slot:title>{{ $title }}</x-slot:title>
    <div class="grid grid-cols-4 gap-4 mb-3">
        <x-modal
            class="bg-cyan-500 text-white p-2 shadow-300 flex justify-center items-center rounded-xl hover:bg-cyan-400 transition duration-300 ease-out w-full">
            <x-slot name="buttonTitle">
                Transfer uang
            </x-slot>
            <x-slot name="modalTitle">
                Form Transfer Uang
            </x-slot>
            <livewire:journal.create-transfer />
        </x-modal>
        <x-modal
            class="bg-cyan-500 text-white p-2 shadow-300 flex justify-center items-center rounded-xl hover:bg-cyan-400 transition duration-300 ease-out w-full">
            <x-slot name="buttonTitle">
                Tarik tunai
            </x-slot>
            <x-slot name="modalTitle">
                Form Tarik Tunai
            </x-slot>
            <livewire:journal.create-cash-withdrawal />
        </x-modal>
        <x-dropdown-button
            class="bg-cyan-500 text-white p-2 shadow-300 flex justify-center items-center rounded-xl hover:bg-cyan-400 transition duration-300 ease-out w-full">
            <x-slot name="trigger">Voucher & Deposit</x-slot>
            <ul class="w-full flex gap-2 flex-col">
                <li class="hover:text-slate-800 hover:bg-slate-100 p-2">
                    <x-modal class="w-full">
                        <x-slot name="buttonTitle">
                            Voucher & Kartu
                        </x-slot>
                        <x-slot name="modalTitle">
                            Form Voucher & Kartu
                        </x-slot>
                        <livewire:journal.create-voucher />
                    </x-modal>
                </li>
                <li class="hover:text-slate-800 hover:bg-slate-100 p-2">
                    <x-modal class="w-full">
                        <x-slot name="buttonTitle">
                            Deposit
                        </x-slot>
                        <x-slot name="modalTitle">
                            Form Deposit
                        </x-slot>
                        <livewire:journal.create-deposit />
                    </x-modal>
                </li>
            </ul>
        </x-dropdown-button>
    </div>
    <livewire:journal.journal-table />
</x-layouts.app>