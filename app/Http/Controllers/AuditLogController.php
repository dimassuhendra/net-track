<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use Illuminate\Http\Request;

class AuditLogController extends Controller
{
    public function index(Request $request)
    {
        $query = ActivityLog::with('user')->latest();

        // 1. Filter Petugas
        if ($request->filled('user')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->user . '%');
            });
        }

        // 2. Filter Berdasarkan Jenis Model
        if ($request->filled('model')) {
            $query->where('model_type', 'like', '%' . $request->model . '%');
        }

        // 3. Filter Rentang Tanggal (BARU)
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('created_at', [
                $request->start_date . ' 00:00:00',
                $request->end_date . ' 23:59:59'
            ]);
        }

        // 4. Logika Per Halaman (BARU) - Default 10
        $perPage = $request->get('per_page', 10);

        // Jika pilih 'all', gunakan total count sebagai limit paginasi
        if ($perPage === 'all') {
            $logs = $query->paginate($query->count())->withQueryString();
        } else {
            $logs = $query->paginate((int) $perPage)->withQueryString();
        }

        return view('audit-log-index', compact('logs'));
    }
}