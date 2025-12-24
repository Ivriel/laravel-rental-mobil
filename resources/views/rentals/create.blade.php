<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Konfirmasi Penyewaan Mobil') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <form action="{{ route('rentals.store') }}" method="POST">
                    @csrf
                    
                    {{-- Hidden ID untuk dikirim ke Controller --}}
                    <input type="hidden" name="car_id" value="{{ $selectedCar->id }}">

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        
                        {{-- KOLOM KIRI: DETAIL KENDARAAN (READONLY) --}}
                        <div class="space-y-4">
                            <h3 class="font-bold text-lg border-b pb-2 text-blue-500">Detail Kendaraan</h3>
                            
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-500">Nama Mobil</label>
                                    <input type="text" value="{{ $selectedCar->nama }}" class="mt-1 block w-full bg-gray-100 dark:bg-gray-700 border-none rounded-md text-gray-600" readonly>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-500">Nomor Polisi</label>
                                    <input type="text" value="{{ $selectedCar->nopol }}" class="mt-1 block w-full bg-gray-100 dark:bg-gray-700 border-none rounded-md text-gray-600" readonly>
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-500">Warna</label>
                                    <input type="text" value="{{ $selectedCar->warna }}" class="mt-1 block w-full bg-gray-100 dark:bg-gray-700 border-none rounded-md text-gray-600" readonly>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-500">Tahun</label>
                                    <input type="text" value="{{ $selectedCar->tahun }}" class="mt-1 block w-full bg-gray-100 dark:bg-gray-700 border-none rounded-md text-gray-600" readonly>
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-500">Kapasitas Penumpang</label>
                                <input type="text" value="{{ $selectedCar->kapasitas_penumpang }} Orang" class="mt-1 block w-full bg-gray-100 dark:bg-gray-700 border-none rounded-md text-gray-600" readonly>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-blue-600 font-bold">Harga Sewa / Hari</label>
                                <input type="text" value="Rp {{ number_format($selectedCar->harga_per_hari, 0, ',', '.') }}" class="mt-1 block w-full bg-blue-50 dark:bg-gray-700 border-none rounded-md font-bold text-blue-700" readonly>
                            </div>
                        </div>

                        {{-- KOLOM KANAN: INFORMASI PENYEWAAN (INPUT) --}}
                        <div class="space-y-4">
                            <h3 class="font-bold text-lg border-b pb-2 text-green-500">Informasi Penyewaan</h3>
                            
                            <div>
                                <label for="tanggal_sewa" class="block text-sm font-medium">Tanggal Mulai Sewa</label>
                                <input type="date" name="tanggal_sewa" id="tanggal_sewa" min="{{ date('Y-m-d') }}" 
                                    class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 rounded-md shadow-sm focus:ring-green-500" 
                                    required onchange="hitungDurasi()">
                            </div>

                            <div>
                                <label for="tanggal_dikembalikan" class="block text-sm font-medium">Tanggal Rencana Kembali</label>
                                <input type="date" name="tanggal_dikembalikan" id="tanggal_dikembalikan" min="{{ date('Y-m-d') }}" 
                                    class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 rounded-md shadow-sm focus:ring-green-500" 
                                    required onchange="hitungDurasi()">
                            </div>

                            <div>
                                <label for="lama_sewa" class="block text-sm font-medium text-gray-500">Lama Sewa (Hari)</label>
                                <input type="number" name="lama_sewa" id="lama_sewa" 
                                    class="mt-1 block w-full bg-gray-50 dark:bg-gray-700 border-gray-200 rounded-md shadow-sm font-semibold" 
                                    placeholder="Otomatis terhitung..." readonly required>
                            </div>

                            <div class="p-4 bg-green-50 dark:bg-green-900/20 rounded-lg">
                                <p class="text-sm text-gray-600 dark:text-gray-400">Total Bayar:</p>
                                <input type="hidden" name="total_bayar" id="total_bayar">
                                <h2 id="display_total" class="text-3xl font-bold text-green-600">Rp 0</h2>
                            </div>
                        </div>
                    </div>

                    <div class="mt-8 pt-6 border-t flex justify-end items-center">
                        <a href="{{ route('cars.index') }}" class="text-gray-500 hover:text-gray-700 mr-6 transition">Kembali ke Daftar Mobil</a>
                        <x-primary-button class="bg-green-600 hover:bg-green-700">
                            {{ __('Proses Booking Sekarang') }}
                        </x-primary-button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    {{-- Script Hitung Otomatis Inklusif --}}
    <script>
        function hitungDurasi() {
            const tglSewa = document.getElementById('tanggal_sewa').value;
            const tglKembali = document.getElementById('tanggal_dikembalikan').value;
            const inputLamaSewa = document.getElementById('lama_sewa');
            const displayTotal = document.getElementById('display_total');
            const inputTotalBayar = document.getElementById('total_bayar');
            const hargaPerHari = {{ $selectedCar->harga_per_hari }};

            if (tglSewa && tglKembali) {
                const start = new Date(tglSewa);
                const end = new Date(tglKembali);
                
                // Selisih dalam milidetik
                const diffTime = end - start;
                
                // Konversi ke hari (ditambah 1 agar inklusif)
                const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)) + 1;

                if (diffDays > 0) {
                    inputLamaSewa.value = diffDays;
                    const total = diffDays * hargaPerHari;
                    displayTotal.innerText = "Rp " + new Intl.NumberFormat('id-ID').format(total);
                    inputTotalBayar.value = total;
                } else {
                    // Reset jika tanggal kembali ngaco (lebih kecil dari tgl sewa)
                    alert("Tanggal kembali tidak boleh sebelum tanggal sewa!");
                    document.getElementById('tanggal_dikembalikan').value = "";
                    inputLamaSewa.value = "";
                    displayTotal.innerText = "Rp 0";
                }
            }
        }
    </script>
</x-app-layout>