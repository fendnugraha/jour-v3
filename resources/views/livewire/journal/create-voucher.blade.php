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
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-0 mb-2 items-center">
            <label for="date_issued" class="block ">Tanggal</label>
            <div class="col-span-2">
                <input type="datetime-local" wire:model="date_issued"
                    class="w-full border rounded-lg p-2 @error('date_issued') border-red-500 @enderror">
                @error('date_issued') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-0 mb-2 items-center">
            <label for="product_id" class="block ">Produk</label>
            <div class="col-span-2">
                <select wire:model="product_id" wire:change="getPrice"
                    class="w-full border rounded-lg p-2 @error('product_id') border-red-500 @enderror">
                    <option value="">--Pilih produk--</option>
                    @foreach ($products as $product)
                    <option value="{{ $product->id }}">{{ $product->name }} -> Rp. {{ Number::format($product->price) }}
                    </option>
                    @endforeach
                </select>
                @error('product_id') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-0 mb-2 items-center">
            <label for="qty" class="block ">Quantity</label>
            <div class="col-span-1">
                <input type="number" wire:model="qty"
                    class="w-full sm:w-3/4 border rounded-lg p-2 @error('qty') border-red-500 @enderror"
                    placeholder="Qty">
                @error('qty') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-0 mb-2 items-center">
            <label for="price" class="block ">Harga Jual</label>
            <div class="col-span-1">
                <input type="number" wire:model.live="price"
                    class="w-full border rounded-lg p-2 @error('price') border-red-500 @enderror"
                    placeholder="Harga jual">
                @error('price') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-0 mb-2 items-center">
            <label for="description" class="block">Description</label>
            <div class="col-span-2">
                <textarea wire:model="description"
                    class="w-full border rounded-lg p-2 @error('description') border-red-500 @enderror"
                    placeholder="Keterangan (Optional)"></textarea>
                @error('description') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-0 mb-2 items-center">
            <button type="submit" class="w-full bg-blue-500 text-white p-2 rounded-lg">Simpan <span wire:loading><i
                        class="fa-solid fa-spinner animate-spin"></i></span></button>
        </div>
    </form>
</div>