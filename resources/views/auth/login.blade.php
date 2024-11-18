<x-layouts.guest>
    <x-slot:title>{{ $title }}</x-slot:title>
    <!-- You must be the change you wish to see in the world. - Mahatma Gandhi -->
    <div class="flex items-center justify-center flex-col min-h-full">
        {{-- <img src="{{ asset('/img/logo-blue.png') }}" alt="" class="h-20 mb-5"> --}}
        <div class="bg-white p-6 rounded-2xl shadow-md">
            <h1 class="text-3xl font-bold mb-6">Login </h1>
            <form action="{{ route('login') }}" method="post">
                @csrf
                <div class="mb-3">
                    <label for="email" class="form-label">Email address</label>
                    <input type="email" name="email" placeholder="Enter valid email address"
                        class="w-full border rounded-xl px-4 py-3 focus:outline-blue-300 @error('email') border-red-500 @enderror"
                        required>
                    @error('email') <span class="text-red-500">{{ $message }}</span> @enderror
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" name="password" placeholder="Enter your password"
                        class="w-full border rounded-xl px-4 py-3 focus:outline-blue-300 @error('password') border-red-500 @enderror"
                        required>
                    @error('password') <span class="text-red-500">{{ $message }}</span> @enderror
                </div>
                <button type="submit" class="w-full bg-blue-800 text-white p-3 my-3 rounded-xl">Login</button>
            </form>
            <p class="text-center mt-6 text-xs">&copy; 2022 <img src="{{ asset('/img/logo-blue.png') }}"
                    alt="eightnite-studio" class="inline h-3"> by <img src="{{ asset('/img/8nite-logo.png') }}"
                    alt="eightnite-studio" class="inline h-5">. All rights
                reserved</p>
        </div>
    </div>
    @if (session('error'))
    <x-notification>
        <x-slot name="classes">bg-red-500 text-white absolute bottom-3 left-4</x-slot>
        <strong>Error!!</strong> {{
        session('error') }}
    </x-notification>
    @endif
</x-layouts.guest>