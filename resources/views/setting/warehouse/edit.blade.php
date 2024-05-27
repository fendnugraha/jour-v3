<x-layouts.app>
    <x-slot:title>{{ $title }}</x-slot:title>
    <div class="bg-slate-200 shadow-300 rounded-lg p-7">
        <form action="{{ route('warehouse.update', $warehouse->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="name" class="block">Warehouse Name</label>
                <input type="text" name="name" id="name"
                    class="w-1/2 border rounded-lg p-2 @error('name') border-red-500 @enderror"
                    value="{{ $warehouse->name }}">
                @error('name') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <div class="mb-3">
                <label for="cashAccount" class="block">Cash Account</label>
                <select name="cashAccount" class="w-1/2 border rounded-lg p-2
                    @foreach ($chartOfAccounts as $c)
                    <option value=" {{ $c->id }}" {{ $c->id == $warehouse->chart_of_account_id ? 'selected' : '' }}>{{
                    $c->acc_name }}</option>
                    @endforeach
                </select>
                @error('cashAccount') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <div class="mb-3">
                <label for="address" class="block">Address</label>
                <textarea name="address" id="address"
                    class="w-1/2 border rounded-lg p-2 @error('address') border-red-500 @enderror">{{ $warehouse->address }}</textarea>
                @error('address') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <button type="submit"
                class="w-1/4 bg-green-500 text-white p-2 rounded-lg hover:bg-green-400">Update</button>
            <a href="{{ route('warehouse.index') }}"
                class="w-1/4 bg-red-500 text-white py-2 px-10 rounded-lg hover:bg-red-400">Batal</a>
        </form>
    </div>
</x-layouts.app>