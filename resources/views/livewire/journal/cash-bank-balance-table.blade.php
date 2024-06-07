<div class="bg-white p-2 rounded-lg relative">
    <div class="flex justify-between items-center mb-3">
        <button wire:click="$refresh"
            class="bg-sky-950 text-white px-2 py-1 text-sm shadow-300 justify-center items-center rounded-full hover:bg-sky-800 transition duration-300 ease-out"><i
                class="fa-solid fa-arrows-rotate"></i>
        </button>
        <h4 class="text-lg font-bold text-right">Total: {{ number_format($accounts->sum('balance')) }}</h4>
    </div>
    <table class="table-auto w-full text-xs mb-2">

        <tbody class="">
            @foreach ($accounts as $account)
            <tr class="border border-slate-100 bg-slate-200">
                <td class="font-bold p-2" colspan="2">{{ $account->acc_name }}</td>
            </tr>
            <tr>
                <td class="p-2 text-right text-lg font-bold bg-white text-sky-700" colspan="2">{{
                    number_format($account->balance) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
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