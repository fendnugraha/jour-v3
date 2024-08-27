<div>
    <div class="grid grid-cols-1 sm:grid-cols-4 mb-1 sm:gap-2">
        <input type="search" name="" placeholder="Search .." id="" wire:model.live.debounce.500ms="search"
            class="text-sm border rounded-lg p-2 mb-2 sm:col-span-3 col-span-1">
        <x-dropdown-button dropdownTitle="Management barang" dropdownName="report"
            class="bg-green-600 hover:bg-green-500 text-white  text-sm p-2 sm:text-sm">
            <div>
                <ul class="text-sm flex flex-col">
                    @can('admin')
                    <li class="py-2 px-4 hover:bg-slate-100 transition">
                        <a href="{{ route('product.index') }}" wire:navigate>Daftar Barang</a>
                    </li>
                    <li class="py-2 px-4 hover:bg-slate-100 transition">
                        <a href="{{ route('store.purchase') }}" wire:navigate>Input Pembelian</a>
                    </li>
                    <li class="py-2 px-4 hover:bg-slate-100 transition">
                        Mutasi Barang
                    </li>
                    @endcan
                    <li class="py-2 px-4 hover:bg-slate-100 transition">
                        <a href="{{ route('store.sales.report') }}" wire:navigate>Report Penjualan</a>
                    </li>
                    <li class="py-2 px-4 hover:bg-slate-100 transition">
                        Stock Opname
                    </li>
                </ul>
            </div>
        </x-dropdown-button>
    </div>
    <div class="">
        <table class="bg-white w-full">
            <tbody>
                @foreach ($products as $p)
                <tr class="border-b hover:bg-orange-100 cursor-pointer">
                    <td class="p-2 text-xs font-bold">{{ $p->name }}</td>
                    <td class="p-2 text-xs text-slate-500">{{ strtoupper($p->category) }}</td>
                    <td class="p-2 text-lg font-bold"><small class="text-slate-400">Rp </small>{{
                        Number::format($p->price) }}</td>
                    <td class="p-2 text-xs">
                        <button wire:click="addToCart({{ $p->id }})"
                            class="text-white font-bold bg-green-500 py-2 px-5 rounded-lg hover:bg-blue-400">
                            <i class="fa-solid fa-plus"></i>
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        {{ $products->links() }}
    </div>
</div>