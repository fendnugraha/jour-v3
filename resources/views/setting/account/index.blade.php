<x-layouts.app>
    <x-slot:title>{{ $title }}</x-slot:title>
    <div class="grid grid-cols-4 gap-4 mb-3">
        <x-modal
            class="bg-cyan-500 text-white p-2 shadow-300 flex justify-center items-center rounded-xl hover:bg-cyan-400 transition duration-300 ease-out w-full">
            <x-slot name="buttonTitle">
                Tambah Account
            </x-slot>
            <x-slot name="modalTitle">
                Form Tambah Account
            </x-slot>
            <livewire:account.create-account />
        </x-modal>
        <a href="/setting"
            class="bg-red-500 text-white p-2 shadow-300 flex justify-center items-center rounded-xl hover:bg-red-400 transition duration-300 ease-out">
            Kembali
        </a>
    </div>
    <table class="table-auto display">
        <thead>
            <tr class="bg-slate-500 text-white">
                <th class="">Code</th>
                <th class="">Name</th>
                <th class="">Type</th>
                <th class="">Balance</th>
                <th class="">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($accounts as $a)
            <tr>
                <td class="">{{ $a->acc_code }}</td>
                <td class="">{{ $a->acc_name }}</td>
                <td class="">{{ $a->account->name }}</td>
                <td class="text-right">{{ number_format($a->st_balance) }}</td>
                <td class="text-center">
                    <a href="/setting/account/{{ $a->id }}"
                        class="bg-yellow-300 px-4 py-2 rounded-lg font-bold hover:bg-yellow-200">Edit</a>
                    <a href="/setting/account/{{ $a->id }}/delete"
                        class="bg-red-300 px-4 py-2 rounded-lg font-bold hover:bg-red-200">Delete</a>

                </td>
            </tr>
            @endforeach
        </tbody>
</x-layouts.app>