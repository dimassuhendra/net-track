<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\Customer;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
            'action_taken' => $request->action_taken, // Pakai nama kolom action_taken
            'status' => 'Open',
            'priority' => $request->priority,
        ]);

        return redirect()->route('dashboard')->with('success', 'Tiket berhasil dibuat!');
    }
}