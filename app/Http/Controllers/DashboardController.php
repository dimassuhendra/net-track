<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\Customer;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Menghitung jumlah berdasarkan status di tabel tickets
        $countOpen = Ticket::where('status', 'Open')->count();
        $countProgress = Ticket::where('status', 'In Progress')->count();
        $countResolvedToday = Ticket::where('status', 'Resolved')
                                    ->whereDate('updated_at', today())
                                    ->count();
        
        // Menghitung total pelanggan
        $totalCustomers = Customer::count();

        // Mengambil 5 tiket terbaru dengan relasi customer & category
        $recentTickets = Ticket::with(['customer', 'category'])
                                ->latest()
                                ->limit(5)
                                ->get();

        return view('dashboard.index', compact(
            'countOpen', 
            'countProgress', 
            'countResolvedToday', 
            'totalCustomers',
            'recentTickets'
        ));
    }
}