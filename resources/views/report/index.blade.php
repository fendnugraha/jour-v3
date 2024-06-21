<x-layouts.app>
    <x-slot:title>{{ $title }}</x-slot:title>
    @livewire('report.daily-dashboard', ['warehouse_id' => Auth()->user()->warehouse_id])
    <div class="mt-6">
        <livewire:report.transfer-from-hq-table :warehouse_id="Auth()->user()->warehouse_id" :warehouse="$warehouse"
            lazy />
    </div>
    <div>
        @livewire('report.sold-voucher-table', ['warehouse_id' => Auth()->user()->warehouse_id])
    </div>
    @livewire('report.expense-table', ['warehouse_id' => Auth()->user()->warehouse_id])
</x-layouts.app>