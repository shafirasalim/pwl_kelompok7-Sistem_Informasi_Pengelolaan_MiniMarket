<h1>Tambah Detail Penjualan</h1>

<form action="{{ route('sale-details.store') }}" method="POST">
    @csrf

    <label>Sale</label>
    <select name="sale_id">
        @foreach($sales as $sale)
            <option value="{{ $sale->id }}">
                Sale #{{ $sale->id }}
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

    <label>Quantity</label>
    <input type="number" name="quantity">

    <br><br>

    <label>Harga</label>
    <input type="number" name="price">

    <br><br>

    <label>Subtotal</label>
    <input type="number" name="subtotal">

    <br><br>

    <button type="submit">
        Simpan
    </button>
</form>