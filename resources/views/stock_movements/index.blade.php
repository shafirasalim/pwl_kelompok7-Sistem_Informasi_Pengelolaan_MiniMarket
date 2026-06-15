<h1>Data Stock Movement</h1>

<a href="{{ route('stock-movements.create') }}">
    Tambah Movement
</a>

<table border="1" cellpadding="10">
    <tr>
        <th>No</th>
        <th>User</th>
        <th>Produk</th>
        <th>Tipe</th>
        <th>Qty</th>
        <th>Tanggal</th>
        <th>Aksi</th>
    </tr>

    @foreach($stockMovements as $movement)
    <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $movement->user->name }}</td>
        <td>{{ $movement->stock->product->name }}</td>
        <td>{{ $movement->type }}</td>
        <td>{{ $movement->quantity }}</td>
        <td>{{ $movement->movement_date }}</td>
        <td>
            <a href="{{ route('stock-movements.edit',$movement->id) }}">
                Edit
            </a>

            <form action="{{ route('stock-movements.destroy',$movement->id) }}"
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