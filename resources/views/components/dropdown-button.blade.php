@props(['dropdownName', 'dropdownTitle'])

<div class="relative" x-data="{ isDropdownOpen: false }" x-on:click.outside="isDropdownOpen = false">
    <div>
        <button x-on:click="isDropdownOpen = !isDropdownOpen" {{ $attributes->merge(['class' => 'sm:p-2 p-6 shadow-300
            flex
            justify-center items-center rounded-xl transition duration-300 ease-out w-full']) }}>
            {{ $dropdownTitle }}
        </button>
    </div>
    <div x-show="isDropdownOpen" x-transition.origin.top.left class="absolute top-10 sm:w-60 w-full z-10">
        <div class="bg-white rounded-md shadow-lg">
            {{ $slot }}
        </div>
    </div>
</div>