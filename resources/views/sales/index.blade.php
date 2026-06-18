<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Data Transaksi Penjualan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-alert type="success" />
            
            <x-card>
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-medium text-gray-900">Daftar Transaksi</h3>
                    <a href="{{ route('sales.create') }}">
                        <x-primary-button>{{ __('+ Transaksi Baru') }}</x-primary-button>
                    </a>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">No</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Cabang</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kasir</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($sales as $sale)
                            <tr>
                                <td class="px-6 py-4 text-sm">{{ $loop->iteration }}</td>
                                <td class="px-6 py-4 text-sm">{{ \Carbon\Carbon::parse($sale->sale_date)->format('d M Y') }}</td>
                                <td class="px-6 py-4 text-sm">{{ $sale->branch->name }}</td>
                                <td class="px-6 py-4 text-sm">{{ $sale->cashier->name }}</td>
                                <td class="px-6 py-4 text-sm font-bold text-green-600">Rp {{ number_format($sale->total_price, 0, ',', '.') }}</td>
                                <td class="px-6 py-4 text-sm space-x-3">
                                    <a href="{{ route('sales.show', $sale->id) }}" class="text-indigo-600 hover:text-indigo-900">Detail</a>
                                    @if(in_array(auth()->user()->role, ['owner', 'manager']))
                                        <form action="{{ route('sales.destroy', $sale->id) }}" method="POST" class="inline">
                                            @csrf @method('DELETE')
                                            <button type="submit" onclick="return confirm('Yakin hapus?')" class="text-red-600 hover:text-red-900">Hapus</button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="px-6 py-4 text-center text-gray-500">Belum ada transaksi.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </x-card>
        </div>
    </div>
</x-app-layout>