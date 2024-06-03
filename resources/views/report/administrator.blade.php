<x-layouts.app>
    <x-slot:title>{{ $title }}</x-slot:title>
    @livewire('report.warehouse-balance')
    @livewire('report.summary', ['warehouse_id' => Auth()->user()->warehouse_id])
    @livewire('journal.journal-table', ['warehouse_id' => Auth()->user()->warehouse_id])
    @livewire('report.mutation-history', ['warehouse_id' => Auth()->user()->warehouse_id])

</x-layouts.app>