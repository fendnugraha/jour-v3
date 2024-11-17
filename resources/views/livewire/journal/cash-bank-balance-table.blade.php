<div class="relative col-span-3 sm:col-span-1">
    <button wire:click="$refresh"
        class="bg-sky-950 text-white px-2 py-1 text-sm shadow-300 rounded-full hover:bg-sky-800 transition duration-300 ease-out absolute"><i
            class="fa-solid fa-arrows-rotate"></i>
    </button>
    <div
        class="flex justify-center items-center mb-3 flex-col bg-sky-950 hover:bg-sky-900 p-2 rounded-2xl text-orange-300 hover:text-white">
        <h1 class="text-sm">Total Saldo Kas & Bank</h1>
        <h1 class="text-2xl font-black">{{ number_format($accounts->sum('balance')) }}</h1>

    </div>
    <div class="rounded-lg">
        @foreach ($accounts as $account)
        <div class="mb-2">
            <div
                class="flex flex-col hover:scale-105 justify-between py-2 px-4 rounded-2xl shadow-sm hover:shadow-lg bg-orange-200 hover:bg-orange-300 transition duration-150 ease-out">
                <h1 class="text-xs">{{ $account->acc_name }}</h1>

                <h1 class="text-lg font-bold text-end">{{
                    number_format($account->balance) }}</h1>
            </div>
        </div>
        @endforeach
    </div>
    <div class="absolute inset-0 flex items-center justify-center" wire:loading>
        <!-- Container for the loading message -->
        <div class="bg-slate-50/10 backdrop-blur-sm h-full w-full flex items-center justify-center gap-2 rounded-lg">
            <!-- Loading text -->
            <i class="fa-solid fa-spinner animate-spin text-blue-950 text-3xl"></i>
            <p class="text-blue-950 text-sm font-bold">
                Loading data, please wait...
            </p>
        </div>
    </div>
</div>