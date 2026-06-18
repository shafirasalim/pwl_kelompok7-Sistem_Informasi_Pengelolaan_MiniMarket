<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Mutasi Stok') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <form action="{{ route('stock-movements.update', $stockMovement->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        {{-- Pilih Stock --}}
                        <div class="mt-4">
                            <x-input-label for="stock_id" :value="__('Pilih Stok (Cabang - Produk)')" />
                            <select id="stock_id" name="stock_id" required 
                                    class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full">
                                @foreach($stocks as $stock)
                                    <option value="{{ $stock->id }}" {{ $stockMovement->stock_id == $stock->id ? 'selected' : '' }}>
                                        {{ $stock->branch->name }} - {{ $stock->product->name }} (Sisa: {{ $stock->stock }})
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('stock_id')" class="mt-2" />
                        </div>

                        {{-- Tipe Mutasi --}}
                        <div class="mt-4">
                            <x-input-label for="type" :value="__('Tipe Mutasi')" />
                            <select id="type" name="type" required 
                                    class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full">
                                <option value="in" {{ $stockMovement->type == 'in' ? 'selected' : '' }}>Barang Masuk (IN)</option>
                                <option value="out" {{ $stockMovement->type == 'out' ? 'selected' : '' }}>Barang Keluar (OUT)</option>
                                <option value="adjustment" {{ $stockMovement->type == 'adjustment' ? 'selected' : '' }}>Adjustment</option>
                            </select>
                            <x-input-error :messages="$errors->get('type')" class="mt-2" />
                        </div>

                        {{-- Quantity --}}
                        <div class="mt-4">
                            <x-input-label for="quantity" :value="__('Jumlah (Qty)')" />
                            <x-text-input id="quantity" class="block mt-1 w-full" type="number" name="quantity" :value="old('quantity', $stockMovement->quantity)" required min="1" />
                            <x-input-error :messages="$errors->get('quantity')" class="mt-2" />
                        </div>

                        {{-- Tanggal --}}
                        <div class="mt-4">
                            <x-input-label for="movement_date" :value="__('Tanggal')" />
                            <x-text-input id="movement_date" class="block mt-1 w-full" type="date" name="movement_date" :value="old('movement_date', $stockMovement->movement_date)" required />
                            <x-input-error :messages="$errors->get('movement_date')" class="mt-2" />
                        </div>

                        {{-- Tombol --}}
                        <div class="flex items-center justify-end mt-6">
                            <a href="{{ route('stock-movements.index') }}" class="text-sm text-gray-600 hover:text-gray-900 mr-4">
                                Kembali
                            </a>
                            <x-primary-button class="ms-4">
                                {{ __('Update') }}
                            </x-primary-button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>