<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Stok</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        h1 { text-align: center; margin-bottom: 5px; }
        h2 { text-align: center; font-size: 14px; margin-top: 0; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f4f4f4; }
    </style>
</head>
<body>
    <h1>MINIMARKET JAYUSMAN</h1>
    <h2>LAPORAN STOK BARANG</h2>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Cabang</th>
                <th>Produk</th>
                <th>Stok</th>
            </tr>
        </thead>
        <tbody>
            @foreach($stocks as $stock)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $stock->branch->name }}</td>
                <td>{{ $stock->product->name }}</td>
                <td>{{ $stock->stock }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>