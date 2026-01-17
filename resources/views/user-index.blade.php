@extends('layouts.app')

@section('content')
    <div class="space-y-6">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="text-2xl font-black text-slate-800 uppercase">Manajemen Petugas</h2>
                <p class="text-sm text-slate-500">Kelola akses staff, PIC, dan pimpinan sistem.</p>
            </div>
            <button onclick="openAddModal()"
                class="bg-blue-600 text-white px-6 py-3 rounded-2xl font-bold text-sm shadow-lg shadow-blue-100 hover:bg-blue-700 transition-all">
                + Tambah User
            </button>
        </div>

        <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden">
            <table class="w-full text-left border-collapse">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Pegawai</th>
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Kontak & Role
                        </th>
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest text-center">
                            Statistik Tiket</th>
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">
                            Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @foreach($users as $user)
                        <tr class="hover:bg-slate-50/50 transition-all">
                            <td class="px-8 py-5">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-2xl flex items-center justify-center font-bold shadow-sm
                                        {{ $user->role == 'gm' ? 'bg-purple-100 text-purple-600' : '' }}
                                        {{ $user->role == 'manager' ? 'bg-blue-100 text-blue-600' : '' }}
                                        {{ $user->role == 'admin' ? 'bg-amber-100 text-amber-600' : '' }}
                                        {{ $user->role == 'staff' ? 'bg-slate-100 text-slate-600' : '' }}">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <p class="text-sm font-bold text-slate-700 leading-none mb-1">{{ $user->name }}</p>
                                        <p class="text-[10px] font-medium uppercase tracking-tighter
                                            {{ $user->role == 'gm' ? 'text-purple-500' : 'text-slate-400' }}">
                                            {{ $user->role }}
                                        </p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-8 py-5">
                                <p class="text-sm text-slate-600 font-medium">{{ $user->email }}</p>
                                <p class="text-xs text-emerald-600 font-bold"><i
                                        class="fa-brands fa-whatsapp mr-1"></i>{{ $user->phone ?? '-' }}</p>
                            </td>
                            <td class="px-8 py-5">
                                <div class="flex items-center justify-center gap-4">
                                    <div class="text-center">
                                        <p class="text-xs font-black text-slate-700">{{ $user->report_count }}</p>
                                        <p class="text-[9px] text-slate-400 uppercase font-bold">Input</p>
                                    </div>
                                    <div class="w-[1px] h-6 bg-slate-100"></div>
                                    <div class="text-center">
                                        <p class="text-xs font-black text-blue-600">{{ $user->pic_count }}</p>
                                        <p class="text-[9px] text-slate-400 uppercase font-bold">PIC</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-8 py-5 text-right">
                                <div class="flex justify-end gap-2">
                                    <button onclick="editUser({{ $user }})"
                                        class="p-2 text-blue-500 hover:bg-blue-50 rounded-xl transition-colors">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </button>
                                    @if($user->id !== auth()->id())
                                        <form action="{{ route('users.destroy', $user) }}" method="POST"
                                            id="delete-form-{{ $user->id }}">
                                            @csrf @method('DELETE')
                                            <button type="button" onclick="confirmDelete({{ $user->id }})"
                                                class="p-2 text-red-400 hover:bg-red-50 rounded-xl transition-colors">
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

    <div id="userModal"
        class="hidden fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 flex items-center justify-center p-4">
        <div
            class="bg-white rounded-[2.5rem] w-full max-w-lg overflow-hidden shadow-2xl animate-in fade-in zoom-in duration-200">
            <div class="p-8 border-b border-slate-50 flex justify-between items-center bg-slate-50/50">
                <h3 id="modalTitle" class="font-black text-xl text-slate-800 uppercase tracking-tight">Tambah Petugas</h3>
                <button onclick="toggleModal('userModal')" class="text-slate-400 hover:text-slate-600">
                    <i class="fa-solid fa-xmark text-xl"></i>
                </button>
            </div>

            <form id="userForm" action="{{ route('users.store') }}" method="POST" class="p-8 space-y-5">
                @csrf
                <div id="methodField"></div>
                <div class="grid grid-cols-2 gap-4">
                    <div class="col-span-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase mb-2 block ml-1">Nama Lengkap</label>
                        <input type="text" name="name" id="formName"
                            class="w-full bg-slate-50 border-2 border-slate-50 rounded-2xl px-5 py-3 text-sm focus:bg-white focus:border-blue-500/20 outline-none transition-all"
                            placeholder="Nama Pegawai" required>
                    </div>
                    <div>
                        <label class="text-[10px] font-black text-slate-400 uppercase mb-2 block ml-1">Email</label>
                        <input type="email" name="email" id="formEmail"
                            class="w-full bg-slate-50 border-2 border-slate-50 rounded-2xl px-5 py-3 text-sm focus:bg-white focus:border-blue-500/20 outline-none transition-all"
                            placeholder="email@perusahaan.com" required>
                    </div>
                    <div>
                        <label class="text-[10px] font-black text-slate-400 uppercase mb-2 block ml-1">WhatsApp
                            (628xxx)</label>
                        <input type="number" name="phone" id="formPhone"
                            class="w-full bg-slate-50 border-2 border-slate-50 rounded-2xl px-5 py-3 text-sm focus:bg-white focus:border-blue-500/20 outline-none transition-all"
                            placeholder="62812..." required>
                    </div>
                    <div class="col-span-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase mb-2 block ml-1">Role Akses</label>
                        <select name="role" id="formRole"
                            class="w-full bg-slate-50 border-2 border-slate-50 rounded-2xl px-5 py-3 text-sm focus:bg-white focus:border-blue-500/20 outline-none transition-all appearance-none cursor-pointer"
                            required>
                            <option value="staff">Staff (Teknisi / PIC)</option>
                            <option value="manager">Manager IT</option>
                            <option value="gm">General Manager</option>
                            <option value="admin">Administrator</option>
                        </select>
                    </div>
                </div>

                <div class="bg-blue-50/50 p-6 rounded-[2rem] border border-blue-100/50 space-y-4">
                    <p class="text-[9px] font-black text-blue-600 uppercase tracking-widest flex items-center gap-2">
                        <i class="fa-solid fa-shield-halved"></i> Kredensial Login
                    </p>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="text-[10px] font-black text-slate-400 uppercase mb-2 block ml-1">Password</label>
                            <input type="password" name="password" id="formPassword"
                                class="w-full bg-white border-0 rounded-xl px-4 py-2 text-sm focus:ring-2 focus:ring-blue-500/20 shadow-sm">
                        </div>
                        <div>
                            <label
                                class="text-[10px] font-black text-slate-400 uppercase mb-2 block ml-1">Konfirmasi</label>
                            <input type="password" name="password_confirmation" id="formConfirm"
                                class="w-full bg-white border-0 rounded-xl px-4 py-2 text-sm focus:ring-2 focus:ring-blue-500/20 shadow-sm">
                        </div>
                    </div>
                    <p id="pwHint" class="hidden text-[9px] text-blue-400 italic font-medium leading-tight">
                        * Kosongkan jika tidak ingin mengubah password saat mode edit.
                    </p>
                </div>

                <div class="flex gap-3 pt-2">
                    <button type="button" onclick="toggleModal('userModal')"
                        class="flex-1 py-4 font-bold text-slate-400 hover:text-slate-600 transition-colors uppercase text-[10px] tracking-widest">
                        Batal
                    </button>
                    <button type="submit"
                        class="flex-[2] bg-blue-600 text-white py-4 rounded-2xl font-bold shadow-xl shadow-blue-200 hover:bg-blue-700 transition-all uppercase text-[10px] tracking-widest flex items-center justify-center gap-2">
                        <span>Simpan Petugas</span>
                        <i class="fa-solid fa-paper-plane"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>

    @if(session('success'))
        <div id="notifModal" class="fixed inset-0 z-[100] flex items-center justify-center p-4">
            <div class="absolute inset-0 bg-slate-900/40 backdrop-blur-sm"></div>
            <div
                class="bg-white rounded-[2.5rem] p-10 max-w-sm w-full relative z-10 text-center shadow-2xl animate-in fade-in zoom-in duration-300">

                <img src="{{ asset('svg/Character03.svg') }}" alt="Success Illustration">

                <h3 class="text-xl font-black text-slate-800 mb-2 uppercase">Berhasil!</h3>
                <p class="text-slate-500 text-sm mb-8 leading-relaxed">{{ session('success') }}</p>
                <button onclick="document.getElementById('notifModal').remove()"
                    class="w-full bg-slate-900 text-white py-4 rounded-2xl font-bold hover:bg-black transition-all uppercase text-xs">Mantap</button>
            </div>
        </div>
    @endif

    <script>
        function toggleModal(id) {
            const modal = document.getElementById(id);
            modal.classList.toggle('hidden');
        }

        // Fungsi khusus saat tombol "+ Tambah Petugas" diklik
        // Kita panggil dari HTML: onclick="openAddModal()"
        function openAddModal() {
            // Reset Judul & Action Form
            document.getElementById('modalTitle').innerText = 'Tambah Petugas Baru';
            document.getElementById('userForm').action = "{{ route('users.store') }}";
            document.getElementById('methodField').innerHTML = ''; // Hapus @method('PUT')

            // Reset Input
            document.getElementById('userForm').reset();

            // Aturan Password: Wajib diisi saat tambah baru
            document.getElementById('formPassword').required = true;
            document.getElementById('formConfirm').required = true;
            document.getElementById('pwHint').classList.add('hidden');

            toggleModal('userModal');
        }

        function editUser(user) {
            document.getElementById('modalTitle').innerText = 'Edit Data Petugas';
            document.getElementById('userForm').action = `/users/${user.id}`;
            document.getElementById('methodField').innerHTML = '@method("PUT")';

            // Isi Data
            document.getElementById('formName').value = user.name;
            document.getElementById('formEmail').value = user.email;
            document.getElementById('formPhone').value = user.phone || '';
            document.getElementById('formRole').value = user.role;

            // Aturan Password: Opsional saat edit
            document.getElementById('formPassword').required = false;
            document.getElementById('formConfirm').required = false;
            document.getElementById('pwHint').classList.remove('hidden');

            toggleModal('userModal');
        }

        function confirmDelete(id) {
            if (confirm('Hapus petugas ini? Data histori tiket akan tetap ada namun nama penginput mungkin terhapus.')) {
                document.getElementById('delete-form-' + id).submit();
            }
        }
    </script>
@endsection