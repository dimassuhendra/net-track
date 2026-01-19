<?php
namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Exports\TicketsExport;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;
use DB;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        // Mengatur agar PHP punya waktu lebih
        set_time_limit(60);

        $range = $request->get('range', '7_days');
        $start_input = $request->get('start_date');
        $end_input = $request->get('end_date');

        $now = Carbon::now();

        // Penentuan Tanggal
        if ($range == '1_day') {
            $start = $now->copy()->startOfDay();
            $end = $now->copy()->endOfDay();
        } elseif ($range == '7_days') {
            $start = $now->copy()->subDays(6)->startOfDay();
            $end = $now->copy()->endOfDay();
        } elseif ($range == '1_month') {
            $start = $now->copy()->subMonth()->startOfDay();
            $end = $now->copy()->endOfDay();
        } elseif ($range == 'manual' && $start_input && $end_input) {
            $start = Carbon::parse($start_input)->startOfDay();
            $end = Carbon::parse($end_input)->endOfDay();
        } else {
            $start = $now->copy()->subDays(6)->startOfDay();
            $end = $now->copy()->endOfDay();
        }

        // 1. Ambil data dasar
        $tickets = Ticket::with(['category'])
            ->whereBetween('waktu_mulai', [$start, $end])
            ->get();

        // 2. A & B: Statistik Kategori
        $categoryData = $tickets->groupBy('category.nama_kategori')->map(function ($row) {
            return ['nama_kategori' => $row->first()->category->nama_kategori ?? 'N/A', 'total' => $row->count()];
        })->values();

        // 3. C: Peak Hours
        $hourlyTrends = Ticket::whereBetween('waktu_mulai', [$start, $end])
            ->select(DB::raw('HOUR(waktu_mulai) as hour'), DB::raw('count(*) as total'))
            ->groupBy('hour')
            ->get();

        // 4. D: Durasi / SLA (Hanya ambil yang Resolved dan hitung selisih di Database)
        $durationsData = Ticket::whereBetween('waktu_mulai', [$start, $end])
            ->whereStatus('Resolved')
            ->whereNotNull('waktu_selesai')
            ->select(DB::raw('TIMESTAMPDIFF(HOUR, waktu_mulai, waktu_selesai) as duration'))
            ->get();

        $durations = $durationsData->pluck('duration');

        $start_str = $start->format('Y-m-d');
        $end_str = $end->format('Y-m-d');

        // logika persentase pada categoryData
        $totalTickets = $tickets->count();
        $categoryTable = $tickets->groupBy('category.nama_kategori')->map(function ($row) use ($totalTickets) {
            $count = $row->count();
            return [
                'nama' => $row->first()->category->nama_kategori ?? 'N/A',
                'jumlah' => $count,
                'persentase' => $totalTickets > 0 ? round(($count / $totalTickets) * 100, 1) : 0
            ];
        })->values();

        // 5. Statistik Top 5 Kategori Pelanggan
        $customerCategoryData = Ticket::with('customer')
            ->whereBetween('waktu_mulai', [$start, $end])
            ->get()
            ->groupBy(function ($ticket) {
                return $ticket->customer->nama_pelanggan ?? 'Umum';
            })
            ->map(function ($row, $label) {
                return [
                    'label' => $label,
                    'total' => $row->count()
                ];
            })
            ->sortByDesc('total')
            ->take(5)
            ->values();

        return view('report-index', compact(
            'categoryData',
            'hourlyTrends',
            'durations',
            'start_str',
            'end_str',
            'range',
            'categoryTable',
            'totalTickets',
            'customerCategoryData'
        ));

    }

    public function exportExcel(Request $request)
    {
        return Excel::download(new TicketsExport($request->start_date, $request->end_date), 'Laporan_Gangguan.xlsx');
    }
}