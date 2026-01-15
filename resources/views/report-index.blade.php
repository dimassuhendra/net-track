@extends('layouts.app')

@section('content')
    <div class="space-y-6 pb-12">

        <div
            class="bg-white p-4 md:p-6 rounded-[2.5rem] shadow-sm border border-slate-100 flex flex-col lg:flex-row justify-between items-center gap-6">

            <div class="inline-flex bg-slate-100 p-1.5 rounded-[1.5rem] w-full lg:w-auto">
                @php $currentRange = request('range', '7_days'); @endphp
                <a href="{{ route('reports.index', ['range' => '1_day']) }}"
                    class="flex-1 lg:flex-none text-center px-6 py-2.5 rounded-2xl text-[11px] font-black uppercase tracking-tighter transition-all {{ $currentRange == '1_day' ? 'bg-white shadow-md text-blue-600' : 'text-slate-400 hover:text-slate-600' }}">
                    Hari Ini
                </a>
                <a href="{{ route('reports.index', ['range' => '7_days']) }}"
                    class="flex-1 lg:flex-none text-center px-6 py-2.5 rounded-2xl text-[11px] font-black uppercase tracking-tighter transition-all {{ $currentRange == '7_days' ? 'bg-white shadow-md text-blue-600' : 'text-slate-400 hover:text-slate-600' }}">
                    7 Hari
                </a>
                <a href="{{ route('reports.index', ['range' => '1_month']) }}"
                    class="flex-1 lg:flex-none text-center px-6 py-2.5 rounded-2xl text-[11px] font-black uppercase tracking-tighter transition-all {{ $currentRange == '1_month' ? 'bg-white shadow-md text-blue-600' : 'text-slate-400 hover:text-slate-600' }}">
                    30 Hari
                </a>
            </div>

            <div class="flex flex-wrap gap-3 items-center w-full lg:w-auto">
                <form action="{{ route('reports.index') }}" method="GET" class="flex flex-wrap gap-3 items-end">
                    <input type="hidden" name="range" value="manual">
                    <div class="flex items-center gap-2 bg-slate-50 p-1.5 rounded-2xl border border-slate-100">
                        <input type="date" name="start_date" value="{{ $start_str }}"
                            class="bg-transparent border-0 text-xs font-bold focus:ring-0">
                        <span class="text-slate-300 px-2">/</span>
                        <input type="date" name="end_date" value="{{ $end_str }}"
                            class="bg-transparent border-0 text-xs font-bold focus:ring-0">
                    </div>
                    <button type="submit"
                        class="bg-blue-600 text-white px-6 py-3 rounded-2xl font-bold text-[11px] uppercase tracking-widest hover:bg-blue-700 transition-all shadow-lg shadow-blue-100">
                        Apply
                    </button>
                </form>

                <a href="{{ route('reports.excel', ['start_date' => $start_str, 'end_date' => $end_str]) }}"
                    class="bg-emerald-500 text-white px-4 py-3 rounded-2xl font-bold text-[11px] uppercase tracking-widest hover:bg-emerald-600 transition-all shadow-lg shadow-emerald-100">
                    <i class="fa-solid fa-file-excel mr-1"></i> Excel
                </a>
            </div>
        </div>

        <div class="flex items-center gap-3 px-4">
            <div class="h-2 w-2 rounded-full bg-emerald-500 animate-pulse"></div>
            <span class="text-[11px] font-bold text-slate-400 uppercase tracking-widest">
                Periode: {{ \Carbon\Carbon::parse($start_str)->format('d M Y') }} -
                {{ \Carbon\Carbon::parse($end_str)->format('d M Y') }}
            </span>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="bg-white p-8 rounded-[3rem] border border-slate-100 shadow-sm">
                <h3 class="font-black text-slate-800 text-lg tracking-tight">Perbandingan Masalah</h3>
                <p class="text-[10px] font-bold text-slate-400 uppercase mb-4">Total Tiket Per Kategori</p>
                <canvas id="barChart"></canvas>
            </div>

            <div class="bg-white p-8 rounded-[3rem] border border-slate-100 shadow-sm text-center">
                <h3 class="font-black text-slate-800 text-lg tracking-tight text-left">Komposisi Persentase</h3>
                <p class="text-[10px] font-bold text-slate-400 uppercase mb-4 text-left">Distribusi Masalah</p>
                <div class="max-w-[250px] mx-auto">
                    <canvas id="donutChart"></canvas>
                </div>
            </div>

            <div class="bg-white p-8 rounded-[3rem] border border-slate-100 shadow-sm md:col-span-2">
                <h3 class="font-black text-slate-800 text-lg tracking-tight">Analisis Waktu & SLA</h3>
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 mt-8">
                    <div>
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-4">Peak Hours (Tren Per
                            Jam)</p>
                        <canvas id="lineChart"></canvas>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-4">Distribusi Durasi
                            (Jam)</p>
                        <canvas id="histogramChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mt-12">
        
        <div class="lg:col-span-2 bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden">
            <div class="p-8 border-b border-slate-50 flex justify-between items-center">
                <h3 class="font-black text-slate-800 tracking-tight">Data Tabulasi Kategori</h3>
                <span class="bg-blue-50 text-blue-600 text-[10px] font-black px-3 py-1 rounded-full uppercase">Total: {{ $totalTickets }} Tiket</span>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-8 py-4 text-[10px] font-black text-slate-400 uppercase">Nama Kategori</th>
                            <th class="px-8 py-4 text-[10px] font-black text-slate-400 uppercase text-center">Jumlah Kasus</th>
                            <th class="px-8 py-4 text-[10px] font-black text-slate-400 uppercase">Persentase</th>
                            <th class="px-8 py-4 text-[10px] font-black text-slate-400 uppercase">Visual Meta</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @foreach($categoryTable as $item)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-8 py-4 font-bold text-slate-700 text-sm">{{ $item['nama'] }}</td>
                            <td class="px-8 py-4 text-center">
                                <span class="bg-slate-100 text-slate-600 px-3 py-1 rounded-lg font-bold text-xs">{{ $item['jumlah'] }}</span>
                            </td>
                            <td class="px-8 py-4 text-sm font-medium text-slate-500">{{ $item['persentase'] }}%</td>
                            <td class="px-8 py-4">
                                <div class="w-full bg-slate-100 h-1.5 rounded-full overflow-hidden">
                                    <div class="bg-blue-500 h-full" style="width: {{ $item['persentase'] }}%"></div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="bg-slate-900 rounded-[2.5rem] p-8 text-white shadow-xl shadow-blue-100/20">
            <h3 class="font-bold text-lg mb-6">Summary Performa</h3>
            <div class="space-y-6">
                <div class="flex justify-between items-center border-b border-white/10 pb-4">
                    <span class="text-white/50 text-xs">Tiket Resolved</span>
                    <span class="font-black text-emerald-400">{{ count($durations) }}</span>
                </div>
                <div class="flex justify-between items-center border-b border-white/10 pb-4">
                    <span class="text-white/50 text-xs">Rata-rata Durasi</span>
                    <span class="font-black">{{ count($durations) > 0 ? round($durations->avg(), 1) : 0 }} Jam</span>
                </div>
                <div class="flex justify-between items-center border-b border-white/10 pb-4">
                    <span class="text-white/50 text-xs">Penyelesaian Tercepat</span>
                    <span class="font-black text-blue-400">{{ count($durations) > 0 ? $durations->min() : 0 }} Jam</span>
                </div>
                
                <div class="pt-4">
                    <p class="text-[10px] text-white/30 uppercase font-black mb-4">Status Target (SLA)</p>
                    @php $avg = count($durations) > 0 ? $durations->avg() : 0; @endphp
                    @if($avg <= 4)
                        <div class="bg-emerald-500/10 border border-emerald-500/20 p-4 rounded-2xl text-emerald-400">
                            <i class="fa-solid fa-circle-check mr-2"></i> <span class="text-xs font-bold">Memenuhi Target</span>
                        </div>
                    @else
                        <div class="bg-red-500/10 border border-red-500/20 p-4 rounded-2xl text-red-400">
                            <i class="fa-solid fa-triangle-exclamation mr-2"></i> <span class="text-xs font-bold">Butuh Evaluasi</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // 1. Data dari Backend
            const categoryLabels = {!! json_encode($categoryData->pluck('nama_kategori')) !!};
            const categoryTotals = {!! json_encode($categoryData->pluck('total')) !!};

            // Data Peak Hours
            const hourlyData = {!! json_encode($hourlyTrends) !!};
            const hoursLabels = Array.from({ length: 24 }, (_, i) => i + ':00');
            const totalsByHour = new Array(24).fill(0);
            hourlyData.forEach(item => { totalsByHour[item.hour] = item.total; });

            // Data Durasi
            const durations = {!! json_encode($durations) !!};
            const durationCounts = {};
            durations.forEach(d => { durationCounts[d] = (durationCounts[d] || 0) + 1; });
            const durLabels = Object.keys(durationCounts).sort((a, b) => a - b);
            const durValues = durLabels.map(label => durationCounts[label]);

            // 2. Inisialisasi Bar Chart
            new Chart(document.getElementById('barChart'), {
                type: 'bar',
                data: {
                    labels: categoryLabels,
                    datasets: [{
                        label: 'Jumlah Tiket',
                        data: categoryTotals,
                        backgroundColor: '#3b82f6',
                        borderRadius: 12,
                        barThickness: 25
                    }]
                },
                options: {
                    responsive: true,
                    plugins: { legend: { display: false } },
                    scales: { y: { beginAtZero: true, grid: { display: false } }, x: { grid: { display: false } } }
                }
            });

            // 3. Inisialisasi Donut Chart
            new Chart(document.getElementById('donutChart'), {
                type: 'doughnut',
                data: {
                    labels: categoryLabels,
                    datasets: [{
                        data: categoryTotals,
                        backgroundColor: ['#3b82f6', '#10b981', '#f59e0b', '#ef4444', '#8b5cf6'],
                        borderWidth: 8,
                        borderColor: '#ffffff',
                        hoverOffset: 15
                    }]
                },
                options: {
                    cutout: '75%',
                    plugins: { legend: { position: 'bottom', labels: { usePointStyle: true, padding: 20, font: { size: 10, weight: 'bold' } } } }
                }
            });

            // 4. Inisialisasi Line Chart (Peak Hours)
            new Chart(document.getElementById('lineChart'), {
                type: 'line',
                data: {
                    labels: hoursLabels,
                    datasets: [{
                        label: 'Laporan',
                        data: totalsByHour,
                        borderColor: '#6366f1',
                        borderWidth: 4,
                        pointBackgroundColor: '#ffffff',
                        pointBorderWidth: 2,
                        tension: 0.4,
                        fill: true,
                        backgroundColor: (context) => {
                            const ctx = context.chart.ctx;
                            const gradient = ctx.createLinearGradient(0, 0, 0, 300);
                            gradient.addColorStop(0, 'rgba(99, 102, 241, 0.2)');
                            gradient.addColorStop(1, 'rgba(99, 102, 241, 0)');
                            return gradient;
                        }
                    }]
                },
                options: {
                    plugins: { legend: { display: false } },
                    scales: {
                        y: { beginAtZero: true, grid: { color: '#f8fafc' } },
                        x: { grid: { display: false } }
                    }
                }
            });

            // 5. Inisialisasi Histogram Chart (SLA)
            new Chart(document.getElementById('histogramChart'), {
                type: 'bar',
                data: {
                    labels: durLabels.map(l => l + ' Jam'),
                    datasets: [{
                        label: 'Jumlah Kasus',
                        data: durValues,
                        backgroundColor: '#f43f5e',
                        borderRadius: 10,
                    }]
                },
                options: {
                    plugins: { legend: { display: false } },
                    scales: {
                        y: { beginAtZero: true, grid: { color: '#f8fafc' } },
                        x: { grid: { display: false } }
                    }
                }
            });
        });
    </script>

    <style>
        canvas {
            width: 100% !important;
            height: auto !important;
        }

        @media print {
            .bg-white {
                border: none !important;
                shadow: none !important;
            }

            form,
            .inline-flex {
                display: none !important;
            }
        }
    </style>
@endsection