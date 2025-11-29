@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">
    <!-- Header -->
    <div style="display:flex; justify-content:space-between; align-items:center; margin:2rem 0 2rem; padding-bottom:1.5rem; border-bottom:1px solid var(--border);">
        <div>
            <h1 style="font-size:28px; font-weight:700; margin:0 0 0.375rem; color:var(--gray-900); letter-spacing:-0.3px;">
                Data Produk
            </h1>
            <p style="color:var(--text-secondary); margin:0; font-size:14px; font-weight:500;">
                Kelola inventaris barang dan stok laundry
            </p>
        </div>
        <a href="{{ route('products.create') }}" class="btn btn-primary" style="height:40px; padding:0 1.5rem; font-size:14px; display:inline-flex; align-items:center; gap:0.5rem;">
            <i class="fas fa-plus" style="font-size:12px;"></i> Tambah Produk
        </a>
    </div>

    <!-- Products Card -->
    <div class="card" style="box-shadow:var(--shadow-sm); border-radius:var(--radius-lg); border:1px solid var(--border);">
        <div class="card-header" style="background:white; border-bottom:1px solid var(--border); border-radius:var(--radius-lg) var(--radius-lg) 0 0; padding:1.25rem 1.5rem;">
            <div style="display:flex; align-items:center; gap:0.75rem;">
                <div style="width:36px; height:36px; background:var(--gray-50); border-radius:var(--radius); display:grid; place-items:center;">
                    <i class="fas fa-box" style="font-size:16px; color:var(--gray-600);"></i>
                </div>
                <span style="font-weight:700; color:var(--gray-900); font-size:15px;">List Produk</span>
            </div>
        </div>
        <div class="card-body" style="padding:1.5rem;">
            <div class="table-responsive">
                <table style="width:100%; border-collapse:separate; border-spacing:0;">
                    <thead>
                        <tr style="background:var(--gray-50);">
                            <th style="padding:1rem 1.5rem; font-size:12px; font-weight:600; text-transform:uppercase; letter-spacing:0.5px; color:var(--gray-600); border-bottom:1px solid var(--border); border-top-left-radius:var(--radius); text-align:left;">Nama Produk</th>
                            <th style="padding:1rem 1.5rem; font-size:12px; font-weight:600; text-transform:uppercase; letter-spacing:0.5px; color:var(--gray-600); border-bottom:1px solid var(--border); text-align:right;">Harga Satuan</th>
                            <th style="padding:1rem 1.5rem; font-size:12px; font-weight:600; text-transform:uppercase; letter-spacing:0.5px; color:var(--gray-600); border-bottom:1px solid var(--border); text-align:center;">Stok</th>
                            <th style="padding:1rem 1.5rem; font-size:12px; font-weight:600; text-transform:uppercase; letter-spacing:0.5px; color:var(--gray-600); border-bottom:1px solid var(--border); border-top-right-radius:var(--radius); text-align:right;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($products as $product)
                        <tr style="transition:all 0.2s; border-bottom:1px solid var(--gray-100);">
                            <td style="padding:1rem 1.5rem; vertical-align:middle; border-bottom:1px solid var(--gray-100);">
                                <div style="font-weight:600; color:var(--gray-900);">{{ $product->name }}</div>
                            </td>
                            <td style="padding:1rem 1.5rem; vertical-align:middle; border-bottom:1px solid var(--gray-100); text-align:right;">
                                <div style="font-weight:600; color:var(--success);">Rp {{ number_format($product->price, 0, ',', '.') }}</div>
                            </td>
                            <td style="padding:1rem 1.5rem; vertical-align:middle; border-bottom:1px solid var(--gray-100); text-align:center;">
                                @if($product->stock < 10)
                                    <span class="badge bg-danger" style="padding:0.5em 0.75em; font-weight:600;">{{ $product->stock }} (Low)</span>
                                @else
                                    <span class="badge bg-success" style="padding:0.5em 0.75em; font-weight:600;">{{ $product->stock }}</span>
                                @endif
                            </td>
                            <td style="padding:1rem 1.5rem; vertical-align:middle; border-bottom:1px solid var(--gray-100); text-align:right;">
                                <div style="display:flex; gap:0.5rem; justify-content:flex-end;">
                                    <a href="{{ route('products.edit', $product->id) }}" class="btn btn-icon" style="width:32px; height:32px; padding:0; display:grid; place-items:center; background:#fef3c7; color:#d97706; border:1px solid #fef3c7; border-radius:var(--radius);">
                                        <i class="fas fa-edit" style="font-size:12px;"></i>
                                    </a>
                                    <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus produk ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-icon" style="width:32px; height:32px; padding:0; display:grid; place-items:center; background:#fee2e2; color:#dc2626; border:1px solid #fee2e2; border-radius:var(--radius);">
                                            <i class="fas fa-trash" style="font-size:12px;"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" style="padding:3rem; text-align:center;">
                                <div style="width:64px; height:64px; background:var(--gray-50); border-radius:50%; display:grid; place-items:center; margin:0 auto 1rem;">
                                    <i class="fas fa-box-open" style="font-size:24px; color:var(--gray-400);"></i>
                                </div>
                                <h3 style="font-size:16px; font-weight:600; color:var(--gray-900); margin-bottom:0.5rem;">Belum ada produk</h3>
                                <p style="color:var(--text-secondary); font-size:14px; margin-bottom:1.5rem;">Mulai dengan menambahkan produk baru ke inventaris.</p>
                                <a href="{{ route('products.create') }}" class="btn btn-primary" style="padding:0.5rem 1.25rem; font-size:14px;">
                                    <i class="fas fa-plus me-2"></i> Tambah Produk
                                </a>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
    tr:hover td {
        background-color: var(--gray-50);
    }
</style>
@endsection
