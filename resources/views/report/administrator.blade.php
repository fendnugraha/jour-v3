<x-layouts.app>
    <x-slot:title>{{ $title }}</x-slot:title>
    @livewire('journal.journal-table', ['warehouse_id' => Auth()->user()->warehouse_id])
    @livewire('report.summary', ['warehouse_id' => Auth()->user()->warehouse_id])
    @livewire('report.mutation-history', ['warehouse_id' => Auth()->user()->warehouse_id])

</x-layouts.app>