<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Laporan Saya') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="mb-6 flex justify-end">
                <a href="{{ route('reports.create') }}" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded-full shadow-lg transition">
                    + Buat Laporan Baru
                </a>
            </div>

            @if (session('success'))
            <div x-data="{ show: true }"
                x-init="setTimeout(() => show = false, 5000)"
                x-show="show"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 transform translate-y-2"
                x-transition:enter-end="opacity-100 transform translate-y-0"
                x-transition:leave="transition ease-in duration-300"
                x-transition:leave-start="opacity-100 transform translate-y-0"
                x-transition:leave-end="opacity-0 transform translate-y-2"
                class="fixed bottom-5 right-5 z-50 bg-green-600 text-white px-6 py-4 rounded-lg shadow-2xl flex items-center gap-4"
                style="display: none;"> <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>

                <span class="font-bold">{{ session('success') }}</span>

                <button @click="show = false" class="text-green-200 hover:text-white transition focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-3 sm:p-6 text-gray-900">
                    
                    @if($reports->isEmpty())
                        <div class="text-center py-10">
                            <p class="text-gray-500 text-lg">Kamu belum pernah membuat laporan.</p>
                            <a href="{{ route('reports.create') }}" class="text-red-600 hover:underline mt-2 inline-block">Yuk lapor sekarang!</a>
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="w-full min-w-[600px] leading-normal">
                                <thead>
                                    <tr>
                                        <th class="px-3 py-3 md:px-5 md:py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                            Foto
                                        </th>
                                        <th class="px-3 py-3 md:px-5 md:py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                            Judul Laporan
                                        </th>
                                        <th class="px-3 py-3 md:px-5 md:py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                            Tanggal
                                        </th>
                                        <th class="px-3 py-3 md:px-5 md:py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                            Status
                                        </th>
                                        <th class="px-3 py-3 md:px-5 md:py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                            Aksi
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($reports as $report)
                                    <tr>
                                        <td class="px-3 py-3 md:px-5 md:py-5 border-b border-gray-200 bg-white text-sm">
                                            <div class="flex-shrink-0 w-16 h-16">
                                                @if($report->image)
                                                    <img class="w-full h-full rounded object-cover" src="{{ asset('storage/' . $report->image) }}" alt="" />
                                                @else
                                                    <div class="w-full h-full bg-gray-200 rounded flex items-center justify-center text-xs">No Pic</div>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="px-3 py-3 md:px-5 md:py-5 border-b border-gray-200 bg-white text-sm">
                                            <p class="text-gray-900 font-bold whitespace-no-wrap">{{ $report->title }}</p>
                                            <p class="text-gray-600 text-xs">{{ $report->location }}</p>
                                        </td>
                                        <td class="px-3 py-3 md:px-5 md:py-5 border-b border-gray-200 bg-white text-sm">
                                            <p class="text-gray-900 whitespace-no-wrap">{{ $report->created_at->format('d M Y') }}</p>
                                        </td>
                                        <td class="px-3 py-3 md:px-5 md:py-5 border-b border-gray-200 bg-white text-sm">
                                            <span class="relative inline-block px-3 py-1 font-semibold leading-tight rounded-full
                                                {{ $report->status == 'pending' ? 'bg-yellow-100 text-yellow-900' : '' }}
                                                {{ $report->status == 'proses' ? 'bg-blue-100 text-blue-900' : '' }}
                                                {{ $report->status == 'selesai' ? 'bg-green-100 text-green-900' : '' }}
                                                {{ $report->status == 'ditolak' ? 'bg-red-100 text-red-900' : '' }}
                                            ">
                                                <span aria-hidden class="absolute inset-0 opacity-50 rounded-full"></span>
                                                <span class="relative">{{ ucfirst($report->status) }}</span>
                                            </span>
                                        </td>
                                        <td class="px-3 py-3 md:px-5 md:py-5 border-b border-gray-200 bg-white text-sm">
                                            <a href="{{ route('reports.show', $report->id) }}" class="text-blue-600 hover:text-blue-900 font-bold">Lihat Detail &rarr;</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>