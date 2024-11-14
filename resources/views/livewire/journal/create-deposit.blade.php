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
            <label for="price" class="block ">Harga jual</label>
            <div class="col-span-1">
                <input type="number" wire:model="price"
                    class="w-full border rounded-lg p-2 @error('price') border-red-500 @enderror" placeholder="Rp">
                @error('price') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-2 mb-2 items-center">
            <label for="cost" class="block ">Harga modal</label>
            <div class="col-span-1">
                <input type="number" wire:model="cost"
                    class="w-full border rounded-lg p-2 @error('cost') border-red-500 @enderror" placeholder="RP">
                @error('cost') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-2 mb-2 items-center">
            <label for="description" class="block">Description</label>
            <div class="col-span-2">
                <textarea wire:model="description"
                    class="w-full border rounded-lg p-2 @error('description') border-red-500 @enderror"
                    placeholder="Keterangan (Optional)"></textarea>
                @error('description') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
        </div>
        <div class="flex gap-2 mt-4 justify-end">
            <button type="submit"
                class="px-12 py-4 bg-slate-700 hover:bg-slate-600 text-white p-2 rounded-2xl disabled:bg-slate-300 disabled:cursor-none"
                wire:loading.attr="disabled">Simpan <span wire:loading><i
                        class="fa-solid fa-spinner animate-spin"></i></span></button>
        </div>
    </form>
</div>