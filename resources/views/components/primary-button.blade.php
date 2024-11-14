<button {{ $attributes->merge(['type' => 'submit', 'class' => 'w-full text-sm bg-sky-950 hover:bg-sky-400 text-white p-2
    rounded-xl']) }}>
    {{ $slot }}
</button>