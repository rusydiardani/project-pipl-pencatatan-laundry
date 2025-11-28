@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">
    <!-- Header -->
    <div style="display:flex; justify-content:space-between; align-items:center; margin:2rem 0 2rem; padding-bottom:1.5rem; border-bottom:1px solid var(--border);">
        <div>
            <h1 style="font-size:28px; font-weight:700; margin:0 0 0.375rem; color:var(--gray-900); letter-spacing:-0.3px;">
                Data Pelanggan
            </h1>
            <p style="color:var(--text-secondary); margin:0; font-size:14px; font-weight:500;">
                Kelola database pelanggan dan riwayat transaksi
            </p>
        </div>
        <div>
            <a href="{{ route('customers.create') }}" class="btn btn-primary" style="height:40px; padding:0 1.5rem; font-size:14px; box-shadow:var(--shadow-sm);">
                <i class="fas fa-plus" style="font-size:12px;"></i> Tambah Pelanggan
            </a>
        </div>
    </div>

    <!-- Search Card -->
    <div class="card" style="box-shadow:var(--shadow-sm); border-radius:var(--radius-lg); border:1px solid var(--border); margin-bottom:1.5rem;">
        <div class="card-body" style="padding:1.25rem 1.5rem;">
            <form action="{{ route('customers.index') }}" method="GET">
                <div style="display:flex; gap:0.75rem;">
                    <input type="text" name="search" class="input" style="flex:1; height:40px;" placeholder="Cari nama, no HP, atau email..." value="{{ request('search') }}">
                    <button type="submit" class="btn btn-primary" style="height:40px; padding:0 1.5rem; white-space:nowrap;">
                        <i class="fas fa-search"></i> Cari
                    </button>
                    @if(request('search'))
                        <a href="{{ route('customers.index') }}" class="btn" style="height:40px; padding:0 1.5rem; background:var(--gray-100); border:1px solid var(--border);">
                            <i class="fas fa-times"></i> Reset
                        </a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    <!-- Table Card -->
    <div class="card" style="box-shadow:var(--shadow-sm); border-radius:var(--radius-lg); border:1px solid var(--border);">
        <div class="card-header" style="background:white; border-bottom:1px solid var(--border); border-radius:var(--radius-lg) var(--radius-lg) 0 0; padding:1.25rem 1.5rem;">
            <div style="display:flex; align-items:center; gap:0.75rem;">
                <div style="width:36px; height:36px; background:var(--gray-50); border-radius:var(--radius); display:grid; place-items:center;">
                    <i class="fas fa-users" style="font-size:16px; color:var(--gray-600);"></i>
                </div>
                <span style="font-weight:700; color:var(--gray-900); font-size:15px;">List Pelanggan</span>
            </div>
        </div>
        <div class="card-body" style="padding:0;">
            <div class="table-responsive">
                <table class="table" style="margin:0;">
                    <thead style="background:var(--gray-50);">
                        <tr>
                            <th style="font-size:12px; text-transform:uppercase; letter-spacing:0.5px; padding:0.875rem 1.5rem; color:var(--gray-600); font-weight:600; border-bottom:1px solid var(--border);">Nama</th>
                            <th style="font-size:12px; text-transform:uppercase; letter-spacing:0.5px; padding:0.875rem 1.5rem; color:var(--gray-600); font-weight:600; border-bottom:1px solid var(--border);">No. HP</th>
                            <th style="font-size:12px; text-transform:uppercase; letter-spacing:0.5px; padding:0.875rem 1.5rem; color:var(--gray-600); font-weight:600; border-bottom:1px solid var(--border);">Email</th>
                            <th style="font-size:12px; text-transform:uppercase; letter-spacing:0.5px; padding:0.875rem 1.5rem; color:var(--gray-600); font-weight:600; border-bottom:1px solid var(--border);">Total Transaksi</th>
                            <th style="font-size:12px; text-transform:uppercase; letter-spacing:0.5px; padding:0.875rem 1.5rem; color:var(--gray-600); font-weight:600; border-bottom:1px solid var(--border);">Total Belanja</th>
                            <th style="font-size:12px; text-transform:uppercase; letter-spacing:0.5px; padding:0.875rem 1.5rem; color:var(--gray-600); font-weight:600; border-bottom:1px solid var(--border);">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($customers as $customer)
                        <tr style="border-bottom:1px solid var(--gray-100);">
                            <td style="padding:1rem 1.5rem;">
                                <div style="font-weight:600; color:var(--gray-900);">{{ $customer->name }}</div>
                            </td>
                            <td style="padding:1rem 1.5rem; font-size:14px; color:var(--gray-700);">{{ $customer->phone }}</td>
                            <td style="padding:1rem 1.5rem; font-size:14px; color:var(--gray-700);">{{ $customer->email ?? '-' }}</td>
                            <td style="padding:1rem 1.5rem;">
                                <span class="badge bg-primary">{{ $customer->transactionCount }} Transaksi</span>
                            </td>
                            <td style="padding:1rem 1.5rem; font-weight:700; color:var(--success); font-size:14px;">Rp {{ number_format($customer->totalSpent, 0, ',', '.') }}</td>
                            <td style="padding:1rem 1.5rem;">
                                <div style="display:flex; gap:0.5rem;">
                                    <a href="{{ route('customers.edit', $customer->id) }}" class="btn btn-sm" style="height:32px; padding:0 1rem; font-size:13px; background:var(--warning-pale); color:var(--warning); border:1px solid var(--warning);">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <form action="{{ route('customers.destroy', $customer->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus pelanggan ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm" style="height:32px; padding:0 1rem; font-size:13px; background:var(--danger-pale); color:var(--danger); border:1px solid var(--danger);">
                                            <i class="fas fa-trash"></i> Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" style="padding:3rem; text-align:center;">
                                <div style="color:var(--text-secondary);">
                                    <i class="fas fa-users" style="font-size:48px; opacity:0.3; margin-bottom:1rem; display:block;"></i>
                                    <div style="font-size:15px; font-weight:500;">Belum ada data pelanggan.</div>
                                    <div style="font-size:13px; margin-top:0.5rem;">Klik "Tambah Pelanggan" untuk memulai.</div>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
@endsection
