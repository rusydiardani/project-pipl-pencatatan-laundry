@extends('layouts.app')
@section('title', 'Daftar Service')

@section('content')
<div class="container-fluid px-4">
    <!-- Header -->
    <div style="display:flex; justify-content:space-between; align-items:center; margin:2rem 0 2rem; padding-bottom:1.5rem; border-bottom:1px solid var(--border);">
        <div>
            <h1 style="font-size:28px; font-weight:700; margin:0 0 0.375rem; color:var(--gray-900); letter-spacing:-0.3px;">
                Daftar Service
            </h1>
            <p style="color:var(--text-secondary); margin:0; font-size:14px; font-weight:500;">
                Total {{ $services->count() }} Service terdaftar
            </p>
        </div>
    </div>

    <div class="row">
        <!-- LEFT: TABLE -->
        <div class="col-lg-8">
            <div class="card" style="box-shadow:var(--shadow-sm); border-radius:var(--radius-lg); border:1px solid var(--border);">
                <div class="card-header" style="background:white; border-bottom:1px solid var(--border); border-radius:var(--radius-lg) var(--radius-lg) 0 0; padding:1.25rem 1.5rem;">
                    <div style="display:flex; align-items:center; gap:0.75rem;">
                        <div style="width:36px; height:36px; background:var(--gray-50); border-radius:var(--radius); display:grid; place-items:center;">
                            <i class="fas fa-concierge-bell" style="font-size:16px; color:var(--gray-600);"></i>
                        </div>
                        <span style="font-weight:700; color:var(--gray-900); font-size:15px;">List Service</span>
                    </div>
                </div>
                <div class="card-body" style="padding:0;">
                    <div class="table-responsive">
                        <table class="table" style="margin:0;">
                            <thead style="background:var(--gray-50);">
                                <tr>
                                    <th style="font-size:12px; text-transform:uppercase; letter-spacing:0.5px; padding:0.875rem 1.5rem; color:var(--gray-600); font-weight:600; border-bottom:1px solid var(--border); width:60px;">No</th>
                                    <th style="font-size:12px; text-transform:uppercase; letter-spacing:0.5px; padding:0.875rem 1.5rem; color:var(--gray-600); font-weight:600; border-bottom:1px solid var(--border);">Nama Service</th>
                                    <th style="font-size:12px; text-transform:uppercase; letter-spacing:0.5px; padding:0.875rem 1.5rem; color:var(--gray-600); font-weight:600; border-bottom:1px solid var(--border);">Harga</th>
                                    <th style="font-size:12px; text-transform:uppercase; letter-spacing:0.5px; padding:0.875rem 1.5rem; color:var(--gray-600); font-weight:600; border-bottom:1px solid var(--border); width:100px;">Tersedia</th>
                                    <th style="font-size:12px; text-transform:uppercase; letter-spacing:0.5px; padding:0.875rem 1.5rem; color:var(--gray-600); font-weight:600; border-bottom:1px solid var(--border); width:150px;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($services as $index => $service)
                                <tr style="border-bottom:1px solid var(--gray-100);">
                                    <td style="padding:1rem 1.5rem; font-size:14px; color:var(--gray-700);">{{ $index + 1 }}</td>
                                    <td style="padding:1rem 1.5rem; font-weight:600; color:var(--gray-900);">{{ $service->name }}</td>
                                    <td style="padding:1rem 1.5rem; font-size:14px; color:var(--success); font-weight:600;">Rp {{ number_format($service->price, 0, ',', '.') }}</td>
                                    <td style="padding:1rem 1.5rem;">
                                        @if($service->available)
                                            <span class="badge bg-success">YA</span>
                                        @else
                                            <span class="badge bg-danger">TIDAK</span>
                                        @endif
                                    </td>
                                    <td style="padding:1rem 1.5rem;">
                                        <div style="display:flex; gap:0.5rem;">
                                            <a href="{{ route('service.edit', $service->id) }}" class="btn btn-sm" style="height:32px; padding:0 0.875rem; font-size:13px; background:var(--warning-pale); color:var(--warning); border:1px solid var(--warning);">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button type="button" onclick="openDeleteModal('{{ route('service.destroy', $service->id) }}', '{{ $service->name }}')" class="btn btn-sm" style="height:32px; padding:0 0.875rem; font-size:13px; background:var(--danger-pale); color:var(--danger); border:1px solid var(--danger);">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" style="padding:3rem; text-align:center;">
                                        <div style="color:var(--text-secondary);">
                                            <i class="fas fa-concierge-bell" style="font-size:48px; opacity:0.3; margin-bottom:1rem; display:block;"></i>
                                            <div style="font-size:15px; font-weight:500;">Belum ada data service.</div>
                                            <div style="font-size:13px; margin-top:0.5rem;">Gunakan form di samping untuk menambah service baru.</div>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- RIGHT: FORM ADD -->
       <div class="col-lg-4">
            <div class="card" style="box-shadow:var(--shadow-sm); border-radius:var(--radius-lg); border:1px solid var(--border);">
                <div class="card-header" style="background:white; border-bottom:1px solid var(--border); border-radius:var(--radius-lg) var(--radius-lg) 0 0; padding:1.25rem 1.5rem;">
                    <div style="display:flex; align-items:center; gap:0.75rem;">
                        <div style="width:36px; height:36px; background:var(--gray-50); border-radius:var(--radius); display:grid; place-items:center;">
                            <i class="fas fa-plus-circle" style="font-size:16px; color:var(--gray-600);"></i>
                        </div>
                        <span style="font-weight:700; color:var(--gray-900); font-size:15px;">Tambah Service Baru</span>
                    </div>
                </div>
                <div class="card-body" style="padding:1.5rem;">
                    <form action="{{ route('service.store') }}" method="POST">
                        @csrf
                        <div style="margin-bottom:1.25rem;">
                            <label style="display:block; font-size:13px; font-weight:600; color:var(--gray-700); margin-bottom:0.5rem;">
                                Nama Service <span style="color:var(--danger);">*</span>
                            </label>
                            <input type="text" name="name" class="input" placeholder="Contoh: Cuci Kiloan" required style="width:100%;">
                        </div>

                        <div style="margin-bottom:1.25rem;">
                            <label style="display:block; font-size:13px; font-weight:600; color:var(--gray-700); margin-bottom:0.5rem;">
                                Harga (Rp) <span style="color:var(--danger);">*</span>
                            </label>
                            <input type="number" name="price" class="input" placeholder="Contoh: 6000" required style="width:100%;">
                        </div>

                        <div style="margin-bottom:1.5rem;">
                            <label style="display:block; font-size:13px; font-weight:600; color:var(--gray-700); margin-bottom:0.5rem;">
                                Ketersediaan <span style="color:var(--danger);">*</span>
                            </label>
                            <select name="available" class="input" required style="width:100%;">
                                <option value="" disabled selected>Pilih status</option>
                                <option value="1">Tersedia</option>
                                <option value="0">Tidak Tersedia</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary" style="width:100%; height:42px;">
                            <i class="fas fa-save"></i> Tambah Service
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<!-- Delete Confirmation Modal -->
<div id="deleteModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:10000; align-items:center; justify-content:center;">
    <div style="background:white; padding:2rem; border-radius:var(--radius-lg); width:90%; max-width:400px; box-shadow:var(--shadow-lg); text-align:center;">
        <div style="width:60px; height:60px; background:var(--danger-pale); color:var(--danger); border-radius:50%; display:grid; place-items:center; margin:0 auto 1.5rem; font-size:24px;">
            <i class="fas fa-trash-alt"></i>
        </div>
        <h3 style="font-size:18px; font-weight:700; color:var(--gray-900); margin-bottom:0.5rem;">Hapus Service?</h3>
        <p style="color:var(--text-secondary); font-size:14px; margin-bottom:2rem; line-height:1.5;">
            Apakah Anda yakin ingin menghapus service <strong id="deleteName" style="color:var(--gray-900);"></strong>? 
            Tindakan ini tidak dapat dibatalkan.
        </p>
        <div style="display:flex; gap:1rem; justify-content:center;">
            <button onclick="closeDeleteModal()" class="btn" style="padding:0.75rem 1.5rem; background:var(--gray-100); color:var(--gray-700); border:none; font-weight:600;">
                Batal
            </button>
            <form id="deleteForm" method="POST" style="margin:0;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn" style="padding:0.75rem 1.5rem; background:var(--danger); color:white; border:none; font-weight:600;">
                    Ya, Hapus
                </button>
            </form>
        </div>
    </div>
</div>

<script>
function openDeleteModal(url, name) {
    const modal = document.getElementById('deleteModal');
    const nameSpan = document.getElementById('deleteName');
    const form = document.getElementById('deleteForm');
    
    nameSpan.textContent = name;
    form.action = url;
    
    modal.style.display = 'flex';
}

function closeDeleteModal() {
    document.getElementById('deleteModal').style.display = 'none';
}

// Close on outside click
document.getElementById('deleteModal').addEventListener('click', (e) => {
    if (e.target === document.getElementById('deleteModal')) {
        closeDeleteModal();
    }
});
</script>
@endsection
