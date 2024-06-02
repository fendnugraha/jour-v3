<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-gray-100" data-bs-theme="light">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://rsms.me/inter/inter.css">
    <title>{{ $title ?? 'Jour Apps' }}</title>
    @livewireStyles
</head>

<body class="h-full">
    <div class="min-h-full">
        <nav class="bg-sky-950" x-data="{ isOpen: false }">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex h-16 items-center justify-between">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <img class="h-8" src="/img/logo.png" alt="Your Company">
                        </div>
                        @livewire('nav-bar-main')
                    </div>
                    <div class="hidden md:block">
                        <div class="ml-4 flex items-center md:ml-6">
                            @livewire('profile-dropdown')
                        </div>
                    </div>
                    <div class="-mr-2 flex md:hidden">
                        <!-- Mobile menu button -->
                        <button type="button" @click="isOpen = !isOpen"
                            class="relative inline-flex items-center justify-center rounded-md bg-gray-700 p-2 text-gray-300 hover:bg-gray-700 hover:text-white focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-700"
                            aria-controls="mobile-menu" aria-expanded="false">
                            <span class="absolute -inset-0.5"></span>
                            <span class="sr-only">Open main menu</span>
                            <!-- Menu open: "hidden", Menu closed: "block" -->
                            <svg :class="{'hidden': isOpen, 'block': !isOpen }" class="block h-6 w-6" fill="none"
                                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                            </svg>
                            <!-- Menu open: "block", Menu closed: "hidden" -->
                            <svg :class="{'block': isOpen, 'hidden': !isOpen }" class="hidden h-6 w-6" fill="none"
                                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Mobile menu, show/hide based on menu state. -->
            <div x-show="isOpen" class="md:hidden" id="mobile-menu">
                <div class="space-y-1 px-2 pb-3 pt-2 sm:px-3">
                    <!-- Current: "bg-gray-900 text-white", Default: "text-gray-300 hover:bg-gray-700 hover:text-white" -->
                    <a href="/journal"
                        class="nav-link {{ request()->is('/journal') ? 'bg-cyan-500 text-white' : 'text-gray-300 hover:bg-cyan-500 hover:text-white' }} block text-base"
                        aria-current="page">Home</a>
                    <a href="/report"
                        class="nav-link {{ request()->is('report') ? 'bg-cyan-500 text-white' : 'text-gray-300 hover:bg-cyan-500 hover:text-white' }} block text-base">Report</a>
                    @can('admin')
                    <a href="/administrator"
                        class="nav-link {{ request()->is('administrator') ? 'bg-cyan-500 text-white' : 'text-gray-300 hover:bg-cyan-500 hover:text-white' }} block text-base">Administrator</a>
                    <a href="/finance"
                        class="nav-link {{ request()->is('finance') ? 'bg-cyan-500 text-white' : 'text-gray-300 hover:bg-cyan-500 hover:text-white' }} block text-base">Hutang
                        x Piutang</a>
                    <a href="/setting"
                        class="nav-link {{ request()->is('setting') ? 'bg-cyan-500 text-white' : 'text-gray-300 hover:bg-cyan-500 hover:text-white' }} block text-base">Setting</a>
                    @endcan

                </div>
                <div class="border-t border-gray-700 pb-3 pt-4">
                    <div class="flex items-center px-5">
                        <div class="flex-shrink-0">
                            <img class="h-10 w-10 rounded-full"
                                src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                                alt="">
                        </div>
                        <div class="ml-3">
                            <div class="text-base font-medium leading-none text-white">{{ Auth()->user()->name }}</div>
                            <div class="text-sm font-medium leading-none text-gray-300">{{ Auth()->user()->email }}
                            </div>
                        </div>
                        <button type="button"
                            class="relative ml-auto flex-shrink-0 rounded-full bg-cyan-700 p-1 text-cyan-400 hover:text-white focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-cyan-700">
                            <span class="absolute -inset-1.5"></span>
                            <span class="sr-only">View notifications</span>
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
                            </svg>
                        </button>
                    </div>
                    <div class="mt-3 space-y-1 px-2">
                        <form action="{{ route('auth.logout') }}" method="post">
                            @csrf
                            <button type="submit"
                                class="nav-link block text-base text-gray-300 hover:bg-cyan-500 hover:text-white"
                                role="menuitem" tabindex="-1" id="user-menu-item-2">Sign out</button>
                        </form>
                    </div>
                </div>
            </div>
        </nav>

        <header class="bg-white shadow">
            <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between">
                    <h1 class="text-3xl font-bold tracking-tight text-gray-900">{{ $title ?? '' }}</h1>
                    <div>
                        {{ '#' . Auth()->user()->warehouse->name }}
                    </div>
                </div>
            </div>
        </header>
        <main>
            <div class="mx-auto max-w-7xl py-6 sm:px-6 lg:px-8">
                {{ $slot }}
            </div>
        </main>
    </div>


    {{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdn.tailwindcss.com/"></script>
    <script src="https://cdn.datatables.net/2.0.7/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.0.7/js/dataTables.tailwindcss.js"></script>
    <script>
        $(document).ready(function() {
            $('.display ').DataTable();
        });
    </script> --}}

    @livewireScripts
</body>

</html>