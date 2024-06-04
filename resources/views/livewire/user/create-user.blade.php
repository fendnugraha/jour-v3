<div>
    @if(session('success'))
    <x-notification class="bg-green-500 text-white mb-3">
        <strong><i class="fas fa-check-circle"></i> Success!!</strong>
    </x-notification>
    @elseif (session('error'))
    <x-notification class="bg-red-500 text-white mb-3">
        <strong>Error!!</strong> {{
        session('error') }}
    </x-notification>
    @endif
    <div class="bg-violet-500 text-white p-2 rounded-lg mb-3 w-full" wire:loading>
        Menyimpan data ..
    </div>
    <form wire:submit="save">
        <div class="">
            <div class="mb-2">
                <label for="email" class="block">Email address</label>
                <input type="email" wire:model="email"
                    class="w-full border rounded-lg p-2 text-xs @error('email') border-red-500 @enderror">
                @error('email') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <div class="mb-2">
                <label for="name" class="block">Full name</label>
                <input type="text" wire:model="name"
                    class="w-full border rounded-lg p-2 text-xs @error('name') border-red-500 @enderror">
                @error('name') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <div class="grid grid-cols-2 gap-2">
                <div class="mb-2">
                    <label for="password" class="block">Password</label>
                    <input type="password" wire:model="password"
                        class="w-full border rounded-lg p-2 text-xs @error('password') border-red-500 @enderror">
                    @error('password') <span class="text-red-500">{{ $message }}</span> @enderror
                </div>
                <div class="mb-2">
                    <label for="cpassword" class="block">Confirm password</label>
                    <input type="password" wire:model="cpassword"
                        class="w-full border rounded-lg p-2 text-xs @error('cpassword') border-red-500 @enderror">
                    @error('cpassword') <span class="text-red-500">{{ $message }}</span> @enderror
                </div>
            </div>
            <div class="mb-2">
                <label for="role" class="block">Role</label>
                <select wire:model="role" class="w-full border rounded-lg p-2 @error('role') border-red-500 @enderror">
                    <option value="">--Pilih Role--</option>
                    <option value="Kasir">Kasir</option>
                    <option value="Administrator">Administrator</option>
                </select>
                @error('role') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <div class="mb-2">
                <label for="warehouse_id" class="block">Warehouse</label>
                <select wire:model="warehouse_id"
                    class="w-full border rounded-lg p-2 @error('warehouse_id') border-red-500 @enderror">
                    <option value="">--Pilih Warehouse--</option>
                    @foreach ($warehouses as $c)
                    <option value="{{ $c->id }}">{{ $c->name }}</option>
                    @endforeach
                </select>
                @error('warehouse_id') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
        </div>
        <div class="grid grid-cols-2 gap-2 mt-4">
            <button type="submit" class="w-full bg-blue-500 text-white p-2 rounded-lg">Simpan</button>
        </div>
    </form>


</div>