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
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-2 mb-2 items-center">
            <label for="date_issued" class="block ">Tanggal</label>
            <div class="col-span-2">
                <input type="datetime-local" wire:model="date_issued"
                    class="w-full border rounded-lg p-2 @error('date_issued') border-red-500 @enderror">
                @error('date_issued') <small class="text-red-500">{{ $message }}</small> @enderror
            </div>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-2 mb-2 items-center">
            <label for="cabang" class="block ">Cabang</label>
            <div class="col-span-2">
                <select wire:model.live="cabang"
                    class="w-full border rounded-lg p-2 @error('cabang') border-red-500 @enderror">
                    <option value="">--Pilih cabang--</option>
                    @foreach ($warehouse as $w)
                    <option value="{{ $w->id }}">{{ $w->name }}</option>
                    @endforeach
                </select>
                @error('cabang') <small class="text-red-500">{{ $message }}</small> @enderror
            </div>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-2 mb-2 items-center">
            <label for="cred_code" class="block ">Dari (Pusat)</label>
            <div class="col-span-2">
                <select wire:model="cred_code"
                    class="w-full border rounded-lg p-2 @error('cred_code') border-red-500 @enderror">
                    <option value="">--Pilih sumber dana--</option>
                    @foreach ($hq as $br)
                    <option value="{{ $br->acc_code }}">{{ $br->acc_name }}</option>
                    @endforeach
                </select>
                @error('cred_code') <small class="text-red-500">{{ $message }}</small> @enderror
            </div>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-2 mb-2 items-center">
            <label for="debt_code" class="block">Ke (Akun Cabang)</label>
            <div class="col-span-2">
                <select wire:model="debt_code" wire:key="{{ $cabang }}"
                    class="w-full border rounded-lg p-2 @error('debt_code') border-red-500 @enderror">
                    <option value="">--Pilih tujuan mutasi--</option>
                    @foreach ($akunCabang->where('warehouse_id', $cabang) as $c)
                    <option value="{{ $c->acc_code }}">{{ $c->acc_name }}</option>
                    @endforeach
                </select>
                @error('debt_code') <small class="text-red-500">{{ $message }}</small> @enderror
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-2 mb-2 items-center">
            <label for="amount" class="block ">Jumlah transfer</label>
            <div class="col-span-2">
                <input type="number" wire:model="amount"
                    class="w-full border rounded-lg p-2 @error('amount') border-red-500 @enderror" placeholder="Rp">
                @error('amount') <small class="text-red-500">{{ $message }}</small> @enderror
            </div>
        </div>
        <div class="mb-2">
            <label for="description" class="block">Description</label>
            <textarea wire:model="description"
                class="w-full border rounded-lg p-2 @error('description') border-red-500 @enderror"
                placeholder="Keterangan (Optional)"></textarea>
            @error('description') <small class="text-red-500">{{ $message }}</small> @enderror
        </div>

        <div class="grid grid-cols-2 gap-2 mt-4 items-center">
            <button type="submit" class="w-full bg-blue-500 text-white p-2 rounded-lg">Simpan <span wire:loading><i
                        class="fa-solid fa-spinner animate-spin"></i></span></button>
        </div>
    </form>
</div>