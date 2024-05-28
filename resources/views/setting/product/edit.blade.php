<x-layouts.app>
    <x-slot:title>{{ $title }}</x-slot:title>
    <div class="bg-white shadow-300 rounded-lg p-7">
        <form action="{{ route('product.update', $product->id) }}" method="post">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="name" class="block">Product Name</label>
                <input type="text" name="name" id="name"
                    class="w-1/2 border rounded-lg px-4 py-2 @error('name') border-red-500 @enderror"
                    value="{{ $product->name }}">
                @error('name') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <div class="mb-3">
                <label for="cost" class="block">Harga Modal</label>
                <input type="number" name="cost" id="cost"
                    class="w-1/2 border rounded-lg px-4 py-2 @error('cost') border-red-500 @enderror"
                    value="{{ $product->cost }}">
                @error('cost') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <div class="mb-3">
                <label for="price" class="block">Harga Jual</label>
                <input type="number" name="price" id="price"
                    class="w-1/2 border rounded-lg px-4 py-2 @error('price') border-red-500 @enderror"
                    value="{{ $product->price }}">
                @error('price') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <button type="submit"
                class="w-1/4 bg-green-500 text-white p-2 rounded-lg hover:bg-green-400">Update</button>
            <a href="{{ route('product.index') }}"
                class="w-1/4 bg-red-500 text-white py-2 px-10 rounded-lg hover:bg-red-400">Batal</a>
        </form>
    </div>
</x-layouts.app>