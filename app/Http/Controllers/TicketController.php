<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\Customer;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class TicketController extends Controller
{
    // Menampilkan Form Input
    public function create()
    {
        $customers = Customer::all();
        $categories = Category::all();
        $users = User::where('role', 'staff')->get();
        return view('ticket-create', compact('customers', 'categories', 'users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'required',
            'category_id' => 'required',
            'priority' => 'required',
            'rincian_masalah' => 'required',
            'pic_id' => 'required',
        ]);

        $ticketNumber = 'TIC-' . date('Ymd') . '-' . rand(100, 999);

        // Logika Penentuan Waktu Mulai
        $waktuMulai = now();
        // Cek jika user adalah manager dan menginputkan tanggal manual
        if (auth()->user()->role == 'manager' && $request->filled('waktu_mulai_manual')) {
            $waktuMulai = $request->waktu_mulai_manual;
        }

        $ticket = Ticket::create([
            'ticket_number' => 'TIC-' . date('Ymd') . '-' . rand(100, 999),
            'customer_id' => $request->customer_id,
            'category_id' => $request->category_id,
            'user_id' => auth()->id(),
            'pic_id' => $request->pic_id,
            'waktu_mulai' => (auth()->user()->role == 'manager' && $request->filled('waktu_mulai_manual'))
                ? $request->waktu_mulai_manual : now(),
            'rincian_masalah' => $request->rincian_masalah,
            'action_taken' => $request->action_taken,
            'status' => $request->status,
            'priority' => $request->priority,
        ]);

        // OPSI: Di sini Anda bisa menambahkan logika pengiriman WA (WhatsApp Gateway API)
        // $this->sendWhatsAppNotification($request->pic_id, $ticketNumber);

        return redirect()->back()->with([
            'success' => 'Tiket berhasil dibuat!',
            'new_ticket' => $ticket->load('pic', 'customer')
        ]);
    }

    public function index(Request $request)
    {
        $query = Ticket::with(['customer', 'category'])->latest();

        // Filter berdasarkan Status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter berdasarkan Range Tanggal (Waktu Mulai)
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('waktu_mulai', [$request->start_date . ' 00:00:00', $request->end_date . ' 23:59:59']);
        }

        // Fitur Pencarian
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('ticket_number', 'like', '%' . $request->search . '%')
                    ->orWhereHas('customer', function ($c) use ($request) {
                        $c->where('nama_pelanggan', 'like', '%' . $request->search . '%');
                    });
            });
        }

        // Aksi Export (Jika tombol download ditekan)
        if ($request->has('export')) {
            return Excel::download(new TicketsExport($query), 'laporan-gangguan.xlsx');
        }

        // Logika Paginasi
        $perPage = $request->get('per_page', 10);
        $tickets = ($perPage === 'all')
            ? $query->paginate($query->count())->withQueryString()
            : $query->paginate((int) $perPage)->withQueryString();

        return view('ticket-index', compact('tickets'));
    }

    // Update Ticket (digunakan oleh Modal Edit)
    public function update(Request $request, Ticket $ticket)
    {
        $request->validate([
            'status' => 'required',
            'action_taken' => 'nullable|string'
        ]);

        $data = [
            'status' => $request->status,
            'action_taken' => $request->action_taken,
        ];

        // Jika status diubah menjadi Resolved, catat waktu selesainya (jika ada kolomnya)
        // Atau Anda bisa menggunakan logika durasi saat runtime di View.
        if ($request->status == 'Resolved' && is_null($ticket->waktu_selesai)) {
            $data['waktu_selesai'] = now();
        }

        $ticket->update($data);

        return back()->with('success', 'Tiket #' . $ticket->ticket_number . ' berhasil diperbarui.');
    }

    // Fungsi untuk menghapus histori jika diperlukan
    public function destroy(Ticket $ticket)
    {
        $ticket->delete();
        return back()->with('success', 'Histori gangguan berhasil dihapus.');
    }
}