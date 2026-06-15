<h1>Tambah Stock Movement</h1>

<form action="{{ route('stock-movements.store') }}" method="POST">
    @csrf

    <label>User</label>
    <select name="user_id">
        @foreach($users as $user)
            <option value="{{ $user->id }}">
                {{ $user->name }}
            </option>
        @endforeach
    </select>

    <br><br>

    <label>Stock</label>
    <select name="stock_id">
        @foreach($stocks as $stock)
            <option value="{{ $stock->id }}">
                {{ $stock->product->name }}
            </option>
        @endforeach
    </select>

    <br><br>

    <label>Tipe</label>
    <select name="type">
        <option value="IN">IN</option>
        <option value="OUT">OUT</option>
    </select>

    <br><br>

    <label>Quantity</label>
    <input type="number" name="quantity">

    <br><br>

    <label>Tanggal</label>
    <input type="date" name="movement_date">

    <br><br>

    <button type="submit">
        Simpan
    </button>
</form>