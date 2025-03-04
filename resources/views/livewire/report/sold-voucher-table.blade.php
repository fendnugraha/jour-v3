<div class="mb-6 relative">
    <div class="flex justify-start items-center mb-1 gap-2">
        <div>
            <input type="datetime-local" wire:model.live="endDate" class="w-full text-sm border rounded-lg p-2">
        </div>

        @can('admin')
        <div>
            <select wire:model.live="warehouse_id" class="w-full text-sm border rounded-lg p-2">
                @foreach ($warehouse as $c)
                <option value="{{ $c->id }}">{{ $c->name }}</option>
                @endforeach
            </select>
        </div>
        @endcan
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
        <div class="bg-white p-2 rounded-lg">
            <h4 class=" text-blue-950 text-lg font-bold mb-3">
                <button wire:click="$refresh"
                    class="bg-sky-950 text-white px-2 py-1 text-sm shadow-300 justify-center items-center rounded-full hover:bg-sky-800 transition duration-300 ease-out"><i
                        class="fa-solid fa-arrows-rotate"></i></button> &nbsp;Rincian Penjualan Voucher & Kartu Perdana
            </h4>
            <input type="text" wire:model.live.debounce.500ms="search" placeholder="Search .."
                class="w-full text-sm border rounded-lg p-2 mb-1">
            <table class="table-auto w-full text-xs mb-2">
                <thead class="bg-white text-blue-950">
                    <tr class="border-b">
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
                        <td class="text-left p-2"><span class="text-blue-500">{{ $s->date_issued }}</span><br>{{
                            $s->product->name }}</td>
                        <td class="text-right p-2">{{ $s->quantity }}</td>
                        <td class="text-right p-2">{{ Number::format($s->price) }} <span
                                class="text-sm text-slate-400">({{ Number::format($s->price *
                                $s->quantity) }})</span></td>
                        <td class="text-right p-2">{{ Number::format($s->cost) }} <span class="text-sm text-slate-400">
                                ({{ Number::format($s->cost * $s->quantity) }})</span></td>
                        <td class="text-right p-2">{{ Number::format($s->price * $s->quantity - $s->cost * $s->quantity)
                            }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $sales->onEachSide(0)->links(data: ['scrollTo' => false]) }}
        </div>
        <div class="bg-white p-2 rounded-lg">
            <div class="flex justify-between items-center mb-3">
                <h4 class=" text-blue-950 text-lg font-bold">Total penjualan per product</h4>
                <div>
                    <h4>Total: {{ Number::format($total->sum('total_cost')) }}</h4>
                </div>
            </div>
            <div class="flex justify-start items-center mb-1 gap-2">
                <input type="text" wire:model.live.debounce.500ms="search" placeholder="Search .."
                    class="w-full text-sm border rounded-lg p-2">
                <select wire:model.live="perPage" class="text-sm border rounded-lg p-2 w-40">
                    <option value="5">5</option>
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
            </div>
            <table class="table-auto w-full text-xs mb-2">
                <thead class="bg-white text-blue-950">
                    <tr class="border-b">
                        <th class="text-left p-3">Product</th>
                        <th class="text-center">Qty</th>
                        <th class="text-center">Jual</th>
                        <th class="text-center">Modal</th>
                        <th class="text-center">Fee</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($salesGroups as $sg)

                    <tr class="border border-slate-100 odd:bg-white even:bg-blue-50">
                        <td class="text-left p-2">{{ $sg->product->name }}</td>
                        <td class="text-right p-2">{{ Number::format($sg->quantity) }}</td>
                        <td class="text-right p-2">{{ Number::format($sg->total_price) }}</td>
                        <td class="text-right p-2">{{ Number::format($sg->total_cost) }}</td>
                        <td class="text-right p-2">{{ Number::format($sg->total_price - $sg->total_cost) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $salesGroups->onEachSide(0)->links(data: ['scrollTo' => false]) }}
        </div>
    </div>
    <div class="absolute inset-0 flex items-center justify-center" wire:loading>
        <!-- Container for the loading message -->
        <div class="bg-slate-50/10 backdrop-blur-sm h-full w-full flex items-center justify-center gap-2">
            <!-- Loading text -->
            <i class="fa-solid fa-spinner animate-spin text-blue-950 text-3xl"></i>
            <p class="text-blue-950 text-sm font-bold">
                Loading data, please wait...
            </p>
        </div>
    </div>
</div>