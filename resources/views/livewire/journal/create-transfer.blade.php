<div class="">
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
                    class="w-full border rounded-lg p-2 @error('date_issued') border-red-500 @enderror">
                @error('date_issued') <small class="text-red-500">{{ $message }}</small> @enderror
            </div>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-1 mb-2 items-center">
            <label for="cred_code" class="block ">Rekening</label>
            <div class="col-span-2">
                <select wire:model="cred_code"
                    class="w-full border rounded-lg p-2 @error('cred_code') border-red-500 @enderror">
                    <option value="">--Pilih Rekening--</option>
                    @foreach ($credits as $credit)
                    <option value="{{ $credit->acc_code }}">{{ $credit->acc_name }}</option>
                    @endforeach
                </select>
                @error('cred_code') <small class="text-red-500">{{ $message }}</small> @enderror
            </div>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-1 mb-2 items-center">
            <label for="amount" class="block ">Jumlah transfer</label>
            <div class="col-span-2">
                <input type="number" wire:model="amount"
                    class="w-full border rounded-lg p-2 @error('amount') border-red-500 @enderror" placeholder="Rp">
                @error('amount') <small class="text-red-500">{{ $message }}</small> @enderror
            </div>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-1 mb-2 items-center">
            <label for="fee_amount" class="block ">Fee (Admin)</label>
            <div class="col-span-2">
                <input type="number" wire:model="fee_amount"
                    class="w-1/2 border rounded-lg p-2 @error('fee_amount') border-red-500 @enderror" placeholder="Rp">
                @error('fee_amount') <small class="text-red-500">{{ $message }}</small> @enderror
            </div>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-1 mb-2 items-center">
            <label for="custName" class="block ">Atas nama</label>
            <div class="col-span-2">
                <input type="text" wire:model="custName"
                    class="w-full border rounded-lg p-2 @error('custName') border-red-500 @enderror"
                    placeholder="Nama rekening customer">
                @error('custName') <small class="text-red-500">{{ $message }}</small> @enderror
            </div>
        </div>
        <div class="mb-2 mt-2">
            <label for="description" class="block">Description</label>
            <textarea wire:model="description"
                class="w-full border rounded-lg p-2 @error('description') border-red-500 @enderror"
                placeholder="Keterangan (Optional)"></textarea>
            @error('description') <small class="text-red-500">{{ $message }}</small> @enderror
        </div>

        <div class="grid grid-cols-2 gap-1 mt-4 items-center">
            <button type="submit" class="w-full bg-blue-500 text-white p-2 rounded-lg">Simpan <span wire:loading><i
                        class="fa-solid fa-spinner animate-spin"></i></span></button>
        </div>
    </form>
</div>