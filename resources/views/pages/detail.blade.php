@extends('layouts.app')
@section('title','Detail Transaksi')

@section('content')
<section class="draft">
  <h1 class="page-title">Detail Transaksi</h1>
  <p class="page-sub">
    Ringkasan transaksi <span id="det-id">#{{ $header->ref_no }}</span> •
    <span id="det-date">{{ \Carbon\Carbon::parse($header->created_at)->format('d M Y H:i') }}</span> •
    Client: <strong id="det-client">{{ $header->client_name }}</strong> •
    Created by: <strong id="det-by">{{ $header->created_by }}</strong>
  </p>
</section>

<section class="summary" id="detail-root">
  {{-- Service --}}
  <div class="table-wrap" id="box-service" style="margin-bottom:16px;">
    <div class="table-title">Service</div>
    <table class="table">
      <thead>
        <tr>
          <th>Ref #</th>
          <th>Created Date</th>
          <th>Created By</th>
          <th>Client</th>
          <th>Service</th>
          <th>Weight</th>
          <th class="tar">Price</th>
          <th>Status</th>
        </tr>
      </thead>
      <tbody id="tbody-service">
        @forelse($services as $it)
          <tr>
            <td>{{ $it->ref_no }}</td>
            <td>{{ \Carbon\Carbon::parse($it->created_at)->format('d M Y H:i') }}</td>
            <td>{{ $it->created_by }}</td>
            <td>{{ $it->client_name }}</td>
            <td>{{ $it->product_name }}</td>
            <td>{{ $it->weight }}</td>
            <td class="tar">Rp {{ number_format($it->price,0,',','.') }}</td>
            <td>{{ $it->status }}</td>
          </tr>
        @empty
          <tr><td colspan="8" class="muted">Tidak ada service.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>


  <div class="actions" style="display:flex; align-items:center; gap:12px; margin-top:12px;">
    <a href="{{ route('list.page') }}" class="btn">Kembali</a>
    <div style="flex:1"></div>
    <div class="strong">Total : <span id="det-total">Rp {{ number_format($total,0,',','.') }}</span></div>
  </div>
</section>

<style>
  .tar{text-align:right}
  .muted{color:#888}
</style>
@endsection
