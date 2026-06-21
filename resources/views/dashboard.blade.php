<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard Analisis Data') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Kartu Ringkasan -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-gray-500 dark:text-gray-400 text-sm">Total Pendapatan</div>
                    <div class="text-2xl font-bold text-green-600 dark:text-green-400">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</div>
                </div>
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-gray-500 dark:text-gray-400 text-sm">Pendapatan Hari Ini</div>
                    <div class="text-2xl font-bold text-blue-600 dark:text-blue-400">Rp {{ number_format($todaySales, 0, ',', '.') }}</div>
                </div>
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-gray-500 dark:text-gray-400 text-sm">Total Transaksi</div>
                    <div class="text-2xl font-bold text-purple-600 dark:text-purple-400">{{ $totalSales }}</div>
                </div>
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-gray-500 dark:text-gray-400 text-sm">Total Cabang</div>
                    <div class="text-2xl font-bold text-orange-600 dark:text-orange-400">{{ $totalBranches }}</div>
                </div>
            </div>

            <!-- Grafik dan Produk Terlaris -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
                
                <!-- Grafik Tren Penjualan -->
                <div class="lg:col-span-2 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Tren Penjualan (7 Hari Terakhir)</h3>
                    <canvas id="salesChart" height="150"></canvas>
                </div>

                <!-- Produk Terlaris -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">5 Produk Terlaris</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm">
                            <thead>
                                <tr class="border-b dark:border-gray-700">
                                    <th class="text-left py-2 text-gray-500 dark:text-gray-400">Produk</th>
                                    <th class="text-right py-2 text-gray-500 dark:text-gray-400">Qty</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($topProducts as $product)
                                <tr class="border-b dark:border-gray-700">
                                    <td class="py-2 text-gray-900 dark:text-gray-100">{{ $product->name }}</td>
                                    <td class="py-2 text-right font-bold text-gray-900 dark:text-gray-100">{{ $product->total_qty }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="2" class="py-4 text-center text-gray-500 dark:text-gray-400">Belum ada data penjualan</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Performa Cabang dan Stok Menipis -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                
                <!-- Performa Cabang (Hanya Owner) -->
                @if(auth()->user()->role === 'owner')
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Performa Penjualan Per Cabang</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm">
                            <thead>
                                <tr class="border-b dark:border-gray-700">
                                    <th class="text-left py-2 text-gray-500 dark:text-gray-400">Cabang</th>
                                    <th class="text-right py-2 text-gray-500 dark:text-gray-400">Transaksi</th>
                                    <th class="text-right py-2 text-gray-500 dark:text-gray-400">Pendapatan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($branchPerformance as $branch)
                                <tr class="border-b dark:border-gray-700">
                                    <td class="py-2 text-gray-900 dark:text-gray-100">{{ $branch->name }}</td>
                                    <td class="py-2 text-right text-gray-900 dark:text-gray-100">{{ $branch->total_trx }}</td>
                                    <td class="py-2 text-right font-bold text-green-600 dark:text-green-400">Rp {{ number_format($branch->total_revenue, 0, ',', '.') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @endif

                <!-- Stok Menipis -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Peringatan Stok Menipis (≤ 10)</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm">
                            <thead>
                                <tr class="border-b dark:border-gray-700">
                                    <th class="text-left py-2 text-gray-500 dark:text-gray-400">Cabang</th>
                                    <th class="text-left py-2 text-gray-500 dark:text-gray-400">Produk</th>
                                    <th class="text-right py-2 text-gray-500 dark:text-gray-400">Sisa</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($lowStock as $stock)
                                <tr class="border-b dark:border-gray-700">
                                    <td class="py-2 text-gray-900 dark:text-gray-100">{{ $stock->branch->name }}</td>
                                    <td class="py-2 text-gray-900 dark:text-gray-100">{{ $stock->product->name }}</td>
                                    <td class="py-2 text-right font-bold text-red-600 dark:text-red-400">{{ $stock->stock }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="py-4 text-center text-gray-500 dark:text-gray-400">Semua stok aman</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Script untuk Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('salesChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: {!! json_encode($chartLabels) !!},
                datasets: [{
                    label: 'Pendapatan (Rp)',
                    data: {!! json_encode($chartData) !!},
                    borderColor: 'rgb(59, 130, 246)',
                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.3
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });
    </script>
</x-app-layout>