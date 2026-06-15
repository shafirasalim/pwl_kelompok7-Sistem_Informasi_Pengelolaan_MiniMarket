<h1>Detail Penjualan</h1>

<p>Cabang: {{ $sale->branch->name }}</p>
<p>Kasir: {{ $sale->cashier->name }}</p>
<p>Tanggal: {{ $sale->sale_date }}</p>
<p>Total: Rp {{ number_format($sale->total_price, 0, ',', '.') }}</p>

<a href="{{ route('sales.index') }}">Kembali</a>