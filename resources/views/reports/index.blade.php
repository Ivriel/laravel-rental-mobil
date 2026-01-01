<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Laporan Penyewaan
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Alert Success --}}
            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 border-l-4 border-green-500 text-green-700">
                    {{ session('success') }}
                </div>
            @endif
            {{-- Filter Form --}}
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-semibold mb-4 text-blue-600 dark:text-blue-400">Filter Laporan</h3>
                    
                    <form method="GET" action="{{ route('reports.index') }}" class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            {{-- Filter Tanggal Mulai --}}
                            <div>
                                <label for="start_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tanggal Mulai</label>
                                <input type="date" name="start_date" id="start_date" 
                                    value="{{ request('start_date') }}"
                                    class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            {{-- Filter Tanggal Akhir --}}
                            <div>
                                <label for="end_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tanggal Akhir</label>
                                <input type="date" name="end_date" id="end_date" 
                                    value="{{ request('end_date') }}"
                                    class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            {{-- Filter Status --}}
                            <div>
                                <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Status</label>
                                <select name="status" id="status" 
                                    class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                    <option value="">Semua Status</option>
                                    <option value="booking" {{ request('status') == 'booking' ? 'selected' : '' }}>Booking</option>
                                    <option value="diambil" {{ request('status') == 'diambil' ? 'selected' : '' }}>Diambil</option>
                                    <option value="kembali" {{ request('status') == 'kembali' ? 'selected' : '' }}>Kembali</option>
                                    <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                </select>
                            </div>
                            {{-- Filter Pelanggan (hanya untuk admin/petugas) --}}
                            @if(in_array(auth()->user()->role, ['admin', 'petugas']))
                                <div>
                                    <label for="user_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Pelanggan</label>
                                    <select name="user_id" id="user_id" 
                                        class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                        <option value="">Semua Pelanggan</option>
                                        @foreach($users as $user)
                                            <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                                                {{ $user->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            @endif
                            {{-- Filter Mobil --}}
                            <div>
                                <label for="car_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Mobil</label>
                                <select name="car_id" id="car_id" 
                                    class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                    <option value="">Semua Mobil</option>
                                    @foreach($cars as $car)
                                        <option value="{{ $car->id }}" {{ request('car_id') == $car->id ? 'selected' : '' }}>
                                            {{ $car->nama }} ({{ $car->nopol }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="flex items-center justify-between pt-4">
                            <div class="flex gap-2">
                                <button type="submit" 
                                    class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md transition flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                    Filter
                                </button>
                                
                                <a href="{{ route('reports.index') }}" 
                                    class="px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-md transition">
                                    Reset
                                </a>
                            </div>
                            {{-- Export Buttons --}}
                            <div class="flex gap-2">
                                <button type="button" onclick="exportPdf()" 
                                    class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-md transition flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    Export PDF
                                </button>
                                
                                <button type="button" onclick="exportExcel()" 
                                    class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-md transition flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    Export Excel
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            {{-- Statistics Cards --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                {{-- Total Rentals --}}
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Rental</p>
                                <p class="text-2xl font-semibold text-gray-900 dark:text-gray-100">{{ $stats['total_rentals'] }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- Total Revenue --}}
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1" />
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Pendapatan</p>
                                <p class="text-2xl font-semibold text-gray-900 dark:text-gray-100">Rp {{ number_format($stats['total_revenue'], 0, ',', '.') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- Active Rentals --}}
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 bg-yellow-500 rounded-full flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Rental Aktif</p>
                                <p class="text-2xl font-semibold text-gray-900 dark:text-gray-100">{{ $stats['active_rentals'] }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- Completed Rentals --}}
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 bg-green-600 rounded-full flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Rental Selesai</p>
                                <p class="text-2xl font-semibold text-gray-900 dark:text-gray-100">{{ $stats['completed_rentals'] }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- Additional Stats --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                {{-- Average Duration --}}
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h4 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-2">Rata-rata Lama Sewa</h4>
                        <p class="text-3xl font-bold text-blue-600">{{ number_format($stats['avg_rental_duration'], 1) }} Hari</p>
                    </div>
                </div>
                {{-- Most Rented Car --}}
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h4 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-2">Mobil Terfavorit</h4>
                        @if($stats['most_rented_car'])
                            <p class="text-lg font-semibold text-green-600">{{ $stats['most_rented_car']->car->nama }}</p>
                            <p class="text-sm text-gray-500">{{ $stats['most_rented_car']->rental_count }} kali disewa</p>
                        @else
                            <p class="text-gray-500">Tidak ada data</p>
                        @endif
                    </div>
                </div>
                {{-- Top Customer --}}
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h4 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-2">Customer Terbaik</h4>
                        @if($stats['top_customer'])
                            <p class="text-lg font-semibold text-purple-600">{{ $stats['top_customer']->user->name }}</p>
                            <p class="text-sm text-gray-500">{{ $stats['top_customer']->rental_count }} rental | Rp {{ number_format($stats['top_customer']->total_spent, 0, ',', '.') }}</p>
                        @else
                            <p class="text-gray-500">Tidak ada data</p>
                        @endif
                    </div>
                </div>
            </div>
            {{-- Data Table --}}
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-semibold mb-4">Data Rental</h3>
                    
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="border-b dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50">
                                    <th class="px-4 py-3 text-sm font-semibold">ID</th>
                                    <th class="px-4 py-3 text-sm font-semibold">Pelanggan</th>
                                    <th class="px-4 py-3 text-sm font-semibold">Mobil</th>
                                    <th class="px-4 py-3 text-sm font-semibold">Tanggal Sewa</th>
                                    <th class="px-4 py-3 text-sm font-semibold">Durasi</th>
                                    <th class="px-4 py-3 text-sm font-semibold">Total Bayar</th>
                                    <th class="px-4 py-3 text-sm font-semibold">Status</th>
                                    <th class="px-4 py-3 text-sm font-semibold">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y dark:divide-gray-700">
                                @forelse($rentals as $rental)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                        <td class="px-4 py-4 text-sm">#{{ $rental->id }}</td>
                                        <td class="px-4 py-4">
                                            <div class="font-medium">{{ $rental->user->name }}</div>
                                            <div class="text-xs text-gray-500">{{ $rental->user->email }}</div>
                                        </td>
                                        <td class="px-4 py-4">
                                            <div class="font-medium text-blue-600">{{ $rental->car->nama }}</div>
                                            <div class="text-xs text-gray-500">{{ $rental->car->nopol }}</div>
                                        </td>
                                        <td class="px-4 py-4 text-sm">
                                            {{ \Carbon\Carbon::parse($rental->tanggal_sewa)->format('d M Y') }}
                                        </td>
                                        <td class="px-4 py-4 text-sm">{{ $rental->lama_sewa }} Hari</td>
                                        <td class="px-4 py-4 text-sm font-semibold">
                                            Rp {{ number_format($rental->total_bayar, 0, ',', '.') }}
                                        </td>
                                        <td class="px-4 py-4">
                                            @if($rental->status_transaksi == 'booking')
                                                <span class="px-2 py-1 text-xs font-semibold bg-yellow-100 text-yellow-800 rounded-full">Booking</span>
                                            @elseif($rental->status_transaksi == 'diambil')
                                                <span class="px-2 py-1 text-xs font-semibold bg-blue-100 text-blue-800 rounded-full">Diambil</span>
                                            @elseif($rental->status_transaksi == 'kembali')
                                                <span class="px-2 py-1 text-xs font-semibold bg-orange-100 text-orange-800 rounded-full">Kembali</span>
                                            @else
                                                <span class="px-2 py-1 text-xs font-semibold bg-green-100 text-green-800 rounded-full">Selesai</span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-4">
                                            <a href="{{ route('rentals.show', $rental->id) }}" 
                                                class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                                Detail
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="px-4 py-8 text-center text-gray-500">
                                            Tidak ada data rental ditemukan.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    {{-- Pagination --}}
                    @if($rentals->hasPages())
                        <div class="mt-6">
                            {{ $rentals->appends(request()->query())->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    {{-- JavaScript for Export Functions --}}
    <script>
        function exportPdf() {
            const params = new URLSearchParams(window.location.search);
            window.open(`{{ route('reports.export-pdf') }}?${params.toString()}`, '_blank');
        }
        function exportExcel() {
            const params = new URLSearchParams(window.location.search);
            window.open(`{{ route('reports.export-excel') }}?${params.toString()}`, '_blank');
        }
    </script>
</x-app-layout>