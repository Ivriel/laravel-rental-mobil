<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Dashboard - {{ ucfirst(auth()->user()->role) }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(auth()->user()->role === 'admin')
                @include('dashboard.admin')
            @elseif(auth()->user()->role === 'petugas')
                @include('dashboard.petugas')
            @else
                @include('dashboard.pelanggan')
            @endif
            
        </div>
    </div>
</x-app-layout>