@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">
    <!-- Header -->
    <div style="display:flex; justify-content:space-between; align-items:center; margin:2rem 0 2rem; padding-bottom:1.5rem; border-bottom:1px solid var(--border);">
        <div>
            <h1 style="font-size:28px; font-weight:700; margin:0 0 0.375rem; color:var(--gray-900); letter-spacing:-0.3px;">
                Edit Produk
            </h1>
            <p style="color:var(--text-secondary); margin:0; font-size:14px; font-weight:500;">
                Perbarui data produk {{ $product->name }}
            </p>
        </div>
        <a href="{{ route('products.index') }}" class="btn" style="height:40px; padding:0 1.5rem; background:var(--gray-100); border:1px solid var(--border); font-size:14px;">
            <i class="fas fa-arrow-left" style="font-size:12px;"></i> Kembali
        </a>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card" style="box-shadow:var(--shadow-sm); border-radius:var(--radius-lg); border:1px solid var(--border);">
                <div class="card-header" style="background:white; border-bottom:1px solid var(--border); border-radius:var(--radius-lg) var(--radius-lg) 0 0; padding:1.25rem 1.5rem;">
                    <div style="display:flex; align-items:center; gap:0.75rem;">
                        <div style="width:36px; height:36px; background:var(--gray-50); border-radius:var(--radius); display:grid; place-items:center;">
                            <i class="fas fa-edit" style="font-size:16px; color:var(--gray-600);"></i>
                        </div>
                        <span style="font-weight:700; color:var(--gray-900); font-size:15px;">Edit Data Produk</span>
                    </div>
                </div>
                <div class="card-body" style="padding:1.5rem;">
                    <form action="{{ route('products.update', $product->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <!-- Nama Produk -->
                        <div style="margin-bottom:1.5rem;">
                            <label for="name" style="display:block; font-size:13px; font-weight:600; color:var(--gray-700); margin-bottom:0.5rem;">
                                Nama Produk <span style="color:var(--danger);">*</span>
                            </label>
                            <input type="text" class="input @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $product->name) }}" required style="width:100%;">
                            @error('name')
                                <div style="color:var(--danger); font-size:12px; margin-top:0.25rem;">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <!-- Harga -->
                            <div class="col-md-6" style="margin-bottom:1.5rem;">
                                <label for="price" style="display:block; font-size:13px; font-weight:600; color:var(--gray-700); margin-bottom:0.5rem;">
                                    Harga Satuan (Rp) <span style="color:var(--danger);">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text" style="background:var(--gray-50); border-color:var(--border); color:var(--gray-600); font-weight:600;">Rp</span>
                                    <input type="number" class="input @error('price') is-invalid @enderror" id="price" name="price" value="{{ old('price', $product->price) }}" min="0" required style="width:100%;">
                                </div>
                                @error('price')
                                    <div style="color:var(--danger); font-size:12px; margin-top:0.25rem;">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Stok -->
                            <div class="col-md-6" style="margin-bottom:1.5rem;">
                                <label for="stock" style="display:block; font-size:13px; font-weight:600; color:var(--gray-700); margin-bottom:0.5rem;">
                                    Stok <span style="color:var(--danger);">*</span>
                                </label>
                                <input type="number" class="input @error('stock') is-invalid @enderror" id="stock" name="stock" value="{{ old('stock', $product->stock) }}" min="0" required style="width:100%;">
                                @error('stock')
                                    <div style="color:var(--danger); font-size:12px; margin-top:0.25rem;">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div style="padding-top:1.5rem; border-top:1px solid var(--border); display:flex; justify-content:flex-end;">
                            <button type="submit" class="btn btn-primary" style="height:42px; padding:0 2rem; font-size:14px; font-weight:600;">
                                <i class="fas fa-save me-2"></i> Update Produk
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
