<div class="hidden md:block">
    <div class="ml-10 flex items-baseline space-x-4">
        <!-- Current: "bg-gray-900 text-white", Default: "text-gray-300 hover:bg-gray-700 hover:text-white" -->
        <a href="/journal"
            class="{{ request()->is('journal', 'journal/*') ? 'nav-link bg-cyan-500 text-white' : 'nav-link text-gray-300 hover:bg-cyan-500 hover:text-white' }}"
            aria-current="page">Home</a>
        <a href="/report"
            class="nav-link {{ request()->is('report', 'report/*') ? 'bg-cyan-500 text-white' : 'text-gray-300 hover:bg-cyan-500 hover:text-white' }}">Report</a>
        <a href="#"
            class="nav-link {{ request()->is('administrator', 'administrator/*') ? 'bg-cyan-500 text-white' : 'text-gray-300 hover:bg-cyan-500 hover:text-white' }}">Administrator</a>
        <a href="#"
            class="nav-link {{ request()->is('finance', 'finance/*') ? 'bg-cyan-500 text-white' : 'text-gray-300 hover:bg-cyan-500 hover:text-white' }}">Hutang
            x Piutang</a>
        <a href="/setting"
            class="nav-link {{ request()->is('setting', 'setting/*') ? 'bg-cyan-500 text-white' : 'text-gray-300 hover:bg-cyan-500 hover:text-white' }}">Setting</a>
    </div>
</div>