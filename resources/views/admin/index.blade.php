<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Dashboard - Kendali Laporan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if (session('success'))
            <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 5000)" x-show="show" class="fixed bottom-5 right-5 z-50 bg-green-600 text-white px-6 py-4 rounded-lg shadow-2xl flex items-center gap-4">
                <span class="font-bold">{{ session('success') }}</span>
                <button @click="show = false" class="text-green-200 hover:text-white">X</button>
            </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 overflow-x-auto">
                    
                    <table class="min-w-full table-auto">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-4 py-2 text-left">Pelapor</th>
                                <th class="px-4 py-2 text-left">Masalah</th>
                                <th class="px-4 py-2 text-left">Lokasi & Foto</th>
                                <th class="px-4 py-2 text-left">Status Saat Ini</th>
                                <th class="px-4 py-2 text-left">Ubah Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($reports as $report)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="px-4 py-4 align-top">
                                    <div class="font-bold">{{ $report->user->name }}</div>
                                    <div class="text-xs text-gray-500">{{ $report->created_at->format('d M Y H:i') }}</div>
                                </td>

                                <td class="px-4 py-4 align-top w-1/4">
                                    <div class="font-bold text-red-600">{{ $report->category }}</div>
                                    <p class="text-sm mt-1">{{ $report->description }}</p>
                                </td>

                                <td class="px-4 py-4 align-top">
                                    <p class="text-sm mb-2">📍 {{ $report->location }}</p>
                                    @if($report->image)
                                        <a href="{{ asset('storage/' . $report->image) }}" target="_blank">
                                            <img src="{{ asset('storage/' . $report->image) }}" class="w-20 h-20 object-cover rounded shadow hover:scale-150 transition cursor-zoom-in">
                                        </a>
                                    @else
                                        <span class="text-xs text-gray-400">No Image</span>
                                    @endif
                                </td>

                                <td class="px-4 py-4 align-top">
                                    <span class="px-2 py-1 text-xs font-bold rounded 
                                        {{ $report->status == 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                        {{ $report->status == 'proses' ? 'bg-blue-100 text-blue-800' : '' }}
                                        {{ $report->status == 'selesai' ? 'bg-green-100 text-green-800' : '' }}
                                        {{ $report->status == 'ditolak' ? 'bg-red-100 text-red-800' : '' }}
                                    ">
                                        {{ strtoupper($report->status) }}
                                    </span>
                                </td>

                                <td class="px-4 py-4 align-middle">
                                    <form action="{{ route('admin.update', $report->id) }}" method="POST" class="flex flex-col gap-2">
                                        @csrf
                                        @method('PATCH')
                                        
                                        @if($report->status == 'pending')
                                            <button name="status" value="proses" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded text-xs shadow-md transition duration-150 flex items-center justify-center gap-2">
                                                ⚡ Proses
                                            </button>
                                            
                                            <button name="status" value="ditolak" class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded text-xs shadow-md transition duration-150 flex items-center justify-center gap-2">
                                                ❌ Tolak
                                            </button>
                                        @endif

                                        @if($report->status == 'proses')
                                            <button name="status" value="selesai" class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded text-xs shadow-md transition duration-150 flex items-center justify-center gap-2">
                                                ✅ Selesai
                                            </button>
                                        @endif

                                        @if($report->status == 'selesai')
                                            <span class="text-xs text-green-600 font-bold border border-green-200 bg-green-50 px-2 py-1 rounded text-center block">Selesai</span>
                                        @endif
                                        @if($report->status == 'ditolak')
                                            <span class="text-xs text-red-600 font-bold border border-red-200 bg-red-50 px-2 py-1 rounded text-center block">Ditolak</span>
                                        @endif
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>