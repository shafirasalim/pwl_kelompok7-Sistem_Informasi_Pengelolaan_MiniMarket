<h1>Data Penjualan</h1>

<a href="{{ route('sales.create') }}">Tambah Penjualan</a>

<table border="1" cellpadding="10">
    <tr>
        <th>No</th>
        <th>Cabang</th>
        <th>Kasir</th>
        <th>Tanggal</th>
        <th>Total</th>
        <th>Aksi</th>
    </tr>

    @foreach($sales as $sale)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $sale->branch->name }}</td>
            <td>{{ $sale->cashier->name }}</td>
            <td>{{ $sale->sale_date }}</td>
            <td>Rp {{ number_format($sale->total_price, 0, ',', '.') }}</td>
            <td>
                <a href="{{ route('sales.show', $sale->id) }}">Detail</a>
                <a href="{{ route('sales.edit', $sale->id) }}">Edit</a>

                <form action="{{ route('sales.destroy', $sale->id) }}" method="POST" style="display:inline">
                    @csrf
                    @method('DELETE')

                    <button type="submit" onclick="return confirm('Yakin hapus data penjualan ini?')">
                        Hapus
                    </button>
                </form>
            </td>
        </tr>
    @endforeach
</table>