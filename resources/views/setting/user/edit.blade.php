<x-layouts.app>
    <x-slot:title>{{ $title }}</x-slot:title>
    <!-- Be present above all else. - Naval Ravikant -->
    <div class="bg-white shadow-300 rounded-lg p-7">
        <form action="{{ route('user.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="name" class="block">Name</label>
                <input type="text" name="name" id="name"
                    class="w-1/2 border rounded-lg px-4 py-2 @error('name') border-red-500 @enderror"
                    value="{{ $user->name }}">
                @error('name') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <div class="mb-3">
                <label for="email" class="block">Email address</label>
                <input type="email" name="email" id="email"
                    class="w-1/2 border rounded-lg px-4 py-2 @error('email') border-red-500 @enderror"
                    value="{{ $user->email }}">
                @error('email') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <div class="mb-3">
                <label for="role" class="block">Role</label>
                <select name="role" id="role"
                    class="w-1/2 border rounded-lg px-4 py-2 @error('role') border-red-500 @enderror">
                    <option value="Kasir" @if ($user->role == 'Kasir') selected @endif>Kasir</option>
                    <option value="Administrator" @if ($user->role == 'Administrator') selected @endif>Administrator
                    </option>
                </select>
                @error('role') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <div class="mb-3">
                <label for="warehouse_id" class="block">Warehouse</label>
                <select name="warehouse_id" id="warehouse_id"
                    class="w-1/2 border rounded-lg px-4 py-2 @error('warehouse_id') border-red-500 @enderror">
                    @foreach ($warehouses as $w)
                    <option value="{{ $w->id }}" @if ($user->warehouse_id == $w->id) selected @endif>{{ $w->name }}
                    </option>
                    @endforeach
                </select>
                @error('warehouse_id') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>

            <button type="submit" class="bg-blue-500 rounded-lg px-4 py-2 text-white">Save</button>
            <a href="{{ route('user.index') }}" class="bg-red-500 rounded-lg px-4 py-2 text-white">Cancel</a>
        </form>
    </div>
</x-layouts.app>