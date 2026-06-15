<h1>Data Stock</h1>

<a href="{{ route('stocks.create') }}">Tambah Stock</a>

<table border="1" cellpadding="10">
    <tr>
        <th>No</th>
        <th>Cabang</th>
        <th>Produk</th>
        <th>Stock</th>
        <th>Aksi</th>
    </tr>

    @foreach($stocks as $stock)
    <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $stock->branch->name }}</td>
        <td>{{ $stock->product->name }}</td>
        <td>{{ $stock->stock }}</td>
        <td>
            <a href="{{ route('stocks.edit', $stock->id) }}">
                Edit
            </a>

            <form action="{{ route('stocks.destroy', $stock->id) }}"
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