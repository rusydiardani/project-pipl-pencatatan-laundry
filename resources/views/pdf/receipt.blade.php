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
            font-size: 12pt;
            color: #000;
            padding: 20px;
            line-height: 1.4;
        }
        
        /* Company Header */
        .header {
            text-align: center;
            margin-bottom: 20px;
            border: 2px solid #000;
            padding: 15px 20px;
            border-radius: 8px;
        }
        .header h1 {
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 8px;
            text-transform: uppercase;
            color: #000;
            letter-spacing: 0.5px;
        }
        .header .address {
            font-size: 11px;
            color: #333;
            line-height: 1.6;
            margin-bottom: 10px;
        }
        .header .divider {
            height: 1px;
            background: #000;
            margin: 10px 0 8px 0;
        }
        .header .invoice-label {
            font-size: 10px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #666;
        }

        /* Transaction Info Grid */
        .info-section {
            margin-bottom: 20px;
            background: #f9f9f9;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 6px;
        }
        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px 20px;
        }
        .info-item {
            display: flex;
            flex-direction: column;
        }
        .info-label {
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #666;
            margin-bottom: 3px;
            font-weight: 600;
        }
        .info-value {
            font-size: 12px;
            font-weight: 600;
            color: #000;
        }
        .info-value.total {
            font-size: 16px;
            color: #000;
            font-weight: 700;
        }

        /* Section Title */
        .section-title {
            font-size: 13px;
            font-weight: bold;
            background: #f0f0f0;
            padding: 8px 12px;
            margin: 20px 0 10px 0;
            border-left: 4px solid #000;
        }

        /* Table Styling */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
            page-break-inside: avoid;
        }
        table th {
            background: #f0f0f0;
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
            font-size: 10px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        table td {
            border: 1px solid #000;
            padding: 6px 8px;
            font-size: 11px;
        }
        .text-right {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }

        /* Total Section */
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
            background: #f0f0f0;
            padding: 12px;
            border: 2px solid #000;
        }

        /* Status Badges */
        .status-badge {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 4px;
            font-size: 10px;
            font-weight: bold;
            border: 1px solid #000;
        }
        .status-new { background: #e0e0e0; color: #333; }
        .status-process { background: #d0d0d0; color: #000; }
        .status-completed { background: #e0e0e0; color: #000; }

        /* Footer */
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
            color: #666;
            border-top: 1px dashed #999;
            padding-top: 15px;
        }
        .footer p {
            margin-bottom: 4px;
        }

        /* Print-specific */
        @media print {
            body {
                padding: 10px;
            }
            @page {
                margin: 0.5cm;
                size: A4 portrait;
            }
        }
    </style>
</head>
<body>
    <!-- Company Header -->
    <div class="header">
        <h1>E.M. LAUNDRY</h1>
        <div class="address">
            Jalan Bandara, Pinang Kencana, Tanjungpinang Timur
            {{-- <br>Telp: 0812-XXXX-XXXX --}}
        </div>
        <div class="divider"></div>
        <div class="invoice-label">Invoice / Resi</div>
    </div>

    <!-- Transaction Info -->
    <div class="info-section">
        <div class="info-grid">
            <div class="info-item">
                <div class="info-label">Tanggal</div>
                <div class="info-value">{{ $date }}</div>
            </div>
            <div class="info-item">
                <div class="info-label">Pelanggan</div>
                <div class="info-value">{{ $client_name }}</div>
            </div>
            <div class="info-item">
                <div class="info-label">Dibuat Oleh</div>
                <div class="info-value">{{ $created_by }}</div>
            </div>
            <div class="info-item">
                <div class="info-label">Total</div>
                <div class="info-value total">Rp {{ number_format($total, 0, ',', '.') }}</div>
            </div>
        </div>
    </div>

    <!-- Services Table -->
    @if($services->count() > 0)
    <div class="section-title">Daftar Service</div>
    <table>
        <thead>
            <tr>
                <th style="width: 5%">No</th>
                <th style="width: 40%">Service</th>
                <th style="width: 18%" class="text-center">Hari/Jam Pengantaran</th>
                <th style="width: 12%" class="text-center">Berat</th>
                <th style="width: 12%" class="text-right">Harga</th>
                <th style="width: 13%" class="text-right">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($services as $index => $service)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>{{ $service->product_name }}</td>
                <td class="text-center" style="font-size:10px;">
                    @if($service->scheduled_date)
                        {{ \Carbon\Carbon::parse($service->scheduled_date)->format('d/m/Y') }}
                        @if($service->scheduled_time)
                            <br>{{ $service->scheduled_time }}
                        @endif
                    @else
                        -
                    @endif
                </td>
                <td class="text-center">{{ $service->weight }} kg</td>
                <td class="text-right">Rp {{ number_format($service->price, 0, ',', '.') }}</td>
                <td class="text-right" style="font-weight:bold;">Rp {{ number_format($service->weight * $service->price, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif

    <!-- Products Table (if any) -->
    @if($products->count() > 0)
    <div class="section-title">Produk</div>
    <table>
        <thead>
            <tr>
                <th style="width: 5%">No</th>
                <th style="width: 45%">Nama Produk</th>
                <th style="width: 15%" class="text-center">Qty</th>
                <th style="width: 17%" class="text-right">Harga</th>
                <th style="width: 18%" class="text-right">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $index => $product)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>{{ $product->product_name }}</td>
                <td class="text-center">{{ $product->weight }}</td>
                <td class="text-right">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                <td class="text-right" style="font-weight:bold;">Rp {{ number_format($product->weight * $product->price, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif

    <!-- Total Section -->
    <div class="total-section">
        <div class="total-row">
            <span>TOTAL:</span>
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
