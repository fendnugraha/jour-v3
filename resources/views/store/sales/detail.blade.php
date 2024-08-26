<x-layouts.app>
    <x-slot:title>{{ $title }}</x-slot:title>
    <div>
        <livewire:store.sales.detail :id="$id" />
    </div>
</x-layouts.app>