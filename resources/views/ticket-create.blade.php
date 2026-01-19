@extends('layouts.app')

@section('title', 'Input Gangguan')
@section('page_title', 'Reporting System')

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css" />
    <style>
        .choices__inner {
            background-color: #f8fafc !important;
            border: 2px solid #f8fafc !important;
            border-radius: 1rem !important;
            padding: 0.5rem 1rem !important;
            /* Diperkecil untuk mobile */
            min-height: 50px !important;
        }

        .choices__list--dropdown {
            border-radius: 1rem !important;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1) !important;
            z-index: 50 !important;
        }

        /* Memperbaiki tampilan radio button agar tidak pecah di layar sangat kecil */
        .priority-group {
            display: grid;
            grid-template-cols: repeat(3, 1fr);
            gap: 0.5rem;
        }
    </style>
@endpush

@section('content')
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 pb-10">
        <div class="flex items-center gap-2 text-slate-400 text-[10px] md:text-xs mb-4 md:mb-6 font-medium">
            <a href="/dashboard" class="hover:text-blue-600 transition-colors uppercase">DASHBOARD</a>
            <i class="fa-solid fa-chevron-right text-[8px]"></i>
            <span class="text-slate-600 uppercase">Input Tiket Baru</span>
        </div>

        <div
            class="bg-white rounded-[1.5rem] md:rounded-[2.5rem] shadow-2xl shadow-slate-200/50 border border-slate-100 overflow-hidden">
            <div class="grid grid-cols-1 lg:grid-cols-12">

                <div
                    class="lg:col-span-4 bg-slate-900 p-8 md:p-12 text-white relative overflow-hidden flex flex-col justify-between min-h-[300px] lg:min-h-[600px]">
                    <div class="relative z-10">
                        <div
                            class="w-12 h-12 md:w-14 md:h-14 bg-gradient-to-br from-blue-500 to-blue-700 rounded-2xl flex items-center justify-center mb-6 md:mb-8 shadow-xl shadow-blue-500/20">
                            <i class="fa-solid fa-file-waveform text-xl md:text-2xl"></i>
                        </div>
                        <h2 class="text-2xl md:text-3xl font-extrabold mb-4 leading-tight uppercase">Buat Laporan <br
                                class="hidden md:block">Gangguan</h2>
                        <p class="text-slate-400 text-xs md:text-sm leading-relaxed mb-8">
                            Lengkapi rincian gangguan pelanggan dan tuliskan tindakan teknis yang telah dilakukan.
                        </p>
                        <img src="{{ asset('svg/Scenes04.svg') }}" alt="Logo"
                            class="opacity-50 w-32 md:w-auto hidden sm:block">
                    </div>

                    <div class="relative z-10 space-y-4 mt-8 lg:mt-auto">
                        <div class="flex items-start gap-3 bg-white/5 p-4 rounded-2xl border border-white/10">
                            <i class="fa-solid fa-circle-check text-blue-400 mt-1"></i>
                            <div>
                                <p class="text-xs font-bold">Sinkronisasi Log</p>
                                <p class="text-[10px] md:text-[11px] text-slate-500">Aktivitas ini akan otomatis dicatat
                                    dalam Audit Log.</p>
                            </div>
                        </div>
                    </div>
                    <div class="absolute -bottom-10 -right-10 w-40 h-40 bg-blue-600/20 rounded-full blur-3xl"></div>
                </div>

                <div class="lg:col-span-8 p-6 md:p-10 lg:p-14">
                    <form action="{{ route('tickets.store') }}" method="POST" class="space-y-6 md:space-y-8"
                        id="ticketForm">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-8">
                            <div class="space-y-2">
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Nama
                                    Pelanggan</label>
                                <select id="select-customer" name="customer_id" required>
                                    <option value="">Pilih Pelanggan...</option>
                                    @foreach($customers as $customer)
                                        <option value="{{ $customer->id }}">{{ $customer->nama_pelanggan }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="space-y-2">
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Kategori
                                    Masalah</label>
                                <select id="select-category" name="category_id" required>
                                    <option value="">Pilih Kategori...</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->nama_kategori }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-8">
                            <div class="space-y-2">
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Pilih
                                    Petugas
                                </label></br>
                                <select id="select-pic" name="pic_id" required>
                                    <option value="">Pilih PIC...</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="space-y-2">
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">
                                    Waktu Pelaporan
                                    @if(auth()->user()->role == 'manager')
                                        <span class="text-emerald-500">(Manual)</span>
                                    @endif
                                </label>
                                <input type="datetime-local" name="waktu_mulai_manual"
                                    class="w-full bg-slate-50 border-2 border-slate-50 rounded-2xl py-3 px-4 text-sm font-bold focus:bg-white focus:border-blue-500/30 outline-none transition-all {{ auth()->user()->role != 'manager' ? 'opacity-50 cursor-not-allowed' : '' }}"
                                    {{ auth()->user()->role != 'manager' ? 'disabled' : '' }}
                                    value="{{ now()->format('Y-m-d\TH:i') }}">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-8">
                            <div class="space-y-3">
                                <label
                                    class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Prioritas</label>
                                <div class="flex gap-2">
                                    @foreach(['Low' => 'blue', 'Medium' => 'amber', 'High' => 'red' , 'Critical' => 'purple'] as $prio => $color)
                                        <label class="flex-1 cursor-pointer">
                                            <input type="radio" name="priority" value="{{ $prio }}" class="peer hidden" {{ $prio == 'Medium' ? 'checked' : '' }}>
                                            <div
                                                class="py-2.5 text-center rounded-xl border-2 border-slate-50 bg-slate-50 text-slate-400 font-bold text-[10px] transition-all peer-checked:border-{{ $color }}-500 peer-checked:bg-{{ $color }}-50 peer-checked:text-{{ $color }}-700">
                                                {{ $prio }}
                                            </div>
                                        </label>
                                    @endforeach
                                </div>
                            </div>

                            <div class="space-y-3">
                                <label
                                    class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Status</label>
                                <div class="relative">
                                    <select name="status"
                                        class="w-full bg-slate-50 border-2 border-slate-50 rounded-2xl py-3 px-4 text-sm font-bold appearance-none cursor-pointer focus:bg-white focus:border-blue-500/30 outline-none"
                                        required>
                                        <option value="Open">🔵 Open</option>
                                        <option value="In Progress">🟡 In Progress</option>
                                        <option value="Resolved">🟢 Resolved</option>
                                        <option value="Closed">🔴 Closed</option>
                                    </select>
                                    <i
                                        class="fa-solid fa-chevron-down absolute right-4 top-4 text-slate-300 text-[10px] pointer-events-none"></i>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-4">
                            <div class="space-y-2">
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Rincian
                                    Masalah</label>
                                <textarea name="rincian_masalah" rows="3"
                                    class="w-full bg-slate-50 border-2 border-slate-50 rounded-2xl focus:bg-white focus:border-blue-500/30 focus:ring-0 py-3 px-4 text-sm font-medium transition-all"
                                    placeholder="Jelaskan kendala..."></textarea>
                            </div>

                            <div class="space-y-2">
                                <label class="text-[10px] font-black text-blue-600 uppercase tracking-widest ml-1">Action
                                    Taken</label>
                                <textarea name="action_taken" rows="3"
                                    class="w-full bg-blue-50/30 border-2 border-blue-100/50 rounded-2xl focus:bg-white focus:border-blue-500/30 focus:ring-0 py-3 px-4 text-sm font-medium transition-all"
                                    placeholder="Tindakan teknisi..."></textarea>
                            </div>
                        </div>

                        <div class="flex flex-col-reverse md:flex-row items-center justify-between gap-4 pt-4">
                            <button type="button" onclick="history.back()"
                                class="w-full md:w-auto text-xs font-bold text-slate-400 hover:text-slate-900 transition-colors uppercase tracking-widest py-2">
                                Kembali
                            </button>
                            <button type="submit"
                                class="w-full md:w-auto bg-blue-600 hover:bg-blue-700 text-white px-10 py-4 rounded-2xl font-bold text-sm shadow-xl shadow-blue-500/20 transition-all flex items-center justify-center gap-3">
                                <span>SIMPAN DATA</span>
                                <i class="fa-solid fa-paper-plane"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @if(session('success'))
        @php 
            $ticket = session('new_ticket');
            $picName = $ticket->pic->name;
            $picPhone = $ticket->pic->phone;
            
            // Format Pesan WhatsApp
            $message = "Halo *$picName*, ada tugas tiket baru:\n\n"
                    . "*No Tiket:* " . $ticket->ticket_number . "\n"
                    . "*Pelanggan:* " . $ticket->customer->nama_pelanggan . "\n"
                    . "*Masalah:* " . $ticket->rincian_masalah . "\n"
                    . "*Prioritas:* " . $ticket->priority . "\n\n"
                    . "Mohon segera ditindaklanjuti. Terima kasih.";
            
            $waUrl = "https://wa.me/" . $picPhone . "?text=" . urlencode($message);
        @endphp

        <div id="successModal" class="fixed inset-0 z-[99] flex items-center justify-center p-4">
            <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm"></div>
            <div class="bg-white rounded-[2rem] md:rounded-[3rem] p-6 md:p-10 max-w-md w-full relative z-10 text-center shadow-2xl animate-in zoom-in duration-300">
                <div class="w-16 h-16 md:w-20 md:h-20 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center mx-auto mb-4 md:mb-6">
                    <i class="fa-solid fa-check text-2xl md:text-3xl"></i>
                </div>
                <h3 class="text-lg md:text-xl font-black text-slate-800 mb-2 uppercase">Tiket Berhasil Dibuat</h3>
                <p class="text-slate-500 text-xs md:text-sm mb-6 md:mb-8 leading-relaxed">
                    Nomor Tiket: <span class="font-bold text-blue-600">{{ $ticket->ticket_number }}</span><br>
                    Tugas telah diberikan kepada <b>{{ $picName }}</b>.
                </p>

                <div class="flex flex-col gap-3">
                    <a href="{{ $waUrl }}" target="_blank"
                        class="w-full bg-emerald-500 text-white py-4 rounded-2xl font-bold hover:bg-emerald-600 transition-all flex items-center justify-center gap-3 text-sm shadow-lg shadow-emerald-200">
                        <i class="fa-brands fa-whatsapp text-xl"></i> 
                        <span>NOTIFIKASI PIC (WA)</span>
                    </a>
                    
                    <button onclick="document.getElementById('successModal').remove()"
                        class="w-full bg-slate-100 text-slate-500 py-4 rounded-2xl font-bold hover:bg-slate-200 transition-all text-sm uppercase tracking-widest">
                        Selesai
                    </button>
                </div>
            </div>
        </div>
    @endif
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
    <script>
        const config = { searchEnabled: true, itemSelectText: '', allowHTML: true };
        new Choices('#select-customer', config);
        new Choices('#select-category', config);
        new Choices('#select-pic', config);
    </script>
@endpush