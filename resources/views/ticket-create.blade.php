@extends('layouts.app')

@section('title', 'Input Gangguan')
@section('page_title', 'Reporting System')

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css" />
    <style>
        /* Custom Style untuk memperbaiki Dropdown agar selaras dengan desain Anda */
        .choices__inner {
            background-color: #f8fafc !important;
            /* slate-50 */
            border: 2px solid #f8fafc !important;
            border-radius: 1rem !important;
            padding: 0.75rem 1.25rem !important;
            min-height: 58px !important;
        }

        .choices__list--dropdown {
            border-radius: 1rem !important;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1) !important;
            border: 1px solid #f1f5f9 !important;
            padding: 0.5rem !important;
        }

        .choices__item--selectable {
            border-radius: 0.5rem !important;
            margin-bottom: 2px !important;
        }
    </style>
@endpush

@section('content')
    <div class="max-w-5xl mx-auto">
        <div class="flex items-center gap-2 text-slate-400 text-xs mb-6 font-medium">
            <a href="/dashboard" class="hover:text-blue-600 transition-colors uppercase">DASHBOARD</a>
            <i class="fa-solid fa-chevron-right text-[8px]"></i>
            <span class="text-slate-600 uppercase">Input Tiket Baru</span>
        </div>

        <div class="bg-white rounded-[2.5rem] shadow-2xl shadow-slate-200/50 border border-slate-100 overflow-hidden">
            <div class="grid grid-cols-1 lg:grid-cols-12">

                <div class="lg:col-span-4 bg-slate-900 p-12 text-white relative overflow-hidden">
                    <div class="relative z-10">
                        <div
                            class="w-14 h-14 bg-gradient-to-br from-blue-500 to-blue-700 rounded-2xl flex items-center justify-center mb-8 shadow-xl shadow-blue-500/20">
                            <i class="fa-solid fa-file-waveform text-2xl"></i>
                        </div>
                        <h2 class="text-3xl font-extrabold mb-4 leading-tight uppercase">Buat Laporan <br>Gangguan</h2>
                        <p class="text-slate-400 text-sm leading-relaxed mb-8">
                            Lengkapi rincian gangguan pelanggan dan tuliskan tindakan teknis yang telah dilakukan.
                        </p>

                        <div class="space-y-4">
                            <div class="flex items-start gap-3 bg-white/5 p-4 rounded-2xl border border-white/10">
                                <i class="fa-solid fa-circle-check text-blue-400 mt-1"></i>
                                <div>
                                    <p class="text-xs font-bold">Sinkronisasi Log</p>
                                    <p class="text-[11px] text-slate-500">Aktivitas ini akan otomatis dicatat dalam Audit
                                        Log.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="absolute -bottom-10 -right-10 w-40 h-40 bg-blue-600/20 rounded-full blur-3xl"></div>
                </div>

                <div class="lg:col-span-8 p-10 md:p-14">
                    <form action="{{ route('tickets.store') }}" method="POST" class="space-y-8" id="ticketForm">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div class="space-y-2">
                                <label
                                    class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Pelanggan</label>
                                <select id="select-customer" name="customer_id" required>
                                    <option value="">Cari Nama Pelanggan...</option>
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

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div class="space-y-3">
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Tingkat
                                    Prioritas</label>
                                <div class="flex gap-2">
                                    @foreach(['Low' => 'blue', 'Medium' => 'amber', 'High' => 'red'] as $prio => $color)
                                        <label class="flex-1 cursor-pointer group">
                                            <input type="radio" name="priority" value="{{ $prio }}" class="peer hidden" {{ $prio == 'Medium' ? 'checked' : '' }}>
                                            <div
                                                class="py-2 text-center rounded-xl border-2 border-slate-50 bg-slate-50 text-slate-400 font-bold text-[10px] transition-all peer-checked:border-{{ $color }}-500 peer-checked:bg-{{ $color }}-50 peer-checked:text-{{ $color }}-700">
                                                {{ $prio }}
                                            </div>
                                        </label>
                                    @endforeach
                                </div>
                            </div>

                            <div class="space-y-3">
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Status
                                    Laporan</label>
                                <div class="relative">
                                    <select name="status"
                                        class="w-full bg-slate-50 border-2 border-slate-50 rounded-2xl py-3 px-5 text-sm font-bold appearance-none cursor-pointer focus:bg-white focus:border-blue-500/30 outline-none"
                                        required>
                                        <option value="Open">🔵 Open (Baru)</option>
                                        <option value="In Progress">🟡 In Progress</option>
                                        <option value="Resolved">🟢 Resolved (Selesai)</option>
                                        <option value="Closed">🔴 Closed</option>
                                    </select>
                                    <i
                                        class="fa-solid fa-chevron-down absolute right-5 top-4 text-slate-300 text-[10px] pointer-events-none"></i>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-6">
                            <div class="space-y-2">
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Rincian
                                    Masalah</label>
                                <textarea name="rincian_masalah" rows="3"
                                    class="w-full bg-slate-50 border-2 border-slate-50 rounded-2xl focus:bg-white focus:border-blue-500/30 focus:ring-0 py-4 px-5 text-sm font-medium transition-all"
                                    placeholder="Jelaskan kendala yang dialami..."></textarea>
                            </div>

                            <div class="space-y-2">
                                <label class="text-[10px] font-black text-blue-600 uppercase tracking-widest ml-1">Tindakan
                                    Petugas (Action Taken)</label>
                                <textarea name="action_taken" rows="3"
                                    class="w-full bg-blue-50/30 border-2 border-blue-100/50 rounded-2xl focus:bg-white focus:border-blue-500/30 focus:ring-0 py-4 px-5 text-sm font-medium transition-all"
                                    placeholder="Apa yang sudah dikerjakan teknisi?"></textarea>
                            </div>
                        </div>

                        <div class="flex items-center justify-between pt-6">
                            <button type="button" onclick="history.back()"
                                class="text-xs font-bold text-slate-400 hover:text-slate-900 transition-colors uppercase tracking-widest">Kembali</button>
                            <button type="submit"
                                class="bg-blue-600 hover:bg-blue-700 text-white px-12 py-4 rounded-2xl font-bold text-sm shadow-xl shadow-blue-500/20 transition-all hover:scale-[1.02] active:scale-95 flex items-center gap-3">
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
        <div id="successModal" class="fixed inset-0 z-[99] flex items-center justify-center p-4">
            <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm"></div>
            <div
                class="bg-white rounded-[3rem] p-10 max-w-sm w-full relative z-10 text-center shadow-2xl scale-100 transition-all">
                <div
                    class="w-20 h-20 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fa-solid fa-check text-3xl"></i>
                </div>
                <h3 class="text-xl font-black text-slate-800 mb-2 uppercase">Tiket Berhasil Dibuat!</h3>
                <p class="text-slate-500 text-sm mb-8 leading-relaxed">Data laporan telah masuk ke sistem dan tercatat di
                    riwayat aktivitas.</p>
                <button onclick="document.getElementById('successModal').remove()"
                    class="w-full bg-slate-900 text-white py-4 rounded-2xl font-bold hover:bg-black transition-all">
                    LANJUTKAN
                </button>
            </div>
        </div>
    @endif

@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
    <script>
        // Inisialisasi Dropdown dengan Choices.js
        const customerSelect = new Choices('#select-customer', { searchEnabled: true, itemSelectText: '' });
        const categorySelect = new Choices('#select-category', { searchEnabled: true, itemSelectText: '' });
    </script>
@endpush