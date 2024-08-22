<div>
    <div>
        <input type="search" name="" placeholder="Search .." id="" wire:model.live.debounce.500ms="search"
            class="w-full text-sm border rounded-lg p-2 mb-2">
    </div>
    <div class="grid grid-cols-4 gap-2 rounded-md max-h-[500px] overflow-y-auto">
        @foreach ($products as $p)
        <div class="bg-white hover:shadow-lg border border-slate-100 shadow-sm p-2 rounded-md">
            <img src="https://via.placeholder.com/300" alt="" class="w-full">
            <h1 class="text-xs">
                {{ strtoupper($p->name) }}
            </h1>
            <small>Stock :
                {{ $p->end_stock }}
            </small>
            <h1 class="font-bold text-lg">Rp.
                {{ number_format($p->price) }}
            </h1>
            <button class="w-full bg-sky-500 hover:bg-sky-400 text-white p-2 rounded-lg"
                wire:click="addToCart({{ $p->id }})"><i class="fa-solid fa-cart-plus"></i> Add
                to
                cart</button>
        </div>
        @endforeach

    </div>
</div>