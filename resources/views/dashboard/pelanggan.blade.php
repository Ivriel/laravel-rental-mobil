<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
    <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Total Rental Saya</h3>
        <p class="text-3xl font-bold text-blue-600">{{ $myRentals }}</p>
    </div>
    
    <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Rental Aktif</h3>
        <p class="text-3xl font-bold text-yellow-600">{{ $activeRentals }}</p>
    </div>
    
    <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Rental Selesai</h3>
        <p class="text-3xl font-bold text-green-600">{{ $completedRentals }}</p>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
    <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Total Pengeluaran</h3>
        <p class="text-3xl font-bold text-purple-600">Rp {{ number_format($totalSpent, 0, ',', '.') }}</p>
        <p class="text-sm text-gray-500 mt-2">Semua rental</p>
    </div>
    
    <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Mobil Tersedia</h3>
        <p class="text-3xl font-bold text-blue-600">{{ $availableCars }}</p>
        <p class="text-sm text-gray-500 mt-2">Siap disewa</p>
    </div>
</div>

<div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Rental Terbaru Saya</h3>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b">
                    <th class="text-left py-2">Mobil</th>
                    <th class="text-left py-2">Tanggal Sewa</th>
                    <th class="text-left py-2">Status</th>
                    <th class="text-left py-2">Total</th>
                    <th class="text-left py-2">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($recentRentals as $rental)
                <tr class="border-b">
                    <td class="py-2">{{ $rental->car->nama }}</td>
                    <td class="py-2">{{ $rental->tanggal_sewa }}</td>
                    <td class="py-2">
                        <span class="px-2 py-1 text-xs rounded-full 
                            @if($rental->status_transaksi == 'booking') bg-yellow-100 text-yellow-800
                            @elseif($rental->status_transaksi == 'diambil') bg-blue-100 text-blue-800
                            @elseif($rental->status_transaksi == 'kembali') bg-orange-100 text-orange-800
                            @else bg-green-100 text-green-800 @endif">
                            {{ ucfirst($rental->status_transaksi) }}
                        </span>
                    </td>
                    <td class="py-2">Rp {{ number_format($rental->total_bayar, 0, ',', '.') }}</td>
                    <td class="py-2">
                        <a href="{{ route('rentals.show', $rental->id) }}" 
                           class="text-blue-600 hover:text-blue-800 text-sm">Detail</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>