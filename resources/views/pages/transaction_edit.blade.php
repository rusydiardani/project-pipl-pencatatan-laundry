@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Edit Transaksi</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('list.page') }}">List Transaksi</a></li>
        <li class="breadcrumb-item active">Edit {{ $transaction->ref_no }}</li>
    </ol>

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-edit me-1"></i>
            Update Status Transaksi
        </div>
        <div class="card-body">
            <form action="{{ route('transactions.updateByRef', $transaction->ref_no) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">No. Referensi</label>
                        <input type="text" class="form-control" value="{{ $transaction->ref_no }}" disabled>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Pelanggan</label>
                        <input type="text" class="form-control" value="{{ $transaction->client_name }}" disabled>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="status" class="form-label">Status Laundry</label>
                        <select class="form-select" id="status" name="status">
                            @foreach(['NEW', 'RECEIVED', 'PROCESS', 'WASHING', 'IRONING', 'READY', 'COMPLETED', 'PICKED_UP', 'CANCELLED'] as $status)
                                <option value="{{ $status }}" {{ $transaction->status == $status ? 'selected' : '' }}>
                                    {{ $status }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="payment_status" class="form-label">Status Pembayaran</label>
                        <select class="form-select" id="payment_status" name="payment_status">
                            <option value="UNPAID" {{ $transaction->payment_status == 'UNPAID' ? 'selected' : '' }}>BELUM LUNAS (UNPAID)</option>
                            <option value="PAID" {{ $transaction->payment_status == 'PAID' ? 'selected' : '' }}>LUNAS (PAID)</option>
                        </select>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Detail Item</label>
                    <table class="table table-bordered table-sm">
                        <thead>
                            <tr>
                                <th>Produk/Layanan</th>
                                <th>Berat/Qty</th>
                                <th>Harga</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($transactions as $item)
                            <tr>
                                <td>{{ $item->product_name }} <span class="badge bg-secondary">{{ $item->product_type }}</span></td>
                                <td>{{ $item->weight }}</td>
                                <td>Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                                <td>Rp {{ number_format($item->weight * $item->price, 0, ',', '.') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="3" class="text-end">Total</th>
                                <th>Rp {{ number_format($transactions->sum(fn($i) => $i->weight * $i->price), 0, ',', '.') }}</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('list.page') }}" class="btn btn-secondary">Kembali</a>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
