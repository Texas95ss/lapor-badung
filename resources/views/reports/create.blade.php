<x-app-layout>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <style>
        #map { height: 400px; width: 100%; border-radius: 0.5rem; z-index: 0; }
    </style>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Buat Laporan Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                @if ($errors->any())
                    <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>• {{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('reports.store') }}" enctype="multipart/form-data">
                    @csrf <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Judul Laporan</label>
                        <input type="text" name="title" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500" placeholder="Contoh: Jalan Berlubang Besar" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Kategori</label>
                        <select name="category" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500">
                            <option value="Fasilitas">Fasilitas Umum</option>
                            <option value="Jalan">Jalan Raya / Jembatan</option>
                            <option value="Banjir">Banjir / Drainase</option>
                            <option value="Sampah">Sampah / Kebersihan</option>
                            <option value="Keamanan">Keamanan / Ketertiban</option>
                            <option value="Lainnya">Lainnya</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Lokasi Kejadian</label>
                        <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Lokasi Kejadian (Klik Peta)</label>
                        
                        <input type="text" name="location" id="locationName" class="w-full border-gray-300 rounded-md shadow-sm mb-3" placeholder="Contoh: Depan Pasar Badung (Atau klik peta di bawah)" required>
                        
                        <input type="hidden" name="latitude" id="latitude">
                        <input type="hidden" name="longitude" id="longitude">

                        <div id="map" class="border border-gray-300 shadow-sm"></div>
                        <p class="text-xs text-gray-500 mt-1">*Geser peta dan klik titik lokasi kejadian.</p>
                    </div>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Detail Masalah</label>
                        <textarea name="description" rows="4" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500" placeholder="Jelaskan detail masalahnya..." required></textarea>
                    </div>

                    <div class="mb-6">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Bukti Foto</label>
                        <input type="file" name="image" class="block w-full text-sm text-gray-500
                          file:mr-4 file:py-2 file:px-4
                          file:rounded-full file:border-0
                          file:text-sm file:font-semibold
                          file:bg-red-50 file:text-red-700
                          hover:file:bg-red-100" required>
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-6 rounded-full shadow-lg transition duration-300">
                            KIRIM LAPORAN 🚀
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
    <script>
        // 1. Inisialisasi Peta (Koordinat Awal: Pusat Badung/Bali)
        var map = L.map('map').setView([-8.5830695, 115.1786657], 13); // Koordinat Mengwi/Badung Tengah

        // 2. Pasang Tile Layer (Gambar Peta dari OpenStreetMap)
        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; OpenStreetMap'
        }).addTo(map);

        // 3. Buat Variabel Marker (Pin Merah)
        var marker;

        // 4. Event: Kalau Peta Diklik
        map.on('click', function(e) {
            var lat = e.latlng.lat;
            var lng = e.latlng.lng;

            // Pindahkan Marker ke titik klik
            if (marker) {
                marker.setLatLng(e.latlng);
            } else {
                marker = L.marker(e.latlng).addTo(map);
            }

            // Isi Input Tersembunyi
            document.getElementById('latitude').value = lat;
            document.getElementById('longitude').value = lng;

            // Opsional: Isi kolom teks lokasi dengan koordinat (biar user tau udah keisi)
            // document.getElementById('locationName').value = "Koordinat: " + lat.toFixed(5) + ", " + lng.toFixed(5);
        });
    </script>
</x-app-layout>