<h1>Tambah Penjualan</h1>

<form action="{{ route('sales.store') }}" method="POST">
    @csrf

    <label>Cabang</label><br>
    <select name="branch_id">
        @foreach($branches as $branch)
            <option value="{{ $branch->id }}">{{ $branch->name }}</option>
        @endforeach
    </select>

    <br><br>

    <label>Kasir</label><br>
    <select name="cashier_id">
        @foreach($cashiers as $cashier)
            <option value="{{ $cashier->id }}">{{ $cashier->name }}</option>
        @endforeach
    </select>

    <br><br>

    <label>Tanggal Penjualan</label><br>
    <input type="date" name="sale_date">

    <br><br>

    <label>Total Harga</label><br>
    <input type="number" name="total_price">

    <br><br>

    <button type="submit">Simpan</button>
    <a href="{{ route('sales.index') }}">Kembali</a>
</form>