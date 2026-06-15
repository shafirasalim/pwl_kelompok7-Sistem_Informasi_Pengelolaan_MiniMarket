<!DOCTYPE html>
<html>
<head>
    <title>Edit Produk</title>
</head>
<body>

    <h1>Edit Produk</h1>

    <form action="{{ route('products.update', $product->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div>
            <label>Nama Produk</label>
            <br>
            <input type="text" name="name" value="{{ $product->name }}" required>
        </div>

        <br>

        <div>
            <label>Harga</label>
            <br>
            <input type="number" name="price" value="{{ $product->price }}" required>
        </div>

        <br>

        <button type="submit">Update</button>
        <a href="{{ route('products.index') }}">Kembali</a>

    </form>

</body>
</html>