<div>
    <div>
        <input type="search" name="" placeholder="Search .." id="" wire:model.live.debounce.500ms="search"
            class="w-1/3 text-sm border rounded-lg p-2 mb-2">
    </div>
    <div class="grid grid-cols-4 gap-2 rounded-md max-h-[550px] overflow-y-auto">
        @foreach ($products as $p)
        <div class="bg-white hover:shadow-lg border border-slate-100 shadow-sm p-2 rounded-md">
            <div class="relative">
                <img src="https://via.placeholder.com/300" alt="" class="w-full">
                <h2 class="text-xs absolute top-2 right-2 bg-sky-600 text-white px-2 py-1 rounded-md">Stock :
                    {{ $p->end_stock }}
                </h2>
            </div>
            <h1 class="text-xs">
                {{ strtoupper($p->name) }}
            </h1>
            <h1 class="font-bold text-lg">Rp.
                {{ number_format($p->price) }}
            </h1>
            <button class="w-full bg-sky-800 hover:bg-sky-700 text-white p-2 rounded-lg focus:bg-sky-600"
                wire:click="addToCart({{ $p->id }})"><i class="fa-solid fa-cart-plus"></i> Add
                to
                cart</button>
        </div>
        @endforeach

    </div>
</div>