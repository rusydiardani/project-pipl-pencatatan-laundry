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
  @if(session('success'))
    <div class="alert alert-success" style="margin-bottom:12px;">{{ session('success') }}</div>
  @endif
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
          <th>Schedule</th>
          <th>Weight</th>
          <th class="tar">Price</th>
          <th class="tar">Subtotal</th>
          <th>Status</th>
          <th>Action</th>
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
            <td>
              @if($it->scheduled_date)
                {{ \Carbon\Carbon::parse($it->scheduled_date)->format('d M Y') }}
                @if($it->scheduled_time) <br><small>{{ $it->scheduled_time }}</small> @endif
              @else
                -
              @endif
            </td>
            <td>{{ $it->weight }}</td>
            <td class="tar">Rp {{ number_format($it->price,0,',','.') }}</td>
            <td class="tar">Rp {{ number_format($it->weight * $it->price,0,',','.') }}</td>
            <td>{{ $it->status }}</td>
            <td>
              <form action="{{ route('transaction.update', $it->id) }}" method="POST" style="display:flex; gap:6px; align-items:center;">
                @csrf
                @method('PUT')
                <select name="status" class="input">
                  <option value="ON PROCESS" {{ $it->status=='ON PROCESS' ? 'selected' : '' }}>ON PROCESS</option>
                  <option value="COMPLETED" {{ $it->status=='COMPLETED' ? 'selected' : '' }}>COMPLETED</option>
                </select>
                <button type="submit" class="btn btn-sm btn-primary">Update</button>
              </form>
            </td>
          </tr>
        @empty
          <tr><td colspan="10" class="muted">Tidak ada service.</td></tr>
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
