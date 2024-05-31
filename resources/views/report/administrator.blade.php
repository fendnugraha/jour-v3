<x-layouts.app>
    <x-slot:title>{{ $title }}</x-slot:title>
    @livewire('report.daily-dashboard', ['warehouse_id' => 1])
    <div class="mt-6">
        @livewire('report.transfer-from-hq-table', ['warehouse_id' => 1])
    </div>
</x-layouts.app>