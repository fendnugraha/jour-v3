<x-layouts.app>
    <x-slot:title>{{ $title }}</x-slot:title>
    <!-- Be present above all else. - Naval Ravikant -->
    <div class="bg-white shadow-300 rounded-lg p-7">
        <form action="{{ route('account.update', $account) }}" method="post">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="name" class="block">Account Name</label>
                <input type="text" name="name" id="name"
                    class="w-1/2 border rounded-lg px-4 py-2 @error('name') border-red-500 @enderror"
                    value="{{ $account->acc_name }}">
                @error('name') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <div class="mb-3">
                <label for="st_balance" class="block">Saldo Awal</label>
                <input type="number" name="st_balance" id="st_balance"
                    class="w-1/2 border rounded-lg px-4 py-2 @error('st_balance') border-red-500 @enderror"
                    value="{{ $account->st_balance }}">
                @error('st_balance') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <button type="submit"
                class="w-1/4 bg-green-500 text-white p-2 rounded-lg hover:bg-green-400">Update</button>
            <a href="{{ route('account.index') }}"
                class="w-1/4 bg-red-500 text-white py-2 px-10 rounded-lg hover:bg-red-400">Batal</a>
        </form>
    </div>
</x-layouts.app>