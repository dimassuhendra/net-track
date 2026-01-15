@extends('layouts.app')

@section('title', 'Daftar Gangguan')
@section('page_title', 'Histori Laporan Gangguan')

@section('content')
    <div class="space-y-6">
        <div class="bg-white p-8 rounded-3xl shadow-sm border border-slate-100">
            <form action="{{ route('tickets.index') }}" method="GET" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                    <div class="md:col-span-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 block">Cari Laporan</label>
                        <input type="text" name="search" value="{{ request('search') }}" 
                            class="w-full bg-slate-50 border-0 rounded-2xl px-5 py-3 text-sm focus:ring-2 focus:ring-blue-500/20" 
                            placeholder="Nomor Tiket / Nama Pelanggan...">
                    </div>

                    <div>
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 block">Status</label>
                        <select name="status" class="w-full bg-slate-50 border-0 rounded-2xl px-5 py-3 text-sm focus:ring-2 focus:ring-blue-500/20">
                            <option value="">Semua Status</option>
                            <option value="Open" {{ request('status') == 'Open' ? 'selected' : '' }}>Open</option>
                            <option value="In Progress" {{ request('status') == 'In Progress' ? 'selected' : '' }}>In Progress</option>
                            <option value="Resolved" {{ request('status') == 'Resolved' ? 'selected' : '' }}>Resolved</option>
                        </select>
                    </div>

                    <div>
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 block">Dari Tanggal</label>
                        <input type="date" name="start_date" value="{{ request('start_date') }}" 
                            class="w-full bg-slate-50 border-0 rounded-2xl px-5 py-3 text-sm focus:ring-2 focus:ring-blue-500/20">
                    </div>

                    <div>
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 block">Sampai Tanggal</label>
                        <input type="date" name="end_date" value="{{ request('end_date') }}" 
                            class="w-full bg-slate-50 border-0 rounded-2xl px-5 py-3 text-sm focus:ring-2 focus:ring-blue-500/20">
                    </div>
                </div>

                <div class="flex justify-between items-center pt-2">
                    <div class="flex gap-2">
                        <button type="submit" class="bg-slate-900 text-white px-8 py-3 rounded-2xl font-bold text-sm hover:bg-black transition-all shadow-lg shadow-slate-200">
                            Terapkan Filter
                        </button>
                        @if(request()->anyFilled(['search', 'status', 'start_date', 'end_date']))
                            <a href="{{ route('tickets.index') }}" class="bg-slate-100 text-slate-500 px-8 py-3 rounded-2xl font-bold text-sm hover:bg-slate-200 transition-all">
                                Reset
                            </a>
                        @endif
                    </div>

                    <a href="/ticket-create" class="bg-blue-600 text-white px-6 py-3 rounded-2xl font-bold text-sm hover:bg-blue-700 transition-all shadow-lg shadow-blue-100 flex items-center gap-2">
                        <i class="fa-solid fa-plus"></i> Tiket Baru
                    </a>
                </div>
            </form>
        </div>

        <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-slate-50 text-[10px] font-black uppercase text-slate-400 tracking-widest">
                        <tr>
                            <th class="px-8 py-5">Info Tiket</th>
                            <th class="px-8 py-5">Pelanggan & Layanan</th>
                            <th class="px-8 py-5">Kategori Masalah</th>
                            <th class="px-8 py-5">Waktu Lapor</th>
                            <th class="px-8 py-5">Status</th>
                            <th class="px-8 py-5 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($tickets as $ticket)
                            <tr class="hover:bg-slate-50/50 transition-colors group">
                                <td class="px-8 py-5">
                                    <div class="font-bold text-blue-600 italic">#{{ $ticket->ticket_number }}</div>
                                    <div
                                        class="text-[10px] bg-slate-100 text-slate-500 px-2 py-0.5 rounded inline-block mt-1 font-bold">
                                        {{ strtoupper($ticket->priority) }} PRIORITY
                                    </div>
                                </td>
                                <td class="px-8 py-5">
                                    <div class="font-bold text-slate-800">{{ $ticket->customer->nama_pelanggan }}</div>
                                    <div class="text-xs text-slate-400">{{ $ticket->customer->layanan }}</div>
                                </td>
                                <td class="px-8 py-5">
                                    <span
                                        class="text-sm text-slate-600 font-medium">{{ $ticket->category->nama_kategori }}</span>
                                </td>
                                <td class="px-8 py-5">
                                    <div class="text-sm text-slate-700 font-medium">{{ $ticket->waktu_mulai->format('d M Y') }}
                                    </div>
                                    <div class="text-xs text-slate-400">{{ $ticket->waktu_mulai->format('H:i') }} WIB</div>
                                </td>
                                <td class="px-8 py-5">
                                    <span class="px-4 py-1.5 rounded-full text-[10px] font-black uppercase tracking-wider
                                        {{ $ticket->status == 'Open' ? 'bg-red-100 text-red-600' : '' }}
                                        {{ $ticket->status == 'In Progress' ? 'bg-amber-100 text-amber-600' : '' }}
                                        {{ $ticket->status == 'Resolved' ? 'bg-emerald-100 text-emerald-600' : '' }}">
                                        {{ $ticket->status }}
                                    </span>
                                </td>
                                <td class="px-8 py-5 text-right">
                                    <div class="flex justify-end gap-2">
                                        <form action="{{ route('tickets.destroy', $ticket->id) }}" method="POST"
                                            onsubmit="return confirm('Hapus histori ini?')">
                                            @csrf @method('DELETE')
                                            <button
                                                class="w-9 h-9 flex items-center justify-center rounded-xl bg-slate-50 text-slate-300 hover:bg-red-50 hover:text-red-500 transition-all">
                                                <i class="fa-solid fa-trash-can text-sm"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-8 py-12 text-center">
                                    <div class="text-slate-400 italic">Data tidak ditemukan.</div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="p-8 bg-slate-50/50 border-t border-slate-50">
                {{ $tickets->links() }}
            </div>
        </div>
    </div>
@endsection