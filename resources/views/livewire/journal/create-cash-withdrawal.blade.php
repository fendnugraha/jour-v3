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
        <div class="grid grid-cols-3 gap-2 mb-2 items-center">
            <label for="date_issued" class="block ">Tanggal</label>
            <div class="col-span-2">
                <input type="datetime-local" wire:model="date_issued"
                    class="w-full border rounded-lg p-2 @error('date_issued') border-red-500 @enderror">
                @error('date_issued') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
        </div>
        <div class="grid grid-cols-3 gap-2 mb-2 items-center">
            <label for="debt_code" class="block ">Rekening</label>
            <div class="col-span-2">
                <select wire:model="debt_code"
                    class="w-full border rounded-lg p-2 @error('debt_code') border-red-500 @enderror">
                    <option value="">--Pilih Rekening--</option>
                    @foreach ($credits as $credit)
                    <option value="{{ $credit->acc_code }}">{{ $credit->acc_name }}</option>
                    @endforeach
                </select>
                @error('debt_code') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
        </div>
        <div class="grid grid-cols-3 gap-2 mb-2 items-center">
            <label for="amount" class="block ">Jumlah penarikan</label>
            <div class="col-span-2">
                <input type="number" wire:model="amount"
                    class="w-full border rounded-lg p-2 @error('amount') border-red-500 @enderror" placeholder="Rp">
                @error('amount') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
        </div>
        <div class="grid grid-cols-3 gap-2 mb-2 items-center">
            <label for="fee_amount" class="block ">Fee (Admin)</label>
            <div class="col-span-2">
                <input type="number" wire:model="fee_amount"
                    class="w-full border rounded-lg p-2 @error('fee_amount') border-red-500 @enderror" placeholder="Rp">
                @error('fee_amount') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
        </div>
        <div class="mb-2">
            <label for="description" class="block">Description</label>
            <textarea wire:model="description"
                class="w-full border rounded-lg p-2 @error('description') border-red-500 @enderror"
                placeholder="Keterangan (Optional)"></textarea>
            @error('description') <span class="text-red-500">{{ $message }}</span> @enderror
        </div>

        <div class="grid grid-cols-2 gap-2 mt-4 items-center">
            <button type="submit" class="w-full bg-blue-500 text-white p-2 rounded-lg">Simpan</button>
            <div wire:loading class="italic text-xs col-span-2">
                Sedang menyimpan data, silahkan tunggu ...
            </div>
        </div>
    </form>
</div>