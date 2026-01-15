@extends('layouts.app')

@section('title', 'Kategori Masalah')
@section('page_title', 'Master Data Kategori')

@section('content')
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        <div class="lg:col-span-1">
            <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-8 sticky top-8">
                <div class="flex items-center gap-3 mb-6">
                    <div
                        class="w-10 h-10 bg-blue-600 rounded-xl flex items-center justify-center text-white shadow-lg shadow-blue-200">
                        <i class="fa-solid fa-plus"></i>
                    </div>
                    <h3 class="font-bold text-slate-800">Tambah Kategori</h3>
                </div>

                <form action="{{ route('categories.store') }}" method="POST">
                    @csrf
                    <div class="space-y-5">
                        <div>
                            <label class="text-[11px] font-black text-slate-400 uppercase tracking-widest mb-2 block">Nama
                                Kategori</label>
                            <input type="text" name="nama_kategori"
                                class="w-full bg-slate-50 border-0 rounded-2xl focus:ring-2 focus:ring-blue-500/20 py-4 px-5 text-sm font-medium"
                                placeholder="Contoh: Gangguan ONT" required>
                        </div>
                        <button type="submit"
                            class="w-full bg-slate-900 hover:bg-black text-white py-4 rounded-2xl font-bold text-sm transition-all shadow-xl shadow-slate-200">
                            Simpan Kategori
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="lg:col-span-2">
            <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
                <div class="p-8 border-b border-slate-50">
                    <h3 class="font-bold text-slate-800 text-lg">Daftar Kategori</h3>
                    <p class="text-xs text-slate-400">Total kategori yang tersedia untuk klasifikasi laporan.</p>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead class="bg-slate-50 text-[10px] font-black uppercase text-slate-400 tracking-widest">
                            <tr>
                                <th class="px-8 py-4">Nama Kategori</th>
                                <th class="px-8 py-4 text-center">Digunakan (Tiket)</th>
                                <th class="px-8 py-4 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @foreach($categories as $category)
                                <tr class="group hover:bg-slate-50/50 transition-all">
                                    <td class="px-8 py-5">
                                        <span class="font-bold text-slate-700">{{ $category->nama_kategori }}</span>
                                    </td>
                                    <td class="px-8 py-5 text-center">
                                        <span class="bg-blue-50 text-blue-600 text-[11px] font-black px-3 py-1 rounded-full">
                                            {{ $category->tickets_count }} Laporan
                                        </span>
                                    </td>
                                    <td class="px-8 py-5 text-right">
                                        <form action="{{ route('categories.destroy', $category->id) }}" method="POST"
                                            onsubmit="return confirm('Hapus kategori ini?')">
                                            @csrf @method('DELETE')
                                            <button class="text-slate-300 hover:text-red-600 transition-colors">
                                                <i class="fa-solid fa-trash-can"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection