<nav class="bg-white shadow-sm border-b border-gray-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            {{-- Logo & Menu --}}
            <div class="flex items-center">
                <a href="{{ route('dashboard') }}" class="text-xl font-bold text-blue-600">
                    Minimarket Jayusman
                </a>
                
                <div class="hidden sm:flex sm:ml-10 space-x-2">
                    <x-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
                        Dashboard
                    </x-nav-link>
                    
                    @if(auth()->user()->role === 'owner')
                        <x-nav-link href="{{ route('branches.index') }}" :active="request()->routeIs('branches.*')">
                            Cabang
                        </x-nav-link>
                        <x-nav-link href="{{ route('users.index') }}" :active="request()->routeIs('users.*')">
                            Pegawai
                        </x-nav-link>
                        <x-nav-link href="{{ route('products.index') }}" :active="request()->routeIs('products.*')">
                            Produk
                        </x-nav-link>
                    @endif
                    
                    @if(in_array(auth()->user()->role, ['owner', 'manager', 'warehouse']))
                        <x-nav-link href="{{ route('stocks.index') }}" :active="request()->routeIs('stocks.*')">
                            Stok
                        </x-nav-link>
                        <x-nav-link href="{{ route('stock-movements.index') }}" :active="request()->routeIs('stock-movements.*')">
                            Mutasi Stok
                        </x-nav-link>
                    @endif
                    
                    @if(in_array(auth()->user()->role, ['owner', 'manager', 'supervisor', 'cashier']))
                        <x-nav-link href="{{ route('sales.index') }}" :active="request()->routeIs('sales.*')">
                            Transaksi
                        </x-nav-link>
                    @endif
                    
                    @if(in_array(auth()->user()->role, ['owner', 'manager']))
                        <x-nav-link href="{{ route('reports.index') }}" :active="request()->routeIs('reports.*')">
                            Laporan
                        </x-nav-link>
                    @endif
                </div>
            </div>
            
            {{-- User Info & Logout --}}
            <div class="flex items-center space-x-4">
                <div class="text-right">
                    <div class="text-sm font-medium text-gray-900">{{ auth()->user()->name }}</div>
                    <div class="text-xs text-gray-500 capitalize">{{ auth()->user()->role }}</div>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-sm text-red-600 hover:text-red-800 font-medium">
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>