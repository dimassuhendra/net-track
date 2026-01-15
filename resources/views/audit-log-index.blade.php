@extends('layouts.app')

@section('content')
    <div class="space-y-6">
        <div class="bg-white p-6 rounded-[2rem] shadow-sm border border-slate-100">
            <form class="flex flex-wrap gap-4 items-end">
                <div class="flex-1 min-w-[200px]">
                    <label
                        class="text-[10px] font-black text-slate-400 uppercase mb-2 block tracking-widest">Petugas</label>
                    <input type="text" name="user" value="{{ request('user') }}"
                        class="w-full bg-slate-50 border-0 rounded-2xl px-5 py-3 text-sm focus:ring-2 focus:ring-blue-500/20"
                        placeholder="Cari nama petugas...">
                </div>
                <div class="w-48">
                    <label class="text-[10px] font-black text-slate-400 uppercase mb-2 block tracking-widest">Model</label>
                    <select name="model"
                        class="w-full bg-slate-50 border-0 rounded-2xl px-5 py-3 text-sm focus:ring-2 focus:ring-blue-500/20">
                        <option value="">Semua Model</option>
                        <option value="Ticket" {{ request('model') == 'Ticket' ? 'selected' : '' }}>Tiket</option>
                        <option value="Customer" {{ request('model') == 'Customer' ? 'selected' : '' }}>Pelanggan</option>
                        <option value="User" {{ request('model') == 'User' ? 'selected' : '' }}>User/Staff</option>
                    </select>
                </div>
                <button type="submit"
                    class="bg-slate-900 text-white px-8 py-3 rounded-2xl font-bold text-sm hover:bg-black transition-all">Filter</button>
                <a href="{{ route('audit.index') }}"
                    class="bg-slate-100 text-slate-500 px-8 py-3 rounded-2xl font-bold text-sm">Reset</a>
            </form>
        </div>

        <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden">
            <table class="w-full text-left border-collapse">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Waktu &
                            Petugas</th>
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Aktivitas</th>
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Objek (Model)
                        </th>
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">IP
                            Address</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($logs as $log)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-8 py-5">
                                <div class="flex items-center gap-4">
                                    <div
                                        class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center font-black text-slate-500 text-xs">
                                        {{ strtoupper(substr($log->user->name ?? '?', 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="text-sm font-black text-slate-700">{{ $log->user->name ?? 'Unknown' }}</div>
                                        <div class="text-[10px] text-slate-400 font-bold uppercase">
                                            {{ $log->created_at->format('d M Y | H:i') }} WIB</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-8 py-5">
                                <div class="text-sm font-bold text-slate-600">{{ $log->activity }}</div>
                                @if($log->payload)
                                    <div class="text-[10px] text-blue-500 font-mono mt-1 italic">
                                        ID: #{{ $log->model_id }}
                                    </div>
                                @endif
                            </td>
                            <td class="px-8 py-5">
                                <span class="px-3 py-1 rounded-full bg-blue-50 text-blue-600 text-[10px] font-black uppercase">
                                    {{ class_basename($log->model_type) }}
                                </span>
                            </td>
                            <td class="px-8 py-5 text-right font-mono text-[10px] text-slate-400">
                                {{ $log->ip_address }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-8 py-20 text-center">
                                <div class="text-slate-300 mb-2"><i class="fa-solid fa-inbox fa-3x"></i></div>
                                <div class="text-sm font-bold text-slate-400">Belum ada riwayat aktivitas ditemukan.</div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            @if($logs->hasPages())
                <div class="p-8 border-t border-slate-50">
                    {{ $logs->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection