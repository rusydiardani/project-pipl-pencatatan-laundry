@extends('layouts.app')

@section('title', 'Laporan Transaksi')

@section('content')
<div class="container-fluid px-4">
    <!-- Header -->
    <div style="display:flex; justify-content:space-between; align-items:center; margin:2rem 0 2rem; padding-bottom:1.5rem; border-bottom:1px solid var(--border);">
        <div>
            <h1 style="font-size:28px; font-weight:700; margin:0 0 0.375rem; color:var(--gray-900); letter-spacing:-0.3px;">
                Laporan Transaksi
            </h1>
            <p style="color:var(--text-secondary); margin:0; font-size:14px; font-weight:500;">
                Generate laporan transaksi berdasarkan periode dan status
            </p>
        </div>
    </div>

    <!-- Filter Card -->
    <div class="card" style="box-shadow:var(--shadow-sm); border-radius:var(--radius-lg); border:1px solid var(--border);">
        <div class="card-header" style="background:white; border-bottom:1px solid var(--border); border-radius:var(--radius-lg) var(--radius-lg) 0 0; padding:1.25rem 1.5rem;">
            <div style="display:flex; align-items:center; gap:0.75rem;">
                <div style="width:36px; height:36px; background:var(--gray-50); border-radius:var(--radius); display:grid; place-items:center;">
                    <i class="fas fa-filter" style="font-size:16px; color:var(--gray-600);"></i>
                </div>
                <span style="font-weight:700; color:var(--gray-900); font-size:15px;">Filter Laporan</span>
            </div>
        </div>
        <div class="card-body" style="padding:1.5rem;">
            <form action="{{ route('reports.generate') }}" method="GET" target="_blank">
                <div class="row" style="margin-bottom:1.25rem;">
                    <div class="col-md-4" style="margin-bottom:1rem;">
                        <label for="start_date" style="display:block; font-size:13px; font-weight:600; color:var(--gray-700); margin-bottom:0.5rem;">
                            Dari Tanggal
                        </label>
                        <input type="date" class="input" id="start_date" name="start_date" value="{{ date('Y-m-01') }}" required style="width:100%;">
                    </div>
                    <div class="col-md-4" style="margin-bottom:1rem;">
                        <label for="end_date" style="display:block; font-size:13px; font-weight:600; color:var(--gray-700); margin-bottom:0.5rem;">
                            Sampai Tanggal
                        </label>
                        <input type="date" class="input" id="end_date" name="end_date" value="{{ date('Y-m-d') }}" required style="width:100%;">
                    </div>
                    <div class="col-md-4" style="margin-bottom:1rem;">
                        <label for="status" style="display:block; font-size:13px; font-weight:600; color:var(--gray-700); margin-bottom:0.5rem;">
                            Status Transaksi
                        </label>
                        <select class="input" id="status" name="status" style="width:100%;">
                            <option value="ALL">Semua Status</option>
                            <option value="NEW">NEW</option>
                            <option value="PROCESS">PROCESS</option>
                            <option value="READY">READY</option>
                            <option value="COMPLETED">COMPLETED</option>
                            <option value="CANCELLED">CANCELLED</option>
                        </select>
                    </div>
                </div>
                <div style="display:flex; gap:0.75rem; padding-top:1rem; border-top:1px solid var(--border);">
                    <button type="submit" class="btn btn-primary" style="height:42px; padding:0 1.75rem;">
                        <i class="fas fa-file-alt"></i> Generate Laporan
                    </button>
                    <button type="button" onclick="document.querySelector('form').reset()" class="btn" style="height:42px; padding:0 1.75rem; background:var(--gray-100); border:1px solid var(--border);">
                        <i class="fas fa-redo"></i> Reset
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Info Card -->
    <div class="card" style="box-shadow:var(--shadow-sm); border-radius:var(--radius-lg); border:1px solid var(--primary-pale); background:var(--primary-pale); margin-top:1.5rem;">
        <div class="card-body" style="padding:1.25rem 1.5rem;">
            <div style="display:flex; align-items:flex-start; gap:1rem;">
                <div style="width:40px; height:40px; background:white; border-radius:var(--radius); display:grid; place-items:center; flex-shrink:0;">
                    <i class="fas fa-info-circle" style="font-size:20px; color:var(--primary);"></i>
                </div>
                <div>
                    <div style="font-weight:600; color:var(--primary-dark); margin-bottom:0.25rem; font-size:14px;">Petunjuk Penggunaan</div>
                    <ul style="margin:0; padding-left:1.25rem; color:var(--primary-dark); font-size:13px; line-height:1.6;">
                        <li>Pilih rentang tanggal yang ingin Anda lihat</li>
                        <li>Filter berdasarkan status transaksi (opsional)</li>
                        <li>Klik "Generate Laporan" untuk melihat hasil</li>
                        <li>Laporan akan terbuka di tab baru dan siap untuk dicetak</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
@endsection
