<!DOCTYPE html>
<html>
<head>
    <title>Tambah Produk</title>
</head>
<body>

    <h1>Tambah Produk</h1>

    <form action="{{ route('products.store') }}" method="POST">
        @csrf

        <div>
            <label>Nama Produk</label>
            <br>
            <input type="text" name="name" required>
        </div>

        <br>

        <div>
            <label>Harga</label>
            <br>
            <input type="number" name="price" required>
        </div>

        <br>

        <button type="submit">Simpan</button>
        <a href="{{ route('products.index') }}">Kembali</a>

    </form>

</body>
</html>