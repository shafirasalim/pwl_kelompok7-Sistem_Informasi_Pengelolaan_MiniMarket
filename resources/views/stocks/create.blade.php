<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Stok Barang') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <form action="{{ route('stocks.store') }}" method="POST">
                        @csrf

                        {{-- Pilih Cabang --}}
                        <div class="mt-4">
                            <x-input-label for="branch_id" :value="__('Cabang')" />
                            <select id="branch_id" name="branch_id" required 
                                    class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full">
                                <option value="">-- Pilih Cabang --</option>
                                @foreach($branches as $branch)
                                    <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('branch_id')" class="mt-2" />
                        </div>

                        {{-- Pilih Produk --}}
                        <div class="mt-4">
                            <x-input-label for="product_id" :value="__('Produk')" />
                            <select id="product_id" name="product_id" required 
                                    class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full">
                                <option value="">-- Pilih Produk --</option>
                                @foreach($products as $product)
                                    <option value="{{ $product->id }}">{{ $product->name }}</option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('product_id')" class="mt-2" />
                        </div>

                        {{-- Jumlah Stok --}}
                        <div class="mt-4">
                            <x-input-label for="stock" :value="__('Jumlah Stok')" />
                            <x-text-input id="stock" class="block mt-1 w-full" type="number" name="stock" :value="old('stock')" required min="0" />
                            <x-input-error :messages="$errors->get('stock')" class="mt-2" />
                        </div>

                        {{-- Tombol --}}
                        <div class="flex items-center justify-end mt-6">
                            <a href="{{ route('stocks.index') }}" class="text-sm text-gray-600 hover:text-gray-900 mr-4">
                                Kembali
                            </a>
                            <x-primary-button class="ms-4">
                                {{ __('Simpan') }}
                            </x-primary-button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>