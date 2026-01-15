@extends('layouts.app')

@section('title', 'Data Pelanggan')
@section('page_title', 'Database Pelanggan')

@section('content')
    <div class="space-y-8" x-data="{ openEdit: false, currentCustomer: {} }">

        <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-8">
            <div class="flex items-center gap-4 mb-6">
                <div
                    class="w-12 h-12 bg-emerald-500 text-white rounded-2xl flex items-center justify-center shadow-lg shadow-emerald-200">
                    <i class="fa-solid fa-user-plus text-lg"></i>
                </div>
                <div>
                    <h3 class="font-bold text-slate-800">Registrasi Pelanggan Baru</h3>
                    <p class="text-xs text-slate-400">Lengkapi data termasuk kontak untuk kemudahan koordinasi.</p>
                </div>
            </div>

            <form action="{{ route('customers.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-5 gap-4">
                @csrf
                <div>
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 block">SID</label>
                    <input type="text" name="customer_id"
                        class="w-full bg-slate-50 border-0 rounded-xl py-3 px-4 text-sm font-medium focus:ring-2 focus:ring-emerald-500/20"
                        placeholder="SID-123" required>
                </div>
                <div>
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 block">Nama</label>
                    <input type="text" name="nama_pelanggan"
                        class="w-full bg-slate-50 border-0 rounded-xl py-3 px-4 text-sm font-medium focus:ring-2 focus:ring-emerald-500/20"
                        placeholder="Nama Pelanggan" required>
                </div>
                <div>
                    <label
                        class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 block">Layanan</label>
                    <input type="text" name="layanan"
                        class="w-full bg-slate-50 border-0 rounded-xl py-3 px-4 text-sm font-medium focus:ring-2 focus:ring-emerald-500/20"
                        placeholder="Contoh: Broadband" required>
                </div>
                <div>
                    <label
                        class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 block">Kontak/WhatsApp</label>
                    <input type="text" name="kontak"
                        class="w-full bg-slate-50 border-0 rounded-xl py-3 px-4 text-sm font-medium focus:ring-2 focus:ring-emerald-500/20"
                        placeholder="0812xxx">
                </div>
                <div class="flex items-end">
                    <button type="submit"
                        class="w-full bg-emerald-500 hover:bg-emerald-600 text-white py-3 rounded-xl font-bold text-sm transition-all shadow-lg shadow-emerald-100">
                        Simpan
                    </button>
                </div>
            </form>
        </div>

        <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
            <table class="w-full text-left border-collapse">
                <thead class="bg-slate-50 text-[10px] font-black uppercase text-slate-400 tracking-widest">
                    <tr>
                        <th class="px-8 py-5">ID & Nama</th>
                        <th class="px-8 py-5">Layanan</th>
                        <th class="px-8 py-5">Kontak</th>
                        <th class="px-8 py-5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @foreach($customers as $customer)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-8 py-5">
                                <div class="font-bold text-slate-800">{{ $customer->nama_pelanggan }}</div>
                                <div class="text-[11px] text-blue-500 font-mono italic">{{ $customer->customer_id }}</div>
                            </td>
                            <td class="px-8 py-5 text-sm font-medium text-slate-600">{{ $customer->layanan }}</td>
                            <td class="px-8 py-5 text-sm text-slate-600 font-bold text-emerald-600">
                                {{ $customer->kontak ?? '-' }}
                            </td>
                            <td class="px-8 py-5 text-right flex justify-end gap-3">
                                <button @click="openEdit = true; currentCustomer = { 
                                            id: '{{ $customer->id }}', 
                                            customer_id: '{{ $customer->customer_id }}', 
                                            nama_pelanggan: '{{ $customer->nama_pelanggan }}', 
                                            layanan: '{{ $customer->layanan }}', 
                                            kontak: '{{ $customer->kontak }}', 
                                            alamat: '{{ addslashes($customer->alamat) }}' 
                                        };" class="text-blue-400 hover:text-blue-600 transition-colors">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </button>

                                <form action="{{ route('customers.destroy', $customer->id) }}" method="POST"
                                    onsubmit="return confirm('Hapus pelanggan?')">
                                    @csrf @method('DELETE')
                                    <button class="text-slate-300 hover:text-red-500 transition-colors">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div x-show="openEdit" class="fixed inset-0 z-50 overflow-y-auto" x-cloak>
            <div class="flex items-center justify-center min-h-screen px-4">
                <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity" @click="openEdit = false">
                </div>

                <div class="relative bg-white rounded-[2.5rem] w-full max-w-lg p-10 shadow-2xl"
                    @click.away="openEdit = false">
                    <div class="flex justify-between items-center mb-8">
                        <h3 class="text-xl font-black text-slate-800 uppercase tracking-tight">Edit Pelanggan</h3>
                        <button @click="openEdit = false" class="text-slate-400 hover:text-slate-600">
                            <i class="fa-solid fa-xmark text-xl"></i>
                        </button>
                    </div>

                    <form :action="'{{ url('customers') }}/' + currentCustomer.id" method="POST" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <div>
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 block">SID /
                                Customer ID</label>
                            <input type="text" name="customer_id" x-model="currentCustomer.customer_id"
                                class="w-full bg-slate-50 border-0 rounded-2xl py-4 px-5 text-sm font-bold focus:ring-2 focus:ring-blue-500/20">
                        </div>

                        <div>
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 block">Nama
                                Pelanggan</label>
                            <input type="text" name="nama_pelanggan" x-model="currentCustomer.nama_pelanggan"
                                class="w-full bg-slate-50 border-0 rounded-2xl py-4 px-5 text-sm font-bold focus:ring-2 focus:ring-blue-500/20">
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label
                                    class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 block">Layanan</label>
                                <input type="text" name="layanan" x-model="currentCustomer.layanan"
                                    class="w-full bg-slate-50 border-0 rounded-2xl py-4 px-5 text-sm font-bold focus:ring-2 focus:ring-blue-500/20">
                            </div>
                            <div>
                                <label
                                    class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 block">Kontak</label>
                                <input type="text" name="kontak" x-model="currentCustomer.kontak"
                                    class="w-full bg-slate-50 border-0 rounded-2xl py-4 px-5 text-sm font-bold focus:ring-2 focus:ring-blue-500/20">
                            </div>
                        </div>

                        <div>
                            <label
                                class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 block">Alamat</label>
                            <textarea name="alamat" x-model="currentCustomer.alamat" rows="3"
                                class="w-full bg-slate-50 border-0 rounded-2xl py-4 px-5 text-sm font-bold focus:ring-2 focus:ring-blue-500/20"></textarea>
                        </div>

                        <button type="submit"
                            class="w-full bg-blue-600 hover:bg-blue-700 text-white py-4 rounded-2xl font-bold shadow-xl shadow-blue-100 transition-all">
                            Update Data Pelanggan
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
@endsection