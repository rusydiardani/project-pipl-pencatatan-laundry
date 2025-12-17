@extends('layouts.app')
@section('title','Detail Transaksi')

@section('content')
<div class="container-fluid px-4">
    <!-- Company Header / Receipt Header -->
    <div style="background:white; border:1px solid var(--border); border-radius:var(--radius-lg); padding:1.5rem 2rem; margin:2rem 0 1.5rem; text-align:center; box-shadow:var(--shadow-sm);">
        <h2 style="font-size:24px; font-weight:700; margin:0 0 0.5rem; color:var(--primary); letter-spacing:0.5px;">E.M. LAUNDRY</h2>
        <div style="color:var(--text-secondary); font-size:13px; line-height:1.6;">
            <div>Jalan Bandara, Pinang Kencana, Tanjungpinang Timur</div>
            {{-- <div style="margin-top:0.25rem;">Telp: 0812-XXXX-XXXX</div> --}}
        </div>
        <div style="height:1px; background:var(--border); margin:1rem 0 0.5rem;"></div>
        <div style="font-size:11px; color:var(--text-secondary); font-weight:600; text-transform:uppercase; letter-spacing:1px;">Invoice / Resi</div>
    </div>

    <!-- Header -->
    <div style="display:flex; justify-content:space-between; align-items:center; margin:0 0 1.5rem; padding-bottom:1.5rem; border-bottom:1px solid var(--border);" class="no-print">
        <div>
            <h1 style="font-size:28px; font-weight:700; margin:0 0 0.375rem; color:var(--gray-900); letter-spacing:-0.3px;">
                Detail Transaksi
            </h1>
            <p style="color:var(--text-secondary); margin:0; font-size:14px; font-weight:500;">
                Ref: <strong style="color:var(--primary); font-family:monospace;">{{ $header->ref_no }}</strong>
            </p>
        </div>
        <div style="display:flex; gap:0.5rem;">
            <button onclick="window.print()" class="btn" style="height:40px; padding:0 1.5rem; background:var(--success); color:white; border:none;">
                <i class="fas fa-print"></i> Cetak Struk
            </button>
            <a href="{{ route('list.page') }}" class="btn" style="height:40px; padding:0 1.5rem; background:var(--gray-100); border:1px solid var(--border);">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="no-print" style="background:#d1fae5; border:1px solid #10b981; border-radius:var(--radius-md); padding:1rem 1.25rem; margin-bottom:1.5rem; color:#065f46;">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    <!-- Transaction Info Card -->
    <div class="card receipt-card" style="box-shadow:var(--shadow-sm); border-radius:var(--radius-lg); border:1px solid var(--border); margin-bottom:1.5rem;">
        <div class="card-header no-print" style="background:var(--gray-50); border-bottom:1px solid var(--border); border-radius:var(--radius-lg) var(--radius-lg) 0 0; padding:1.25rem 1.5rem;">
            <div style="display:flex; align-items:center; gap:0.75rem;">
                <div style="width:36px; height:36px; background:white; border-radius:var(--radius); display:grid; place-items:center; border:1px solid var(--border);">
                    <i class="fas fa-info-circle" style="font-size:16px; color:var(--primary);"></i>
                </div>
                <span style="font-weight:700; color:var(--gray-900); font-size:15px;">Informasi Transaksi</span>
            </div>
        </div>
        <div class="card-body" style="padding:1.5rem;">
            <div class="row">
                <div class="col-md-3" style="margin-bottom:1rem;">
                    <div style="font-size:12px; color:var(--text-secondary); font-weight:600; margin-bottom:0.375rem; text-transform:uppercase; letter-spacing:0.5px;">Tanggal</div>
                    <div style="font-size:14px; font-weight:600; color:var(--gray-900);">
                        <i class="fas fa-calendar" style="color:var(--gray-400); margin-right:0.5rem;"></i>
                        {{ \Carbon\Carbon::parse($header->created_at)->format('d M Y H:i') }}
                    </div>
                </div>
                <div class="col-md-3" style="margin-bottom:1rem;">
                    <div style="font-size:12px; color:var(--text-secondary); font-weight:600; margin-bottom:0.375rem; text-transform:uppercase; letter-spacing:0.5px;">Pelanggan</div>
                    <div style="font-size:14px; font-weight:600; color:var(--gray-900);">
                        <i class="fas fa-user" style="color:var(--gray-400); margin-right:0.5rem;"></i>
                        {{ $header->client_name }}
                    </div>
                </div>
                <div class="col-md-3" style="margin-bottom:1rem;">
                    <div style="font-size:12px; color:var(--text-secondary); font-weight:600; margin-bottom:0.375rem; text-transform:uppercase; letter-spacing:0.5px;">Dibuat Oleh</div>
                    <div style="font-size:14px; font-weight:600; color:var(--gray-900);">
                        <i class="fas fa-user-tag" style="color:var(--gray-400); margin-right:0.5rem;"></i>
                        {{ $header->created_by }}
                    </div>
                </div>
                <div class="col-md-3" style="margin-bottom:1rem;">
                    <div style="font-size:12px; color:var(--text-secondary); font-weight:600; margin-bottom:0.375rem; text-transform:uppercase; letter-spacing:0.5px;">Total</div>
                    <div style="font-size:18px; font-weight:700; color:var(--success);">
                        <i class="fas fa-money-bill-wave" style="margin-right:0.5rem;"></i>
                        Rp {{ number_format($total, 0, ',', '.') }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Service Items Table -->
    <div class="card" style="box-shadow:var(--shadow-sm); border-radius:var(--radius-lg); border:1px solid var(--border); margin-bottom:2rem;">
        <div class="card-header" style="background:white; border-bottom:1px solid var(--border); border-radius:var(--radius-lg) var(--radius-lg) 0 0; padding:1.25rem 1.5rem;">
            <div style="display:flex; align-items:center; gap:0.75rem;">
                <div style="width:36px; height:36px; background:var(--gray-50); border-radius:var(--radius); display:grid; place-items:center;">
                    <i class="fas fa-list-ul" style="font-size:16px; color:var(--gray-600);"></i>
                </div>
                <span style="font-weight:700; color:var(--gray-900); font-size:15px;">Daftar Service</span>
            </div>
        </div>
        <div class="card-body" style="padding:0;">
            <div class="table-responsive">
                <table class="table" style="margin:0;">
                    <thead style="background:var(--gray-50);">
                        <tr>
                            <th style="font-size:12px; text-transform:uppercase; letter-spacing:0.5px; padding:0.875rem 1.5rem; color:var(--gray-600); font-weight:600; border-bottom:1px solid var(--border);">No</th>
                            <th style="font-size:12px; text-transform:uppercase; letter-spacing:0.5px; padding:0.875rem 1.5rem; color:var(--gray-600); font-weight:600; border-bottom:1px solid var(--border);">Service</th>
                            <th style="font-size:12px; text-transform:uppercase; letter-spacing:0.5px; padding:0.875rem 1.5rem; color:var(--gray-600); font-weight:600; border-bottom:1px solid var(--border);">Hari/Jam Pengantaran</th>
                            <th style="font-size:12px; text-transform:uppercase; letter-spacing:0.5px; padding:0.875rem 1.5rem; color:var(--gray-600); font-weight:600; border-bottom:1px solid var(--border);">Berat</th>
                            <th style="font-size:12px; text-transform:uppercase; letter-spacing:0.5px; padding:0.875rem 1.5rem; color:var(--gray-600); font-weight:600; border-bottom:1px solid var(--border);">Harga</th>
                            <th style="font-size:12px; text-transform:uppercase; letter-spacing:0.5px; padding:0.875rem 1.5rem; color:var(--gray-600); font-weight:600; border-bottom:1px solid var(--border);">Subtotal</th>
                            <th class="no-print" style="font-size:12px; text-transform:uppercase; letter-spacing:0.5px; padding:0.875rem 1.5rem; color:var(--gray-600); font-weight:600; border-bottom:1px solid var(--border);">Status</th>
                            <th class="no-print" style="font-size:12px; text-transform:uppercase; letter-spacing:0.5px; padding:0.875rem 1.5rem; color:var(--gray-600); font-weight:600; border-bottom:1px solid var(--border); width:250px;">Update Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($services as $index => $it)
                        <tr style="border-bottom:1px solid var(--gray-100);">
                            <td style="padding:1rem 1.5rem; font-size:14px; color:var(--gray-700);">{{ $index + 1 }}</td>
                            <td style="padding:1rem 1.5rem; font-weight:600; color:var(--gray-900);">{{ $it->product_name }}</td>
                            <td style="padding:1rem 1.5rem; font-size:13px; color:var(--gray-700);">
                                @if($it->scheduled_date)
                                    <div style="display:flex; align-items:center; gap:0.5rem;">
                                        <i class="fas fa-calendar-check" style="color:var(--primary); font-size:12px;"></i>
                                        <div>
                                            <div>{{ \Carbon\Carbon::parse($it->scheduled_date)->format('d M Y') }}</div>
                                            @if($it->scheduled_time)
                                                <div style="font-size:11px; color:var(--text-secondary);">{{ $it->scheduled_time }}</div>
                                            @endif
                                        </div>
                                    </div>
                                @else
                                    <span style="color:var(--text-secondary);">-</span>
                                @endif
                            </td>
                            <td style="padding:1rem 1.5rem; font-size:14px; color:var(--gray-700);">{{ $it->weight }} kg</td>
                            <td style="padding:1rem 1.5rem; font-size:14px; color:var(--gray-700);">Rp {{ number_format($it->price, 0, ',', '.') }}</td>
                            <td style="padding:1rem 1.5rem; font-weight:700; color:var(--success); font-size:15px;">Rp {{ number_format($it->weight * $it->price, 0, ',', '.') }}</td>
                            <td class="no-print" style="padding:1rem 1.5rem;">
                                @if($it->status == 'ON PROCESS')
                                    <span class="badge bg-primary">ON PROCESS</span>
                                @elseif($it->status == 'COMPLETED')
                                    <span class="badge bg-success">COMPLETED</span>
                                @else
                                    <span class="badge bg-secondary">{{ $it->status }}</span>
                                @endif
                            </td>
                            <td class="no-print" style="padding:1rem 1.5rem;">
                                <form action="{{ route('transaction.update', $it->id) }}" method="POST" style="display:flex; gap:0.5rem; align-items:center;">
                                    @csrf
                                    @method('PUT')
                                    <select name="status" class="input" style="flex:1; height:36px; font-size:13px;">
                                        <option value="ON PROCESS" {{ $it->status=='ON PROCESS' ? 'selected' : '' }}>ON PROCESS</option>
                                        <option value="COMPLETED" {{ $it->status=='COMPLETED' ? 'selected' : '' }}>COMPLETED</option>
                                    </select>
                                    <button type="submit" class="btn btn-sm" style="height:36px; padding:0 1rem; font-size:13px; background:var(--primary); color:white; border:none;">
                                        <i class="fas fa-check"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" style="padding:3rem; text-align:center;">
                                <div style="color:var(--text-secondary);">
                                    <i class="fas fa-inbox" style="font-size:48px; opacity:0.3; display:block; margin-bottom:1rem;"></i>
                                    <div style="font-size:15px; font-weight:500;">Tidak ada service.</div>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                    <tfoot style="background:var(--gray-50);">
                        <tr>
                            <td colspan="5" style="padding:1.25rem 1.5rem; text-align:right; font-weight:700; font-size:16px; color:var(--gray-900);">TOTAL:</td>
                            <td colspan="3" style="padding:1.25rem 1.5rem; font-weight:700; font-size:18px; color:var(--success);">Rp {{ number_format($total, 0, ',', '.') }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        </div>
    </div>

    <!-- Product Items Table (if any) -->
    @if($meds->isNotEmpty())
    <div class="card" style="box-shadow:var(--shadow-sm); border-radius:var(--radius-lg); border:1px solid var(--border); margin-bottom:2rem;">
        <div class="card-header" style="background:white; border-bottom:1px solid var(--border); border-radius:var(--radius-lg) var(--radius-lg) 0 0; padding:1.25rem 1.5rem;">
            <div style="display:flex; align-items:center; gap:0.75rem;">
                <div style="width:36px; height:36px; background:var(--gray-50); border-radius:var(--radius); display:grid; place-items:center;">
                    <i class="fas fa-box" style="font-size:16px; color:var(--gray-600);"></i>
                </div>
                <span style="font-weight:700; color:var(--gray-900); font-size:15px;">Daftar Produk</span>
            </div>
        </div>
        <div class="card-body" style="padding:0;">
            <div class="table-responsive">
                <table class="table" style="margin:0;">
                    <thead style="background:var(--gray-50);">
                        <tr>
                            <th style="font-size:12px; text-transform:uppercase; letter-spacing:0.5px; padding:0.875rem 1.5rem; color:var(--gray-600); font-weight:600; border-bottom:1px solid var(--border);">No</th>
                            <th style="font-size:12px; text-transform:uppercase; letter-spacing:0.5px; padding:0.875rem 1.5rem; color:var(--gray-600); font-weight:600; border-bottom:1px solid var(--border);">Produk</th>
                            <th style="font-size:12px; text-transform:uppercase; letter-spacing:0.5px; padding:0.875rem 1.5rem; color:var(--gray-600); font-weight:600; border-bottom:1px solid var(--border);">Qty</th>
                            <th style="font-size:12px; text-transform:uppercase; letter-spacing:0.5px; padding:0.875rem 1.5rem; color:var(--gray-600); font-weight:600; border-bottom:1px solid var(--border);">Harga</th>
                            <th style="font-size:12px; text-transform:uppercase; letter-spacing:0.5px; padding:0.875rem 1.5rem; color:var(--gray-600); font-weight:600; border-bottom:1px solid var(--border);">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($meds as $index => $item)
                        <tr style="border-bottom:1px solid var(--gray-100);">
                            <td style="padding:1rem 1.5rem; font-size:14px; color:var(--gray-700);">{{ $index + 1 }}</td>
                            <td style="padding:1rem 1.5rem; font-weight:600; color:var(--gray-900);">{{ $item->product_name }}</td>
                            <td style="padding:1rem 1.5rem; font-size:14px; color:var(--gray-700);">{{ $item->weight }}</td>
                            <td style="padding:1rem 1.5rem; font-size:14px; color:var(--gray-700);">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                            <td style="padding:1rem 1.5rem; font-weight:700; color:var(--success); font-size:15px;">Rp {{ number_format($item->weight * $item->price, 0, ',', '.') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endif

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
/* Print Styles */
@media print {
    /* Hide non-printable elements */
    .no-print,
    nav,
    .navbar,
    .btn,
    button,
    form,
    select,
    input[type="submit"],
    .card-header.no-print,
    th.no-print,
    td.no-print {
        display: none !important;
        visibility: hidden !important;
    }

    /* Page setup */
    @page {
        margin: 0.5cm;
        size: A4 portrait;
    }

    body {
        font-size: 12pt;
        line-height: 1.4;
        color: #000;
        background: white;
    }

    /* Reset container padding for print */
    .container-fluid {
        padding: 0 !important;
        max-width: 100% !important;
    }

    /* Company header - make it stand out */
    .container-fluid > div:first-child {
        padding: 1rem !important;
        margin: 0 0 1rem 0 !important;
        border: 2px solid #000 !important;
        text-align: center;
    }

    .container-fluid > div:first-child h2 {
        font-size: 18pt !important;
        color: #000 !important;
        margin: 0 0 0.5rem 0 !important;
    }

    /* Receipt card styling */
    .receipt-card {
        border: 1px solid #000 !important;
        box-shadow: none !important;
        page-break-inside: avoid;
        margin-bottom: 1rem !important;
    }

    .receipt-card .card-body {
        padding: 1rem !important;
    }

    /* Table styling for print */
    table {
        width: 100%;
        border-collapse: collapse;
        page-break-inside: avoid;
        font-size: 10pt;
    }

    table th {
        background: #f0f0f0 !important;
        color: #000 !important;
        font-weight: bold;
        border: 1px solid #000 !important;
        padding: 0.5rem !important;
    }

    table td {
        border: 1px solid #000 !important;
        padding: 0.5rem !important;
        color: #000 !important;
    }

    table tfoot {
        background: #f0f0f0 !important;
        font-weight: bold;
    }

    table tfoot td {
        border-top: 2px solid #000 !important;
    }

    /* Remove card borders except main ones */
    .card {
        border: none !important;
        box-shadow: none !important;
    }

    /* Ensure black text for print */
    * {
        color: #000 !important;
    }

    /* Status badges */
    .badge {
        border: 1px solid #000 !important;
        padding: 0.25rem 0.5rem !important;
        font-weight: bold !important;
    }

    /* Hide all Font Awesome icons in print */
    .fas, .far, .fa, .fab, i[class*="fa-"] {
        display: none !important;
    }

    /* Info section - make it a simple grid */
    .info-section, .receipt-card .card-body .row {
        display: grid !important;
        grid-template-columns: 1fr 1fr !important;
        gap: 0.5rem 1rem !important;
    }

    .col-md-3 {
        margin-bottom: 0.5rem !important;
    }

    .col-md-3 > div:first-child {
        font-size: 9pt !important;
        font-weight: bold !important;
        text-transform: uppercase !important;
        margin-bottom: 2px !important;
    }

    .col-md-3 > div:last-child {
        font-size: 11pt !important;
    }

    /* Card headers - compact */
    .card-header {
        padding: 0.5rem 1rem !important;
        font-size: 11pt !important;
        background: #f0f0f0 !important;
        border-bottom: 1px solid #000 !important;
    }

    .card-header > div {
        gap: 0 !important;
    }

    .card-header div[style*="width:36px"] {
        display: none !important;
    }

    /* Table section title */
    .card-body {
        padding: 0.75rem !important;
    }

    /* Remove row class styling */
    .row {
        margin: 0 !important;
    }
}
</style>
@endsection
