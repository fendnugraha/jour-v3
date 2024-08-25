<x-layouts.app>
    <x-slot:title>{{ $title }}</x-slot:title>
    <div>
        <livewire:store.purchase.detail :id="$id" />
    </div>
</x-layouts.app>