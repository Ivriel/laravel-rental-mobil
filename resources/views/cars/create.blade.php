<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Create Car') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form action="{{ route('cars.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="col-span-2">
                                <x-input-label for="gambar" :value="__('Gambar Mobil')" />
                                <input value="{{ old('gambar') }}" type="file" name="gambar" id="gambar" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 rounded-md shadow-sm focus:ring-indigo-500 py-2 px-2" required>
                                <x-input-error class="mt-2 text-red-500" :messages="$errors->get('gambar')" />
                            </div>

                            <div>
                                <x-input-label for="nama" :value="__('Nama Mobil')" />
                                <x-text-input id="nama" name="nama" type="text" class="mt-1 block w-full" :value="old('nama')" required autofocus />
                                <x-input-error class="mt-2 text-red-500" :messages="$errors->get('nama')" />
                            </div>

                            <div>
                                <x-input-label for="nopol" :value="__('Nomor Polisi (Nopol)')" />
                                <x-text-input id="nopol" name="nopol" type="text" class="mt-1 block w-full" :value="old('nopol')" required />
                                <x-input-error class="mt-2 text-red-500" :messages="$errors->get('nopol')" />
                            </div>

                            <div>
                                <x-input-label for="brand_id" :value="__('Merk / Brand')" />
                                <select name="brand_id" id="brand_id" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 rounded-md shadow-sm focus:ring-indigo-500" required>
                                    @foreach($brands as $brand)
                                        <option value="{{ $brand->id }}" {{ old('brand_id') == $brand->id ? 'selected' : '' }}>{{ $brand->name }}</option>
                                    @endforeach
                                </select>
                                <x-input-error class="mt-2 text-red-500" :messages="$errors->get('brand_id')" />
                            </div>

                            <div>
                                <x-input-label for="tahun" :value="__('Tahun')" />
                                <x-text-input id="tahun" name="tahun" type="number" min="2000" max="{{ date('Y') }}" class="mt-1 block w-full" :value="old('tahun')" required />
                                <x-input-error class="mt-2 text-red-500" :messages="$errors->get('tahun')" />
                            </div>

                            <div>
                                <x-input-label for="warna" :value="__('Warna')" />
                                <x-text-input id="warna" name="warna" type="text" class="mt-1 block w-full" :value="old('warna')" required />
                                <x-input-error class="mt-2 text-red-500" :messages="$errors->get('warna')" />
                            </div>

                            <div>
                                <x-input-label for="kapasitas_penumpang" :value="__('Kapasitas Penumpang')" />
                                <x-text-input id="kapasitas_penumpang" name="kapasitas_penumpang" type="number" class="mt-1 block w-full" :value="old('kapasitas_penumpang')" required />
                                <x-input-error class="mt-2 text-red-500" :messages="$errors->get('kapasitas_penumpang')" />
                            </div>

                            <div>
                                <x-input-label for="harga_per_hari" :value="__('Harga Per Hari (Rp)')" />
                                <x-text-input id="harga_per_hari" name="harga_per_hari" type="number" class="mt-1 block w-full" :value="old('harga_per_hari')" required />
                                <x-input-error class="mt-2 text-red-500" :messages="$errors->get('harga_per_hari')" />
                            </div>

                            <div>
                                <x-input-label for="status" :value="__('Status Mobil')" />
                                <select name="status" id="status" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 rounded-md shadow-sm focus:ring-indigo-500" required>
                                    <option value="tersedia" {{ old('status') == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                                    <option value="disewa" {{ old('status') == 'disewa' ? 'selected' : '' }}>Disewa</option>
                                </select>
                                <x-input-error class="mt-2 text-red-500" :messages="$errors->get('status')" />
                            </div>
                        </div>

                        <div class="mt-6 flex items-center justify-end">
                            <a href="{{ route('cars.index') }}" class="mr-4 text-sm text-gray-600 dark:text-gray-400 hover:underline">Batal</a>
                            <x-primary-button>
                                {{ __('Simpan Mobil') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>