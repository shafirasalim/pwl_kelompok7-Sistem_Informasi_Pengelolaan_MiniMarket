<h1>Edit Penjualan</h1>

<form action="{{ route('sales.update', $sale->id) }}" method="POST">
    @csrf
    @method('PUT')

    <label>Cabang</label><br>
    <select name="branch_id">
        @foreach($branches as $branch)
            <option value="{{ $branch->id }}" {{ $sale->branch_id == $branch->id ? 'selected' : '' }}>
                {{ $branch->name }}
            </option>
        @endforeach
    </select>

    <br><br>

    <label>Kasir</label><br>
    <select name="cashier_id">
        @foreach($cashiers as $cashier)
            <option value="{{ $cashier->id }}" {{ $sale->cashier_id == $cashier->id ? 'selected' : '' }}>
                {{ $cashier->name }}
            </option>
        @endforeach
    </select>

    <br><br>

    <label>Tanggal Penjualan</label><br>
    <input type="date" name="sale_date" value="{{ $sale->sale_date }}">

    <br><br>

    <label>Total Harga</label><br>
    <input type="number" name="total_price" value="{{ $sale->total_price }}">

    <br><br>

    <button type="submit">Update</button>
    <a href="{{ route('sales.index') }}">Kembali</a>
</form>