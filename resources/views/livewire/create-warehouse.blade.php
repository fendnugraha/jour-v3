<div>
    <form wire:submit="save">
        <div class="">
            <div class="mb-2">
                <label for="code" class="block">Code</label>
                <input type="text" wire:model="code"
                    class="w-full border rounded-lg p-2 @error('code') border-red-500 @enderror"
                    placeholder="Contoh: W01">
                @error('code') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <div class="mb-2">
                <label for="name" class="block">Name</label>
                <input type="text" wire:model="name"
                    class="w-full border rounded-lg p-2 @error('name') border-red-500 @enderror">
                @error('name') <span class="text-red-500">{{ $message }}</span> @enderror

            </div>
            <div class="mb-2">
                <label for="cashAccount" class="block">Cash Account</label>
                <select wire:model="cashAccount" class="w-full border rounded-lg p-2">
                    <option value="">--Pilih Account--</option>
                    @foreach ($cashAccounts as $c)
                    <option value="{{ $c->id }}">{{ $c->acc_name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-2">
                <label for="address" class="block">Alamat</label>
                <textarea wire:model="address" class="w-full border rounded-lg p-2"></textarea>
            </div>

        </div>
        <div class="grid grid-cols-2 gap-2 mt-4">
            <button type="submit" class="w-full bg-blue-500 text-white p-2 rounded-lg">Simpan</button>
        </div>
    </form>

    @if (session()->has('success'))
    <div class="bg-green-500 text-white p-2 rounded-lg">{{ session('success') }}</div>
    @endif
</div>