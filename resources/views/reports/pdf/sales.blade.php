<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Penjualan</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        h1 { text-align: center; margin-bottom: 5px; }
        h2 { text-align: center; font-size: 14px; margin-top: 0; }
        .info { text-align: center; margin-bottom: 20px; color: #666; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f4f4f4; }
    </style>
</head>
<body>
    <h1>MINIMARKET JAYUSMAN</h1>
    <h2>LAPORAN PENJUALAN</h2>
    <div class="info">
        Total Transaksi: {{ $totalTransactions }} | Total Pendapatan: Rp {{ number_format($totalRevenue, 0, ',', '.') }}
    </div>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Cabang</th>
                <th>Kasir</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($sales as $sale)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ \Carbon\Carbon::parse($sale->sale_date)->format('d M Y') }}</td>
                <td>{{ $sale->branch->name }}</td>
                <td>{{ $sale->cashier->name }}</td>
                <td>Rp {{ number_format($sale->total_price, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>