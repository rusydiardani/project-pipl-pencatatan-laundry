<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Transaksi</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ccc; padding: 6px; text-align: left; }
        th { background: #f0f0f0; }
        .header { text-align: center; margin-bottom: 20px; }
        .header h2 { margin: 0; }
        .summary { margin-top: 20px; display: flex; gap: 20px; }
        .summary-box { border: 1px solid #ccc; padding: 10px; flex: 1; }
        .text-right { text-align: right; }
        @media print {
            .no-print { display: none; }
        }
    </style>
</head>
<body>
    <div class="no-print" style="margin-bottom: 20px;">
        <button onclick="window.print()">Cetak / Simpan PDF</button>
        <button onclick="window.close()">Tutup</button>
    </div>

    <div class="header">
        <h2>Laporan Transaksi Laundry</h2>
        <p>Periode: {{ $startDate->format('d M Y') }} - {{ $endDate->format('d M Y') }}</p>
        @if($status && $status !== 'ALL')
            <p>Status: {{ $status }}</p>
        @endif
    </div>

    <div class="summary">
        <div class="summary-box">
            <strong>Total Transaksi:</strong> {{ $totalTransactions }}
        </div>
        <div class="summary-box">
            <strong>Total Item:</strong> {{ $totalItems }}
        </div>
        <div class="summary-box">
            <strong>Total Pendapatan:</strong> Rp {{ number_format($totalRevenue, 0, ',', '.') }}
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Ref No</th>
                <th>Pelanggan</th>
                <th>Item</th>
                <th>Berat/Qty</th>
                <th>Harga</th>
                <th>Subtotal</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($transactions as $t)
            <tr>
                <td>{{ $t->created_at->format('d/m/Y H:i') }}</td>
                <td>{{ $t->ref_no }}</td>
                <td>{{ $t->client_name }}</td>
                <td>{{ $t->product_name }}</td>
                <td>{{ $t->weight }}</td>
                <td class="text-right">{{ number_format($t->price, 0, ',', '.') }}</td>
                <td class="text-right">{{ number_format($t->weight * $t->price, 0, ',', '.') }}</td>
                <td>{{ $t->status }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="8" style="text-align:center;">Tidak ada data transaksi pada periode ini.</td>
            </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr>
                <th colspan="6" class="text-right">Total</th>
                <th class="text-right">{{ number_format($totalRevenue, 0, ',', '.') }}</th>
                <th></th>
            </tr>
        </tfoot>
    </table>

    <div style="margin-top: 30px; text-align: right;">
        <p>Dicetak pada: {{ now()->format('d M Y H:i') }}</p>
        <p>Oleh: {{ auth()->user()->username ?? 'System' }}</p>
    </div>
</body>
</html>
