@extends('layouts.app')

@section('title', 'Input Gangguan')
@section('page_title', 'Reporting System')

@section('content')
<div class="max-w-5xl mx-auto">
    <div class="flex items-center gap-2 text-slate-400 text-xs mb-6 font-medium">
        <a href="/dashboard" class="hover:text-blue-600 transition-colors">DASHBOARD</a>
        <i class="fa-solid fa-chevron-right text-[8px]"></i>
        <span class="text-slate-600 uppercase">Input Tiket Baru</span>
    </div>

    <div class="bg-white rounded-[2.5rem] shadow-2xl shadow-slate-200/50 border border-slate-100 overflow-hidden">
        <div class="grid grid-cols-1 lg:grid-cols-12">
            
            <div class="lg:col-span-4 bg-slate-900 p-12 text-white relative">
                <div class="relative z-10">
                    <div class="w-14 h-14 bg-gradient-to-br from-blue-500 to-blue-700 rounded-2xl flex items-center justify-center mb-8 shadow-xl shadow-blue-500/20">
                        <i class="fa-solid fa-file-waveform text-2xl"></i>
                    </div>
                    <h2 class="text-3xl font-extrabold mb-4 leading-tight">Buat Laporan <br>Gangguan</h2>
                    <p class="text-slate-400 text-sm leading-relaxed mb-8">
                        Lengkapi rincian gangguan pelanggan dan tuliskan tindakan teknis yang telah dilakukan di lapangan atau melalui sistem.
                    </p>

                    <div class="space-y-4">
                        <div class="flex items-start gap-3 bg-white/5 p-4 rounded-2xl border border-white/10">
                            <i class="fa-solid fa-circle-check text-blue-400 mt-1"></i>
                            <div>
                                <p class="text-xs font-bold">Validasi Data</p>
                                <p class="text-[11px] text-slate-500">Pastikan ID Pelanggan sudah sesuai sebelum submit.</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="absolute bottom-0 right-0 w-32 h-32 bg-blue-600/10 rounded-full blur-3xl"></div>
            </div>

            <div class="lg:col-span-8 p-10 md:p-14">
                <form action="{{ route('tickets.store') }}" method="POST" class="space-y-8">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Pelanggan</label>
                            <div class="relative">
                                <select name="customer_id" class="w-full bg-slate-50 border-2 border-slate-50 rounded-2xl focus:bg-white focus:border-blue-500/30 focus:ring-0 py-4 px-5 text-sm font-semibold transition-all appearance-none cursor-pointer" required>
                                    <option value="">Cari Nama Pelanggan...</option>
                                    @foreach($customers as $customer)
                                        <option value="{{ $customer->id }}">{{ $customer->nama_pelanggan }}</option>
                                    @endforeach
                                </select>
                                <i class="fa-solid fa-chevron-down absolute right-5 top-5 text-slate-300 text-xs pointer-events-none"></i>
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Kategori Masalah</label>
                            <div class="relative">
                                <select name="category_id" class="w-full bg-slate-50 border-2 border-slate-50 rounded-2xl focus:bg-white focus:border-blue-500/30 focus:ring-0 py-4 px-5 text-sm font-semibold transition-all appearance-none cursor-pointer" required>
                                    <option value="">Pilih Kategori...</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->nama_kategori }}</option>
                                    @endforeach
                                </select>
                                <i class="fa-solid fa-chevron-down absolute right-5 top-5 text-slate-300 text-xs pointer-events-none"></i>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-3">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Tingkat Prioritas</label>
                        <div class="flex flex-wrap gap-4">
                            @foreach(['Low' => 'blue', 'Medium' => 'amber', 'High' => 'red'] as $prio => $color)
                            <label class="flex-1 min-w-[100px] cursor-pointer group">
                                <input type="radio" name="priority" value="{{ $prio }}" class="peer hidden" {{ $prio == 'Low' ? 'checked' : '' }}>
                                <div class="p-3 text-center rounded-xl border-2 border-slate-50 bg-slate-50 text-slate-400 font-bold text-xs transition-all peer-checked:border-{{ $color }}-500 peer-checked:bg-{{ $color }}-50 peer-checked:text-{{ $color }}-700 group-hover:border-slate-200">
                                    {{ $prio }}
                                </div>
                            </label>
                            @endforeach
                        </div>
                    </div>

                    <div class="space-y-6">
                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Rincian Masalah</label>
                            <textarea name="rincian_masalah" rows="3" class="w-full bg-slate-50 border-2 border-slate-50 rounded-2xl focus:bg-white focus:border-blue-500/30 focus:ring-0 py-4 px-5 text-sm font-medium transition-all" placeholder="Jelaskan kendala yang dialami pelanggan..."></textarea>
                        </div>

                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-blue-600 uppercase tracking-widest ml-1">Tindakan Petugas (Action Taken)</label>
                            <textarea name="action_taken" rows="3" class="w-full bg-blue-50/30 border-2 border-blue-100/50 rounded-2xl focus:bg-white focus:border-blue-500/30 focus:ring-0 py-4 px-5 text-sm font-medium transition-all" placeholder="Contoh: Mengganti connector RJ45 dan melakukan reset ONT. Link kembali UP."></textarea>
                        </div>
                    </div>

                    <div class="flex items-center justify-between pt-6">
                        <button type="button" onclick="history.back()" class="text-xs font-bold text-slate-400 hover:text-slate-900 transition-colors uppercase tracking-widest">Kembali</button>
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-12 py-4 rounded-2xl font-bold text-sm shadow-xl shadow-blue-500/20 transition-all hover:scale-[1.02] active:scale-95 flex items-center gap-3">
                            <span>SUBMIT TIKET</span>
                            <i class="fa-solid fa-arrow-right-long"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection