<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Models\Ticket;
use App\Models\User;
use App\Models\Notification;

class Kernel extends ConsoleKernel
{
    /**
     * Definisikan jadwal perintah otomatis (Task Scheduling)
     */
    protected function schedule(Schedule $schedule)
    {
        // Tugas: Mengirim Ringkasan Laporan Harian setiap jam 08:00 pagi
        $schedule->call(function () {
            $yesterday = now()->subDay();

            // Hitung data statistik tiket kemarin
            $total = Ticket::whereDate('created_at', $yesterday)->count();
            $solved = Ticket::whereDate('created_at', $yesterday)->where('status', 'Resolved')->count();
            $process = Ticket::whereDate('created_at', $yesterday)
                ->whereIn('status', ['Open', 'In Progress'])->count();

            // Ambil semua user dengan role GM dan Manager IT
            $pimpinan = User::whereIn('role', ['gm', 'manager_it'])->get();

            foreach ($pimpinan as $user) {
                Notification::create([
                    'user_id' => $user->id,
                    'title' => 'RINGKASAN LAPORAN HARIAN',
                    'message' => "Statistik kemarin: Total $total Tiket. ($solved Berhasil di-Resolve, $process Masih dalam proses).",
                    'type' => 'report'
                ]);
            }
        })->dailyAt('08:00');
    }

    /**
     * Daftarkan perintah (commands) untuk aplikasi.
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}