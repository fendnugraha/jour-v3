<div>
    <div class="flex justify-between items-center mb-1 gap-2">
        <x-dropdown-button dropdownTitle="Management barang" dropdownName="report"
            class="bg-green-600 hover:bg-green-500 text-white  text-xl sm:text-sm">
            <div>
                <ul class="text-sm flex flex-col">
                    <li class="py-2 px-4 hover:bg-slate-100 transition">
                        Daftar Barang
                    </li>
                    <li class="py-2 px-4 hover:bg-slate-100 transition">
                        Input Pembelian
                    </li>
                    <li class="py-2 px-4 hover:bg-slate-100 transition">
                        Mutasi Barang
                    </li>
                    <li class="py-2 px-4 hover:bg-slate-100 transition">
                        Stock Opname
                    </li>
                </ul>
            </div>
        </x-dropdown-button>
        <input type="search" name="" placeholder="Search .." id="" wire:model.live.debounce.500ms="search"
            class="text-sm border rounded-lg p-2 mb-2">
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
            <h1 class="font-bold text-lg"><sup class="text-slate-400">Rp</sup>{{ number_format($p->price) }}
            </h1>
            <button class="w-full bg-sky-800 hover:bg-sky-700 text-white p-2 rounded-lg focus:bg-sky-600"
                wire:click="addToCart({{ $p->id }})"><i class="fa-solid fa-cart-plus"></i> Add
                to
                cart</button>
        </div>
        @endforeach

    </div>
</div>