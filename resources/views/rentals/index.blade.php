<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            @if (auth()->user()->role === 'pelanggan')
                {{ __('Riwayat Penyewaan Saya') }}
            @else
                {{ __('Riwayat Penyewaan Pelanggan') }}
            @endif
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

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="border-b dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50">
                                    <th class="px-4 py-3 text-sm font-semibold">Mobil</th>
                                    <th class="px-4 py-3 text-sm font-semibold">Tanggal Sewa</th>
                                    <th class="px-4 py-3 text-sm font-semibold">Rencana Kembali</th>
                                    <th class="px-4 py-3 text-sm font-semibold">Durasi</th>
                                    <th class="px-4 py-3 text-sm font-semibold">Total Bayar</th>
                                    <th class="px-4 py-3 text-sm font-semibold">Status</th>
                                    <th class="px-4 py-3 text-sm font-semibold">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y dark:divide-gray-700">
                                @forelse($rentals as $rental)
                                    <tr>
                                        <td class="px-4 py-4">
                                            <div class="font-bold text-blue-600">
                                                <a href="{{ route('rentals.show', $rental->id) }}">
                                                    {{ $rental->car->nama }}
                                                </a>
                                            </div>
                                            <div class="text-xs text-gray-500">{{ $rental->car->nopol }}</div>
                                        </td>
                                        <td class="px-4 py-4 text-sm">
                                            {{ \Carbon\Carbon::parse($rental->tanggal_sewa)->format('d M Y') }}</td>
                                        <td class="px-4 py-4 text-sm">
                                            {{ \Carbon\Carbon::parse($rental->tanggal_dikembalikan)->format('d M Y') }}</td>
                                        <td class="px-4 py-4 text-sm">{{ $rental->lama_sewa }} Hari</td>
                                        <td class="px-4 py-4 text-sm font-bold">
                                            Rp {{ number_format($rental->total_bayar, 0, ',', '.') }}
                                        </td>
                                        <td class="px-4 py-4">
                                            <div class="flex items-center gap-2">
                                                @if($rental->status_transaksi == 'booking')
                                                    <span
                                                        class="px-2 py-1 text-xs font-semibold bg-yellow-100 text-yellow-800 rounded-full">Menunggu
                                                        Diambil</span>
                                                @elseif($rental->status_transaksi == 'diambil')
                                                    <span
                                                        class="px-2 py-1 text-xs font-semibold bg-blue-100 text-blue-800 rounded-full">Sedang
                                                        Digunakan</span>
                                                @elseif($rental->status_transaksi == 'kembali')
                                                    <span
                                                        class="px-2 py-1 text-xs font-semibold bg-orange-100 text-orange-800 rounded-full">Dikembalikan</span>
                                                @else
                                                    <span
                                                        class="px-2 py-1 text-xs font-semibold bg-green-100 text-green-800 rounded-full">Selesai</span>
                                                @endif


                                            </div>
                                        </td>
                                        <td>
                                            {{-- Tombol Update Status untuk Petugas/Admin --}}
                                            @if(auth()->user()->role === 'petugas' || auth()->user()->role === 'admin')
                                                @if($rental->status_transaksi == 'booking')
                                                    <form action="{{ route('rentals.updateStatus', $rental->id) }}" method="POST"
                                                        class="inline">
                                                        @csrf
                                                        @method('PATCH')
                                                        <input type="hidden" name="status" value="diambil">
                                                        <button type="submit"
                                                            class="px-2 py-1 text-xs bg-blue-500 hover:bg-blue-600 text-white rounded transition"
                                                            onclick="return confirm('Konfirmasi bahwa mobil sudah diambil pelanggan?')">
                                                            Konfirm Diambil
                                                        </button>
                                                    </form>
                                                @elseif($rental->status_transaksi == 'diambil')
                                                    <form action="{{ route('rentals.updateStatus', $rental->id) }}" method="POST"
                                                        class="inline">
                                                        @csrf
                                                        @method('PATCH')
                                                        <input type="hidden" name="status" value="kembali">
                                                        <button type="submit"
                                                            class="px-2 py-1 text-xs bg-orange-500 hover:bg-orange-600 text-white rounded transition"
                                                            onclick="return confirm('Konfirmasi bahwa mobil sudah dikembalikan?')">
                                                            Terima Kembali
                                                        </button>
                                                    </form>
                                                @elseif($rental->status_transaksi == 'kembali')
                                                    <form action="{{ route('rentals.updateStatus', $rental->id) }}" method="POST"
                                                        class="inline">
                                                        @csrf
                                                        @method('PATCH')
                                                        <input type="hidden" name="status" value="selesai">
                                                        <button type="submit"
                                                            class="px-2 py-1 text-xs bg-green-500 hover:bg-green-600 text-white rounded transition"
                                                            onclick="return confirm('Selesaikan transaksi rental ini?')">
                                                            Selesaikan
                                                        </button>
                                                    </form>
                                                @endif
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-4 py-8 text-center text-gray-500">
                                            Belum ada data rental.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>