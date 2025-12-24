<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            Detail Rental #{{ $rental->id }}
        </h2>
    </x-slot>

    <style>
        @media print {

            /* Sembunyikan Navigasi, Tombol Kembali, dan Tombol Cetak */
            nav,
            .nav-container,
            button,
            .back-link,
            header,
            footer {
                display: none !important;
            }

            /* Hilangkan padding abu-abu di luar container */
            body {
                background-color: white !important;
                color: black !important;
                padding: 0 !important;
                margin: 0 !important;
            }

            .py-12 {
                padding-top: 0 !important;
                padding-bottom: 0 !important;
            }

            /* Pastikan Card memenuhi lebar kertas dan hilangkan shadow */
            .bg-slate-900 {
                background-color: white !important;
                color: black !important;
                box-shadow: none !important;
                width: 100% !important;
                padding: 0 !important;
            }

            /* Paksa warna teks agar tetap terbaca (beberapa browser otomatis memutihkan teks) */
            .text-blue-400,
            .text-blue-500 {
                color: #2563eb !important;
            }

            .text-green-400,
            .text-green-500 {
                color: #16a34a !important;
            }

            .text-gray-400 {
                color: #4b5563 !important;
            }

            input {
                background-color: #f3f4f6 !important;
                /* Abu-abu sangat muda saat diprint */
                border: 1px solid #d1d5db !important;
                color: black !important;
            }

            /* Kecilkan gambar sedikit agar tidak memakan tempat ke halaman 2 */
            img {
                max-height: 200px !important;
                width: auto !important;
                margin-bottom: 10px !important;
            }

            /* Atur margin kertas */
            @page {
                size: auto;
                margin: 10mm;
            }
        }
    </style>

    {{-- stylekan ini aja. --}}
    <div class="py-12 text-gray-100">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-slate-900 overflow-hidden shadow-xl sm:rounded-lg p-8">
                <h2 class="text-2xl font-semibold mb-6 border-l-4 border-blue-500 pl-4">Detail Rental #{{ $rental->id }}
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                    <div>
                        <h3 class="text-blue-400 font-medium mb-4 uppercase tracking-wider text-sm">Detail Kendaraan
                        </h3>
                        <div class="space-y-4">
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm text-gray-400">Nama Mobil</label>
                                    <input type="text" value="{{ $rental->car->nama }}" readonly
                                        class="w-full bg-slate-800 border-slate-700 rounded-md text-gray-300 mt-1 focus:ring-0">
                                </div>
                                <div>
                                    <label class="block text-sm text-gray-400">Nomor Polisi</label>
                                    <input type="text" value="{{ $rental->car->nopol }}" readonly
                                        class="w-full bg-slate-800 border-slate-700 rounded-md text-gray-300 mt-1 focus:ring-0">
                                </div>

                                <div>
                                    <label class="block text-sm text-gray-400">Warna</label>
                                    <input type="text" value="{{ $rental->car->warna }}" readonly
                                        class="w-full bg-slate-800 border-slate-700 rounded-md text-gray-300 mt-1 focus:ring-0">
                                </div>


                                <div>
                                    <label class="block text-sm text-gray-400">Tahun</label>
                                    <input type="text" value="{{ $rental->car->tahun }}" readonly
                                        class="w-full bg-slate-800 border-slate-700 rounded-md text-gray-300 mt-1 focus:ring-0">
                                </div>

                                <div>
                                    <label class="block text-sm text-gray-400">Brand</label>
                                    <input type="text" value="{{ $rental->car->brand->name }}" readonly
                                        class="w-full bg-slate-800 border-slate-700 rounded-md text-gray-300 mt-1 focus:ring-0">
                                </div>

                                <div>
                                    <label class="block text-sm text-gray-400">Kapasitas Penumpang</label>
                                    <input type="text" value="{{ $rental->car->kapasitas_penumpang }}" readonly
                                        class="w-full bg-slate-800 border-slate-700 rounded-md text-gray-300 mt-1 focus:ring-0">
                                </div>


                            </div>



                            <div>
                                <label class="block text-sm text-gray-400 mb-2">Foto Mobil</label>
                                <img src="{{ asset('storage/' . $rental->car->gambar) }}" alt="{{ $rental->car->nama }}"
                                    class="w-full max-w-sm rounded-xl border-2 border-slate-700 shadow-lg">
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-col">
                        <h3 class="text-green-400 font-medium mb-4 uppercase tracking-wider text-sm">Informasi Penyewaan
                        </h3>
                        <div class="bg-slate-800/50 p-6 rounded-xl border border-slate-700 space-y-4 flex-grow">
                            <div class="grid grid-cols-2 gap-4">
                                <div class="col-span-2">
                                    <label class="block text-sm text-gray-400">Nama Penyewa</label>
                                    <input type="text" value="{{ $rental->user->name }}" readonly
                                        class="w-full bg-slate-800 border-slate-700 rounded-md text-gray-300 mt-1">
                                </div>

                                <div>
                                    <label class="block text-sm text-gray-400">Tanggal Mulai</label>
                                    <input type="text" value="{{ $rental->tanggal_sewa }}" readonly
                                        class="w-full bg-slate-800 border-slate-700 rounded-md text-gray-300 mt-1">
                                </div>
                                <div>
                                    <label class="block text-sm text-gray-400">Tanggal Kembali</label>
                                    <input type="text" value="{{ $rental->tanggal_dikembalikan }}" readonly
                                        class="w-full bg-slate-800 border-slate-700 rounded-md text-gray-300 mt-1">
                                </div>

                                   <div class="col-span-2">
                                    <label class="block text-sm text-gray-400">Lama sewa</label>
                                    <input type="text" value="{{ $rental->lama_sewa }}" readonly
                                        class="w-full bg-slate-800 border-slate-700 rounded-md text-gray-300 mt-1">
                                </div>

                            </div>

                            <div class="pt-6 mt-6 border-t border-slate-700">
                                <div>
                                    <label class="block text-sm text-gray-400">Harga Sewa / Hari</label>
                                    <p class="text-blue-500 font-semibold text-lg">Rp
                                        {{ number_format($rental->car->harga_per_hari, 0, ',', '.') }}
                                    </p>
                                </div>

                                <div class="mt-4">
                                    <label class="block text-sm text-gray-400 uppercase">Total Bayar</label>
                                    <p class="text-4xl font-bold text-green-500 mt-2">
                                        Rp {{ number_format($rental->total_bayar, 0, ',', '.') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-10 pt-6 border-t border-slate-700 flex items-center justify-between">
                    <a href="{{ route('rentals.index') }}"
                        class="text-gray-400 hover:text-white transition-colors flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Kembali ke Daftar Mobil
                    </a>

                    <button onclick="window.print()"
                        class="bg-white text-slate-900 px-6 py-2.5 rounded-lg font-bold hover:bg-gray-200 transition-all shadow-lg active:scale-95">
                        CETAK BUKTI SEWA
                    </button>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>