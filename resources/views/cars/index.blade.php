<x-app-layout>
    <x-slot name="header">
       <div class="flex items-center justify-between">
         <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Cars') }}
        </h2>

           @if (auth()->check() && in_array(auth()->user()->role, ['admin','petugas']))
          <button class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
            <a href="{{ route('cars.create') }}">Tambah Mobil</a>
        </button>
        @endif
       </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($cars as $car)
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg flex flex-col">
                        <div class="h-48 w-full bg-gray-300 dark:bg-gray-700 flex items-center justify-center">
                            @if($car->gambar)
                                <img src="{{ asset('storage/' . $car->gambar) }}" alt="{{ $car->nama }}" class="w-full h-full object-cover">
                            @else
                                <span class="text-gray-500">No Image Available</span>
                            @endif
                        </div>

                        <div class="p-6 flex-1">
                            <div class="flex justify-between items-start mb-2">
                                <h3 class="text-lg font-bold text-gray-900 dark:text-white">{{ $car->nama }}</h3>
                                <span class="px-2 py-1 text-xs font-semibold rounded {{ $car->status == 'tersedia' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ ucfirst($car->status) }}
                                </span>
                            </div>
                            
                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">Merk: <strong>{{ $car->brand->name }}</strong></p>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">Nopol: {{ $car->nopol }}</p>
                            <p class="text-lg font-semibold text-blue-600 dark:text-blue-400 mt-4">
                                Rp {{ number_format($car->harga_per_hari, 0, ',', '.') }} <span class="text-xs text-gray-500">/hari</span>
                            </p>
                        </div>

                           @if (auth()->check() && in_array(auth()->user()->role, ['admin','petugas']))
                        <div class="p-4 bg-gray-50 dark:bg-gray-700/50 border-t border-gray-100 dark:border-gray-600 flex justify-between gap-2">
                            <a href="{{ route('cars.edit', $car->id) }}" class="flex-1 text-center bg-yellow-500 hover:bg-yellow-600 text-white py-2 rounded text-sm font-medium transition">
                                Edit
                            </a>
                            
                            <form action="{{ route('cars.destroy', $car->id) }}" method="POST" class="flex-1" onsubmit="return confirm('Yakin ingin menghapus mobil {{ $car->nama }}')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white py-2 rounded text-sm font-medium transition">
                                    Hapus
                                </button>
                            </form>
                        </div>
                        @endif
                    </div>
                @endforeach
            </div>

            @if($cars->isEmpty())
                <div class="bg-white dark:bg-gray-800 p-6 text-center rounded-lg shadow">
                    <p class="text-gray-500">Belum ada data mobil.</p>
                </div>
            @endif
        </div>
    </div>

</x-app-layout>