<div x-data="{ open: false }" @click.away="open = false" class="relative">
    <button @click="open = !open" {{ $attributes->merge(['class' => '']) }}>{{ $trigger }}</button>
    <div x-show="open" class="bg-white text-black p-2 rounded-lg absolute w-full mt-1 border z-50 shadow-300"
        x-transition:enter="transition ease-out duration-300 transform origin-top"
        x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100">
        {{ $slot }}
    </div>
</div>