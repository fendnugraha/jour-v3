<div x-data="{ showNotification: true }" x-init="setTimeout(() => { showNotification = false; }, 5000)"
    class="fixed bottom-1 right-2">
    <div x-show="showNotification" x-on:click.away="showNotification = false"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 transform translate-y-4"
        x-transition:enter-end="opacity-100 transform translate-y-0"
        x-transition:leave="transition ease-in duration-300"
        x-transition:leave-start="opacity-100 transform translate-y-0"
        x-transition:leave-end="opacity-0 transform translate-y-4" {{ $attributes->merge(['class' => 'px-4 py-2
        rounded-lg shadow-md ']) }}>
        {{ $slot }}
    </div>
</div>