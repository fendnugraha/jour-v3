<x-layouts.app>
    <x-slot:title>{{ $title }}</x-slot:title>
    <div class="grid grid-cols-4 gap-4">
        <a class="text-2xl bg-white p-4 shadow-300 h-60 flex justify-center items-center rounded-xl hover:bg-cyan-200 hover:text-cyan-700 hover:text-5xl transition duration-300 ease-out"
            href="/setting/user">User
        </a>
        <a class="text-2xl bg-white p-4 shadow-300 h-60 flex justify-center items-center rounded-xl hover:bg-cyan-200 hover:text-cyan-700 hover:text-5xl transition duration-300 ease-out"
            href="/setting/account">Account
        </a>
        <a class="text-2xl bg-white p-4 shadow-300 h-60 flex justify-center items-center rounded-xl hover:bg-cyan-200 hover:text-cyan-700 hover:text-5xl transition duration-300 ease-out"
            href="/setting/warehouse">Warehouse
        </a>
        <a class="text-2xl bg-white p-4 shadow-300 h-60 flex justify-center items-center rounded-xl hover:bg-cyan-200 hover:text-cyan-700 hover:text-5xl transition duration-300 ease-out"
            href="/setting/contact">Contact
        </a>
        <a class="text-2xl bg-white p-4 shadow-300 h-60 flex justify-center items-center rounded-xl hover:bg-cyan-200 hover:text-cyan-700 hover:text-5xl transition duration-300 ease-out"
            href="/setting/product">Product
        </a>
    </div>
</x-layouts.app>