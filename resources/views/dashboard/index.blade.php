@extends('layouts.app')

@section('title', 'Dashboard')
@section('page_title', 'Overview Monitoring')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex items-center gap-4">
        <div class="w-12 h-12 bg-red-100 text-red-600 rounded-xl flex items-center justify-center text-xl">
            <i class="fa-solid fa-circle-exclamation"></i>
        </div>
        <div>
            <p class="text-slate-500 text-sm font-medium">Tiket Aktif</p>
            <h3 class="text-2xl font-bold text-slate-800">{{ $countOpen }}</h3>
        </div>
    </div>

    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex items-center gap-4">
        <div class="w-12 h-12 bg-amber-100 text-amber-600 rounded-xl flex items-center justify-center text-xl">
            <i class="fa-solid fa-spinner"></i>
        </div>
        <div>
            <p class="text-slate-500 text-sm font-medium">Dalam Perbaikan</p>
            <h3 class="text-2xl font-bold text-slate-800">{{ $countProgress }}</h3>
        </div>
    </div>

    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex items-center gap-4">
        <div class="w-12 h-12 bg-emerald-100 text-emerald-600 rounded-xl flex items-center justify-center text-xl">
            <i class="fa-solid fa-check-double"></i>
        </div>
        <div>
            <p class="text-slate-500 text-sm font-medium">Selesai (Hari Ini)</p>
            <h3 class="text-2xl font-bold text-slate-800">{{ $countResolvedToday }}</h3>
        </div>
    </div>

    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex items-center gap-4">
        <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-xl flex items-center justify-center text-xl">
            <i class="fa-solid fa-users"></i>
        </div>
        <div>
            <p class="text-slate-500 text-sm font-medium">Total Pelanggan</p>
            <h3 class="text-2xl font-bold text-slate-800">{{ number_format($totalCustomers) }}</h3>
        </div>
    </div>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
    <div class="p-6 border-b border-slate-100 flex justify-between items-center">
        <h3 class="font-bold text-slate-800">5 Gangguan Terakhir</h3>
        <a href="/tickets" class="text-blue-600 text-sm font-semibold hover:underline">Lihat Semua</a>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead class="bg-slate-50 text-slate-500 text-[10px] uppercase tracking-wider">
                <tr>
                    <th class="px-6 py-4">Nomor Tiket</th>
                    <th class="px-6 py-4">Pelanggan</th>
                    <th class="px-6 py-4">Masalah</th>
                    <th class="px-6 py-4">Status</th>
                </tr>
            </thead>
            <tbody class="text-sm divide-y divide-slate-100">
                @forelse($recentTickets as $ticket)
                <tr>
                    <td class="px-6 py-4 font-medium text-blue-600 italic">#{{ $ticket->ticket_number }}</td>
                    <td class="px-6 py-4">{{ $ticket->customer->nama_pelanggan }}</td>
                    <td class="px-6 py-4 text-slate-500">{{ $ticket->category->nama_kategori }}</td>
                    <td class="px-6 py-4">
                        <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase 
                            {{ $ticket->status == 'Open' ? 'bg-red-100 text-red-600' : 'bg-amber-100 text-amber-600' }}">
                            {{ $ticket->status }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-6 py-10 text-center text-slate-400 italic">
                        Belum ada data gangguan yang tercatat hari ini.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection