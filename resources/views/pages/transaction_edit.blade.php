@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">
    <!-- Header -->
    <div style="display:flex; justify-content:space-between; align-items:center; margin:2rem 0 2rem; padding-bottom:1.5rem; border-bottom:1px solid var(--border);">
        <div>
            <h1 style="font-size:28px; font-weight:700; margin:0 0 0.375rem; color:var(--gray-900); letter-spacing:-0.3px;">
                Edit Transaksi
            </h1>
            <p style="color:var(--text-secondary); margin:0; font-size:14px; font-weight:500;">
                Update status transaksi {{ $transaction->ref_no }}
            </p>
        </div>
        <a href="{{ route('list.page') }}" class="btn" style="height:40px; padding:0 1.5rem; background:var(--gray-100); border:1px solid var(--border); font-size:14px;">
            <i class="fas fa-arrow-left" style="font-size:12px;"></i> Kembali
        </a>
    </div>

    <!-- Main Grid -->
    <div style="display:grid; grid-template-columns: 2fr 1fr; gap:1.5rem;">
        
        <!-- Left Column - Form -->
        <div>
            <div class="card" style="box-shadow:var(--shadow-sm); border-radius:var(--radius-lg); border:1px solid var(--border); height:100%;">
                <div class="card-header" style="background:white; border-bottom:1px solid var(--border); border-radius:var(--radius-lg) var(--radius-lg) 0 0; padding:1.25rem 1.5rem;">
                    <div style="display:flex; align-items:center; gap:0.75rem;">
                        <div style="width:36px; height:36px; background:var(--gray-50); border-radius:var(--radius); display:grid; place-items:center;">
                            <i class="fas fa-edit" style="font-size:16px; color:var(--gray-600);"></i>
                        </div>
                        <span style="font-weight:700; color:var(--gray-900); font-size:15px;">Update Status</span>
                    </div>
                </div>
                <div class="card-body" style="padding:1.5rem;">
                    @if ($errors->any())
                        <div style="background:var(--danger-pale); border:1px solid var(--danger); border-radius:var(--radius-md); padding:1rem; margin-bottom:1.5rem;">
                            <ul style="margin:0; padding-left:1.5rem; color:var(--danger);">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form action="{{ route('transactions.updateByRef', $transaction->ref_no) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Info Read-Only -->
                        <div class="row" style="margin-bottom:1.5rem;">
                            <div class="col-md-6" style="margin-bottom:1rem;">
                                <label style="display:block; font-size:13px; font-weight:600; color:var(--gray-700); margin-bottom:0.5rem;">
                                    No. Referensi
                                </label>
                                <input type="text" class="input" value="{{ $transaction->ref_no }}" disabled style="width:100%; background:var(--gray-50); cursor:not-allowed;">
                            </div>
                            <div class="col-md-6" style="margin-bottom:1rem;">
                                <label style="display:block; font-size:13px; font-weight:600; color:var(--gray-700); margin-bottom:0.5rem;">
                                    Pelanggan
                                </label>
                                <input type="text" class="input" value="{{ $transaction->client_name }}" disabled style="width:100%; background:var(--gray-50); cursor:not-allowed;">
                            </div>
                        </div>

                        <!-- Editable Status -->
                        <div class="row" style="margin-bottom:1.5rem;">
                            <div class="col-md-6" style="margin-bottom:1rem;">
                                <label for="status" style="display:block; font-size:13px; font-weight:600; color:var(--gray-700); margin-bottom:0.5rem;">
                                    Status Laundry
                                </label>
                                <select class="input" id="status" name="status" style="width:100%;">
                                    @foreach(['PROCESS','COMPLETED', 'CANCELLED'] as $status)
                                        <option value="{{ $status }}" {{ $transaction->status == $status ? 'selected' : '' }}>
                                            {{ $status }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6" style="margin-bottom:1rem;">
                                <label for="payment_status" style="display:block; font-size:13px; font-weight:600; color:var(--gray-700); margin-bottom:0.5rem;">
                                    Status Pembayaran
                                </label>
                                <select class="input" id="payment_status" name="payment_status" style="width:100%;">
                                    <option value="UNPAID" {{ $transaction->payment_status == 'UNPAID' ? 'selected' : '' }}>BELUM LUNAS (UNPAID)</option>
                                    <option value="PAID" {{ $transaction->payment_status == 'PAID' ? 'selected' : '' }}>LUNAS (PAID)</option>
                                </select>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div style="padding-top:1rem; border-top:1px solid var(--border);">
                            <button type="submit" class="btn btn-primary" style="height:42px; padding:0 1.75rem; font-size:14px;">
                                <i class="fas fa-save"></i> Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Right Column - Transaction Detail -->
        <div>
            <div class="card" style="box-shadow:var(--shadow-sm); border-radius:var(--radius-lg); border:1px solid var(--border); height:100%;">
                <div class="card-header" style="background:white; border-bottom:1px solid var(--border); border-radius:var(--radius-lg) var(--radius-lg) 0 0; padding:1.25rem 1.5rem;">
                    <div style="display:flex; align-items:center; gap:0.75rem;">
                        <div style="width:36px; height:36px; background:var(--gray-50); border-radius:var(--radius); display:grid; place-items:center;">
                            <i class="fas fa-list-ul" style="font-size:16px; color:var(--gray-600);"></i>
                        </div>
                        <span style="font-weight:700; color:var(--gray-900); font-size:15px;">Detail Item</span>
                    </div>
                </div>
                <div class="card-body" style="padding:1.5rem;">
                    <div class="table-responsive">
                        <table style="width:100%; font-size:13px;">
                            <thead style="background:var(--gray-50);">
                                <tr>
                                    <th style="font-size:11px; text-transform:uppercase; letter-spacing:0.5px; padding:0.75rem 1rem; color:var(--gray-600); font-weight:600; border-bottom:1px solid var(--border); text-align:left;">Item</th>
                                    <th style="font-size:11px; text-transform:uppercase; letter-spacing:0.5px; padding:0.75rem 1rem; color:var(--gray-600); font-weight:600; border-bottom:1px solid var(--border); text-align:right;">Qty</th>
                                    <th style="font-size:11px; text-transform:uppercase; letter-spacing:0.5px; padding:0.75rem 1rem; color:var(--gray-600); font-weight:600; border-bottom:1px solid var(--border); text-align:right;">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($transactions as $item)
                                <tr style="border-bottom:1px solid var(--gray-100);">
                                    <td style="padding:1rem;">
                                        <div style="font-weight:600; color:var(--gray-900); margin-bottom:0.25rem;">{{ $item->product_name }}</div>
                                        <span class="badge bg-secondary" style="font-size:10px;">{{ $item->product_type }}</span>
                                    </td>
                                    <td style="padding:1rem; text-align:right; color:var(--gray-700);">{{ $item->weight }}</td>
                                    <td style="padding:1rem; text-align:right; font-weight:600; color:var(--success);">Rp {{ number_format($item->weight * $item->price, 0, ',', '.') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot style="background:var(--gray-50);">
                                <tr>
                                    <th colspan="2" style="padding:1.25rem 1rem; text-align:right; font-weight:700; font-size:14px; color:var(--gray-900); border-top:2px solid var(--border);">TOTAL:</th>
                                    <th style="padding:1.25rem 1rem; text-align:right; font-weight:700; font-size:16px; color:var(--success); border-top:2px solid var(--border);">Rp {{ number_format($transactions->sum(fn($i) => $i->weight * $i->price), 0, ',', '.') }}</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    @media (max-width: 992px) {
        div[style*="grid-template-columns: 1fr 1fr"] {
            grid-template-columns: 1fr !important;
        }
    }
</style>
@endsection
