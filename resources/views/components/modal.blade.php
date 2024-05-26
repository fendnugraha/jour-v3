<div x-data="{ open: false }">
    <!-- Trigger button for the modal -->
    <button @click=" open=true" {{ $attributes->merge(['class' => '']) }}>
        {{ $buttonTitle }}
    </button>

    <!-- Modal -->
    <div x-show="open"
        class="fixed z-10 inset-0 overflow-y-auto bg-gray-500 bg-opacity-75 flex items-center justify-center">
        <div class="relative bg-white rounded-lg w-1/2" @click.away="open = false">
            <!-- Modal header -->
            <div class="flex justify-between items-center p-4 border-b">
                <h5 class="font-bold text-lg">{{ $modalTitle }}</h5>
                <button @click="open = false" class="text-gray-500 hover:text-gray-700 focus:outline-none">
                    <svg class="h-6 w-6 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <path
                            d="M18.364 5.636c.78.78.78 2.048 0 2.828L14.828 12l3.536 3.536c.78.78.78 2.048 0 2.828-.78.78-2.048.78-2.828 0L12 14.828l-3.536 3.536c-.78.78-2.048.78-2.828 0-.78-.78-.78-2.048 0-2.828L9.172 12 5.636 8.464c-.78-.78-.78-2.048 0-2.828s2.048-.78 2.828 0L12 9.172l3.536-3.536c.78-.78 2.048-.78 2.828 0z" />
                    </svg>
                </button>
            </div>
            <!-- Modal content -->
            <div class="p-4">
                {{ $slot }}
            </div>
        </div>
    </div>
</div>