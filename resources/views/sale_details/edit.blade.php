<h1>Edit Detail Penjualan</h1>

<form action="{{ route('sale-details.update', $saleDetail->id) }}"
      method="POST">

    @csrf
    @method('PUT')

    <label>Sale</label>
    <select name="sale_id">
        @foreach($sales as $sale)
            <option value="{{ $sale->id }}"
                {{ $saleDetail->sale_id == $sale->id ? 'selected' : '' }}>
                Sale #{{ $sale->id }}
            </option>
        @endforeach
    </select>

    <br><br>

    <label>Produk</label>
    <select name="product_id">
        @foreach($products as $product)
            <option value="{{ $product->id }}"
                {{ $saleDetail->product_id == $product->id ? 'selected' : '' }}>
                {{ $product->name }}
            </option>
        @endforeach
    </select>

    <br><br>

    <label>Quantity</label>
    <input type="number"
           name="quantity"
           value="{{ $saleDetail->quantity }}">

    <br><br>

    <label>Harga</label>
    <input type="number"
           name="price"
           value="{{ $saleDetail->price }}">

    <br><br>

    <label>Subtotal</label>
    <input type="number"
           name="subtotal"
           value="{{ $saleDetail->subtotal }}">

    <br><br>

    <button type="submit">
        Update
    </button>
</form>