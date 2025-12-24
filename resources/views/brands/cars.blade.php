<x-app-layout>
        <x-slot name="header">
        <div class="flex items-center justify-between px-1">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Brand Mobil: {{ $brand->name }}
            </h2>
            <a href="{{ route('brands.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                Kembali ke Brands
            </a>
        </div>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if ($cars->count() > 0)
                  <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($cars as $car)
                         <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg flex flex-col">
                        <div class="h-48 w-full bg-gray-300 dark:bg-gray-700 flex items-center justify-center">
                            @if($car->gambar)
                                <img src="{{ asset('storage/' . $car->gambar) }}" alt="{{ $car->nama }}"
                                    class="w-full h-full object-cover">
                            @else
                                <span class="text-gray-500">No Image Available</span>
                            @endif
                        </div>

                        <div class="p-6 flex-1">
                            <div class="flex justify-between items-start mb-2">
                                <h3 class="text-lg font-bold text-gray-900 dark:text-white">
                                    <a href="{{ route('cars.show',$car->id )}}">
                                        {{ $car->nama }}
                                    </a>
                                </h3>
                                <span
                                    class="px-2 py-1 text-xs font-semibold rounded {{ $car->status == 'tersedia' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ ucfirst($car->status) }}
                                </span>
                            </div>

                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">Merk:
                                <strong>{{ $car->brand->name }}</strong>
                            </p>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">Nopol: {{ $car->nopol }}</p>
                            <p class="text-lg font-semibold text-blue-600 dark:text-blue-400 mt-4">
                                Rp {{ number_format($car->harga_per_hari, 0, ',', '.') }} <span
                                    class="text-xs text-gray-500">/hari</span>
                            </p>
                        </div>

                        @if (auth()->check() && in_array(auth()->user()->role, ['admin', 'petugas']))
                            <div
                                class="p-4 bg-gray-50 dark:bg-gray-700/50 border-t border-gray-100 dark:border-gray-600 flex justify-between gap-2">
                                <a href="{{ route('cars.edit', $car->id) }}"
                                    class="flex-1 text-center bg-yellow-500 hover:bg-yellow-600 text-white py-2 rounded text-sm font-medium transition">
                                    Edit
                                </a>

                                <form action="{{ route('cars.destroy', $car->id) }}" method="POST" class="flex-1"
                                    onsubmit="return confirm('Yakin ingin menghapus mobil {{ $car->nama }}')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="w-full bg-red-600 hover:bg-red-700 text-white py-2 rounded text-sm font-medium transition">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        @endif
                        @if (auth()->check() && auth()->user()->role === 'pelanggan')
                            <div class="p-4 bg-gray-50 dark:bg-gray-700/50 border-t border-gray-100 dark:border-gray-600">
                                @if ($car->status === 'tersedia')
                                      <a href="{{ route('rentals.create', ['car_id' => $car->id]) }}"
                                        class="block w-full text-center bg-green-600 hover:bg-green-700 text-white py-2 rounded text-sm font-medium transition">
                                        Sewa Mobil
                                    </a>
                                    @else
                                    <button disabled
                                        class="block w-full bg-gray-500 text-white py-2 rounded text-sm font-medium cursor-not-allowed">
                                        Sudah Disewa
                                    </button>
                                @endif
                         
                            </div>

                        @endif
                    </div>
                    @endforeach
                </div>
                @else
                 <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100 text-center">
                        <p>Tidak ada mobil untuk brand {{ $brand->name }}</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>