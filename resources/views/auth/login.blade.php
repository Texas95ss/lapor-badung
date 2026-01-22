<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Masuk Sistem - Lapor Badung</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body { font-family: 'Figtree', sans-serif; }
        /* Animasi halus untuk input */
        .input-focus:focus {
            border-color: #E02424; /* Merah Badung */
            box-shadow: 0 0 0 4px rgba(224, 36, 36, 0.1);
        }
    </style>
</head>

<body class="antialiased min-h-screen flex items-center justify-center bg-[#111827]">

    <div class="w-full max-w-md px-6 relative z-10">
        
        <div class="text-center mb-8">
            <img src="{{ asset('img/logo-badung.png') }}" alt="Logo" class="w-24 h-auto mx-auto mb-4 drop-shadow-2xl" onerror="this.style.display='none'">
            <h2 class="text-3xl font-extrabold text-white tracking-tight">Selamat Datang</h2>
            <p class="text-gray-400 mt-2 text-sm">Silakan masuk untuk mulai melapor</p>
        </div>

        <div class="bg-white rounded-2xl shadow-2xl overflow-hidden">
            
            <div class="h-2 bg-[#E02424] w-full"></div>

            <div class="p-8">
                @if (session('success'))
                        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                            <strong class="font-bold">Sukses!</strong>
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif
                    
                    @if (session('status'))
                        <div class="mb-4 bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded relative" role="alert">
                            <span class="block sm:inline">{{ session('status') }}</span>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="mb-5">
                        <label class="block text-sm font-bold text-gray-700 mb-2 ml-1">Email</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus 
                            class="w-full px-5 py-3 rounded-lg bg-gray-50 border border-gray-200 text-gray-900 focus:outline-none input-focus transition-all"
                            placeholder="nama@email.com">
                        @error('email')
                            <p class="text-[#E02424] text-xs mt-1 font-bold">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label class="block text-sm font-bold text-gray-700 mb-2 ml-1">Password</label>
                        <input id="password" type="password" name="password" required 
                            class="w-full px-5 py-3 rounded-lg bg-gray-50 border border-gray-200 text-gray-900 focus:outline-none input-focus transition-all"
                            placeholder="••••••••">
                        @error('password')
                            <p class="text-[#E02424] text-xs mt-1 font-bold">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" class="w-full bg-[#E02424] hover:bg-[#c81e1e] text-white font-bold py-3.5 rounded-lg shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200">
                        MASUK
                    </button>

                    <div class="relative mt-8 mb-4">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-gray-200"></div>
                        </div>
                        <div class="relative flex justify-center text-sm">
                            <span class="px-2 bg-white text-gray-400">Atau</span>
                        </div>
                    </div>

                    <div class="text-center mt-2">
                        <p class="text-sm text-gray-600">Belum punya akun?</p>
                        <a href="{{ route('register') }}" class="inline-block mt-1 text-[#E02424] font-bold hover:underline hover:text-[#b01b1b] transition-colors">
                            Buat Akun Baru
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <p class="text-center text-gray-600 text-xs mt-8">
            &copy; {{ date('Y') }} Lapor Badung. All rights reserved.
        </p>

    </div>

    <div class="fixed top-0 left-0 w-full h-full pointer-events-none overflow-hidden z-0">
        <div class="absolute top-[-10%] right-[-5%] w-96 h-96 bg-[#E02424] rounded-full mix-blend-multiply filter blur-3xl opacity-10 animate-blob"></div>
        <div class="absolute bottom-[-10%] left-[-5%] w-96 h-96 bg-gray-600 rounded-full mix-blend-multiply filter blur-3xl opacity-10 animate-blob animation-delay-2000"></div>
    </div>

</body>
</html>