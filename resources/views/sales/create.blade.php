<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Transaksi Baru (Kasir)') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <x-card>
                <form action="{{ route('sales.store') }}" method="POST" x-data="{ 
                    items: [], 
                    products: @json($stocks->map(fn($s) => ['id' => $s->product_id, 'name' => $s->product->name, 'price' => $s->product->price, 'stock_id' => $s->id, 'stock' => $s->stock])),
                    selectedProduct: '',
                    qty: 1,
                    get total() { return this.items.reduce((sum, item) => sum + (item.price * item.qty), 0); },
                    addItem() {
                        if(!this.selectedProduct) return;
                        const product = this.products.find(p => p.id == this.selectedProduct);
                        if(this.qty > product.stock) { alert('Stok tidak mencukupi!'); return; }
                        
                        const existing = this.items.find(i => i.id == product.id);
                        if(existing) { existing.qty += this.qty; } 
                        else { this.items.push({...product, qty: this.qty}); }
                        
                        this.selectedProduct = ''; this.qty = 1;
                    },
                    removeItem(index) { this.items.splice(index, 1); }
                }">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        
                        {{-- KOLOM KIRI: Pilih Barang --}}
                        <div class="md:col-span-1 bg-gray-50 p-4 rounded-lg border border-gray-200">
                            <h3 class="font-bold text-lg mb-4 text-gray-700">Pilih Produk</h3>
                            
                            <div class="mb-4">
                                <x-input-label for="product_select" :value="__('Nama Produk')" />
                                <select id="product_select" x-model="selectedProduct" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full">
                                    <option value="">-- Pilih Produk --</option>
                                    <template x-for="product in products" :key="product.id">
                                        <option :value="product.id" x-text="product.name + ' (Stok: ' + product.stock + ')'"></option>
                                    </template>
                                </select>
                            </div>

                            <div class="mb-4">
                                <x-input-label for="qty" :value="__('Jumlah')" />
                                <x-text-input id="qty" type="number" min="1" x-model.number="qty" class="block mt-1 w-full" />
                            </div>

                            <button type="button" @click="addItem()" class="w-full bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 font-medium">
                                + Tambah ke Keranjang
                            </button>
                        </div>

                        {{-- KOLOM KANAN: Keranjang --}}
                        <div class="md:col-span-2">
                            <h3 class="font-bold text-lg mb-4 text-gray-700">Keranjang Belanja</h3>
                            
                            <div class="overflow-x-auto mb-6">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-100">
                                        <tr>
                                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Produk</th>
                                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Harga</th>
                                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Qty</th>
                                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Subtotal</th>
                                            <th class="px-4 py-2"></th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        <template x-for="(item, index) in items" :key="index">
                                            <tr>
                                                <td class="px-4 py-2 text-sm text-gray-900" x-text="item.name"></td>
                                                <td class="px-4 py-2 text-sm text-gray-900">Rp <span x-text="item.price.toLocaleString('id-ID')"></span></td>
                                                <td class="px-4 py-2 text-sm text-gray-900" x-text="item.qty"></td>
                                                <td class="px-4 py-2 text-sm font-bold text-gray-900">Rp <span x-text="(item.price * item.qty).toLocaleString('id-ID')"></span></td>
                                                <td class="px-4 py-2 text-sm">
                                                    <button type="button" @click="removeItem(index)" class="text-red-600 hover:text-red-900">Hapus</button>
                                                </td>
                                                <input type="hidden" :name="'items[' + index + '][product_id]'" :value="item.id">
                                                <input type="hidden" :name="'items[' + index + '][quantity]'" :value="item.qty">
                                            </tr>
                                        </template>
                                        <tr x-show="items.length === 0">
                                            <td colspan="5" class="px-4 py-8 text-center text-gray-500">Keranjang masih kosong.</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <div class="bg-gray-50 p-4 rounded-lg border border-gray-200 flex flex-col md:flex-row justify-between items-end gap-4">
                                <div class="w-full md:w-1/2">
                                    <x-input-label for="sale_date" :value="__('Tanggal Transaksi')" />
                                    <x-text-input id="sale_date" type="date" name="sale_date" :value="old('sale_date', date('Y-m-d'))" required class="block mt-1 w-full" />
                                </div>
                                <div class="text-right">
                                    <div class="text-sm text-gray-600">Total Pembayaran:</div>
                                    <div class="text-2xl font-bold text-green-600">Rp <span x-text="total.toLocaleString('id-ID')"></span></div>
                                </div>
                            </div>

                            <div class="flex items-center justify-end mt-6">
                                <a href="{{ route('sales.index') }}" class="text-sm text-gray-600 hover:text-gray-900 mr-4">Batal</a>
                                <x-primary-button class="ms-4" x-bind:disabled="items.length === 0">
                                    {{ __('Bayar & Simpan') }}
                                </x-primary-button>
                            </div>
                        </div>
                    </div>
                </form>
            </x-card>
        </div>
    </div>
</x-app-layout>