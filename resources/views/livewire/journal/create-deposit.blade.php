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
            <label for="price" class="block ">Harga jual</label>
            <div class="col-span-1">
                <input type="number" wire:model="price"
                    class="w-full border rounded-lg p-2 @error('price') border-red-500 @enderror" placeholder="Rp">
                @error('price') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
        </div>
        <div class="grid grid-cols-3 gap-2 mb-2 items-center">
            <label for="cost" class="block ">Harga modal</label>
            <div class="col-span-1">
                <input type="number" wire:model="cost"
                    class="w-full border rounded-lg p-2 @error('cost') border-red-500 @enderror" placeholder="RP">
                @error('cost') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
        </div>
        <div class="grid grid-cols-3 gap-2 mb-2 items-center">
            <label for="description" class="block">Description</label>
            <div class="col-span-2">
                <textarea wire:model="description"
                    class="w-full border rounded-lg p-2 @error('description') border-red-500 @enderror"
                    placeholder="Keterangan (Optional)"></textarea>
                @error('description') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
        </div>
        <div class="grid grid-cols-3 gap-2 mb-2 items-center">
            <button type="submit" class="w-full bg-blue-500 text-white p-2 rounded-xl">Simpan</button>
            <div wire:loading class="italic text-xs col-span-2">
                Sedang menyimpan data, silahkan tunggu ...
            </div>
        </div>
    </form>
</div>