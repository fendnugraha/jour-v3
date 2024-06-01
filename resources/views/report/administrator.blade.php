<x-layouts.app>
    <x-slot:title>{{ $title }}</x-slot:title>
    @livewire('report.mutation-history', ['warehouse_id' => Auth()->user()->warehouse_id])

</x-layouts.app>