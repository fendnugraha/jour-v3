<div>
    <input type="text" class="w-full border rounded-lg p-2" placeholder="Cari...">
    <table class="w-full">
        <tbody>
            @foreach ($products as $p)
            <tr class="border-b text-xs">
                <td class="p-2">{{ $p->name }}<br><small>{{ $p->category }}</small></td>
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
</div>