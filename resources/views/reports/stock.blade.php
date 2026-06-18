<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Laporan Stok Barang') }}</h2>
            <button onclick="window.print()" class="bg-gray-200 text-gray-700 px-4 py-2 rounded hover:bg-gray-300 text-sm font-medium print:hidden">🖨️ Cetak / PDF</button>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-card>
                <div class="text-center mb-6 border-b pb-4 print:block hidden">
                    <h1 class="text-2xl font-bold">MINIMARKET JAYUSMAN</h1>
                    <p>Laporan Stok Barang (Stok Menipis)</p>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Cabang</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Produk</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Sisa Stok</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($stocks as $stock)
                            <tr>
                                <td class="px-6 py-4 text-sm">{{ $stock->branch->name }}</td>
                                <td class="px-6 py-4 text-sm font-medium">{{ $stock->product->name }}</td>
                                <td class="px-6 py-4 text-sm font-bold">{{ $stock->stock }}</td>
                                <td class="px-6 py-4 text-sm">
                                    @if($stock->stock <= 5)
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Kritis</span>
                                    @elseif($stock->stock <= 10)
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Menipis</span>
                                    @else
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Aman</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </x-card>
        </div>
    </div>
</x-app-layout>