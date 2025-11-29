@extends('layouts.app')

@section('title', 'Halaman Tidak Ditemukan')

@section('content')
<div class="container-fluid px-4" style="height: 80vh; display: flex; align-items: center; justify-content: center;">
    <div style="text-align: center; max-width: 500px;">
        <div style="width: 80px; height: 80px; background: var(--gray-100); border-radius: 50%; display: grid; place-items: center; margin: 0 auto 1.5rem;">
            <i class="fas fa-search" style="font-size: 32px; color: var(--gray-600);"></i>
        </div>
        <h1 style="font-size: 28px; font-weight: 800; color: var(--gray-900); margin-bottom: 0.5rem;">Halaman Tidak Ditemukan (404)</h1>
        <p style="color: var(--text-secondary); font-size: 16px; margin-bottom: 2rem; line-height: 1.6;">
            Maaf, halaman yang Anda cari tidak ditemukan.<br>
            Mungkin link rusak atau halaman sudah dihapus.
        </p>
        <a href="{{ route('dashboard') }}" class="btn btn-primary" style="padding: 0.75rem 2rem; font-size: 15px; font-weight: 600;">
            <i class="fas fa-home me-2"></i> Kembali ke Dashboard
        </a>
    </div>
</div>
@endsection
