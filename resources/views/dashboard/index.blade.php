@extends('layouts.app')

@section('title', 'Dashboard')
@section('page_title', 'Overview Monitoring')

@section('content')
    <div class="space-y-8 animate-fade-in">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div
                class="group bg-white p-6 rounded-3xl shadow-sm border border-slate-100 hover:shadow-md transition-all duration-300">
                <div class="flex items-center justify-between mb-4">
                    <div
                        class="w-12 h-12 bg-red-50 text-red-600 rounded-2xl flex items-center justify-center text-xl group-hover:scale-110 transition-transform">
                        <i class="fa-solid fa-land-mine-on"></i>
                    </div>
                    <span class="text-xs font-bold text-red-500 bg-red-50 px-2 py-1 rounded-lg">Mendesak</span>
                </div>
                <div>
                    <p class="text-slate-500 text-sm font-semibold tracking-wide uppercase">Tiket Aktif</p>
                    <h3 class="text-3xl font-black text-slate-800 mt-1">{{ $countOpen }}</h3>
                </div>
            </div>

            <div
                class="group bg-white p-6 rounded-3xl shadow-sm border border-slate-100 hover:shadow-md transition-all duration-300">
                <div class="flex items-center justify-between mb-4">
                    <div
                        class="w-12 h-12 bg-amber-50 text-amber-600 rounded-2xl flex items-center justify-center text-xl group-hover:scale-110 transition-transform">
                        <i class="fa-solid fa-screwdriver-wrench"></i>
                    </div>
                    <span class="text-xs font-bold text-amber-500 bg-amber-50 px-2 py-1 rounded-lg">Proses</span>
                </div>
                <div>
                    <p class="text-slate-500 text-sm font-semibold tracking-wide uppercase">Dalam Perbaikan</p>
                    <h3 class="text-3xl font-black text-slate-800 mt-1">{{ $countProgress }}</h3>
                </div>
            </div>

            <div
                class="group bg-white p-6 rounded-3xl shadow-sm border border-slate-100 hover:shadow-md transition-all duration-300">
                <div class="flex items-center justify-between mb-4">
                    <div
                        class="w-12 h-12 bg-emerald-50 text-emerald-600 rounded-2xl flex items-center justify-center text-xl group-hover:scale-110 transition-transform">
                        <i class="fa-solid fa-circle-check"></i>
                    </div>
                    <span class="text-xs font-bold text-emerald-500 bg-emerald-50 px-2 py-1 rounded-lg">Selesai</span>
                </div>
                <div>
                    <p class="text-slate-500 text-sm font-semibold tracking-wide uppercase">Selesai Hari Ini</p>
                    <h3 class="text-3xl font-black text-slate-800 mt-1">{{ $countResolvedToday }}</h3>
                </div>
            </div>

            <div
                class="group bg-white p-6 rounded-3xl shadow-sm border border-slate-100 hover:shadow-md transition-all duration-300">
                <div class="flex items-center justify-between mb-4">
                    <div
                        class="w-12 h-12 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center text-xl group-hover:scale-110 transition-transform">
                        <i class="fa-solid fa-users"></i>
                    </div>
                    <span class="text-xs font-bold text-blue-500 bg-blue-50 px-2 py-1 rounded-lg">Database</span>
                </div>
                <div>
                    <p class="text-slate-500 text-sm font-semibold tracking-wide uppercase">Total Pelanggan</p>
                    <h3 class="text-3xl font-black text-slate-800 mt-1">{{ number_format($totalCustomers) }}</h3>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2 bg-white p-8 rounded-3xl shadow-sm border border-slate-100">
                <div class="flex items-center justify-between mb-8">
                    <div>
                        <h3 class="font-bold text-slate-800 text-lg">Tren Gangguan</h3>
                        <p class="text-slate-400 text-sm">Visualisasi 7 hari terakhir</p>
                    </div>
                    <div class="flex gap-2">
                        <span class="w-3 h-3 bg-blue-500 rounded-full"></span>
                    </div>
                </div>
                <div class="relative h-[300px]">
                    <canvas id="trendChart"></canvas>
                </div>
            </div>

            <div class="bg-white p-8 rounded-3xl shadow-sm border border-slate-100">
                <h3 class="font-bold text-slate-800 text-lg mb-1">Kategori Masalah</h3>
                <p class="text-slate-400 text-sm mb-8">Distribusi keluhan terbanyak</p>
                <div class="relative">
                    <canvas id="categoryChart"></canvas>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
            <div class="p-8 border-b border-slate-50 flex justify-between items-center">
                <div>
                    <h3 class="font-bold text-slate-800 text-lg">Gangguan Terbaru</h3>
                    <p class="text-slate-400 text-sm mt-1">Daftar 5 tiket yang baru masuk sistem</p>
                </div>
                <a href="/tickets"
                    class="inline-flex items-center gap-2 bg-slate-50 hover:bg-slate-100 text-slate-700 px-4 py-2 rounded-xl text-sm font-bold transition-colors">
                    Lihat Semua <i class="fa-solid fa-arrow-right text-[10px]"></i>
                </a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-slate-50/50 text-slate-500 text-[11px] uppercase font-bold tracking-widest">
                            <th class="px-8 py-4">Nomor Tiket</th>
                            <th class="px-8 py-4">Pelanggan</th>
                            <th class="px-8 py-4">Masalah</th>
                            <th class="px-8 py-4">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($recentTickets as $ticket)
                            <tr class="hover:bg-slate-50/50 transition-colors group">
                                <td class="px-8 py-5">
                                    <span
                                        class="font-mono font-bold text-blue-600 bg-blue-50 px-3 py-1 rounded-lg text-sm">#{{ $ticket->ticket_number }}</span>
                                </td>
                                <td class="px-8 py-5">
                                    <div class="font-semibold text-slate-700">{{ $ticket->customer->nama_pelanggan }}</div>
                                </td>
                                <td class="px-8 py-5 text-slate-500 font-medium">
                                    {{ $ticket->category->nama_kategori }}
                                </td>
                                <td class="px-8 py-5">
                                    @if($ticket->status == 'Open')
                                        <span
                                            class="inline-flex items-center gap-1.5 py-1.5 px-3 rounded-full text-xs font-bold bg-red-100 text-red-600">
                                            <span class="w-1.5 h-1.5 bg-red-500 rounded-full animate-pulse"></span> Open
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center gap-1.5 py-1.5 px-3 rounded-full text-xs font-bold bg-amber-100 text-amber-600">
                                            <span class="w-1.5 h-1.5 bg-amber-500 rounded-full"></span> Progress
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-8 py-16 text-center">
                                    <div class="flex flex-col items-center justify-center space-y-3">
                                        <i class="fa-solid fa-clipboard-check text-4xl text-slate-200"></i>
                                        <p class="text-slate-400 font-medium">Semua aman! Tidak ada laporan gangguan hari ini.
                                        </p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <style>
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in {
            animation: fadeIn 0.5s ease-out forwards;
        }
    </style>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Global Chart Defaults
        Chart.defaults.font.family = "'Plus Jakarta Sans', sans-serif";
        Chart.defaults.color = '#94a3b8';

        // Konfigurasi Trend Chart (Line Chart)
        const ctxTrend = document.getElementById('trendChart').getContext('2d');
        const gradient = ctxTrend.createLinearGradient(0, 0, 0, 300);
        gradient.addColorStop(0, 'rgba(37, 99, 235, 0.2)');
        gradient.addColorStop(1, 'rgba(37, 99, 235, 0)');

        new Chart(ctxTrend, {
            type: 'line',
            data: {
                labels: {!! json_encode($trendData->pluck('date')) !!},
                datasets: [{
                    label: 'Laporan',
                    data: {!! json_encode($trendData->pluck('total')) !!},
                    borderColor: '#2563eb',
                    borderWidth: 3,
                    backgroundColor: gradient,
                    fill: true,
                    tension: 0.45,
                    pointBackgroundColor: '#2563eb',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 4,
                    pointHoverRadius: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#1e293b',
                        padding: 12,
                        titleFont: { size: 14, weight: 'bold' },
                        cornerRadius: 8
                    }
                },
                scales: {
                    y: { beginAtZero: true, grid: { borderDash: [5, 5], color: '#f1f5f9' } },
                    x: { grid: { display: false } }
                }
            }
        });

        // Konfigurasi Category Chart (Doughnut)
        const ctxCat = document.getElementById('categoryChart').getContext('2d');
        new Chart(ctxCat, {
            type: 'doughnut',
            data: {
                labels: {!! json_encode($categoryData->pluck('nama_kategori')) !!},
                datasets: [{
                    data: {!! json_encode($categoryData->pluck('total')) !!},
                    backgroundColor: ['#6366f1', '#f59e0b', '#3b82f6', '#10b981', '#ef4444'],
                    hoverOffset: 10,
                    borderWidth: 0
                }]
            },
            options: {
                cutout: '75%',
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            usePointStyle: true,
                            padding: 20,
                            font: { size: 12, weight: '600' }
                        }
                    }
                }
            }
        });
    </script>
@endsection