<div class="hidden md:block">
    <div class="ml-10 flex items-baseline space-x-4">
        <!-- Current: "bg-gray-900 text-white", Default: "text-gray-300 hover:bg-gray-700 hover:text-white" -->
        <a href="/"
            class="{{ request()->is('/') ? 'nav-link bg-cyan-500 text-white' : 'nav-link text-gray-300 hover:bg-cyan-500 hover:text-white' }}"
            aria-current="page">Home</a>
        <a href="/report"
            class="nav-link {{ request()->is('report') ? 'bg-cyan-500 text-white' : 'text-gray-300 hover:bg-cyan-500 hover:text-white' }} }}">Report</a>
        <a href="#"
            class="nav-link {{ request()->is('administrator') ? 'bg-cyan-500 text-white' : 'text-gray-300 hover:bg-cyan-500 hover:text-white' }}">Administrator</a>
        <a href="#"
            class="nav-link {{ request()->is('finance') ? 'bg-cyan-500 text-white' : 'text-gray-300 hover:bg-cyan-500 hover:text-white' }}">Hutang
            x Piutang</a>
        <a href="#"
            class="nav-link {{ request()->is('setting') ? 'bg-cyan-500 text-white' : 'text-gray-300 hover:bg-cyan-500 hover:text-white' }}">Setting</a>
    </div>
</div>