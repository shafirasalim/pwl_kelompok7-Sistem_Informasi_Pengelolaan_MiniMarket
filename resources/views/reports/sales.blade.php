<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Laporan Penjualan') }}</h2>
            <button onclick="window.print()" class="bg-gray-200 text-gray-700 px-4 py-2 rounded hover:bg-gray-300 text-sm font-medium print:hidden">️ Cetak / PDF</button>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Form Filter (Disembunyikan saat di-print) --}}
            <x-card class="print:hidden">
                <form action="{{ route('reports.sales') }}" method="GET" class="flex flex-wrap gap-4 items-end">
                    <div class="w-full md:w-auto">
                        <x-input-label for="start_date" :value="__('Tanggal Mulai')" />
                        <x-text-input id="start_date" type="date" name="start_date" :value="$request->start_date" required class="block mt-1" />
                    </div>
                    <div class="w-full md:w-auto">
                        <x-input-label for="end_date" :value="__('Tanggal Akhir')" />
                        <x-text-input id="end_date" type="date" name="end_date" :value="$request->end_date" required class="block mt-1" />
                    </div>
                    @if(auth()->user()->role === 'owner')
                        <div class="w-full md:w-auto">
                            <x-input-label for="branch_id" :value="__('Cabang (Opsional)')" />
                            <x-select name="branch_id" class="block mt-1">
                                <option value="">Semua Cabang</option>
                                @foreach($branches as $branch)
                                    <option value="{{ $branch->id }}" {{ $request->branch_id == $branch->id ? 'selected' : '' }}>{{ $branch->name }}</option>
                                @endforeach
                            </x-select>
                        </div>
                    @endif
                    <x-primary-button>Filter</x-primary-button>
                </form>
            </x-card>

            {{-- Hasil Laporan --}}
            <x-card>
                <div class="text-center mb-6 border-b pb-4 print:block hidden">
                    <h1 class="text-2xl font-bold">MINIMARKET JAYUSMAN</h1>
                    <p>Laporan Penjualan: {{ $request->start_date }} s/d {{ $request->end_date }}</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                    <div class="bg-blue-50 p-4 rounded-lg">
                        <div class="text-sm text-gray-600">Total Transaksi</div>
                        <div class="text-2xl font-bold text-blue-700">{{ $totalTransactions }}</div>
                    </div>
                    <div class="bg-green-50 p-4 rounded-lg">
                        <div class="text-sm text-gray-600">Total Pendapatan</div>
                        <div class="text-2xl font-bold text-green-700">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</div>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">No. Invoice</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Cabang</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kasir</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($sales as $sale)
                            <tr>
                                <td class="px-6 py-4 text-sm">{{ \Carbon\Carbon::parse($sale->sale_date)->format('d M Y') }}</td>
                                <td class="px-6 py-4 text-sm font-mono">#{{ $sale->id }}</td>
                                <td class="px-6 py-4 text-sm">{{ $sale->branch->name }}</td>
                                <td class="px-6 py-4 text-sm">{{ $sale->cashier->name }}</td>
                                <td class="px-6 py-4 text-sm font-bold">Rp {{ number_format($sale->total_price, 0, ',', '.') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </x-card>
        </div>
    </div>
</x-app-layout>