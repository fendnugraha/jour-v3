<x-layouts.guest>
    <x-slot:title>{{ $title }}</x-slot:title>
    <!-- You must be the change you wish to see in the world. - Mahatma Gandhi -->
    <div class="flex items-center justify-center flex-col min-h-full">
        <div class="bg-white p-6 rounded-lg">
            <h1 class="text-3xl font-bold mb-3">Login</h1>
            <form action="{{ route('login') }}" method="post">
                @csrf
                <div class="mb-3">
                    <label for="email" class="form-label">Email address</label>
                    <input type="email" name="email"
                        class="w-full border rounded-lg px-4 py-2 @error('email') border-red-500 @enderror" required>
                    @error('email') <span class="text-red-500">{{ $message }}</span> @enderror
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" name="password"
                        class="w-full border rounded-lg px-4 py-2 @error('password') border-red-500 @enderror" required>
                    @error('password') <span class="text-red-500">{{ $message }}</span> @enderror
                </div>
                <button type="submit" class="w-full bg-blue-500 text-white p-2 rounded-lg">Login</button>
            </form>
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