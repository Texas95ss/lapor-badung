<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Detail Laporan - {{ $report->title }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
</head>
<body class="bg-gray-50 text-gray-800 font-sans antialiased">

    <nav class="bg-white shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <a href="{{ url('/') }}" class="text-xl font-bold text-red-600 tracking-tighter">
                    &larr; HOME
                </a>
                @auth
                    <a href="{{ url('/dashboard') }}" class="text-sm font-medium text-gray-700">Dashboard Saya</a>
                @else
                    <a href="{{ route('login') }}" class="text-sm font-medium text-gray-700">Login</a>
                @endauth
            </div>
        </div>
    </nav>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            <div class="w-full h-96 bg-gray-200 flex items-center justify-center overflow-hidden">
                @if($report->image)
                    <img src="{{ asset('storage/' . $report->image) }}" class="w-full h-full object-cover">
                @else
                    <span class="text-gray-400">Tidak ada foto lampiran</span>
                @endif
            </div>

            <div class="p-8">
                <div class="flex justify-between items-center mb-6">
                    <span class="px-4 py-2 text-sm font-bold rounded-full 
                        {{ $report->status == 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                        {{ $report->status == 'proses' ? 'bg-blue-100 text-blue-800' : '' }}
                        {{ $report->status == 'selesai' ? 'bg-green-100 text-green-800' : '' }}
                        {{ $report->status == 'ditolak' ? 'bg-red-100 text-red-800' : '' }}
                    ">
                        STATUS: {{ strtoupper($report->status) }}
                    </span>
                    <span class="text-gray-500 text-sm">{{ $report->created_at->format('d F Y, H:i') }} WITA</span>
                </div>

                <h1 class="text-3xl font-extrabold text-gray-900 mb-2">{{ $report->title }}</h1>
                <div class="flex items-center gap-2 mb-6 text-gray-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    <span>Dilaporkan oleh: <strong>{{ $report->user->name }}</strong></span>
                </div>

                <hr class="border-gray-200 mb-6">

                <div class="mb-8">
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Lokasi:</h3>
                    <p class="text-gray-600 mb-4 flex items-center gap-2">
                    @if($report->latitude && $report->longitude)
                        <div id="map" class="h-64 w-full rounded-xl shadow-md border border-gray-200 mt-4 z-0"></div>

                        <script>
                            // Ambil data koordinat dari PHP
                            var lat = {{ $report->latitude }};
                            var lng = {{ $report->longitude }};

                            // Pasang Peta
                            var map = L.map('map').setView([lat, lng], 15); // Zoom level 15 biar agak dekat

                            L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                                maxZoom: 19,
                                attribution: '&copy; OpenStreetMap'
                            }).addTo(map);

                            // Pasang Pin (Marker)
                            L.marker([lat, lng]).addTo(map)
                                .bindPopup("<b>Lokasi Kejadian</b><br>{{ $report->location }}")
                                .openPopup();
                        </script>
                    @else
                        <div class="bg-gray-100 text-gray-500 p-4 rounded text-sm text-center">
                            Pelapor tidak menyertakan titik lokasi peta.
                        </div>
                    @endif
                        <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        {{ $report->location }}
                    </p>

                    <h3 class="text-lg font-bold text-gray-900 mb-2">Detail Keluhan:</h3>
                    <p class="text-gray-700 leading-relaxed text-lg whitespace-pre-wrap">{{ $report->description }}</p>
                </div>

                @if($report->status == 'selesai')
                <div class="bg-green-50 border border-green-200 rounded-lg p-6 mt-8">
                    <h3 class="text-green-800 font-bold text-lg mb-2">🎉 Laporan Selesai</h3>
                    <p class="text-green-700">Masalah ini telah ditangani oleh pihak terkait. Terima kasih atas laporan Anda!</p>
                </div>
                @endif

            </div>
        <div class="px-8 pb-8"> 

            <hr class="border-gray-200 mb-8">

            <h3 class="text-xl font-bold text-gray-900 mb-6">Diskusi & Tindak Lanjut ({{ $report->comments->count() }})</h3>

            <div class="space-y-6 mb-8">
                @foreach($report->comments as $comment)
                <div class="flex gap-4 {{ $comment->user->role == 'admin' ? 'flex-row-reverse text-right' : '' }}">
                    <div class="flex-shrink-0">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center font-bold text-white
                            {{ $comment->user->role == 'admin' ? 'bg-red-600' : 'bg-gray-400' }}">
                            {{ substr($comment->user->name, 0, 1) }}
                        </div>
                    </div>
                    <div class="max-w-lg">
                        <div class="text-sm text-gray-500 mb-1">
                            <span class="font-bold text-gray-900">{{ $comment->user->name }}</span>
                            <span class="text-xs">• {{ $comment->created_at->diffForHumans() }}</span>
                        </div>
                        <div class="px-4 py-3 rounded-2xl text-sm shadow-sm
                            {{ $comment->user->role == 'admin' 
                                ? 'bg-red-50 text-red-900 rounded-tr-none border border-red-100' 
                                : 'bg-gray-100 text-gray-800 rounded-tl-none' }}">
                            {{ $comment->message }}
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            @auth
            <form action="{{ route('comments.store') }}" method="POST" class="bg-gray-50 p-4 rounded-xl flex gap-4 items-start border border-gray-200">
                @csrf
                <input type="hidden" name="report_id" value="{{ $report->id }}">
                
                <div class="w-10 h-10 rounded-full bg-gray-800 flex items-center justify-center font-bold text-white flex-shrink-0">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
                
                <div class="flex-grow">
                    <textarea name="message" rows="2" class="w-full border-gray-300 rounded-lg focus:ring-red-500 focus:border-red-500" placeholder="Tulis komentar atau update perkembangan..."></textarea>
                    <div class="mt-2 flex justify-end">
                        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-6 rounded-full text-sm shadow-lg transition">
                            Kirim Balasan ✈️
                        </button>
                    </div>
                </div>
            </form>
            @else
                <div class="bg-gray-100 p-4 rounded-lg text-center text-gray-500 text-sm">
                    Ingin ikut berdiskusi? <a href="{{ route('login') }}" class="text-red-600 font-bold hover:underline">Login dulu yuk!</a>
                </div>
            @endauth

        </div> 
        </div>
    
    </div>

</body>
</html>