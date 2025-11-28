<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Struk Transaksi - {{ $ref_no }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Arial', sans-serif;
            font-size: 12px;
            color: #333;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #000;
            padding-bottom: 15px;
        }
        .header h1 {
            font-size: 24px;
            margin-bottom: 5px;
            text-transform: uppercase;
        }
        .header p {
            font-size: 11px;
            color: #666;
        }
        .info-section {
            margin-bottom: 15px;
        }
        .info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 5px;
        }
        .info-label {
            font-weight: bold;
            width: 120px;
        }
        .section-title {
            font-size: 14px;
            font-weight: bold;
            background: #f0f0f0;
            padding: 8px;
            margin: 15px 0 10px 0;
            border-left: 4px solid #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        table th {
            background: #f5f5f5;
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
            font-size: 11px;
        }
        table td {
            border: 1px solid #ddd;
            padding: 6px 8px;
            font-size: 11px;
        }
        .text-right {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
        .total-section {
            margin-top: 20px;
            padding-top: 15px;
            border-top: 2px solid #000;
        }
        .total-row {
            display: flex;
            justify-content: space-between;
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .status-badge {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 3px;
            font-size: 10px;
            font-weight: bold;
        }
        .status-new { background: #e0e0e0; color: #333; }
        .status-paid { background: #4caf50; color: white; }
        .status-unpaid { background: #f44336; color: white; }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
            color: #666;
            border-top: 1px dashed #999;
            padding-top: 15px;
        }
        .footer p {
            margin-bottom: 3px;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <h1>Laundry Express</h1>
        <p>Jl. Contoh No. 123, Kota | Telp: (021) 1234-5678 | Whapp: 0812-3456-7890</p>
        <p>Email: info@laundryexpress.com</p>
    </div>

    <!-- Transaction Info -->
    <div class="info-section">
        <div class="info-row">
            <span class="info-label">No. Transaksi:</span>
            <span>{{ $ref_no }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Tanggal:</span>
            <span>{{ $date }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Pelanggan:</span>
            <span>{{ $client_name }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Kasir:</span>
            <span>{{ $created_by }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Status:</span>
            <span>
                <span class="status-badge status-new">{{ $status }}</span>
                <span class="status-badge {{ $payment_status == 'PAID' ? 'status-paid' : 'status-unpaid' }}">
                    {{ $payment_status == 'PAID' ? 'LUNAS' : 'BELUM LUNAS' }}
                </span>
            </span>
        </div>
    </div>

    <!-- Services Table -->
    @if($services->count() > 0)
    <div class="section-title">Layanan</div>
    <table>
        <thead>
            <tr>
                <th style="width: 40%">Nama Layanan</th>
                <th style="width: 15%" class="text-center">Qty/Kg</th>
                <th style="width: 20%" class="text-right">Harga</th>
                <th style="width: 25%" class="text-right">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($services as $service)
            <tr>
                <td>{{ $service->product_name }}</td>
                <td class="text-center">{{ $service->weight }} Kg</td>
                <td class="text-right">Rp {{ number_format($service->price, 0, ',', '.') }}</td>
                <td class="text-right">Rp {{ number_format($service->weight * $service->price, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif

    <!-- Products Table -->
    @if($products->count() > 0)
    <div class="section-title">Produk</div>
    <table>
        <thead>
            <tr>
                <th style="width: 40%">Nama Produk</th>
                <th style="width: 15%" class="text-center">Qty</th>
                <th style="width: 20%" class="text-right">Harga</th>
                <th style="width: 25%" class="text-right">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $product)
            <tr>
                <td>{{ $product->product_name }}</td>
                <td class="text-center">{{ $product->weight }}</td>
                <td class="text-right">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                <td class="text-right">Rp {{ number_format($product->weight * $product->price, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif

    <!-- Total Section -->
    <div class="total-section">
        <div class="total-row">
            <span>TOTAL PEMBAYARAN:</span>
            <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
        </div>
    </div>

    <!-- Footer -->
    <div class="footer">
        <p><strong>Terima kasih atas kepercayaan Anda!</strong></p>
        <p>Barang yang sudah dicuci tidak dapat dikembalikan</p>
        <p>Simpan struk ini sebagai bukti pengambilan</p>
        <p style="margin-top: 10px;">Dicetak pada: {{ now()->format('d/m/Y H:i:s') }}</p>
    </div>
</body>
</html>
