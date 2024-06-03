<div>
    @if(session('success'))
    <x-notification>
        <x-slot name="classes">bg-green-500 text-white mb-3</x-slot>
        <strong>Success!!</strong> {{ session('success') }}
    </x-notification>
    @elseif (session('error'))
    <x-notification>
        <x-slot name="classes">bg-red-500 text-white mb-3</x-slot>
        <strong>Error!!</strong> {{
        session('error') }}
    </x-notification>
    @endif
    <form wire:submit="save">
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-1 mb-2 items-center">
            <label for="date_issued" class="block ">Tanggal</label>
            <div class="col-span-2">
                <input type="datetime-local" wire:model="date_issued"
                    class="w-1/2 border rounded-lg p-2 @error('date_issued') border-red-500 @enderror">
                @error('date_issued') <small class="text-red-500">{{ $message }}</small> @enderror
            </div>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-1 mb-2 items-center">
            <label for="debt_code" class="block ">Rekening</label>
            <div class="col-span-2">
                <select wire:model="debt_code"
                    class="w-full border rounded-lg p-2 @error('debt_code') border-red-500 @enderror">
                    <option value="">--Pilih Rekening--</option>
                    @foreach ($accounts as $a)
                    <option value="{{ $a->acc_code }}">{{ $a->acc_name }}</option>
                    @endforeach
                </select>
                @error('debt_code') <small class="text-red-500">{{ $message }}</small> @enderror
            </div>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-1 mb-2 items-center">
            <label for="cred_code" class="block ">Akun Hutang</label>
            <div class="col-span-2">
                <select wire:model="cred_code"
                    class="w-full border rounded-lg p-2 @error('cred_code') border-red-500 @enderror">
                    <option value="">--Pilih Akun--</option>
                    @foreach ($payAccounts as $p)
                    <option value="{{ $p->acc_code }}">{{ $p->acc_name }}</option>
                    @endforeach
                </select>
                @error('cred_code') <small class="text-red-500">{{ $message }}</small> @enderror
            </div>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-1 mb-2 items-center">
            <label for="contact" class="block ">Contact</label>
            <div class="col-span-2">
                <select wire:model="contact"
                    class="w-full border rounded-lg p-2 @error('contact') border-red-500 @enderror">
                    <option value="">--Pilih Contact--</option>
                    @foreach ($contacts as $c)
                    <option value="{{ $c->id }}">{{ $c->name }}</option>
                    @endforeach
                </select>
                @error('contact') <small class="text-red-500">{{ $message }}</small> @enderror
            </div>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-1 mb-2 items-center">
            <label for="amount" class="block ">Jumlah</label>
            <div class="col-span-2">
                <input type="number" wire:model="amount"
                    class="w-1/2 border rounded-lg p-2 @error('amount') border-red-500 @enderror" placeholder="Rp">
                @error('amount') <small class="text-red-500">{{ $message }}</small> @enderror
            </div>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-1 mb-2 items-center">
            <label for="description" class="block ">Catatan</label>
            <div class="col-span-2">
                <textarea wire:model="description"
                    class="w-full border rounded-lg p-2 @error('description') border-red-500 @enderror"
                    placeholder="Catatan (Optional)"></textarea>
                @error('description') <small class="text-red-500">{{ $message }}</small> @enderror
            </div>
        </div>
        <button type="submit" class="border rounded-lg p-2 bg-blue-500 text-white">Simpan</button>
    </form>
</div>