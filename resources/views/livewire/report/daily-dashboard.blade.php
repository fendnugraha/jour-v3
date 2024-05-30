<div>
    <div class="container min-h-[28rem] grid grid-cols-1 sm:grid-cols-5 sm:grid-rows-4 gap-1 sm:gap-3">
        <div
            class="bg-gray-800 w-full h-full p-3 rounded-lg sm:rounded-3xl flex flex-col gap-2 items-center justify-center col-span-2 row-span-2">
            <h4 class="text-md sm:text-xl font-bold text-white">Saldo Kas Tunai</h4>
            <h1 class="text-2xl sm:text-5xl font-black text-yellow-300">{{ number_format($totalCash) }}</h1>
        </div>
        <div
            class="bg-gray-800 w-full h-full p-3 rounded-lg sm:rounded-3xl flex flex-col gap-2 items-center justify-center col-span-2 row-span-2">
            <h4 class="text-md sm:text-xl font-bold text-white">Voucher & SP</h4>
            <h1 class="text-2xl sm:text-5xl font-black text-yellow-300">{{ number_format($totalVoucher) }}</h1>
        </div>
        <div
            class="bg-violet-700 rounded-lg sm:rounded-3xl w-full h-full p-3 flex flex-col gap-1 items-center justify-center">
            <h4 class="text-md sm:text-xl text-white">Saldo Bank</h4>
            <h1 class="text-2xl font-extrabold text-white">{{ number_format($totalBank) }}</h1>
        </div>
        <div
            class="bg-orange-500 rounded-lg sm:rounded-3xl w-full h-full p-3 flex flex-col gap-1 items-center justify-center">
            <h4 class="text-md sm:text-xl text-white">Fee (Admin)</h4>
            <h1 class="text-2xl font-extrabold text-white">{{ number_format($totalFee) }}</h1>
        </div>
        <div
            class="bg-gray-800 w-full h-full p-3 rounded-lg sm:rounded-3xl flex flex-col gap-3 sm:gap-6 items-center justify-center col-span-2 row-span-2">
            <div class="flex gap-2 flex-col justify-center items-center">
                <h4 class="text-md sm:text-xl font-bold text-white">Laba (Profit)</h4>
                <h1 class="text-2xl sm:text-5xl font-black text-yellow-300">{{ number_format($profit) }}</h1>
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
            <h1 class="text-2xl sm:text-5xl font-black text-yellow-300">{{ number_format($totalCashDeposit) }}</h1>
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
</div>