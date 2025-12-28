<!-- Box Total Pendapatan - Paling Besar -->
<div class="mb-6">
    <div class="bg-gradient-to-r from-green-500 to-blue-600 p-8 rounded-xl shadow-lg text-white">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-2xl font-bold mb-2">💰 Total Pendapatan</h3>
                <p class="text-5xl font-bold">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
                <p class="text-green-100 mt-2">Semua transaksi rental</p>
            </div>
            <div class="text-6xl opacity-20">
                💵
            </div>
        </div>
    </div>
</div>

<!-- Grid Box Statistik Utama -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
    <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow hover:shadow-lg transition-shadow">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Total Mobil</h3>
                <p class="text-3xl font-bold text-blue-600">{{ $totalCars }}</p>
            </div>
            <div class="text-3xl text-blue-500">🚗</div>
        </div>
    </div>
    
    <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow hover:shadow-lg transition-shadow">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Total Pelanggan</h3>
                <p class="text-3xl font-bold text-green-600">{{ $totalUsers }}</p>
            </div>
            <div class="text-3xl text-green-500">👥</div>
        </div>
    </div>
    
    <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow hover:shadow-lg transition-shadow">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Total Rental</h3>
                <p class="text-3xl font-bold text-purple-600">{{ $totalRentals }}</p>
            </div>
            <div class="text-3xl text-purple-500">📋</div>
        </div>
    </div>
    
    <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow hover:shadow-lg transition-shadow">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Mobil Tersedia</h3>
                <p class="text-3xl font-bold text-green-600">{{ $availableCars }}</p>
            </div>
            <div class="text-3xl text-green-500">✅</div>
        </div>
    </div>
</div>

<!-- Grid Box Status Rental -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
    <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow hover:shadow-lg transition-shadow">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Rental Aktif</h3>
                <p class="text-3xl font-bold text-blue-600">{{ $totalActiveRentals }}</p>
                <p class="text-sm text-gray-500 mt-1">Sedang digunakan</p>
            </div>
            <div class="text-3xl text-blue-500">🔄</div>
        </div>
    </div>

    <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow hover:shadow-lg transition-shadow">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Pending Booking</h3>
                <p class="text-3xl font-bold text-yellow-600">{{ $totalPendingRentals }}</p>
                <p class="text-sm text-gray-500 mt-1">Menunggu diambil</p>
            </div>
            <div class="text-3xl text-yellow-500">⏳</div>
        </div>
    </div>

    <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow hover:shadow-lg transition-shadow">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Perlu Dikembalikan</h3>
                <p class="text-3xl font-bold text-red-600">{{ $totalReturnedRentals }}</p>
                <p class="text-sm text-gray-500 mt-1">Proses pengembalian</p>
            </div>
            <div class="text-3xl text-red-500">🔙</div>
        </div>
    </div>
</div>

<!-- Tabel Rental Terbaru -->
<div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">📊 Rental Terbaru</h3>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b dark:border-gray-700">
                    <th class="text-left py-3 px-2 font-semibold">Pelanggan</th>
                    <th class="text-left py-3 px-2 font-semibold">Mobil</th>
                    <th class="text-left py-3 px-2 font-semibold">Tanggal</th>
                    <th class="text-left py-3 px-2 font-semibold">Status</th>
                    <th class="text-left py-3 px-2 font-semibold">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($recentRentals as $rental)
                <tr class="border-b dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700">
                    <td class="py-3 px-2">{{ $rental->user->name }}</td>
                    <td class="py-3 px-2">{{ $rental->car->nama }}</td>
                    <td class="py-3 px-2">{{ $rental->tanggal_sewa }}</td>
                    <td class="py-3 px-2">
                        <span class="px-2 py-1 text-xs rounded-full font-medium
                            @if($rental->status_transaksi == 'booking') bg-yellow-100 text-yellow-800
                            @elseif($rental->status_transaksi == 'diambil') bg-blue-100 text-blue-800
                            @elseif($rental->status_transaksi == 'kembali') bg-orange-100 text-orange-800
                            @else bg-green-100 text-green-800 @endif">
                            {{ ucfirst($rental->status_transaksi) }}
                        </span>
                    </td>
                    <td class="py-3 px-2 font-semibold">Rp {{ number_format($rental->total_bayar, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>