@extends('layouts.app')

@section('title', 'Laporan Transaksi')

@section('content')
<div class="container-fluid px-4">
    <!-- Header -->
    <div style="display:flex; justify-content:space-between; align-items:center; margin:2rem 0 2rem; padding-bottom:1.5rem; border-bottom:1px solid var(--border);">
        <div>
            <h1 style="font-size:28px; font-weight:700; margin:0 0 0.375rem; color:var(--gray-900); letter-spacing:-0.3px;">
                Laporan Transaksi
            </h1>
            <p style="color:var(--text-secondary); margin:0; font-size:14px; font-weight:500;">
                Generate laporan transaksi berdasarkan periode dan status
            </p>
        </div>
    </div>

    <!-- Filter Card -->
    <div class="card" style="box-shadow:var(--shadow-sm); border-radius:var(--radius-lg); border:1px solid var(--border);">
        <div class="card-header" style="background:white; border-bottom:1px solid var(--border); border-radius:var(--radius-lg) var(--radius-lg) 0 0; padding:1.25rem 1.5rem; position:relative;">
            <div style="display:flex; align-items:center; gap:0.75rem;">
                <div style="width:36px; height:36px; background:var(--gray-50); border-radius:var(--radius); display:grid; place-items:center;">
                    <i class="fas fa-filter" style="font-size:16px; color:var(--gray-600);"></i>
                </div>
                <span style="font-weight:700; color:var(--gray-900); font-size:15px;">Filter Laporan</span>
            </div>
            <!-- Info Button - Absolute Position Right -->
            <button type="button" onclick="toggleHelpModal()" style="position:absolute; top:1.25rem; right:1.5rem; width:32px; height:32px; background:var(--primary-pale); border:1px solid var(--primary); border-radius:var(--radius); display:grid; place-items:center; cursor:pointer; transition:all 0.2s;">
                <i class="fas fa-info-circle" style="font-size:16px; color:var(--primary);"></i>
            </button>
        </div>
        <div class="card-body" style="padding:1.5rem;">
            <form id="filterForm" action="{{ route('reports.generate') }}" method="GET" target="_blank">
                <div class="row" style="margin-bottom:1.25rem;">
                    <div class="col-md-4" style="margin-bottom:1rem;">
                        <label for="start_date" style="display:block; font-size:13px; font-weight:600; color:var(--gray-700); margin-bottom:0.5rem;">
                            Dari Tanggal
                        </label>
                        <input type="date" class="input" id="start_date" name="start_date" value="{{ date('Y-m-01') }}" required style="width:100%;">
                    </div>
                    <div class="col-md-4" style="margin-bottom:1rem;">
                        <label for="end_date" style="display:block; font-size:13px; font-weight:600; color:var(--gray-700); margin-bottom:0.5rem;">
                            Sampai Tanggal
                        </label>
                        <input type="date" class="input" id="end_date" name="end_date" value="{{ date('Y-m-d') }}" required style="width:100%;">
                    </div>
                    <div class="col-md-4" style="margin-bottom:1rem;">
                        <label for="status" style="display:block; font-size:13px; font-weight:600; color:var(--gray-700); margin-bottom:0.5rem;">
                            Status Transaksi
                        </label>
                        <select class="input" id="status" name="status" style="width:100%;">
                            <option value="ALL">Semua Status</option>
                            <option value="NEW">NEW</option>
                            <option value="PROCESS">PROCESS</option>
                            <option value="READY">READY</option>
                            <option value="COMPLETED">COMPLETED</option>
                            <option value="CANCELLED">CANCELLED</option>
                        </select>
                    </div>
                </div>
                <div style="display:flex; gap:0.75rem; padding-top:1rem; border-top:1px solid var(--border);">
                    <button type="submit" class="btn btn-primary" style="height:42px; padding:0 1.75rem;">
                        <i class="fas fa-file-alt"></i> Generate Laporan
                    </button>
                    <button type="button" onclick="resetFilter()" class="btn" style="height:42px; padding:0 1.75rem; background:var(--gray-100); border:1px solid var(--border);">
                        <i class="fas fa-redo"></i> Reset
                    </button>
                </div>
            </form>

<script>
function resetFilter() {
    // Set default dates
    const today = new Date();
    const firstDay = new Date(today.getFullYear(), today.getMonth(), 1);
    
    // Format to YYYY-MM-DD
    const formatDate = (date) => {
        const d = new Date(date);
        let month = '' + (d.getMonth() + 1);
        let day = '' + d.getDate();
        const year = d.getFullYear();

        if (month.length < 2) month = '0' + month;
        if (day.length < 2) day = '0' + day;

        return [year, month, day].join('-');
    };

    document.getElementById('start_date').value = formatDate(firstDay);
    document.getElementById('end_date').value = formatDate(today);
    document.getElementById('status').value = 'ALL';
    
    Toast.info('Filter laporan telah di-reset ke default.');
}
</script>
        </div>
    </div>

    <!-- Help Modal -->
    <div id="helpModal" class="modal-overlay" style="display:none;">
        <div class="modal-container">
            <div class="modal-header">
                <div style="display:flex; align-items:center; gap:0.75rem;">
                    <div style="width:40px; height:40px; background:var(--primary-pale); border-radius:var(--radius); display:grid; place-items:center;">
                        <i class="fas fa-info-circle" style="font-size:20px; color:var(--primary);"></i>
                    </div>
                    <h3 style="margin:0; font-size:18px; font-weight:700; color:var(--gray-900);">Petunjuk Penggunaan</h3>
                </div>
                <button onclick="toggleHelpModal()" class="modal-close">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <ul style="margin:0; padding-left:1.5rem; color:var(--gray-700); font-size:14px; line-height:1.8;">
                    <li style="margin-bottom:0.5rem;">Pilih rentang tanggal yang ingin Anda lihat</li>
                    <li style="margin-bottom:0.5rem;">Filter berdasarkan status transaksi (opsional)</li>
                    <li style="margin-bottom:0.5rem;">Klik "Generate Laporan" untuk melihat hasil</li>
                    <li>Laporan akan terbuka di tab baru dan siap untuk dicetak</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
/* Modal Styles */
.modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    backdrop-filter: blur(4px);
    z-index: 9999;
    display: flex;
    align-items: center;
    justify-content: center;
    animation: fadeIn 0.2s ease;
}

.modal-container {
    background: white;
    border-radius: var(--radius-lg);
    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    max-width: 500px;
    width: 90%;
    max-height: 90vh;
    overflow: hidden;
    animation: slideUp 0.3s ease;
}

.modal-header {
    padding: 1.5rem;
    border-bottom: 1px solid var(--border);
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.modal-body {
    padding: 1.5rem;
    max-height: 60vh;
    overflow-y: auto;
}

.modal-close {
    width: 32px;
    height: 32px;
    border-radius: var(--radius);
    border: none;
    background: var(--gray-100);
    color: var(--gray-600);
    cursor: pointer;
    display: grid;
    place-items: center;
    transition: all 0.2s;
}

.modal-close:hover {
    background: var(--gray-200);
    color: var(--gray-900);
}

@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

@keyframes slideUp {
    from { 
        opacity: 0;
        transform: translateY(20px);
    }
    to { 
        opacity: 1;
        transform: translateY(0);
    }
}

/* Info Button Hover Effect */
button:has(.fa-info-circle):hover {
    background: var(--primary) !important;
    transform: scale(1.05);
}

button:has(.fa-info-circle):hover i {
    color: white !important;
}
</style>

<script>
function toggleHelpModal() {
    const modal = document.getElementById('helpModal');
    if (modal.style.display === 'none' || !modal.style.display) {
        modal.style.display = 'flex';
        document.body.style.overflow = 'hidden';
    } else {
        modal.style.display = 'none';
        document.body.style.overflow = 'auto';
    }
}

// Close modal on outside click
document.addEventListener('click', function(e) {
    const modal = document.getElementById('helpModal');
    if (e.target === modal) {
        toggleHelpModal();
    }
});

// Close modal on ESC key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        const modal = document.getElementById('helpModal');
        if (modal.style.display === 'flex') {
            toggleHelpModal();
        }
    }
});
</script>
@endsection
