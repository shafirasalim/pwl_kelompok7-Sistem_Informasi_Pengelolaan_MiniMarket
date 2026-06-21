<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $showAll ? __('Laporan Semua Stok Barang') : __('Laporan Stok Barang Menipis') }}
            </h2>
            <div class="flex gap-2">
                <button onclick="window.print()" class="bg-gray-200 text-gray-700 px-4 py-2 rounded hover:bg-gray-300 text-sm font-medium print:hidden">
                    🖨️ Print
                </button>
                <a href="{{ route('reports.stock.pdf', array_merge(request()->query(), ['show_all' => $showAll ? 1 : 0])) }}" 
                   class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 text-sm font-medium">
                    📥 Download PDF
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- Toggle Filter --}}
            <x-card class="mb-6">
                <form action="{{ route('reports.stock') }}" method="GET" class="flex flex-wrap gap-4 items-end">
                    <div class="flex items-center gap-2">
                        <input type="checkbox" name="show_all" id="show_all" value="1" 
                               {{ $showAll ? 'checked' : '' }}
                               onchange="this.form.submit()"
                               class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        <label for="show_all" class="text-sm font-medium text-gray-700">
                            Tampilkan Semua Stok
                        </label>
                    </div>

                    @if(!$showAll)
                    <div class="w-full md:w-auto">
                        <x-input-label for="low_stock_threshold" :value="__('Stok ≤')" />
                        <x-text-input id="low_stock_threshold" type="number" name="low_stock_threshold" 
                                      :value="$threshold" min="1" max="100"
                                      onchange="this.form.submit()"
                                      class="block mt-1 w-24" />
                    </div>
                    @endif

                    @if(auth()->user()->role === 'owner')
                        <div class="w-full md:w-auto">
                            <x-input-label for="branch_id" :value="__('Cabang (Opsional)')" />
                            <select name="branch_id" id="branch_id" onchange="this.form.submit()"
                                    class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1">
                                <option value="">Semua Cabang</option>
                                @foreach($branches as $branch)
                                    <option value="{{ $branch->id }}" {{ request('branch_id') == $branch->id ? 'selected' : '' }}>
                                        {{ $branch->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    @endif
                </form>
            </x-card>

            {{-- Info --}}
            <div class="mb-4 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                <p class="text-sm text-blue-700">
                    @if($showAll)
                        📦 Menampilkan <strong>{{ $stocks->count() }}</strong> produk dari semua stok
                    @else
                        ⚠️ Menampilkan <strong>{{ $stocks->count() }}</strong> produk dengan stok menipis (≤ {{ $threshold }})
                    @endif
                </p>
            </div>

            {{-- Table --}}
            <x-card>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">No</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Cabang</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Produk</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Sisa Stok</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($stocks as $stock)
                            <tr>
                                <td class="px-6 py-4 text-sm">{{ $loop->iteration }}</td>
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
                            @empty
                            <tr>
                                <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                                    @if($showAll)
                                        Tidak ada data stok
                                    @else
                                        Tidak ada stok yang menipis. Semua stok dalam kondisi aman! ✅
                                    @endif
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </x-card>
        </div>
    </div>
</x-app-layout>