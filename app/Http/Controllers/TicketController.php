<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\Customer;
use App\Models\Category;
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
        return view('ticket-create', compact('customers', 'categories'));
    }

    // Menyimpan Data ke Database
    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'required',
            'category_id' => 'required',
            'priority' => 'required',
            'rincian_masalah' => 'required',
            'action_taken' => 'required', // Sesuaikan dengan nama di DB
        ]);

        $ticketNumber = 'TIC-' . date('Ymd') . '-' . rand(100, 999);

        \App\Models\Ticket::create([
            'ticket_number' => $ticketNumber,
            'customer_id' => $request->customer_id,
            'category_id' => $request->category_id,
            'user_id' => auth()->id(),
            'waktu_mulai' => now(),
            'rincian_masalah' => $request->rincian_masalah,
            'action_taken' => $request->action_taken,
            'status' => $request->status,
            'priority' => $request->priority,
        ]);

        return redirect()->route('dashboard')->with('success', 'Tiket berhasil dibuat!');
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

    // Fungsi untuk menghapus histori jika diperlukan
    public function destroy(Ticket $ticket)
    {
        $ticket->delete();
        return back()->with('success', 'Histori gangguan berhasil dihapus.');
    }
}