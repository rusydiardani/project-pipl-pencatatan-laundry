@extends('layouts.app')

@section('title', 'Akses Ditolak')

@section('content')
<div class="container-fluid px-4" style="height: 80vh; display: flex; align-items: center; justify-content: center;">
    <div style="text-align: center; max-width: 500px;">
        <div style="width: 80px; height: 80px; background: var(--danger-pale); border-radius: 50%; display: grid; place-items: center; margin: 0 auto 1.5rem;">
            <i class="fas fa-lock" style="font-size: 32px; color: var(--danger);"></i>
        </div>
        <h1 style="font-size: 28px; font-weight: 800; color: var(--gray-900); margin-bottom: 0.5rem;">Akses Ditolak (403)</h1>
        <p style="color: var(--text-secondary); font-size: 16px; margin-bottom: 2rem; line-height: 1.6;">
            Maaf, Anda tidak memiliki izin untuk mengakses halaman ini.<br>
            Halaman ini khusus untuk Administrator.
        </p>
        <a href="{{ route('dashboard') }}" class="btn btn-primary" style="padding: 0.75rem 2rem; font-size: 15px; font-weight: 600;">
            <i class="fas fa-arrow-left me-2"></i> Kembali ke Dashboard
        </a>
    </div>
</div>
@endsection
