<h1>Data Sale Detail</h1>

<a href="{{ route('sale-details.create') }}">
    Tambah Detail Penjualan
</a>

<table border="1" cellpadding="10">
    <tr>
        <th>No</th>
        <th>ID Sale</th>
        <th>Produk</th>
        <th>Qty</th>
        <th>Harga</th>
        <th>Subtotal</th>
        <th>Aksi</th>
    </tr>

    @foreach($saleDetails as $detail)
    <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $detail->sale_id }}</td>
        <td>{{ $detail->product->name }}</td>
        <td>{{ $detail->quantity }}</td>
        <td>{{ $detail->price }}</td>
        <td>{{ $detail->subtotal }}</td>

        <td>
            <a href="{{ route('sale-details.edit', $detail->id) }}">
                Edit
            </a>

            <form action="{{ route('sale-details.destroy', $detail->id) }}"
                  method="POST"
                  style="display:inline">
                @csrf
                @method('DELETE')

                <button type="submit">
                    Hapus
                </button>
            </form>
        </td>
    </tr>
    @endforeach
</table>