<h1>Tambah Stock</h1>

<form action="{{ route('stocks.store') }}" method="POST">
    @csrf

    <label>Cabang</label>
    <select name="branch_id">
        @foreach($branches as $branch)
            <option value="{{ $branch->id }}">
                {{ $branch->name }}
            </option>
        @endforeach
    </select>

    <br><br>

    <label>Produk</label>
    <select name="product_id">
        @foreach($products as $product)
            <option value="{{ $product->id }}">
                {{ $product->name }}
            </option>
        @endforeach
    </select>

    <br><br>

    <label>Stock</label>
    <input type="number" name="stock">

    <br><br>

    <button type="submit">
        Simpan
    </button>
</form>