<div>
    <h1 class="text-xl font-bold"><i class="fa-solid fa-cart-shopping"></i> Purchase Order <span
            class="text-slate-300 text-md">({{ 0 }}
            items)</span></h1>
    <div class="max-h-[400px] overflow-y-auto">
        @if(count($purchaseCart) > 0)
        @foreach($purchaseCart as $item)
        <div class="flex gap-2 border-b border-slate-200 my-1 py-2">
            {{-- <img src="https://via.placeholder.com/50" alt="" width="50" height="50"> --}}
            <div class="flex flex-col w-full">
                <h1 class="text-sm text-sky-700 font-bold">
                    {{ $item['name'] }}
                </h1>
                {{-- <h1 class="text-xs">{{ $item['quantity'] }} x Rp. {{ number_format($item['price']) }}</h1> --}}
                <div class="grid grid-cols-3 gap-2 my-1">
                    <input type="number" class="w-full border rounded-md text-xs px-2 py-1 col-span-1"
                        wire:model="cart.{{ $item['id'] }}.quantity"
                        wire:change="updateQuantity({{ $item['id'] }}, $event.target.value)"
                        value="{{ $item['quantity'] }}" min="1">
                    <div class="col-span-2 flex gap-2 w-full text-xs items-center justify-between">
                        x Rp <input type="number" class="w-3/4 border rounded-md text-xs px-2 py-1"
                            wire:model="cart.{{ $item['id'] }}.price" value="{{ $item['price'] }}"
                            wire:change="updatePrice({{ $item['id'] }}, $event.target.value)">
                    </div>
                </div>
                <div class="flex gap-2 items-center">
                    <h1 class="text-sm font-bold w-full">Rp. {{ number_format($item['price'] * $item['quantity']) }}
                    </h1>
                    <button class="w-[20%] bg-red-500 hover:bg-red-400 text-white rounded-lg text-xs px-2 py-1"
                        wire:click="removeFromCart({{ $item['id'] }})"><i class="fa-solid fa-trash-can"></i></button>
                </div>
            </div>
        </div>
        @endforeach
        @else
        <div class="h-96 flex justify-center items-center text-slate-500">
            <strong><i class="fas fa-times-circle"></i> Cart Empty!!</strong>
        </div>
        @endif
    </div>
    @if(count($purchaseCart) > 0)
    <div>
        <div class="flex justify-between items-center gap-2 my-2">
            <h1 class="text-sm">Total</h1>
            <div class="flex gap-2">
                <span class="text-xs text-slate-500">Rp.</span>
                <h1 class="text-lg font-bold">{{ number_format($total) }}</h1>
            </div>
        </div>
        <div class="grid grid-cols-3 gap-2 my-2">
            <x-modal modalName="checkout" modalTitle="Form Pembayaran">

                <div class="mb-5">
                    <h1>Total</h1>
                    <h1
                        class="text-4xl text-red-700 font-bold text-end border border-slate-400 p-2 rounded-lg bg-white">
                        <sup class="text-slate-400">Rp </sup>{{
                        number_format($total, 2) }}
                    </h1>
                    <h2>Kembalian : <span class="text-green-700 font-bold">
                            @if (empty($payment) || $payment == "")
                            {{ number_format(-$total, 2) }}
                            @else
                            {{ number_format($payment - $total, 2) }}
                            @endif
                        </span>
                    </h2>
                </div>
                <div class="mb-5">
                    <h1>Total Bayar</h1>
                    <input type="number" class="border rounded-lg px-2 py-1" wire:model.live.debounce.500ms="payment"
                        value="{{ $total }}" min="1">
                </div>
                <button wire:click="storeCart" wire:loading.attr="disabled"
                    class="w-full bg-green-800 hover:bg-green-700 text-white p-2 rounded-lg disabled:bg-slate-500">Simpan
                    <span wire:loading><i class="fa-solid fa-spinner animate-spin"></i></span></button>
            </x-modal>
            <button x-data x-on:click="$dispatch('open-modal', {'modalName': 'checkout'})"
                class="col-span-2 w-full text-sm bg-sky-950 hover:bg-sky-400 text-white p-2 rounded-xl">
                Checkout
            </button>
            {{-- <button class="col-span-2 w-full text-sm bg-sky-950 hover:bg-sky-400 text-white p-2 rounded-xl"
                wire:click="storeCart">Checkout</button> --}}
            <button class="w-full text-sm bg-red-500 hover:bg-sky-400 text-white p-2 rounded-xl" wire:click="clearCart"
                wire:confirm="Apakah anda yakin?"><i class="fa-solid fa-trash"></i></button>
        </div>
    </div>
    @endif
</div>