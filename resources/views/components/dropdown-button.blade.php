<div x-data="{ open: false }" @keydown.escape.window="open = false" @click.away="open = false" class="relative z-10">
    <button @click="open = !open" aria-haspopup="true" :aria-expanded="open.toString()" aria-controls="dropdown-menu" {{
        $attributes->merge(['class' => '']) }}
        >
        <!-- Add your trigger text or icon here -->
        {{ $trigger }}
    </button>
    <div x-show="open" id="dropdown-menu" role="menu"
        class="origin-top-right absolute left-0 mt-2 rounded-xl shadow-lg bg-white ring-1 ring-black ring-opacity-5 divide-y divide-gray-100 focus:outline-none min-w-[10rem]"
        @click="open = false">
        <!-- Add your dropdown items here -->
        {{ $slot }}
    </div>
</div>