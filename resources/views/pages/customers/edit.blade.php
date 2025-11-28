@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">
    <!-- Header -->
    <div style="display:flex; justify-content:space-between; align-items:center; margin:2rem 0 1.5rem;">
        <div>
            <h1 style="font-size:28px; font-weight:700; margin:0 0 0.375rem; color:var(--gray-900); letter-spacing:-0.3px;">
                Edit Pelanggan
            </h1>
            <p style="color:var(--text-secondary); margin:0; font-size:14px; font-weight:500;">
                Update data pelanggan
            </p>
        </div>
    </div>

    <!-- Form Card -->
    <div class="card" style="box-shadow:var(--shadow-sm); border-radius:var(--radius-lg); border:1px solid var(--border); max-width:800px;">
        <div class="card-header" style="background:white; border-bottom:1px solid var(--border); border-radius:var(--radius-lg) var(--radius-lg) 0 0; padding:1.25rem 1.5rem;">
            <div style="display:flex; align-items:center; gap:0.75rem;">
                <div style="width:36px; height:36px; background:var(--gray-50); border-radius:var(--radius); display:grid; place-items:center;">
                    <i class="fas fa-user-edit" style="font-size:16px; color:var(--gray-600);"></i>
                </div>
                <span style="font-weight:700; color:var(--gray-900); font-size:15px;">Edit Data Pelanggan</span>
            </div>
        </div>
        <div class="card-body" style="padding:1.5rem;">
            <form action="{{ route('customers.update', $customer->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row" style="margin-bottom:1.25rem;">
                    <div class="col-md-6" style="margin-bottom:1.25rem;">
                        <label for="name" style="display:block; font-size:13px; font-weight:600; color:var(--gray-700); margin-bottom:0.5rem;">
                            Nama Lengkap <span style="color:var(--danger);">*</span>
                        </label>
                        <input type="text" class="input @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $customer->name) }}" required style="width:100%;">
                        @error('name')
                            <div style="color:var(--danger); font-size:12px; margin-top:0.25rem;">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6" style="margin-bottom:1.25rem;">
                        <label for="phone" style="display:block; font-size:13px; font-weight:600; color:var(--gray-700); margin-bottom:0.5rem;">
                            No. HP (WhatsApp) <span style="color:var(--danger);">*</span>
                        </label>
                        <input type="text" class="input @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone', $customer->phone) }}" required style="width:100%;">
                        @error('phone')
                            <div style="color:var(--danger); font-size:12px; margin-top:0.25rem;">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div style="margin-bottom:1.25rem;">
                    <label for="email" style="display:block; font-size:13px; font-weight:600; color:var(--gray-700); margin-bottom:0.5rem;">
                        Email (Opsional)
                    </label>
                    <input type="email" class="input @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $customer->email) }}" style="width:100%;">
                    @error('email')
                        <div style="color:var(--danger); font-size:12px; margin-top:0.25rem;">{{ $message }}</div>
                    @enderror
                </div>

                <div style="margin-bottom:1.25rem;">
                    <label for="address" style="display:block; font-size:13px; font-weight:600; color:var(--gray-700); margin-bottom:0.5rem;">
                        Alamat (Opsional)
                    </label>
                    <textarea class="input @error('address') is-invalid @enderror" id="address" name="address" rows="3" style="width:100%; min-height:80px; padding:0.75rem 1rem;">{{ old('address', $customer->address) }}</textarea>
                    @error('address')
                        <div style="color:var(--danger); font-size:12px; margin-top:0.25rem;">{{ $message }}</div>
                    @enderror
                </div>

                <div style="margin-bottom:1.5rem;">
                    <label for="notes" style="display:block; font-size:13px; font-weight:600; color:var(--gray-700); margin-bottom:0.5rem;">
                        Catatan Tambahan (Opsional)
                    </label>
                    <textarea class="input @error('notes') is-invalid @enderror" id="notes" name="notes" rows="2" style="width:100%; min-height:60px; padding:0.75rem 1rem;">{{ old('notes', $customer->notes) }}</textarea>
                    @error('notes')
                        <div style="color:var(--danger); font-size:12px; margin-top:0.25rem;">{{ $message }}</div>
                    @enderror
                </div>

                <div style="display:flex; justify-content:space-between; padding-top:1rem; border-top:1px solid var(--border);">
                    <a href="{{ route('customers.index') }}" class="btn" style="height:40px; padding:0 1.5rem; background:var(--gray-100); border:1px solid var(--border);">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                    <button type="submit" class="btn btn-primary" style="height:40px; padding:0 1.5rem;">
                        <i class="fas fa-save"></i> Update Pelanggan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
@endsection
