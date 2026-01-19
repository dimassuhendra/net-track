<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\Customer;
use App\Models\Category;
use App\Models\User;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Exports\TicketsExport;
use Maatwebsite\Excel\Facades\Excel;

class TicketController extends Controller
{
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
            'status' => $request->status ?? 'Open',
            'priority' => $request->priority,
        ]);

        // NOTIFIKASI STAFF (PIC)
        Notification::create([
            'user_id' => $request->pic_id,
            'title' => 'PENUGASAN TIKET BARU',
            'message' => "Halo, Anda ditugaskan menangani Tiket #" . $ticket->ticket_number . " (" . $ticket->customer->nama_pelanggan . ")",
            'type' => 'assignment'
        ]);

        return redirect()->back()->with([
            'success' => 'Tiket berhasil dibuat!',
            'new_ticket' => $ticket->load('pic', 'customer')
        ]);
    }

    public function index(Request $request)
    {
        $query = Ticket::with(['customer', 'category'])->latest();

        if ($request->filled('status'))
            $query->where('status', $request->status);
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('waktu_mulai', [$request->start_date . ' 00:00:00', $request->end_date . ' 23:59:59']);
        }

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('ticket_number', 'like', '%' . $request->search . '%')
                    ->orWhereHas('customer', function ($c) use ($request) {
                        $c->where('nama_pelanggan', 'like', '%' . $request->search . '%');
                    });
            });
        }

        if ($request->has('export')) {
            return Excel::download(new TicketsExport($query, $request->start_date, $request->end_date), 'laporan-gangguan.xlsx');
        }

        $perPage = $request->get('per_page', 10);
        $tickets = ($perPage === 'all') ? $query->paginate($query->count()) : $query->paginate((int) $perPage);

        return view('ticket-index', compact('tickets'));
    }

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

        if ($request->status == 'Resolved' && is_null($ticket->waktu_selesai)) {
            $data['waktu_selesai'] = now();
        }

        $ticket->update($data);
        return back()->with('success', 'Tiket #' . $ticket->ticket_number . ' diperbarui.');
    }

    public function destroy(Ticket $ticket)
    {
        $ticket->delete();
        return back()->with('success', 'Histori berhasil dihapus.');
    }
}