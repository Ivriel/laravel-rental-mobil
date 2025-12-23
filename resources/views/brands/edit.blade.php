<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Brand') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <form method="POST" action="{{ route('brands.update', $brand->id) }}" class="mt-6 space-y-6">
                        @csrf
                        @method('PUT')
                        <div>
                            <x-input-label for="name" :value="__('Nama Brand')" />
                            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value=" old('name', $brand->name) " required autofocus placeholder="Contoh: Toyota, Honda, dll" />
                            <x-input-error class="mt-2 text-red-500" :messages="$errors->get('name')" />
                        </div>

                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('Update Brand') }}</x-primary-button>
                            
                            <a href="{{ route('brands.index') }}" class="text-sm text-gray-600 hover:underline">
                                {{ __('Batal') }}
                            </a>
                        </div>
                    </form>
                    </div>
            </div>
        </div>
    </div>

</x-app-layout>