<aside class="w-64 bg-slate-900 min-h-screen text-slate-300 p-4">
    <div class="mb-8 px-4">
        <h1 class="text-white text-xl font-bold tracking-wider">NET-TRACK</h1>
        <p class="text-xs text-slate-500">Network Reporting System</p>
    </div>

    <nav class="space-y-2">
        <a href="{{ route('dashboard') }}"
            class="flex items-center gap-3 p-3 rounded-lg hover:bg-slate-800 hover:text-white transition-all {{ request()->is('dashboard') ? 'bg-blue-600 text-white' : '' }}">
            <i class="fa-solid fa-gauge-high w-5"></i>
            <span>Dashboard</span>
        </a>

        @if(in_array(Auth::user()->role, ['admin', 'staff', 'manager_it', 'gm']))
            <div class="pt-4 pb-2 px-4 text-xs font-semibold text-slate-500 uppercase tracking-widest">Operasional</div>

            @if(in_array(Auth::user()->role, ['admin', 'staff']))
                <a href="{{ route('tickets.create') }}"
                    class="flex items-center gap-3 p-3 rounded-lg hover:bg-slate-800 transition-all {{ request()->is('tickets/create') ? 'bg-blue-600 text-white' : '' }}">
                    <i class="fa-solid fa-circle-plus w-5 text-emerald-500"></i>
                    <span>Input Gangguan</span>
                </a>
            @endif

            <a href="/tickets"
                class="flex items-center gap-3 p-3 rounded-lg hover:bg-slate-800 hover:text-white transition-all {{ request()->is('tickets') ? 'bg-blue-600 text-white' : '' }}">
                <i class="fa-solid fa-list-check w-5"></i>
                <span>Daftar Gangguan</span>
            </a>
        @endif

        @if(in_array(Auth::user()->role, ['admin', 'manager_it']))
            <div class="pt-4 pb-2 px-4 text-xs font-semibold text-slate-500 uppercase tracking-widest">Master Data</div>

            <a href="/customers"
                class="flex items-center gap-3 p-3 rounded-lg hover:bg-slate-800 hover:text-white transition-all {{ request()->is('customers*') ? 'bg-blue-600 text-white' : '' }}">
                <i class="fa-solid fa-users w-5"></i>
                <span>Data Pelanggan</span>
            </a>

            <a href="{{ route('categories.index') }}"
                class="flex items-center gap-3 p-3 rounded-lg hover:bg-slate-800 transition-all {{ request()->is('categories*') ? 'bg-blue-600 text-white' : '' }}">
                <i class="fa-solid fa-tag w-5 text-blue-400"></i>
                <span>Kategori Masalah</span>
            </a>
        @endif

        @if(in_array(Auth::user()->role, ['admin', 'manager_it', 'gm']))
            <div class="pt-4 pb-2 px-4 text-xs font-semibold text-slate-500 uppercase tracking-widest">Laporan</div>
            <a href="{{ route('reports.index') }}"
                class="flex items-center gap-3 p-3 rounded-lg hover:bg-slate-800 hover:text-white transition-all {{ request()->is('reports*') ? 'bg-blue-600 text-white' : '' }}">
                <i class="fa-solid fa-chart-line w-5"></i>
                <span>Analisa Laporan</span>
            </a>
        @endif

        <div class="pt-4 pb-2 px-4 text-xs font-semibold text-slate-500 uppercase tracking-widest">Sistem & Riwayat
        </div>

        @if(Auth::user()->role == 'admin')
            <a href="{{ route('users.index') }}"
                class="flex items-center gap-3 p-3 rounded-lg hover:bg-slate-800 hover:text-white transition-all {{ request()->is('users*') ? 'bg-blue-600 text-white' : '' }}">
                <i class="fa-solid fa-user-gear w-5 text-amber-500"></i>
                <span>Manajemen User</span>
            </a>
        @endif

        <a href="{{ route('audit.index') }}"
            class="flex items-center gap-3 p-3 rounded-lg hover:bg-slate-800 hover:text-white transition-all {{ request()->is('audit*') ? 'bg-blue-600 text-white' : '' }}">
            <i class="fa-solid fa-clock-rotate-left w-5 text-indigo-400"></i>
            <span>Audit Log (History)</span>
        </a>

        <div class="mt-10 pt-4 border-t border-slate-800">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit"
                    class="flex items-center gap-3 p-3 w-full rounded-lg text-red-400 hover:bg-red-500/10 transition-all">
                    <i class="fa-solid fa-right-from-bracket w-5"></i>
                    <span>Keluar</span>
                </button>
            </form>
        </div>
    </nav>
</aside>