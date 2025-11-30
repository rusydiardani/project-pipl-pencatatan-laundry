<nav class="nav">
  <div class="nav-brand-wrapper">
    <a class="nav-brand" href="{{ route('dashboard') }}">Laundry App</a>
    <button class="mobile-menu-btn" onclick="document.querySelector('.nav').classList.toggle('open')">
      <i class="fas fa-bars"></i>
    </button>
  </div>

  <div class="nav-content">
    <div class="nav-left">
      <a class="nav-link" href="{{ route('dashboard') }}" style="{{ request()->routeIs('dashboard') ? 'color:var(--primary);' : '' }}">Home</a>
      <a class="nav-link" href="{{ route('list.page') }}" style="{{ request()->routeIs('list.page') ? 'color:var(--primary);' : '' }}">List Transaksi</a>
      <a class="nav-link" href="{{ route('reports.index') }}" style="{{ request()->routeIs('reports.index') ? 'color:var(--primary);' : '' }}">Laporan</a>
      <!-- <a class="nav-link" href="{{ route('customers.index') }}">Pelanggan</a> -->
      <a class="nav-link" href="{{ route('buat.page') }}" style="{{ request()->routeIs('buat.page') ? 'color:var(--primary);' : '' }}">Buat Transaksi</a>

      {{-- Dropdown Master Data --}}
      <div class="nav-dropdown">
        <button class="nav-link dropdown-toggle" data-dd style="{{ request()->routeIs('service.*') || request()->routeIs('products.*') || request()->routeIs('customers.*') ? 'color:var(--primary);' : '' }}">Data Master ▾</button>
        <div class="dropdown-menu">
          <a href="{{ route('service.index') }}" class="dropdown-item" style="{{ request()->routeIs('service.*') ? 'color:var(--primary); background:var(--gray-50);' : '' }}">Layanan (Service)</a>
          <a href="{{ route('products.index') }}" class="dropdown-item" style="{{ request()->routeIs('products.*') ? 'color:var(--primary); background:var(--gray-50);' : '' }}">Barang (Stok)</a>
          <a href="{{ route('customers.index') }}" class="dropdown-item" style="{{ request()->routeIs('customers.*') ? 'color:var(--primary); background:var(--gray-50);' : '' }}">Pelanggan</a>
        </div>
      </div>
    </div>

    <div class="nav-right">
      <div class="nav-dropdown">
        <button class="nav-user" data-dd>
          <span class="user-name">{{ auth()->user()->username ?? 'Admin' }}</span> ▾
        </button>
        <div class="dropdown-menu dropdown-right">
          {{-- Tombol Ganti Password --}}
          <button type="button" class="dropdown-item" onclick="document.getElementById('changePassModal').style.display='block'">
            Ganti Password
          </button>

          {{-- Tombol Logout --}}
          <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
            @csrf
            <button type="submit" class="dropdown-item">Logout</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</nav>

{{-- Modal Ganti Password --}}
<div id="changePassModal" class="modal" style="display:none;">
  <div class="modal-content" style="max-width:400px; margin:auto; background:#fff; padding:20px; border-radius:8px; box-shadow:0 2px 10px rgba(0,0,0,0.2);">
    <h3>Ganti Password</h3>
    <form action="{{ route('password.update') }}" method="POST">
      @csrf
      <div class="form-row">
        <label>Password Lama</label>
        <input type="password" name="old_password" class="input" required>
      </div>
      <div class="form-row">
        <label>Password Baru</label>
        <input type="password" name="new_password" class="input" required>
      </div>
      <div class="form-row">
        <label>Konfirmasi Password Baru</label>
        <input type="password" name="new_password_confirmation" class="input" required>
      </div>
      <div class="form-actions" style="margin-top:10px; display:flex; justify-content:space-between;">
        <button type="submit" class="btn btn-primary">Simpan</button>
        <button type="button" class="btn btn-secondary" onclick="document.getElementById('changePassModal').style.display='none'">Batal</button>
      </div>
    </form>
  </div>
</div>

{{-- Tambahkan sedikit CSS --}}
<style>
.modal {
  position: fixed;
  top: 0; left: 0;
  width: 100%; height: 100%;
  background: rgba(0,0,0,0.4);
  display: none;
  align-items: center;
  justify-content: center;
  z-index: 999;
}
.modal-content {
  animation: fadeIn 0.2s ease;
}
@keyframes fadeIn {
  from { opacity: 0; transform: scale(0.9); }
  to { opacity: 1; transform: scale(1); }
}
</style>
