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
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-2 mb-2 items-center">
            <label for="date_issued" class="block ">Tanggal</label>
            <div class="col-span-2">
                <input type="datetime-local" wire:model="date_issued"
                    class="w-full border rounded-lg p-2 @error('date_issued') border-red-500 @enderror">
                @error('date_issued') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-2 mb-2 items-center">
            <label for="cred_code" class="block ">Dari (Cabang)</label>
            <div class="col-span-2">
                <select wire:model="cred_code"
                    class="w-full border rounded-lg p-2 @error('cred_code') border-red-500 @enderror">
                    <option value="">--Pilih sumber dana--</option>
                    @foreach ($branches as $br)
                    <option value="{{ $br->acc_code }}">{{ $br->acc_name }}</option>
                    @endforeach
                </select>
                @error('cred_code') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-2 mb-2 items-center">
            <label for="debt_code" class="block ">Ke (Pusat)</label>
            <div class="col-span-2">
                <select wire:model="debt_code"
                    class="w-full border rounded-lg p-2 @error('debt_code') border-red-500 @enderror">
                    <option value="">--Pilih tujuan mutasi--</option>
                    @foreach ($hq as $br)
                    <option value="{{ $br->acc_code }}">{{ $br->acc_name }}</option>
                    @endforeach
                </select>
                @error('debt_code') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-2 mb-2 items-center" x-data="{ amount: '' }">
            <label for="amount" class="block ">Jumlah transfer</label>
            <div class="">
                <input type="number" wire:model="amount" x-model="amount"
                    class="w-full border rounded-lg p-2 @error('amount') border-red-500 @enderror" placeholder="Rp">
                @error('amount') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <span x-text="'Rp ' + new Intl.NumberFormat('id-ID').format(amount)"
                class="text-sky-500 italic font-bold text-lg text-right"></span>
        </div>
        <div class="mb-2">
            <label for="description" class="block">Description</label>
            <textarea wire:model="description"
                class="w-full border rounded-lg p-2 @error('description') border-red-500 @enderror"
                placeholder="Keterangan (Optional)"></textarea>
            @error('description') <span class="text-red-500">{{ $message }}</span> @enderror
        </div>

        <div class="flex gap-2 mt-4 justify-end">
            <button type="submit"
                class="px-12 py-4 bg-slate-700 hover:bg-slate-600 text-white p-2 rounded-2xl disabled:bg-slate-300 disabled:cursor-none"
                wire:loading.attr="disabled">Simpan <span wire:loading><i
                        class="fa-solid fa-spinner animate-spin"></i></span></button>
        </div>
    </form>
</div>