<div class="container grid grid-cols-2 gap-3 mb-6">
    <div class="bg-white p-2 rounded-lg">
        <h4 class=" text-blue-950 text-lg font-bold mb-3">Penjualan Voucher & Kartu Perdana</h4>
        <input type="text" wire:model.live.debounce.500ms="search" placeholder="Search .."
            class="w-full border rounded-lg p-2 mb-1">
        <table class="table-auto w-full text-xs mb-2">
            <thead class="bg-white text-blue-950">
                <tr>
                    <th class="text-left p-3">Product</th>
                    <th class="text-center">Qty</th>
                    <th class="text-center">Jual</th>
                    <th class="text-center">Modal</th>
                    <th class="text-center">Fee</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($sales as $s)
                <tr class="border border-slate-100 odd:bg-white even:bg-blue-50">
                    <td class="text-left p-2">{{ $s->product->name }}</td>
                    <td class="text-right p-2">{{ $s->quantity }}</td>
                    <td class="text-right p-2">{{ number_format($s->price) }}</td>
                    <td class="text-right p-2">{{ number_format($s->cost) }}</td>
                    <td class="text-right p-2">{{ number_format($s->price * $s->quantity - $s->cost * $s->quantity) }}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        {{ $sales->links() }}
    </div>
    <div class="bg-white p-2 rounded-lg">
        <h4 class=" text-blue-950 text-lg font-bold mb-3">Penjualan per product</h4>
        <input type="text" wire:model.live.debounce.500ms="search" placeholder="Search .."
            class="w-full border rounded-lg p-2 mb-1">
        <table class="table-auto w-full text-xs mb-2">
            <thead class="bg-white text-blue-950">
                <tr>
                    <th class="text-left p-3">Product</th>
                    <th class="text-center">Qty</th>
                    <th class="text-center">Jual</th>
                    <th class="text-center">Modal</th>
                    <th class="text-center">Fee</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($salesGroup as $productId => $productSales)
                @php
                $product = $productSales->first()->product;
                $totalFee = 0;
                @endphp
                @foreach ($productSales as $sale)
                @php
                $totalFee += ($sale->price * $sale->quantity) - ($sale->cost * $sale->quantity);
                @endphp
                @endforeach
                <tr class="border border-slate-100 odd:bg-white even:bg-blue-50">
                    <td class="text-left p-2">{{ $product->name }}</td>
                    <td class="text-right p-2">{{ $productSales->sum('quantity') }}</td>
                    <td class="text-right p-2">{{ number_format($productSales->sum('price')) }}</td>
                    <td class="text-right p-2">{{ number_format($productSales->sum('cost')) }}</td>
                    <td class="text-right p-2">{{ number_format($totalFee) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>


    </div>
</div>