<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - NetTrack ISP</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

        body {
            font-family: 'Poppins', sans-serif;
        }

        .bg-gradient-blue {
            background: linear-gradient(135deg, #3b82f6 0%, #1e3a8a 100%);
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
        }
    </style>
</head>

<body class="bg-gray-100 min-h-screen flex items-center justify-center p-4">

    <div
        class="flex flex-col md:flex-row w-full max-w-5xl bg-white rounded-3xl overflow-hidden shadow-2xl min-h-[600px]">

        <div class="w-full md:w-1/2 p-8 md:p-16 flex flex-col justify-center relative bg-[#F2F2F2]">
            <div class="z-10">
                <h2 class="text-2xl font-bold text-gray-800 mb-2 border-b-2 border-gray-300 inline-block pb-1">Login
                    please</h2>

                @if($errors->any())
                    <div class="bg-red-100 text-red-600 p-3 rounded-lg mb-6 text-sm">
                        {{ $errors->first() }}
                    </div>
                @endif

                <form action="{{ url('/login') }}" method="POST" class="mt-8 space-y-6">
                    @csrf
                    <div class="relative group">
                        <div
                            class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none border-r border-gray-300 pr-3 my-2 group-focus-within:border-blue-500">
                            <i class="fa-regular fa-envelope text-gray-400"></i>
                        </div>
                        <input type="email" name="email" value="{{ old('email') }}"
                            class="block w-full pl-14 pr-4 py-4 bg-white border border-transparent shadow-sm rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white italic text-gray-600"
                            placeholder="Input your user ID or Email" required>
                    </div>

                    <div class="relative group">
                        <div
                            class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none border-r border-gray-300 pr-3 my-2 group-focus-within:border-blue-500">
                            <i class="fa-solid fa-key text-gray-400"></i>
                        </div>
                        <input type="password" name="password"
                            class="block w-full pl-14 pr-4 py-4 bg-white border border-transparent shadow-sm rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white italic text-gray-600"
                            placeholder="Input your password" required>
                    </div>

                    <div class="flex items-center justify-between text-sm">
                        <label class="flex items-center text-gray-500 cursor-pointer">
                            <input type="checkbox"
                                class="w-4 h-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500 mr-2">
                            Remember me
                        </label>
                        <a href="#"
                            class="font-semibold text-gray-700 hover:text-blue-600 underline decoration-2 underline-offset-4">Forgot
                            Password?</a>
                    </div>

                    <div class="pt-4">
                        <button type="submit"
                            class="bg-[#1D4ED8] hover:bg-blue-800 text-white font-bold py-3 px-8 rounded-lg shadow-lg flex items-center gap-3 transition-all transform hover:scale-105">
                            <i class="fa-solid fa-right-to-bracket rotate-180"></i>
                            LOG IN
                        </button>
                    </div>
                </form>
            </div>

            <div class="absolute -top-10 -left-10 w-32 h-32 bg-blue-600 rounded-full opacity-80"></div>
        </div>

        <div
            class="w-full md:w-1/2 bg-gradient-blue p-12 flex flex-col items-center justify-center text-center text-white relative overflow-hidden">
            <div class="absolute inset-0 opacity-20">
                <svg class="absolute bottom-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
                    <path fill="#ffffff" fill-opacity="1"
                        d="M0,192L48,197.3C96,203,192,213,288,192C384,171,480,117,576,112C672,107,768,149,864,165.3C960,181,1056,171,1152,149.3C1248,128,1344,96,1392,80L1440,64L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z">
                    </path>
                </svg>
            </div>

            <div class="z-10">
                <h1 class="text-4xl font-bold mb-4">WELCOME!</h1>
                <p class="text-lg font-light mb-8 max-w-xs">Enter your details and start journey with us</p>
                <button
                    class="border-2 border-white/50 bg-white/10 hover:bg-white hover:text-blue-900 transition-all px-12 py-2 rounded-lg font-bold tracking-widest text-sm shadow-xl">
                    SIGNUP
                </button>
            </div>

            <div
                class="absolute top-20 -right-10 w-40 h-40 bg-blue-400 rounded-full mix-blend-multiply filter blur-xl opacity-30 animate-blob">
            </div>
        </div>

    </div>

</body>

</html>