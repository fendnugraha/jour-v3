<x-layouts.app>
    <x-slot:title>{{ $title }}</x-slot:title>
    @livewire('report.daily-dashboard')
    <div class="container grid grid-cols-3 gap-3 mt-12">
        <div class="col-span-2">
            @livewire('report.transfer-from-hq-table')
        </div>
        <div>
            @livewire('report.expense-table')
        </div>
    </div>
    @livewire('report.sold-voucher-table')
</x-layouts.app>