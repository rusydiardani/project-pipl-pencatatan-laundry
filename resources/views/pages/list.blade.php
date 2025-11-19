@extends('layouts.app')
@section('title','List Transaksi')

@section('content')
<section class="draft">
  <h1 class="page-title">List Transaksi</h1>
  <p class="page-sub">Daftar transaksi milik <strong>{{ auth()->user()->username ?? 'Admin' }}</strong>.</p>
</section>

<section class="summary">
  {{-- Search --}}
  <form method="GET" action="{{ route('list.page') }}" style="display:flex; gap:8px; align-items:center; margin-bottom:12px;">
    <input type="text" name="search" value="{{ old('search', $search ?? '') }}" class="input" placeholder="Cari Ref No atau Nama Client (mis. TX-2025...)" style="min-width:300px;">
    <select name="per_page" class="input" style="width:120px;">
      @foreach([10,20,50,100] as $pp)
        <option value="{{ $pp }}" {{ (request('per_page', 10) == $pp) ? 'selected' : '' }}>{{ $pp }}/hal</option>
      @endforeach
    </select>
    <button class="btn btn-primary" type="submit">Cari</button>
    @if(request()->filled('search') || request()->filled('per_page'))
      <a href="{{ route('list.page') }}" class="btn btn-sm btn-outline-secondary">Reset</a>
    @endif
  </form>

  <div class="table-wrap">
    <table class="table">
      <thead>
        <tr>
          <th style="width: 80px;">No</th>
          <th style="width: 160px;">ID (Ref No)</th>
          <th>Tanggal</th>
          <th>Created By</th>
          <th>Client</th>
          <th class="tar">Total</th>
          <th style="width: 160px;">Aksi</th>
        </tr>
      </thead>
      <tbody>
      @forelse($rows as $i => $t)
        <tr>
          <td>{{ $rows->firstItem() + $i }}</td>
          <td>{{ $t->ref_no }}</td>
          <td>{{ \Carbon\Carbon::parse($t->created_at)->format('d M Y H:i') }}</td>
          <td>{{ $t->created_by }}</td>
          <td>{{ $t->client_name }}</td>
          <td class="tar">Rp {{ number_format($t->total, 0, ',', '.') }}</td>
          <td>
            <a href="{{ route('transactions.detail', $t->ref_no) }}" class="btn btn-sm btn-primary">Detail</a>
            <form action="{{ route('transactions.destroyByRef', $t->ref_no) }}" method="POST" style="display:inline"
                  onsubmit="return confirm('Hapus transaksi {{ $t->ref_no }} ({{ $t->items_count }} item)? Tindakan ini tidak bisa dibatalkan.');">
              @csrf
              @method('DELETE')
              <button type="submit" class="btn btn-sm btn-outline-danger">Hapus</button>
            </form>
          </td>
        </tr>
      @empty
        <tr><td colspan="7" class="muted">Belum ada transaksi.</td></tr>
      @endforelse
      </tbody>
    </table>
  </div>

  {{-- Pagination --}}
  <div style="margin-top:12px; display:flex; justify-content:space-between; align-items:center;">
    <div class="muted">
      Menampilkan <strong>{{ $rows->firstItem() ?? 0 }}</strong> sampai <strong>{{ $rows->lastItem() ?? 0 }}</strong> dari <strong>{{ $rows->total() }}</strong> transaksi
    </div>
    <div>
      {{ $rows->links() }}
    </div>
  </div>
</section>

<style>
  .tar{text-align:right}
  .muted{color:#888}
  form .input{padding:.4rem .6rem; border-radius:6px; border:1px solid #ddd}
</style>
@endsection
