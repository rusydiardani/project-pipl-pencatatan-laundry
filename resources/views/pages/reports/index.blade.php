@extends('layouts.app')

@section('title', 'Laporan Transaksi')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Laporan Transaksi</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Laporan</li>
    </ol>

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-filter me-1"></i>
            Filter Laporan
        </div>
        <div class="card-body">
            <form action="{{ route('reports.generate') }}" method="GET" target="_blank">
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="start_date" class="form-label">Dari Tanggal</label>
                        <input type="date" class="form-control" id="start_date" name="start_date" value="{{ date('Y-m-01') }}" required>
                    </div>
                    <div class="col-md-4">
                        <label for="end_date" class="form-label">Sampai Tanggal</label>
                        <input type="date" class="form-control" id="end_date" name="end_date" value="{{ date('Y-m-d') }}" required>
                    </div>
                    <div class="col-md-4">
                        <label for="status" class="form-label">Status Transaksi</label>
                        <select class="form-select" id="status" name="status">
                            <option value="ALL">Semua Status</option>
                            <option value="NEW">NEW</option>
                            <option value="PROCESS">PROCESS</option>
                            <option value="READY">READY</option>
                            <option value="COMPLETED">COMPLETED</option>
                            <option value="CANCELLED">CANCELLED</option>
                        </select>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-print me-1"></i> Generate Laporan
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
