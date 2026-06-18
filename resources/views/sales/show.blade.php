<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Detail Transaksi #' . $sale->id) }}
            </h2>
            <button onclick="window.print()" class="bg-gray-200 text-gray-700 px-4 py-2 rounded hover:bg-gray-300 text-sm font-medium print:hidden">
                🖨️ Cetak Struk
            </button>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <x-card class="print:shadow-none">
                
                {{-- Header Struk --}}
                <div class="text-center mb-8 border-b pb-4">
                    <h1 class="text-2xl font-bold text-gray-800">MINIMARKET JAYUSMAN</h1>
                    <p class="text-gray-600">{{ $sale->branch->name }}</p>
                    <p class="text-sm text-gray-500 mt-2">Tanggal: {{ \Carbon\Carbon::parse($sale->sale_date)->format('d M Y, H:i') }}</p>
                    <p class="text-sm text-gray-500">Kasir: {{ $sale->cashier->name }}</p>
                </div>

                {{-- Daftar Barang --}}
                <table class="w-full mb-8">
                    <thead>
                        <tr class="border-b-2 border-gray-800">
                            <th class="text-left py-2">Produk</th>
                            <th class="text-center py-2">Qty</th>
                            <th class="text-right py-2">Harga</th>
                            <th class="text-right py-2">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($sale->details as $detail)
                        <tr class="border-b border-gray-200">
                            <td class="py-2">{{ $detail->product->name }}</td>
                            <td class="text-center py-2">{{ $detail->quantity }}</td>
                            <td class="text-right py-2">Rp {{ number_format($detail->price, 0, ',', '.') }}</td>
                            <td class="text-right py-2">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                {{-- Total --}}
                <div class="flex justify-end">
                    <div class="w-1/2">
                        <div class="flex justify-between text-lg font-bold border-t-2 border-gray-800 pt-4">
                            <span>TOTAL</span>
                            <span>Rp {{ number_format($sale->total_price, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>

                {{-- Footer --}}
                <div class="text-center mt-12 text-sm text-gray-500">
                    <p>Terima kasih atas kunjungan Anda!</p>
                </div>

            </x-card>
        </div>
    </div>
</x-app-layout>