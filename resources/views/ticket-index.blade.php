@extends('layouts.app')

@section('title', 'Daftar Gangguan')
@section('page_title', 'Histori Laporan Gangguan')

@section('content')
    <div class="space-y-6">
        <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-slate-100">
            <form action="{{ route('tickets.index') }}" method="GET" class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-4 lg:grid-cols-5 gap-6">
                    <div class="md:col-span-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 block ml-1">Cari
                            Laporan</label>
                        <input type="text" name="search" value="{{ request('search') }}"
                            class="w-full bg-slate-50 border-0 rounded-2xl px-5 py-3 text-sm focus:ring-2 focus:ring-blue-500/20"
                            placeholder="Nomor Tiket / Nama Pelanggan...">
                    </div>

                    <div>
                        <label
                            class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 block ml-1">Status</label>
                        <select name="status"
                            class="w-full bg-slate-50 border-0 rounded-2xl px-5 py-3 text-sm focus:ring-2 focus:ring-blue-500/20">
                            <option value="">Semua Status</option>
                            <option value="Open" {{ request('status') == 'Open' ? 'selected' : '' }}>🔵 Open</option>
                            <option value="In Progress" {{ request('status') == 'In Progress' ? 'selected' : '' }}>🟡 In
                                Progress</option>
                            <option value="Resolved" {{ request('status') == 'Resolved' ? 'selected' : '' }}>🟢 Resolved
                            </option>
                        </select>
                    </div>

                    <div class="md:col-span-2">
                        <label
                            class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 block ml-1">Rentang
                            Waktu</label>
                        <div class="flex items-center gap-3">
                            <input type="date" name="start_date" value="{{ request('start_date') }}"
                                class="flex-1 bg-slate-50 border-0 rounded-2xl px-5 py-3 text-sm focus:ring-2 focus:ring-blue-500/20">
                            <span class="text-slate-300 font-bold text-xs uppercase">s/d</span>
                            <input type="date" name="end_date" value="{{ request('end_date') }}"
                                class="flex-1 bg-slate-50 border-0 rounded-2xl px-5 py-3 text-sm focus:ring-2 focus:ring-blue-500/20">
                        </div>
                    </div>
                </div>

                <div class="flex flex-wrap items-center justify-between gap-4 pt-6 border-t border-slate-50">
                    <div class="flex items-center gap-3">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Tampilkan:</label>
                        <select name="per_page" onchange="this.form.submit()"
                            class="bg-slate-100 border-0 rounded-xl px-4 py-2 text-xs font-bold focus:ring-0">
                            @foreach([10, 20, 50, 100, 'all'] as $val)
                                <option value="{{ $val }}" {{ request('per_page', 10) == $val ? 'selected' : '' }}>
                                    {{ strtoupper($val) }} Baris
                                </option>
                            @endforeach
                        </select>

                        <button type="submit" name="export" value="1"
                            class="flex items-center gap-2 bg-emerald-50 text-emerald-600 px-5 py-2 rounded-xl font-bold text-xs hover:bg-emerald-100 transition-all border border-emerald-100">
                            <i class="fa-solid fa-file-excel"></i> Export Excel
                        </button>
                    </div>

                    <div class="flex gap-2">
                        @if(request()->anyFilled(['search', 'status', 'start_date', 'end_date']))
                            <a href="{{ route('tickets.index') }}"
                                class="bg-slate-100 text-slate-500 px-8 py-3 rounded-2xl font-bold text-sm hover:bg-slate-200 transition-all">
                                Reset
                            </a>
                        @endif
                        <button type="submit"
                            class="bg-slate-900 text-white px-8 py-3 rounded-2xl font-bold text-sm hover:bg-black transition-all shadow-lg shadow-slate-200">
                            Terapkan Filter
                        </button>
                        <a href="/ticket-create"
                            class="bg-blue-600 text-white px-6 py-3 rounded-2xl font-bold text-sm hover:bg-blue-700 transition-all shadow-lg shadow-blue-100 flex items-center gap-2">
                            <i class="fa-solid fa-plus"></i> Tiket Baru
                        </a>
                    </div>
                </div>
            </form>
        </div>

        <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-slate-50 text-[10px] font-black uppercase text-slate-400 tracking-widest">
                        <tr>
                            <th class="px-8 py-5 text-center w-20">Prioritas</th>
                            <th class="px-8 py-5">Info Tiket</th>
                            <th class="px-8 py-5">Pelanggan & Layanan</th>
                            <th class="px-8 py-5">Kategori</th>
                            <th class="px-8 py-5">Penginput</th>
                            <th class="px-8 py-5">Waktu Lapor</th>
                            <th class="px-8 py-5">Status</th>
                            <th class="px-8 py-5 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($tickets as $ticket)
                            <tr class="hover:bg-slate-50/50 transition-colors group">
                                <td class="px-8 py-5">
                                    <div class="flex flex-col items-center">
                                        <div
                                            class="w-2 h-8 rounded-full {{ $ticket->priority == 'High' ? 'bg-red-500' : ($ticket->priority == 'Medium' ? 'bg-amber-500' : 'bg-blue-500') }}">
                                        </div>
                                        <span
                                            class="text-[8px] font-black mt-1 text-slate-400 uppercase">{{ $ticket->priority }}</span>
                                    </div>
                                </td>
                                <td class="px-8 py-5">
                                    <div class="font-black text-slate-700">#{{ $ticket->ticket_number }}</div>
                                    <div class="text-[10px] text-slate-400 font-bold uppercase tracking-tighter">Reference ID
                                    </div>
                                </td>
                                <td class="px-8 py-5">
                                    <div class="font-bold text-slate-800">{{ $ticket->customer->nama_pelanggan }}</div>
                                    <div class="text-[11px] text-slate-400">{{ $ticket->customer->layanan }}</div>
                                </td>
                                <td class="px-8 py-5">
                                    <span
                                        class="text-sm text-slate-600 font-semibold">{{ $ticket->category->nama_kategori }}</span>
                                </td>
                                <td class="px-8 py-5">
                                    <div class="flex items-center gap-2">
                                        <div
                                            class="w-7 h-7 rounded-full bg-blue-100 flex items-center justify-center text-[10px] font-black text-blue-600">
                                            {{ strtoupper(substr($ticket->user->name ?? '?', 0, 1)) }}
                                        </div>
                                        <span
                                            class="text-xs font-bold text-slate-600">{{ $ticket->user->name ?? 'System' }}</span>
                                    </div>
                                </td>
                                <td class="px-8 py-5">
                                    <div class="text-sm text-slate-700 font-medium">{{ $ticket->waktu_mulai->format('d M Y') }}
                                    </div>
                                    <div class="text-[11px] text-slate-400 font-bold">{{ $ticket->waktu_mulai->format('H:i') }}
                                        WIB</div>
                                </td>
                                <td class="px-8 py-5">
                                    @php
                                        $statusClasses = [
                                            'Open' => 'bg-red-50 text-red-600 border-red-100',
                                            'In Progress' => 'bg-amber-50 text-amber-600 border-amber-100',
                                            'Resolved' => 'bg-emerald-50 text-emerald-600 border-emerald-100'
                                        ];
                                        $class = $statusClasses[$ticket->status] ?? 'bg-slate-50 text-slate-600 border-slate-100';
                                    @endphp
                                    <span
                                        class="px-4 py-1.5 rounded-full text-[10px] font-black uppercase tracking-wider border {{ $class }}">
                                        {{ $ticket->status }}
                                    </span>
                                </td>
                                <td class="px-8 py-5 text-right">
                                    <div class="flex justify-end gap-2">
                                        <form action="{{ route('tickets.destroy', $ticket->id) }}" method="POST"
                                            onsubmit="return confirm('Hapus histori ini?')">
                                            @csrf @method('DELETE')
                                            <button
                                                class="w-9 h-9 flex items-center justify-center rounded-xl bg-slate-50 text-slate-300 hover:bg-red-50 hover:text-red-500 transition-all border border-transparent hover:border-red-100">
                                                <i class="fa-solid fa-trash-can text-sm"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-8 py-20 text-center">
                                    <div class="text-slate-200 mb-3"><i class="fa-solid fa-folder-open fa-4x"></i></div>
                                    <div class="text-sm font-bold text-slate-400">Tidak ada data gangguan ditemukan.</div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($tickets->hasPages())
                <div class="p-8 bg-slate-50/30 border-t border-slate-50">
                    {{ $tickets->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection