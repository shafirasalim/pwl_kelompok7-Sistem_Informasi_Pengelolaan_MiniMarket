<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Data Mutasi Stok') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <div class="mb-6">
                        <a href="{{ route('stock-movements.create') }}">
                            <x-primary-button>
                                {{ __('+ Tambah Mutasi Stok') }}
                            </x-primary-button>
                        </a>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Cabang - Produk</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tipe</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Qty</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">User</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($stockMovements as $movement)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ \Carbon\Carbon::parse($movement->movement_date)->format('d M Y') }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-900">
                                        {{ $movement->stock->branch->name }} - {{ $movement->stock->product->name }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        @if($movement->type === 'in')
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Masuk</span>
                                        @elseif($movement->type === 'out')
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Keluar</span>
                                        @else
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Adjustment</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $movement->quantity }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $movement->user->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-3">
                                        <a href="{{ route('stock-movements.edit', $movement->id) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                        <form action="{{ route('stock-movements.destroy', $movement->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" onclick="return confirm('Yakin hapus data ini?')" class="text-red-600 hover:text-red-900">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>