<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Laporan Penjualan') }}</h2>
            <div class="flex gap-2">
                <button onclick="window.print()" class="bg-gray-200 text-gray-700 px-4 py-2 rounded hover:bg-gray-300 text-sm font-medium print:hidden">🖨️ Print</button>
                <a href="{{ route('reports.sales.pdf', request()->query()) }}" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 text-sm font-medium">📥 Download PDF</a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-card class="mb-6 print:hidden">
                <form action="{{ route('reports.sales') }}" method="GET" class="flex flex-wrap gap-4 items-end">
                    <div class="w-full md:w-auto">
                        <x-input-label for="start_date" :value="__('Tanggal Mulai')" />
                        <x-text-input id="start_date" type="date" name="start_date" :value="request('start_date', now()->subDays(7)->format('Y-m-d'))" required class="block mt-1" />
                    </div>
                    <div class="w-full md:w-auto">
                        <x-input-label for="end_date" :value="__('Tanggal Akhir')" />
                        <x-text-input id="end_date" type="date" name="end_date" :value="request('end_date', now()->format('Y-m-d'))" required class="block mt-1" />
                    </div>
                    @if(auth()->user()->role === 'owner')
                        <div class="w-full md:w-auto">
                            <x-input-label for="branch_id" :value="__('Cabang (Opsional)')" />
                            <select name="branch_id" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1">
                                <option value="">Semua Cabang</option>
                                @foreach($branches as $branch)
                                    <option value="{{ $branch->id }}" {{ request('branch_id') == $branch->id ? 'selected' : '' }}>{{ $branch->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    @endif
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        Filter
                    </button>
                </form>
            </x-card>

            <x-card>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
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
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Cabang</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kasir</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($sales as $sale)
                            <tr>
                                <td class="px-6 py-4 text-sm">{{ \Carbon\Carbon::parse($sale->sale_date)->format('d M Y') }}</td>
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