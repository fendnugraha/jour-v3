<div class="bg-white p-2 rounded-lg">
    <h4 class=" text-blue-950 text-lg font-bold mb-6">Hutang</h4>
    <div class="flex justify-between items-center mb-3 gap-3">
        <div>
            <x-modal modalName="addPayable" modalTitle="Form Input Hutang">
                <livewire:journal.payable.create-payable />
            </x-modal>
            <button x-data x-on:click="$dispatch('open-modal', {'modalName': 'addPayable'})"
                class="bg-sky-950 text-white p-2 text-sm shadow-300 flex justify-center items-center rounded-lg hover:bg-sky-800 transition duration-300 ease-out w-60">
                <i class="fa-solid fa-plus"></i> Tambah Hutang
            </button>
        </div>
        <input type="text" wire:model="search" class="w-full text-sm border rounded-lg p-2" placeholder="Search ..">
        <select wire:model="perPage" class="w-text-sm border rounded-lg p-2 w-40">
            <option value="10">10</option>
            <option value="25">25</option>
            <option value="50">50</option>
            <option value="100">100</option>
        </select>
    </div>
    <table class="table-auto w-full text-xs mb-2">
        <thead class="bg-white text-blue-950">
            <tr class="border-b">
                <th class="text-center p-4">Contact</th>
                <th class="text-center">Tagihan</th>
                <th class="text-center">Terbayar</th>
                <th class="text-center">Sisa</th>
                <th class="text-center">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($payables as $payable)
            @php
            $lunas = $payable->terbayar > 0 && $payable->sisa == 0 ? '<span class="text-green-500 font-bold"><i
                    class="fa-solid fa-check"></i> Lunas</span>' : Number::format($payable->sisa);
            @endphp
            <tr class="border border-slate-100 odd:bg-white even:bg-blue-50">
                <td class="p-3">{{ $payable->contact->name }}</td>
                <td class="p-3 text-right">{{ Number::format($payable->tagihan) }}</td>
                <td class="p-3 text-right">{{ Number::format($payable->terbayar) }}</td>
                <td class="p-3 text-right">{!! $lunas !!}</td>
                <td class="p-3 text-center">
                    <a href="{{ route('payable.edit', $payable->contact->id) }}"
                        class="text-slate-800 font-bold bg-yellow-400 py-1 px-3 rounded-lg hover:bg-yellow-300"><i
                            class="fa-solid fa-circle-info"></i> Detail</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{ $payables->links() }}
</div>