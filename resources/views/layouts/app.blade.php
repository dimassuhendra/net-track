<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - NetTrack ISP</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-slate-50">

    <div class="flex">
        @include('layouts.sidebar')

        <div class="flex-1 min-h-screen flex flex-col">
            <header class="bg-white border-b border-slate-200 h-16 flex items-center justify-between px-8 sticky top-0 z-30">
                <div class="flex items-center gap-4">
                    <button class="text-slate-500 md:hidden"><i class="fa-solid fa-bars"></i></button>
                    <h2 class="text-slate-700 font-semibold uppercase tracking-wider text-sm">@yield('page_title')</h2>
                </div>
                
                <div class="flex items-center gap-6">
                    <div class="hidden md:block text-right">
                        <p id="clock" class="text-slate-800 font-bold leading-none"></p>
                        <p class="text-[10px] text-slate-500 uppercase">{{ date('d M Y') }}</p>
                    </div>
                    
                    <div class="h-8 w-[1px] bg-slate-200"></div>

                    <div class="flex items-center gap-3">
                        <div class="text-right hidden sm:block">
                            <p class="text-sm font-bold text-slate-800 leading-none">{{ Auth::user()->name }}</p>
                            <span class="text-[10px] bg-blue-100 text-blue-700 px-2 py-0.5 rounded-full font-bold uppercase">
                                {{ Auth::user()->role }}
                            </span>
                        </div>
                        <div class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center text-white font-bold shadow-lg">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                    </div>
                </div>
            </header>

            <main class="p-8">
                @yield('content')
            </main>
        </div>
    </div>

    <script>
        function updateClock() {
            const now = new Date();
            document.getElementById('clock').innerText = now.toLocaleTimeString('id-ID');
        }
        setInterval(updateClock, 1000);
        updateClock();
    </script>
</body>
</html>