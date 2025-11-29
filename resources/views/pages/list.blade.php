@extends('layouts.app')
@section('title','List Transaksi')

@section('content')
<div class="container-fluid px-4">
    <!-- Header -->
    <div style="display:flex; justify-content:space-between; align-items:center; margin:2rem 0 2rem; padding-bottom:1.5rem; border-bottom:1px solid var(--border);">
        <div>
            <h1 style="font-size:28px; font-weight:700; margin:0 0 0.375rem; color:var(--gray-900); letter-spacing:-0.3px;">
                List Transaksi
            </h1>
            <p style="color:var(--text-secondary); margin:0; font-size:14px; font-weight:500;">
                Daftar semua transaksi
            </p>
        </div>
        <div>
            <a href="{{ route('buat.page') }}" class="btn btn-primary" style="height:40px; padding:0 1.5rem; font-size:14px;">
                <i class="fas fa-plus" style="font-size:12px;"></i> Buat Transaksi
            </a>
        </div>
    </div>

    <!-- Search & Filter Card -->
    <div class="card" style="box-shadow:var(--shadow-sm); border-radius:var(--radius-lg); border:1px solid var(--border); margin-bottom:1.5rem;">
        <div class="card-body" style="padding:1.25rem 1.5rem;">
            <form method="GET" action="{{ route('list.page') }}" style="display:flex; gap:0.75rem; flex-wrap:wrap;">
                <input type="text" name="search" value="{{ old('search', $search ?? '') }}" class="input" placeholder="Cari Ref No atau Nama Client..." style="flex:1; min-width:250px; height:40px;">
                <select name="per_page" class="input" style="width:120px; height:40px;">
                  @foreach([10,20,50,100] as $pp)
                    <option value="{{ $pp }}" {{ (request('per_page', 10) == $pp) ? 'selected' : '' }}>{{ $pp }}/hal</option>
                  @endforeach
                </select>
                <button class="btn btn-primary" type="submit" style="height:40px; padding:0 1.5rem; white-space:nowrap;">
                    <i class="fas fa-search"></i> Cari
                </button>
                @if(request()->filled('search') || request()->filled('per_page'))
                  <a href="{{ route('list.page') }}" class="btn" style="height:40px; padding:0 1.5rem; background:var(--gray-100); border:1px solid var(--border);">
                    <i class="fas fa-times"></i> Reset
                  </a>
                @endif
            </form>
        </div>
    </div>

    <!-- Table Card -->
    <div class="card" style="box-shadow:var(--shadow-sm); border-radius:var(--radius-lg); border:1px solid var(--border);">
        <div class="card-header" style="background:white; border-bottom:1px solid var(--border); border-radius:var(--radius-lg) var(--radius-lg) 0 0; padding:1.25rem 1.5rem;">
            <div style="display:flex; align-items:center; gap:0.75rem;">
                <div style="width:36px; height:36px; background:var(--gray-50); border-radius:var(--radius); display:grid; place-items:center;">
                    <i class="fas fa-receipt" style="font-size:16px; color:var(--gray-600);"></i>
                </div>
                <span style="font-weight:700; color:var(--gray-900); font-size:15px;">Daftar Transaksi</span>
            </div>
        </div>
        <div class="card-body" style="padding:0;">
            <div class="table-responsive">
                <table class="table" style="margin:0;">
                    <thead style="background:var(--gray-50);">
                        <tr>
                            <th style="font-size:12px; text-transform:uppercase; letter-spacing:0.5px; padding:0.875rem 1.5rem; color:var(--gray-600); font-weight:600; border-bottom:1px solid var(--border);">No</th>
                            <th style="font-size:12px; text-transform:uppercase; letter-spacing:0.5px; padding:0.875rem 1.5rem; color:var(--gray-600); font-weight:600; border-bottom:1px solid var(--border);">Ref No</th>
                            <th style="font-size:12px; text-transform:uppercase; letter-spacing:0.5px; padding:0.875rem 1.5rem; color:var(--gray-600); font-weight:600; border-bottom:1px solid var(--border);">Tanggal</th>
                            <th style="font-size:12px; text-transform:uppercase; letter-spacing:0.5px; padding:0.875rem 1.5rem; color:var(--gray-600); font-weight:600; border-bottom:1px solid var(--border);">Created By</th>
                            <th style="font-size:12px; text-transform:uppercase; letter-spacing:0.5px; padding:0.875rem 1.5rem; color:var(--gray-600); font-weight:600; border-bottom:1px solid var(--border);">Client</th>
                            <th style="font-size:12px; text-transform:uppercase; letter-spacing:0.5px; padding:0.875rem 1.5rem; color:var(--gray-600); font-weight:600; border-bottom:1px solid var(--border);">Total</th>
                            <th style="font-size:12px; text-transform:uppercase; letter-spacing:0.5px; padding:0.875rem 1.5rem; color:var(--gray-600); font-weight:600; border-bottom:1px solid var(--border);">Status</th>
                            <th style="font-size:12px; text-transform:uppercase; letter-spacing:0.5px; padding:0.875rem 1.5rem; color:var(--gray-600); font-weight:600; border-bottom:1px solid var(--border);">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse($rows as $i => $t)
                        <tr style="border-bottom:1px solid var(--gray-100);">
                            <td style="padding:1rem 1.5rem; font-size:14px; color:var(--gray-700);">{{ $rows->firstItem() + $i }}</td>
                            <td style="padding:1rem 1.5rem; font-family:monospace; font-weight:600; color:var(--primary); font-size:13px;">{{ $t->ref_no }}</td>
                            <td style="padding:1rem 1.5rem; font-size:13px; color:var(--gray-700);">{{ \Carbon\Carbon::parse($t->created_at)->format('d M Y H:i') }}</td>
                            <td style="padding:1rem 1.5rem; font-size:14px; color:var(--gray-700);">{{ $t->created_by }}</td>
                            <td style="padding:1rem 1.5rem; font-weight:500; color:var(--gray-900);">{{ $t->client_name }}</td>
                            <td style="padding:1rem 1.5rem; font-weight:700; color:var(--success); text-align:right;">Rp {{ number_format($t->total, 0, ',', '.') }}</td>
                            <td style="padding:1rem 1.5rem;">
                                @if(($t->on_process_count ?? 0) > 0)
                                    <span class="badge bg-warning">{{ $t->on_process_count }} ON PROCESS</span>
                                @else
                                    <span class="badge bg-success">COMPLETED</span>
                                @endif
                            </td>
                            <td style="padding:1rem 1.5rem;">
                                <div style="display:flex; gap:0.5rem; flex-wrap:wrap;">
                                    <a href="{{ route('transactions.detail', $t->ref_no) }}" class="btn btn-sm" style="height:32px; padding:0 0.875rem; font-size:13px; background:var(--primary-pale); color:var(--primary); border:1px solid var(--primary);">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('transactions.edit', $t->ref_no) }}" class="btn btn-sm" style="height:32px; padding:0 0.875rem; font-size:13px; background:var(--warning-pale); color:var(--warning); border:1px solid var(--warning);">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="{{ route('transactions.print', $t->ref_no) }}" target="_blank" class="btn btn-sm" style="height:32px; padding:0 0.875rem; font-size:13px; background:var(--success-pale); color:var(--success); border:1px solid var(--success);">
                                        <i class="fas fa-print"></i>
                                    </a>
                                    <form action="{{ route('transactions.destroyByRef', $t->ref_no) }}" method="POST" style="display:inline; margin:0;" onsubmit="return confirm('Hapus transaksi {{ $t->ref_no}} ({{ $t->items_count }} item)?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm" style="height:32px; padding:0 0.875rem; font-size:13px; background:var(--danger-pale); color:var(--danger); border:1px solid var(--danger);">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" style="padding:3rem; text-align:center;">
                                <div style="color:var(--text-secondary);">
                                    <i class="fas fa-receipt" style="font-size:48px; opacity:0.3; margin-bottom:1rem; display:block;"></i>
                                    <div style="font-size:15px; font-weight:500;">Belum ada transaksi.</div>
                                    <div style="font-size:13px; margin-top:0.5rem;">Klik "Buat Transaksi" untuk memulai.</div>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($rows->hasPages())
        <div class="card-footer" style="background:var(--gray-50); border-top:1px solid var(--border); border-radius:0 0 var(--radius-lg) var(--radius-lg); padding:1rem 1.5rem;">
            <div style="display:flex; justify-content:space-between; align-items:center;">
                <div style="color:var(--text-secondary); font-size:13px;">
                    Menampilkan <strong>{{ $rows->firstItem() ?? 0 }}</strong> sampai <strong>{{ $rows->lastItem() ?? 0 }}</strong> dari <strong>{{ $rows->total() }}</strong> transaksi
                </div>
                <div>
                    {{ $rows->links() }}
                </div>
            </div>
        </div>
        @endif
    </div>
</div>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
@endsection
