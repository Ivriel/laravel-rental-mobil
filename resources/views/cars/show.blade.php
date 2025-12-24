<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Detail Mobil #{{ $car->id }}
            </h2>

               <button class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600" onclick="window.history.back()">
                Kembali
                </button>
    </x-slot>
    <div class="py-12 text-gray-100">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-slate-700 overflow-hidden shadow-xl sm:rounded-lg p-8">
               <div class="flex items-center justify-between border-b border-b-gray-100 mb-8 pb-4">
                 <h2 class="text-2xl font-semibold">
                    {{ $car->nama }}
                </h2>

                <span class="rounded-lg bg-red-500 px-4 py-2">
                    {{ $car->brand->name }}
                </span>

               </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm text-gray-400">Nama Mobil</label>
                        <input type="text" value="{{ $car->nama }}" readonly
                            class="w-full bg-slate-800 border-slate-700 rounded-md text-gray-300 mt-1 focus:ring-0">
                    </div>

                     <div>
                        <label class="block text-sm text-gray-400">Nopol</label>
                        <input type="text" value="{{ $car->nopol }}" readonly
                            class="w-full bg-slate-800 border-slate-700 rounded-md text-gray-300 mt-1 focus:ring-0">
                    </div>

                     <div>
                        <label class="block text-sm text-gray-400">Tahun</label>
                        <input type="text" value="{{ $car->tahun }}" readonly
                            class="w-full bg-slate-800 border-slate-700 rounded-md text-gray-300 mt-1 focus:ring-0">
                    </div>

                     <div>
                        <label class="block text-sm text-gray-400">Warna</label>
                        <input type="text" value="{{ $car->warna}}" readonly
                            class="w-full bg-slate-800 border-slate-700 rounded-md text-gray-300 mt-1 focus:ring-0">
                    </div>

                     <div>
                        <label class="block text-sm text-gray-400">Kapasitas Penumpang</label>
                        <input type="text" value="{{ $car->kapasitas_penumpang }}" readonly
                            class="w-full bg-slate-800 border-slate-700 rounded-md text-gray-300 mt-1 focus:ring-0">
                    </div>

                     <div>
                        <label class="block text-sm text-gray-400">Harga/Hari</label>
                        <input type="text" value="Rp {{ number_format($car->harga_per_hari, 0, ',', '.') }}" readonly
                            class="w-full bg-slate-800 border-slate-700 rounded-md text-gray-300 mt-1 focus:ring-0">
                    </div>

                     <div>
                        <label class="block text-sm text-gray-400">Nama Mobil</label>
                        <input type="text" value="{{ $car->nama }}" readonly
                            class="w-full bg-slate-800 border-slate-700 rounded-md text-gray-300 mt-1 focus:ring-0">
                    </div>

                    <div>
                        <label class="block text-sm text-gray-400">Status</label>
                        <input type="text" value="{{ ucfirst($car->status)}}" readonly
                            class="w-full {{ $car->status === 'disewa' ? 'bg-red-100 text-red-800' : ' bg-green-100 text-green-800' }} rounded-md mt-1 focus:ring-0">
                    </div>

                    <div class="col-span-2">
                           <img src="{{ asset('storage/' . $car->gambar) }}" alt="{{ $car->nama }}"
                                    class="w-full h-full object-cover rounded-lg">
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>