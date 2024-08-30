<div class="relative">
    <div class="absolute left-4 bottom-3">
        <button wire:click="$refresh"
            class="bg-white text-sky-950 px-2 py-1 text-sm shadow-300 justify-center items-center rounded-full hover:bg-sky-800 transition duration-300 ease-out"><i
                class="fa-solid fa-arrows-rotate"></i>
        </button>
    </div>
    @can('admin')
    <div class="flex flex-col sm:flex-row justify-start items-center gap-2 mb-3 w-full">
        <div class="w-full">
            <select wire:model.live="warehouse_id" class="text-sm border rounded-lg p-2 w-full">
                <option value="">-- Pilih Cabang --</option>
                @foreach ($warehouses as $c)
                <option value="{{ $c->id }}">{{ $c->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="flex flex-col sm:flex-row justify-start gap-2 items-center w-full">
            <input type="datetime-local" wire:model.live="startDate" class="w-full text-sm border rounded-lg p-2">
        </div>
        <div class="flex flex-col sm:flex-row justify-start gap-2 items-center w-full">
            <label for="to" class="tex-xs">s/d</label>
            <input type="datetime-local" wire:model.live="endDate" class="w-full text-sm border rounded-lg p-2">
        </div>
    </div>
    @endcan
    <div class="min-h-[28rem] grid grid-cols-1 sm:grid-cols-5 sm:grid-rows-4 gap-1 sm:gap-3">
        <div
            class="bg-gray-800 w-full h-full p-3 rounded-lg sm:rounded-3xl flex flex-col gap-6 items-center justify-center col-span-2 row-span-2">
            <div class="flex gap-2 flex-col justify-center items-center">
                <h4 class="text-md sm:text-xl font-bold text-white">Saldo Kas Tunai</h4>
                <h1 class="text-2xl sm:text-4xl font-black text-yellow-300">{{ number_format($totalCash) }}</h1>
            </div>
            <div class="flex gap-2 w-full justify-evenly">
                <div>
                    <h4 class="text-xs text-white">Saldo Bank</h4>
                    <h1 class="text-sm font-bold text-white">{{ number_format($totalBank) }}</h1>
                </div>
                <div>
                    <h4 class="text-xs text-yellow-400">Total Kas & Bank</h4>
                    <h1 class="text-sm font-bold text-white">{{ number_format($totalCash + $totalBank) }}</h1>
                </div>
            </div>
        </div>
        <div
            class="bg-gray-800 w-full h-full p-3 rounded-lg sm:rounded-3xl flex flex-col gap-2 items-center justify-center col-span-2 row-span-2">
            <div class="flex gap-10 justify-between items-center">
                <div class="flex gap-2 flex-col justify-center items-center">
                    <h4 class="text-md sm:text-lg font-bold text-white">Voucher & SP</h4>
                    <h1 class="text-2xl sm:text-3xl font-black text-yellow-300">{{ number_format($totalVoucher) }}</h1>
                </div>
                @if ($totalAccessories > 0)
                <div class="flex gap-2 flex-col justify-center items-center">
                    <h4 class="text-md sm:text-lg font-bold text-white">Accessories</h4>
                    <h1 class="text-2xl sm:text-3xl font-black text-yellow-300">{{ number_format($totalAccessories) }}
                    </h1>
                </div>
                @endif

            </div>
        </div>
        <div
            class="bg-violet-700 rounded-lg sm:rounded-3xl w-full h-full p-3 flex flex-col gap-1 items-center justify-center">
            <h4 class="text-md sm:text-xl text-white">Total Setoran</h4>
            <h1 class="text-2xl font-extrabold text-white">{{ number_format($totalCash + $totalVoucher +
                $totalCashDeposit +
                $profit + $totalAccessories) }}</h1>
        </div>
        <div
            class="bg-orange-500 rounded-lg sm:rounded-3xl w-full h-full p-3 flex flex-col gap-1 items-center justify-center">
            <h4 class="text-md sm:text-xl text-white">Fee (Admin)</h4>
            <h1 class="text-2xl font-extrabold text-white">{{ number_format($totalFee) }}</h1>
        </div>
        <div
            class="bg-gray-800 w-full h-full p-3 rounded-lg sm:rounded-3xl flex flex-col gap-4 sm:gap-6 items-center justify-center col-span-2 row-span-2">
            <div class="flex gap-2 flex-col justify-center items-center">
                <h4 class="text-md sm:text-xl font-bold text-white">Laba (Profit)</h4>
                <h1 class="text-2xl sm:text-4xl font-black text-yellow-300">{{ number_format($profit) }}</h1>
            </div>
            <div class="flex gap-2 w-full justify-evenly">
                <div>
                    <h4 class="text-xs text-white">Transfer Uang</h4>
                    <h1 class="text-sm font-bold text-white">{{ number_format($totalTransfer) }}</h1>
                </div>
                <div>
                    <h4 class="text-xs text-white">Tarik Tunai</h4>
                    <h1 class="text-sm font-bold text-white">{{ number_format($totalCashWithdrawal) }}</h1>
                </div>
            </div>
        </div>
        <div
            class="bg-gray-800 w-full h-full p-3 rounded-lg sm:rounded-3xl flex flex-col gap-2 items-center justify-center col-span-2 row-span-2">
            <h4 class="text-md sm:text-xl font-bold text-white">Deposit</h4>
            <h1 class="text-2xl sm:text-4xl font-black text-yellow-300">{{ number_format($totalCashDeposit) }}</h1>
        </div>
        <div
            class="bg-red-600 rounded-lg sm:rounded-3xl w-full h-full p-3 flex flex-col gap-1 items-center justify-center">
            <h4 class="text-md sm:text-xl text-white">Biaya</h4>
            <h1 class="text-2xl font-extrabold text-white">{{ number_format(-$totalExpense) }}</h1>
        </div>
        <div
            class="bg-gray-700 rounded-lg sm:rounded-3xl w-full h-full p-3 flex flex-col gap-1 items-center justify-center">
            <h4 class="text-md sm:text-xl text-white">Transaksi</h4>
            <h1 class="text-2xl font-extrabold text-white">{{ number_format($salesCount) }}</h1>
        </div>
    </div>
    <div class="absolute inset-0 flex items-center justify-center" wire:loading>
        <!-- Container for the loading message -->
        <div class="bg-white/20 backdrop-blur-sm h-full w-full flex items-center justify-center gap-2">
            <!-- Loading text -->
            <i class="fa-solid fa-spinner animate-spin text-white text-3xl"></i>
            <p class="text-white text-sm font-bold">
                Loading data, please wait...
            </p>
        </div>
    </div>
</div>