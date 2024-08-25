<div>
    <div class="grid grid-cols-4 gap-2">
        <input type="text" class="w-full text-sm border rounded-lg p-2 col-span-3 mb-2" placeholder="Cari..."
            wire:model.live.debounce.500ms="search">
        <x-dropdown-button dropdownTitle="Management barang" dropdownName="report"
            class="bg-green-600 hover:bg-green-500 text-white text-xl sm:text-sm">
            <div>
                <ul class="text-sm flex flex-col">
                    <li class="py-2 px-4 hover:bg-slate-100 transition">
                        <a href="{{ route('product.index') }}" wire:navigate>Daftar Barang</a>
                    </li>
                    <li class="py-2 px-4 hover:bg-slate-100 transition">
                        <a href="{{ route('store.index') }}" wire:navigate>Input Penjualan</a>
                    </li>
                    <li class="py-2 px-4 hover:bg-slate-100 transition">
                        Mutasi Barang
                    </li>
                    <li class="py-2 px-4 hover:bg-slate-100 transition">
                        <a href="{{ route('store.purchase.report') }}" wire:navigate>Report Pembelian</a>
                    </li>
                    <li class="py-2 px-4 hover:bg-slate-100 transition">
                        Stock Opname
                    </li>
                </ul>
            </div>
        </x-dropdown-button>
    </div>
    <table class="w-full bg-white">
        <tbody>
            @foreach ($products as $p)
            <tr class="border-b text-xs hover:bg-slate-200">
                <td class="p-2 font-bold">{{ $p->name }}<br><small>{{ $p->category }} Cost: {{ number_format($p->cost)
                        }}</small>
                </td>
                <td class="p-2 text-end text-lg font-bold text-orange-500">{{ number_format($p->end_stock) }}
                    <sup class="text-slate-400">Pcs</sup>
                </td>
                <td class="p-2 text-end">
                    <button wire:click="addToPurchase({{ $p->id }})"
                        class="text-white font-bold bg-blue-500 py-2 px-5 rounded-lg hover:bg-blue-400">
                        <i class="fa-solid fa-plus"></i>
                    </button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{ $products->links() }}
</div>