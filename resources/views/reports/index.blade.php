<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Laporan') }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <x-card>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">📊 Laporan Penjualan</h3>
                    <p class="text-gray-600 mb-4">Cetak laporan transaksi penjualan berdasarkan rentang tanggal.</p>
                    <a href="{{ route('reports.sales') }}">
                        <x-primary-button>Buka Laporan Penjualan</x-primary-button>
                    </a>
                </x-card>

                <x-card>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">📦 Laporan Stok Barang</h3>
                    <p class="text-gray-600 mb-4">Lihat dan cetak stok barang yang menipis di setiap cabang.</p>
                    <a href="{{ route('reports.stock') }}">
                        <x-primary-button>Buka Laporan Stok</x-primary-button>
                    </a>
                </x-card>
            </div>
        </div>
    </div>
</x-app-layout>