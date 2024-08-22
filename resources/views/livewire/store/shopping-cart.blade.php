<div>
    <h1 class="text-xl font-bold"><i class="fa-solid fa-cart-shopping"></i> Cart <span
            class="text-slate-300 text-md">({{ count($cart) }}
            items)</span></h1>
    @if(count($cart) > 0)
    @foreach($cart as $item)
    <div class="flex gap-2 border-b border-slate-200 my-2 py-2">
        <img src="https://via.placeholder.com/50" alt="" width="50" height="50">
        <div class="flex flex-col w-full">
            <h1 class="text-xs font-bold">
                {{ $item['name'] }}
            </h1>
            <h1 class="text-xs">{{ $item['quantity'] }} x Rp. {{ number_format($item['price']) }}</h1>
            <h1 class="text-xs font-bold">Rp. {{ number_format($item['price'] * $item['quantity']) }}</h1>
            <div class="flex gap-2">
                <button class="w-full bg-yellow-500 hover:bg-yellow-400 text-white rounded-lg"><i
                        class="fa-solid fa-edit"></i></button>
                <button class="w-full bg-red-500 hover:bg-red-400 text-white rounded-lg"
                    wire:click="removeFromCart({{ $item['id'] }})"><i class="fa-solid fa-trash"></i></button>
            </div>
        </div>
    </div>
    @endforeach
    @endif
    <div>
        <div class="flex justify-between items-center gap-2 my-2">
            <h1 class="text-sm">Total</h1>
            <div class="flex gap-2">
                <span class="text-xs text-slate-500">Rp.</span>
                <h1 class="text-lg font-bold">{{ number_format($total) }}</h1>
            </div>
        </div>
        <div class="grid grid-cols-3 gap-2 my-2">
            <button
                class="col-span-2 w-full text-sm bg-sky-950 hover:bg-sky-400 text-white p-2 rounded-xl">Checkout</button>
            <button class="w-full text-sm bg-red-500 hover:bg-sky-400 text-white p-2 rounded-xl"
                wire:click="clearCart"><i class="fa-solid fa-trash"></i></button>
        </div>
    </div>
</div>