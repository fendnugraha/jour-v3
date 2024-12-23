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
    <form wire:submit="save">
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-1 mb-2 items-center">
            <label for="date_issued" class="block ">Tanggal</label>
            <div class="col-span-2">
                <input type="datetime-local" wire:model="date_issued"
                    class="w-full border rounded-lg p-2 @error('date_issued') border-red-500 @enderror">
                @error('date_issued') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-1 mb-2 items-center">
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
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-1 mb-2 items-center" x-data="{ amount: '' }">
            <label for="amount" class="block ">Jumlah penarikan</label>
            <div class="">
                <input type="number" wire:model="amount" x-model="amount"
                    class="w-full border rounded-lg p-2 @error('amount') border-red-500 @enderror" placeholder="Rp">
                @error('amount') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <span x-text="'Rp ' + new Intl.NumberFormat('id-ID').format(amount)"
                class="text-sky-500 italic font-bold text-sm sm:text-lg sm:text-right"></span>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-1 mb-2 items-center" x-data="{ fee_amount: '' }">
            <label for="fee_amount" class="block ">Fee (Admin)</label>
            <div class="col-span-1">
                <input type="number" wire:model="fee_amount" x-model="fee_amount"
                    class="w-1/2 border rounded-lg p-2 @error('fee_amount') border-red-500 @enderror" placeholder="Rp">
                @error('fee_amount') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <span x-text="'Rp ' + new Intl.NumberFormat('id-ID').format(fee_amount)"
                class="text-sky-500 italic font-bold text-sm sm:text-lg sm:text-right"></span>
        </div>
        <div class="mb-2">
            <label for="description" class="block">Description</label>
            <textarea wire:model="description"
                class="w-full border rounded-lg p-2 @error('description') border-red-500 @enderror"
                placeholder="Keterangan (Optional)"></textarea>
            @error('description') <span class="text-red-500">{{ $message }}</span> @enderror
            <div class="flex items-center gap-1">
                <input type="checkbox" class="w-5 h-5 accent-green-400" wire:model="is_taken" value="2">
                <label for="is_taken" class="">Belum diambil</label>
            </div>
        </div>
        <div class="flex gap-1 mt-4 justify-end">
            <button type="submit"
                class="px-12 py-4 bg-slate-700 hover:bg-slate-600 text-white p-2 rounded-2xl disabled:bg-slate-300 disabled:cursor-none"
                wire:loading.attr="disabled">Simpan <span wire:loading><i
                        class="fa-solid fa-spinner animate-spin"></i></span></button>
        </div>
    </form>
</div>