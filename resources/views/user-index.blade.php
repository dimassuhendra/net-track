@extends('layouts.app')

@section('content')
    <div class="space-y-6">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="text-2xl font-black text-slate-800">Manajemen Petugas</h2>
                <p class="text-sm text-slate-500">Kelola akses staff dan admin sistem.</p>
            </div>
            <button onclick="toggleModal('addUser')"
                class="bg-blue-600 text-white px-6 py-3 rounded-2xl font-bold text-sm shadow-lg shadow-blue-100 hover:bg-blue-700 transition-all">
                + Tambah Petugas
            </button>
        </div>

        <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden">
            <table class="w-full text-left">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Nama Pegawai
                        </th>
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Role
                        </th>
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Email</th>
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Dibuat Pada
                        </th>
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">
                            Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @foreach($users as $user)
                        <tr class="hover:bg-slate-50/50 transition-all">
                            <td class="px-8 py-5">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-9 h-9 rounded-full bg-slate-100 flex items-center justify-center font-bold text-slate-500 text-xs">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                    <span class="text-sm font-bold text-slate-700">{{ $user->name }}</span>
                                </div>
                            </td>
                            <td class="px-8 py-5 text-sm text-slate-500">{{ $user->role }}</td>
                            <td class="px-8 py-5 text-sm text-slate-500">{{ $user->email }}</td>
                            <td class="px-8 py-5 text-xs text-slate-400">{{ $user->created_at->format('d M Y') }}</td>
                            <td class="px-8 py-5 text-right">
                                <div class="flex justify-end gap-2">
                                    <button class="p-2 text-blue-500 hover:bg-blue-50 rounded-lg transition-colors">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </button>
                                    @if($user->id !== auth()->id())
                                        <form action="{{ route('users.destroy', $user) }}" method="POST"
                                            onsubmit="return confirm('Hapus user ini?')">
                                            @csrf @method('DELETE')
                                            <button class="p-2 text-red-500 hover:bg-red-50 rounded-lg transition-colors">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div id="addUser" class="hidden fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-50 flex items-center justify-center">
        <div class="bg-white p-8 rounded-[2.5rem] w-full max-w-md">
            <h3 class="font-black text-xl mb-6">Tambah Petugas</h3>
            <form action="{{ route('users.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="text-[10px] font-black text-slate-400 uppercase block mb-2">Nama Lengkap</label>
                    <input type="text" name="name"
                        class="w-full bg-slate-50 border-0 rounded-2xl px-5 py-3 text-sm focus:ring-2 focus:ring-blue-500/20"
                        required>
                </div>
                <div>
                    <label class="text-[10px] font-black text-slate-400 uppercase block mb-2">Email</label>
                    <input type="email" name="email"
                        class="w-full bg-slate-50 border-0 rounded-2xl px-5 py-3 text-sm focus:ring-2 focus:ring-blue-500/20"
                        required>
                </div>
                <div>
                    <label class="text-[10px] font-black text-slate-400 uppercase block mb-2">Password</label>
                    <input type="password" name="password"
                        class="w-full bg-slate-50 border-0 rounded-2xl px-5 py-3 text-sm focus:ring-2 focus:ring-blue-500/20"
                        required>
                </div>
                <div>
                    <label class="text-[10px] font-black text-slate-400 uppercase block mb-2">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation"
                        class="w-full bg-slate-50 border-0 rounded-2xl px-5 py-3 text-sm focus:ring-2 focus:ring-blue-500/20"
                        required>
                </div>
                <div class="flex gap-3 pt-4">
                    <button type="button" onclick="toggleModal('addUser')"
                        class="flex-1 py-3 font-bold text-slate-400">Batal</button>
                    <button type="submit"
                        class="flex-1 bg-blue-600 text-white py-3 rounded-2xl font-bold shadow-lg shadow-blue-100">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function toggleModal(id) {
            const modal = document.getElementById(id);
            modal.classList.toggle('hidden');
        }
    </script>
@endsection