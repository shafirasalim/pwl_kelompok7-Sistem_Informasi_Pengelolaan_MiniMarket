<h1>Edit Stock</h1>

<form action="{{ route('stocks.update', $stock->id) }}" method="POST">
    @csrf
    @method('PUT')

    <label>Cabang</label>
    <select name="branch_id">
        @foreach($branches as $branch)
            <option value="{{ $branch->id }}"
                {{ $stock->branch_id == $branch->id ? 'selected' : '' }}>
                {{ $branch->name }}
            </option>
        @endforeach
    </select>

    <br><br>

    <label>Produk</label>
    <select name="product_id">
        @foreach($products as $product)
            <option value="{{ $product->id }}"
                {{ $stock->product_id == $product->id ? 'selected' : '' }}>
                {{ $product->name }}
            </option>
        @endforeach
    </select>

    <br><br>

    <label>Stock</label>
    <input type="number"
           name="stock"
           value="{{ $stock->stock }}">

    <br><br>

    <button type="submit">
        Update
    </button>
</form>