@extends('layouts.app')
@section('title','Web Invoice Laundry')

@section('content')
  <section class="draft">
    <h1 class="page-title">Selamat Datang Admin</h1>
    <!--<p class="page-sub">Anda belum punya transaksi.</p>-->

    <a href="/buat" class="btn btn-primary btn-draft">Buat Transaksi</a>
  </section>
@endsection
