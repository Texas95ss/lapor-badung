<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lapor Badung - Layanan Aspirasi Warga</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body { font-family: 'Poppins', sans-serif; }
        /* Animasi halus */
        .hover-scale { transition: transform 0.3s ease; }
        .hover-scale:hover { transform: translateY(-5px); }
    </style>
</head>
<body class="bg-gray-50 text-gray-800 antialiased">

    <nav class="fixed top-0 left-0 w-full z-50 bg-gray-900 border-b border-gray-800 h-16 shadow-lg transition-all duration-300">
        <div class="max-w-7xl mx-auto px-6 lg:px-8 h-full">
            <div class="flex justify-between items-center h-full">
                
                <div class="flex items-center gap-3">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/d/d2/Lambang_Kabupaten_Badung.png/486px-Lambang_Kabupaten_Badung.png" 
                        alt="Logo Badung" 
                        class="h-10 w-auto hover:scale-110 transition duration-300"> <span class="text-white text-xl font-bold tracking-tight">Lapor<span class="text-red-500">Badung</span></span>
                </div>

                <div class="flex items-center gap-4">
                    @auth
                    <div class="flex items-center gap-3">
                        <span class="text-white font-bold text-sm hidden sm:block">
                            {{ Auth::user()->name }}
                        </span>
                        <div class="w-8 h-8 rounded-full bg-red-600 flex items-center justify-center text-white text-xs font-bold ring-2 ring-gray-800">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                    </div>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="ml-2 text-gray-400 hover:text-red-500 transition" title="Keluar">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                        </button>
                    </form>
                @else
                        <a href="{{ route('login') }}" class="text-gray-300 font-medium text-sm hover:text-white transition">Masuk</a>
                        <a href="{{ route('register') }}" class="bg-red-600 text-white px-5 py-2 rounded-full font-bold text-sm shadow-lg hover:bg-red-700 transition transform hover:scale-105">
                            Daftar
                        </a>
                    @endauth
                </div>

            </div>
        </div>
    </nav>

    <div class="relative bg-gray-900 h-auto md:h-[600px] pb-40 md:pb-0 flex items-center overflow-hidden">
        <img src="https://images.unsplash.com/photo-1537996194471-e657df975ab4?q=80&w=2000&auto=format&fit=crop" 
             class="absolute w-full h-full object-cover opacity-40">
        
        <div class="absolute inset-0 bg-gradient-to-t from-gray-900 via-transparent to-transparent"></div>

        <div class="relative z-10 max-w-7xl mx-auto px-6 lg:px-8 h-full flex flex-col justify-center items-center text-center pt-20 pb-20">
    
            <span class="bg-red-600 text-white px-3 py-1 rounded-full text-xs font-bold tracking-wider uppercase mb-4 inline-block">Official Platform</span>
            
            <h1 class="text-4xl md:text-6xl font-extrabold text-white mb-4 md:mb-6 leading-tight">
                Jangan Diam.<br>
                <span class="text-red-500">Suarakan Masalahmu.</span>
            </h1>

            <p class="text-base md:text-xl text-gray-200 mb-8 max-w-2xl mx-auto">
                Jalan rusak? Banjir? Sampah numpuk? Laporkan langsung ke Pemerintah Kabupaten Badung lewat sini. Transparan dan Cepat.
            </p>

            <div class="flex flex-col sm:flex-row gap-4 items-center w-full justify-center">
    
                <a href="{{ route('reports.create') }}" class="w-full sm:w-auto px-8 py-4 bg-red-600 text-white text-lg font-bold rounded-xl shadow-red-900/50 shadow-lg hover:bg-red-700 transition transform hover:scale-105 flex items-center justify-center gap-2">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                    Buat Laporan Baru
                </a>

                @auth
                <a href="{{ route('dashboard') }}" class="w-full sm:w-auto px-8 py-4 bg-white/10 backdrop-blur-md text-white border border-white/20 text-lg font-semibold rounded-xl hover:bg-white/20 transition flex items-center justify-center gap-2">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Riwayat Laporan
                </a>
                @endauth

                <a href="#laporan-terbaru" class="w-full sm:w-auto px-8 py-4 bg-white/10 backdrop-blur-md text-white border border-white/20 text-lg font-semibold rounded-xl hover:bg-white/20 transition flex items-center justify-center">
                    Lihat Laporan Warga
                </a>

            </div>

        </div>
    </div>

    <div class="max-w-7xl mx-auto px-6 lg:px-8 -mt-16 relative z-10">
        <div class="bg-white rounded-2xl shadow-xl p-8 grid grid-cols-1 md:grid-cols-3 gap-8 text-center border-b-4 border-red-600">
            <div>
                <div class="text-4xl font-extrabold text-gray-900">{{ $reports->count() }}</div>
                <div class="text-sm text-gray-500 font-semibold uppercase tracking-wide">Total Laporan Masuk</div>
            </div>
            <div>
                <div class="text-4xl font-extrabold text-red-600">{{ $reports->where('status', 'proses')->count() }}</div>
                <div class="text-sm text-gray-500 font-semibold uppercase tracking-wide">Sedang Diproses</div>
            </div>
            <div>
                <div class="text-4xl font-extrabold text-green-600">{{ $reports->where('status', 'selesai')->count() }}</div>
                <div class="text-sm text-gray-500 font-semibold uppercase tracking-wide">Masalah Selesai</div>
            </div>
        </div>
    </div>

    <div id="laporan-terbaru" class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900">Apa Kata Warga Badung?</h2>
                <p class="text-gray-500 mt-2">Update laporan terbaru secara real-time.</p>
                <div class="mt-8 mb-10 max-w-3xl mx-auto">
                <form action="{{ url('/') }}#laporan-terbaru" method="GET" class="w-full max-w-4xl mx-auto bg-white p-2 rounded-3xl shadow-xl border border-gray-100 flex flex-col md:flex-row gap-2 relative z-10">
    
                    <select name="kategori" class="w-full md:w-48 border-none bg-transparent focus:ring-0 text-gray-700 font-semibold px-4 py-3 rounded-full cursor-pointer hover:bg-gray-50 transition text-center md:text-left">
                        <option value="">📂 Semua Kategori</option> <option value="Jalan" {{ request('kategori') == 'Jalan' ? 'selected' : '' }}>🛣️ Jalan Raya</option>
                        <option value="Banjir" {{ request('kategori') == 'Banjir' ? 'selected' : '' }}>🌊 Banjir</option>
                        <option value="Sampah" {{ request('kategori') == 'Sampah' ? 'selected' : '' }}>🗑️ Sampah</option>
                        <option value="Fasilitas" {{ request('kategori') == 'Fasilitas' ? 'selected' : '' }}>💡 Fasilitas</option>
                        <option value="Keamanan" {{ request('kategori') == 'Keamanan' ? 'selected' : '' }}>👮 Keamanan</option>
                    </select>

                    <div class="hidden md:block w-px bg-gray-200 my-2"></div>
                    <div class="block md:hidden h-px bg-gray-200 mx-4"></div>

                    <input type="text" name="cari" value="{{ request('cari') }}" 
                        class="flex-grow border-none focus:ring-0 px-4 py-3 text-gray-700 text-center md:text-left placeholder-gray-400" 
                        placeholder="Cari masalah (misal: 'Canggu')...">

                    <button type="submit" class="w-full md:w-auto bg-red-600 text-white px-8 py-3 rounded-full font-bold hover:bg-red-700 transition shadow-lg flex items-center justify-center gap-2 transform active:scale-95">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        Cari
                    </button>
                </form>

                @if(request('cari') || request('kategori'))
                    <div class="text-center mt-3">
                        <a href="{{ url('/') }}#laporan-terbaru" class="text-red-500 text-sm font-semibold hover:underline">🔄 Reset Pencarian</a>
                    </div>
                @endif
            </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($reports as $report)
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover-scale group">
                    <div class="relative h-56 bg-gray-200 overflow-hidden">
                        @if($report->image)
                            <img src="{{ asset('storage/' . $report->image) }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-gray-400">No Image</div>
                        @endif
                        
                        <div class="absolute top-4 right-4 px-3 py-1 rounded-full text-xs font-bold text-white shadow-md
                            {{ $report->status == 'pending' ? 'bg-yellow-500' : '' }}
                            {{ $report->status == 'proses' ? 'bg-blue-500' : '' }}
                            {{ $report->status == 'selesai' ? 'bg-green-500' : '' }}
                            {{ $report->status == 'ditolak' ? 'bg-red-500' : '' }}
                        ">
                            {{ strtoupper($report->status) }}
                        </div>
                    </div>

                    <div class="p-6">
                        <div class="flex items-center gap-2 mb-3">
                            <div class="w-8 h-8 rounded-full bg-gradient-to-tr from-red-500 to-orange-500 flex items-center justify-center text-white font-bold text-xs">
                                {{ substr($report->user->name, 0, 1) }}
                            </div>
                            <div class="text-xs text-gray-500">
                                <span class="font-bold text-gray-900 block">{{ $report->user->name }}</span>
                                {{ $report->created_at->diffForHumans() }}
                            </div>
                        </div>

                        <a href="{{ route('reports.show', $report->id) }}">
                            <h3 class="font-bold text-xl text-gray-900 mb-2 hover:text-red-600 transition truncate">{{ $report->title }}</h3>
                        </a>
                        <p class="text-gray-600 text-sm line-clamp-2 mb-4">{{ $report->description }}</p>

                        <div class="flex items-center gap-2 text-xs text-gray-400 border-t pt-4">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            {{ Str::limit($report->location, 30) }}
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            
        </div>
    </div>

    <footer class="bg-gray-900 text-white py-10 border-t border-gray-800">
        <div class="max-w-7xl mx-auto px-6 lg:px-8 flex flex-col md:flex-row justify-between items-center text-center md:text-left gap-6">
            <div>
                <h2 class="text-2xl font-bold tracking-tight">Lapor<span class="text-red-500">Badung</span></h2>
                <p class="text-gray-400 text-sm mt-1">Membangun Badung yang lebih baik, satu laporan setiap waktu.</p>
            </div>
            <div class="text-gray-500 text-sm">
                &copy; {{ date('Y') }} Pemerintah Kabupaten Badung. All rights reserved.
            </div>
        </div>
    </footer>

</body>
</html>