<x-layouts.app>
    <x-slot:title>{{ $title }}</x-slot:title>
    <div class="bg-white shadow-300 rounded-lg p-7">
        <form action="{{ route('contact.update', $contact) }}" method="post">
            @csrf
            @method('put')
            <div class="mb-3">
                <label for="name" class="block">Contact Name</label>
                <input type="text" name="name" id="name"
                    class="w-1/2 border rounded-lg px-4 py-2 @error('name') border-red-500 @enderror"
                    value="{{ $contact->name }}">
                @error('name') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <div class="mb-3">
                <label for="type" class="block">Type</label>
                <select name="type" id="type"
                    class="w-1/2 border rounded-lg px-4 py-2 @error('type') border-red-500 @enderror">
                    <option value="">--Pilih Type--</option>
                    <option value="Customer" {{ $contact->type == 'Customer' ? 'selected' : '' }}>Customer</option>
                    <option value="Supplier" {{ $contact->type == 'Supplier' ? 'selected' : '' }}>Supplier</option>
                </select>
                @error('type') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <div class="mb-3">
                <label for="description" class="block">Description</label>
                <textarea name="description" id="description"
                    class="w-1/2 border rounded-lg px-4 py-2 @error('description') border-red-500 @enderror">{{ $contact->description }}</textarea>
                @error('description') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <div class="grid grid-cols-2 gap-2 mt-4">
                <button type="submit" class="w-full bg-blue-500 text-white p-2 rounded-lg">Save</button>
            </div>
        </form>
    </div>
</x-layouts.app>