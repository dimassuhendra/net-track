<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\Customer;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $countOpen = Ticket::where('status', 'Open')->count();
        $countProgress = Ticket::where('status', 'In Progress')->count();
        $countResolvedToday = Ticket::where('status', 'Resolved')->whereDate('updated_at', today())->count();
        $totalCustomers = Customer::count();
        $recentTickets = Ticket::with(['customer', 'category'])->latest()->limit(5)->get();

        // Data 1: Tren Gangguan 7 Hari Terakhir
        $trendData = Ticket::select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as total'))
            ->where('created_at', '>=', now()->subDays(6))
            ->groupBy('date')
            ->orderBy('date', 'ASC')
            ->get();

        // Data 2: Distribusi Kategori (Histori Terbanyak)
        $categoryData = Ticket::join('categories', 'tickets.category_id', '=', 'categories.id')
            ->select('categories.nama_kategori', DB::raw('count(*) as total'))
            ->groupBy('categories.nama_kategori')
            ->get();

        return view('dashboard.index', compact(
            'countOpen',
            'countProgress',
            'countResolvedToday',
            'totalCustomers',
            'recentTickets',
            'trendData',
            'categoryData'
        ));
    }
}