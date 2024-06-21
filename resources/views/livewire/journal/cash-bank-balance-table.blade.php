<div class="w-full relative">
    <button wire:click="$refresh"
        class="bg-sky-950 text-white px-2 py-1 text-sm shadow-300 rounded-full hover:bg-sky-800 transition duration-300 ease-out absolute"><i
            class="fa-solid fa-arrows-rotate"></i>
    </button>
    <div class="flex justify-center items-center mb-3 flex-col bg-sky-950 p-2 rounded-lg text-orange-300">
        <h1 class="text-sm">Total Saldo Kas & Bank</h1>
        <h1 class="text-2xl font-black">{{ number_format($accounts->sum('balance')) }}</h1>

    </div>
    <div class="bg-white p-2 rounded-lg">
        @foreach ($accounts as $account)
        <div class="mb-2">
            <h1 class="text-xs">{{ $account->acc_name }}</h1>
            <div class="flex justify-end py-1 px-3 rounded-md items-center bg-orange-100">
                <h1 class="text-lg font-bold">{{
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
</div>