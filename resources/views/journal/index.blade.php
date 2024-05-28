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
    </div>
    <livewire:journal.journal-table />
</x-layouts.app>