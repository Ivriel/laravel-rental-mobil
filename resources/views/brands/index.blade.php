<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between px-1">
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Brands') }}
        </h2>
@if (auth()->check() && in_array(auth()->user()->role, ['admin','petugas']))
    
<button class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
            <a href="{{ route('brands.create') }}">Tambah Brand</a>
        </button>
        @endif
        </div> 

    </x-slot>

     <div class="mt-4 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-2">
         @foreach ($brands as $brand)
        <div class="py-2">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="px-6 py-4 text-gray-900 dark:text-gray-100 flex items-center justify-between">
                  
                        <p>
                            <a href="{{ route('brands.cars',$brand->id) }}">
                                {{ $brand->name }}
                            </a>
                        </p>
                        @if (auth()->check() && in_array(auth()->user()->role, ['admin','petugas']))
                            
                   
                    <div class="flex gap-4 items-center">
                        <a href="{{ route('brands.edit', $brand->id) }}" class="bg-orange-500 text-white px-4 py-2 rounded hover:bg-orange-600">Edit</a>
                        <form action="{{ route('brands.destroy', $brand->id) }}" method="POST" class="inline">
                            @method('delete')
                            @csrf
                            <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600" onclick="return confirm('Yakin ingin menghapus brand {{ $brand->name }}?')">
                                Delete
                            </button>
                        </form>
                    </div>
                         @endif
                </div>
            </div>
        </div>
    </div>
    @endforeach
     </div>
</x-app-layout>