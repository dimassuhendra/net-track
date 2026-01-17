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
                                <td class="px-8 py-5">
                                    <div class="flex justify-end gap-2">
                                        <button
                                            onclick="showDetail({{ json_encode($ticket->load('customer', 'category', 'user', 'pic')) }}, '{{ $ticket->waktu_mulai->format('d M Y H:i') }}')"
                                            class="w-9 h-9 flex items-center justify-center rounded-xl bg-blue-50 text-blue-500 hover:bg-blue-600 hover:text-white transition-all border border-blue-100">
                                            <i class="fa-solid fa-eye text-sm"></i>
                                        </button>

                                        <button onclick="openEditModal({{ $ticket }})"
                                            class="w-9 h-9 flex items-center justify-center rounded-xl bg-amber-50 text-amber-500 hover:bg-amber-600 hover:text-white transition-all border border-amber-100">
                                            <i class="fa-solid fa-pen-to-square text-sm"></i>
                                        </button>

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

    <div id="detailModal" class="fixed inset-0 z-[100] hidden items-center justify-center p-4">
        <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm" onclick="closeModal('detailModal')"></div>
        <div class="bg-white rounded-[2.5rem] w-full max-w-2xl relative z-10 overflow-hidden shadow-2xl">
            <div class="bg-slate-900 p-8 text-white flex justify-between items-center">
                <div>
                    <h3 class="text-xl font-black uppercase" id="det-ticket-number">#TIC-0000</h3>
                    <p class="text-slate-400 text-xs mt-1 uppercase tracking-widest">Detail Laporan Gangguan</p>
                </div>
                <button onclick="closeModal('detailModal')" class="text-slate-400 hover:text-white"><i
                        class="fa-solid fa-xmark fa-xl"></i></button>
            </div>
            <div class="p-8 space-y-6 max-h-[70vh] overflow-y-auto">
                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <label class="text-[10px] font-black text-slate-400 uppercase block mb-1">Pelanggan</label>
                        <p class="font-bold text-slate-800" id="det-customer">-</p>
                    </div>
                    <div>
                        <label class="text-[10px] font-black text-slate-400 uppercase block mb-1">PIC Petugas</label>
                        <p class="font-bold text-slate-800" id="det-pic">-</p>
                    </div>
                    <div>
                        <label class="text-[10px] font-black text-slate-400 uppercase block mb-1">Waktu Lapor</label>
                        <p class="font-bold text-slate-800" id="det-time">-</p>
                    </div>
                    <div>
                        <label class="text-[10px] font-black text-slate-400 uppercase block mb-1">Durasi Penanganan</label>
                        <p class="font-bold text-blue-600" id="det-duration">-</p>
                    </div>
                </div>
                <hr class="border-slate-100">
                <div>
                    <label class="text-[10px] font-black text-slate-400 uppercase block mb-2">Rincian Masalah</label>
                    <div class="bg-slate-50 p-4 rounded-2xl text-sm text-slate-700 italic border-l-4 border-slate-200"
                        id="det-issue"></div>
                </div>
                <div>
                    <label class="text-[10px] font-black text-blue-600 uppercase block mb-2">Tindakan Petugas (Action
                        Taken)</label>
                    <div class="bg-blue-50 text-blue-700 p-4 rounded-2xl text-sm font-medium border-l-4 border-blue-200"
                        id="det-action">Belum ada tindakan.</div>
                </div>
            </div>
        </div>
    </div>

    <div id="editModal" class="fixed inset-0 z-[100] hidden items-center justify-center p-4">
        <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm" onclick="closeModal('editModal')"></div>
        <div class="bg-white rounded-[2.5rem] w-full max-w-lg relative z-10 overflow-hidden shadow-2xl">
            <form id="editForm" method="POST">
                @csrf @method('PUT')
                <div class="p-8">
                    <h3 class="text-xl font-black text-slate-800 uppercase mb-6">Update Progress Tiket</h3>
                    <div class="space-y-5">
                        <div>
                            <label class="text-[10px] font-black text-slate-400 uppercase mb-2 block ml-1">Status
                                Laporan</label>
                            <select name="status" id="edit-status"
                                class="w-full bg-slate-50 border-0 rounded-2xl px-5 py-3 text-sm font-bold focus:ring-2 focus:ring-blue-500/20">
                                <option value="Open">🔵 Open</option>
                                <option value="In Progress">🟡 In Progress</option>
                                <option value="Resolved">🟢 Resolved</option>
                            </select>
                        </div>
                        <div>
                            <label class="text-[10px] font-black text-slate-400 uppercase mb-2 block ml-1">Tindakan (Action
                                Taken)</label>
                            <textarea name="action_taken" id="edit-action" rows="4"
                                class="w-full bg-slate-50 border-0 rounded-2xl px-5 py-4 text-sm focus:ring-2 focus:ring-blue-500/20"
                                placeholder="Tuliskan tindakan yang dilakukan..."></textarea>
                        </div>
                    </div>
                    <div class="flex gap-3 mt-8">
                        <button type="button" onclick="closeModal('editModal')"
                            class="flex-1 py-4 text-xs font-bold text-slate-400 uppercase tracking-widest">Batal</button>
                        <button type="submit"
                            class="flex-1 bg-blue-600 text-white py-4 rounded-2xl font-bold text-sm shadow-xl shadow-blue-200 hover:bg-blue-700 transition-all">SIMPAN
                            PERUBAHAN</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openEditModal(ticket) {
            const modal = document.getElementById('editModal');
            const form = document.getElementById('editForm');

            // Set action URL secara dinamis
            form.action = `/tickets/${ticket.id}`;

            // Isi nilai
            document.getElementById('edit-status').value = ticket.status;
            document.getElementById('edit-action').value = ticket.action_taken || '';

            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function showDetail(ticket, formattedTime) {
            const modal = document.getElementById('detailModal');

            document.getElementById('det-ticket-number').innerText = '#' + ticket.ticket_number;
            document.getElementById('det-customer').innerText = ticket.customer.nama_pelanggan;
            document.getElementById('det-pic').innerText = ticket.pic ? ticket.pic.name : '-';
            document.getElementById('det-time').innerText = formattedTime;
            document.getElementById('det-issue').innerText = ticket.rincian_masalah;
            document.getElementById('det-action').innerText = ticket.action_taken || 'Belum ada tindakan yang dicatat.';

            // Logika durasi sederhana
            if (ticket.status === 'Resolved' && ticket.updated_at) {
                const start = new Date(ticket.waktu_mulai);
                const end = new Date(ticket.updated_at);
                const diffMs = end - start;
                const diffHrs = Math.floor(diffMs / 3600000);
                const diffMins = Math.round(((diffMs % 3600000) / 60000));
                document.getElementById('det-duration').innerText = `${diffHrs} Jam ${diffMins} Menit`;
            } else {
                document.getElementById('det-duration').innerText = 'Masih dalam proses';
            }

            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeModal(id) {
            const modal = document.getElementById(id);
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }
    </script>
@endsection