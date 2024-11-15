<x-layouts.app>
    <x-slot:title>{{ $title }}</x-slot:title>
    @livewire('report.daily-dashboard', ['warehouse_id' => Auth()->user()->warehouse_id])
    <div class="mt-6">
        <livewire:report.transfer-from-hq-table :warehouse_id="Auth()->user()->warehouse_id" :warehouse="$warehouse" />
    </div>
    <div>
        @livewire('report.sold-voucher-table', ['warehouse_id' => Auth()->user()->warehouse_id])
    </div>
    @livewire('report.expense-table', ['warehouse_id' => Auth()->user()->warehouse_id])
    <div class="fixed bottom-4 right-4 sm:hidden">
        <x-modal modalName="mutasiSaldo" modalTitle="Mutasi Saldo Kas & Bank">
            <livewire:journal.create-mutation />
        </x-modal>
        <button x-data x-on:click="$dispatch('open-modal', {'modalName': 'mutasiSaldo'})"
            class="bg-sky-950 text-white rounded-2xl py-3 px-8 shadow-md">
            <i class="fa-solid fa-plus"></i> Mutasi Saldo
        </button>
    </div>
</x-layouts.app>