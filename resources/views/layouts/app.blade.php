<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - NetTrack ISP</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet"> -->
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;600&family=Domine:wght@700&display=swap" rel="stylesheet">
    
    <style>
        body { 
            font-family: 'Fredoka', sans-serif; 
            scroll-behavior: smooth;
        }
        .glass-header {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
        }
    </style>
</head>
<body class="bg-[#F8FAFC] text-slate-900">

    <div class="flex">
        @include('layouts.sidebar')

        <div class="flex-1 min-h-screen flex flex-col">
            <header class="glass-header border-b border-slate-200/60 h-20 flex items-center justify-between px-6 md:px-10 sticky top-0 z-40 transition-all">
                
                <div class="flex items-center gap-6">
                    <button class="p-2.5 bg-white border border-slate-200 rounded-xl text-slate-600 md:hidden hover:bg-slate-50 transition-colors shadow-sm">
                        <i class="fa-solid fa-bars-staggered"></i>
                    </button>

                    <div class="hidden sm:block">
                        <nav class="flex mb-1" aria-label="Breadcrumb">
                            <ol class="inline-flex items-center space-x-1 md:space-x-2 text-[11px] font-bold uppercase tracking-widest text-slate-400">
                                <li>NetTrack</li>
                                <li><i class="fa-solid fa-chevron-right text-[8px] mx-1"></i></li>
                                <li class="text-blue-600">Admin Area</li>
                            </ol>
                        </nav>
                        <h2 class="text-xl font-extrabold text-slate-800 tracking-tight">@yield('page_title')</h2>
                    </div>
                </div>
                
                <div class="flex items-center gap-3 md:gap-6">
                    <div class="hidden lg:flex flex-col items-end border-r border-slate-200 pr-6">
                        <div class="flex items-center gap-2 text-slate-800">
                            <span class="relative flex h-2 w-2">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                            </span>
                            <p id="clock" class="font-mono font-bold text-lg leading-none"></p>
                        </div>
                        <p class="text-[10px] text-slate-500 font-bold uppercase tracking-tighter mt-1">
                            <i class="fa-regular fa-calendar-check mr-1"></i> {{ date('l, d F Y') }}
                        </p>
                    </div>
                    
                    <div class="flex items-center gap-2">
                        <button class="p-2.5 text-slate-500 hover:text-blue-600 hover:bg-blue-50 rounded-xl transition-all relative">
                            <i class="fa-regular fa-bell text-xl"></i>
                            <span class="absolute top-2 right-2.5 w-2 h-2 bg-red-500 border-2 border-white rounded-full"></span>
                        </button>
                    </div>

                    <div class="flex items-center gap-3 pl-2 md:pl-4">
                        <div class="text-right hidden sm:block">
                            <p class="text-sm font-extrabold text-slate-800 leading-none mb-1">{{ Auth::user()->name }}</p>
                            <div class="flex justify-end">
                                <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[10px] font-black bg-gradient-to-r from-blue-600 to-indigo-600 text-white uppercase shadow-sm">
                                    {{ Auth::user()->role }}
                                </span>
                            </div>
                        </div>
                        
                        <div class="relative group cursor-pointer">
                            <div class="w-11 h-11 rounded-2xl bg-gradient-to-tr from-blue-600 to-indigo-400 p-[2px] shadow-md group-hover:shadow-blue-200 transition-all duration-300">
                                <div class="w-full h-full bg-white rounded-[14px] flex items-center justify-center overflow-hidden">
                                    <span class="text-blue-700 font-black text-lg">{{ substr(Auth::user()->name, 0, 1) }}</span>
                                    {{-- Jika ada foto: <img src="path/to/photo.jpg" class="w-full h-full object-cover"> --}}
                                </div>
                            </div>
                            <div class="absolute -bottom-0.5 -right-0.5 w-3.5 h-3.5 bg-emerald-500 border-2 border-white rounded-full"></div>
                        </div>
                    </div>
                </div>
            </header>

            <main class="p-6 md:p-10 max-w-[1600px] mx-auto w-full">
                <div class="sm:hidden mb-6">
                    <h2 class="text-2xl font-black text-slate-800 tracking-tight">@yield('page_title')</h2>
                    <p class="text-slate-500 text-sm">Dashboard Monitoring</p>
                </div>

                @yield('content')
            </main>

            <footer class="mt-auto py-6 px-10 border-t border-slate-200/60 text-center md:text-left">
                <p class="text-slate-400 text-xs font-medium">
                    &copy; 2026 <span class="text-slate-600 font-bold">NetTrack ISP</span>. All rights reserved.
                </p>
            </footer>
        </div>
    </div>

    <script>
        function updateClock() {
            const now = new Date();
            const options = { 
                hour: '2-digit', 
                minute: '2-digit', 
                second: '2-digit',
                hour12: false 
            };
            document.getElementById('clock').innerText = now.toLocaleTimeString('id-ID', options).replace(/\./g, ':');
        }
        setInterval(updateClock, 1000);
        updateClock();
    </script>
</body>
</html>