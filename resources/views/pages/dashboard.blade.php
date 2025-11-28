@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">
    <!-- Header -->
    <div style="display:flex; justify-content:space-between; align-items:center; margin:2rem 0 2rem; padding-bottom:1.5rem; border-bottom:1px solid var(--border);">
        <div>
            <h1 style="font-size:28px; font-weight:700; margin:0 0 0.375rem; color:var(--gray-900); letter-spacing:-0.3px;">
                Dashboard
            </h1>
            <p style="color:var(--text-secondary); margin:0; font-size:14px; font-weight:500;">
                Selamat datang, <strong style="color:var(--primary);">{{ auth()->user()->username ?? 'Admin' }}</strong>
            </p>
        </div>
        <div>
            <a href="{{ route('buat.page') }}" class="btn btn-primary" style="height:40px; padding:0 1.5rem; font-size:14px; box-shadow:var(--shadow-sm);">
                <i class="fas fa-plus" style="font-size:12px;"></i> Buat Transaksi
            </a>
        </div>
    </div>

    <!-- Metrics Cards - Professional White Cards -->
    <div class="row" style="margin-bottom:1.75rem;">
        <!-- Transaksi Hari Ini -->
        <div class="col-xl-3 col-md-6" style="margin-bottom:1.25rem;">
            <div style="background:white; border:1px solid var(--border); border-radius:var(--radius-lg); padding:1.5rem; transition:all 0.2s ease; box-shadow:var(--shadow-xs);" onmouseover="this.style.boxShadow='var(--shadow-md)'; this.style.borderColor='var(--primary-pale)'" onmouseout="this.style.boxShadow='var(--shadow-xs)'; this.style.borderColor='var(--border)'">
                <div style="display:flex; align-items:flex-start; justify-content:space-between; margin-bottom:1rem;">
                    <div style="width:48px; height:48px; background:var(--primary-pale); border-radius:var(--radius); display:grid; place-items:center;">
                        <i class="fas fa-shopping-cart" style="font-size:20px; color:var(--primary);"></i>
                    </div>
                </div>
                <div style="color:var(--text-secondary); font-size:13px; font-weight:600; margin-bottom:0.375rem; text-transform:uppercase; letter-spacing:0.5px;">Transaksi Hari Ini</div>
                <div style="font-size:32px; font-weight:700; color:var(--gray-900); line-height:1;">{{ $metrics['total_transactions'] }}</div>
            </div>
        </div>

        <!-- Pendapatan Hari Ini -->
        <div class="col-xl-3 col-md-6" style="margin-bottom:1.25rem;">
            <div style="background:white; border:1px solid var(--border); border-radius:var(--radius-lg); padding:1.5rem; transition:all 0.2s ease; box-shadow:var(--shadow-xs);" onmouseover="this.style.boxShadow='var(--shadow-md)'; this.style.borderColor='#d1fae5'" onmouseout="this.style.boxShadow='var(--shadow-xs)'; this.style.borderColor='var(--border)'">
                <div style="display:flex; align-items:flex-start; justify-content:space-between; margin-bottom:1rem;">
                    <div style="width:48px; height:48px; background:#d1fae5; border-radius:var(--radius); display:grid; place-items:center;">
                        <i class="fas fa-trending-up" style="font-size:20px; color:var(--success);"></i>
                    </div>
                </div>
                <div style="color:var(--text-secondary); font-size:13px; font-weight:600; margin-bottom:0.375rem; text-transform:uppercase; letter-spacing:0.5px;">Pendapatan Hari Ini</div>
                <div style="font-size:28px; font-weight:700; color:var(--gray-900); line-height:1; letter-spacing:-0.5px;">Rp {{ number_format($metrics['total_revenue'], 0, ',', '.') }}</div>
            </div>
        </div>

        <!-- Pending Payment -->
        <div class="col-xl-3 col-md-6" style="margin-bottom:1.25rem;">
            <div style="background:white; border:1px solid var(--border); border-radius:var(--radius-lg); padding:1.5rem; transition:all 0.2s ease; box-shadow:var(--shadow-xs);" onmouseover="this.style.boxShadow='var(--shadow-md)'; this.style.borderColor='#fed7aa'" onmouseout="this.style.boxShadow='var(--shadow-xs)'; this.style.borderColor='var(--border)'">
                <div style="display:flex; align-items:flex-start; justify-content:space-between; margin-bottom:1rem;">
                    <div style="width:48px; height:48px; background:#fed7aa; border-radius:var(--radius); display:grid; place-items:center;">
                        <i class="fas fa-clock" style="font-size:20px; color:var(--warning);"></i>
                    </div>
                </div>
                <div style="color:var(--text-secondary); font-size:13px; font-weight:600; margin-bottom:0.375rem; text-transform:uppercase; letter-spacing:0.5px;">Pending Payment</div>
                <div style="font-size:32px; font-weight:700; color:var(--gray-900); line-height:1;">{{ $metrics['pending_payments']['count'] }}</div>
                <div style="color:var(--text-secondary); font-size:12px; margin-top:0.5rem; font-weight:500;">Rp {{ number_format($metrics['pending_payments']['total'], 0, ',', '.') }}</div>
            </div>
        </div>

        <!-- Total Item -->
        <div class="col-xl-3 col-md-6" style="margin-bottom:1.25rem;">
            <div style="background:white; border:1px solid var(--border); border-radius:var(--radius-lg); padding:1.5rem; transition:all 0.2s ease; box-shadow:var(--shadow-xs);" onmouseover="this.style.boxShadow='var(--shadow-md)'; this.style.borderColor='#e0e7ff'" onmouseout="this.style.boxShadow='var(--shadow-xs)'; this.style.borderColor='var(--border)'">
                <div style="display:flex; align-items:flex-start; justify-content:space-between; margin-bottom:1rem;">
                    <div style="width:48px; height:48px; background:#e0e7ff; border-radius:var(--radius); display:grid; place-items:center;">
                        <i class="fas fa-box" style="font-size:20px; color:#6366f1;"></i>
                    </div>
                </div>
                <div style="color:var(--text-secondary); font-size:13px; font-weight:600; margin-bottom:0.375rem; text-transform:uppercase; letter-spacing:0.5px;">Total Item Hari Ini</div>
                <div style="font-size:32px; font-weight:700; color:var(--gray-900); line-height:1;">{{ $metrics['total_items'] }}</div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Status Breakdown -->
        <div class="col-xl-6" style="margin-bottom:1.75rem;">
            <div class="card" style="box-shadow:var(--shadow-sm); border-radius:var(--radius-lg); border:1px solid var(--border); height:100%;">
                <div class="card-header" style="background:white; border-bottom:1px solid var(--border); border-radius:var(--radius-lg) var(--radius-lg) 0 0; padding:1.25rem 1.5rem;">
                    <div style="display:flex; align-items:center; gap:0.75rem;">
                        <div style="width:36px; height:36px; background:var(--gray-50); border-radius:var(--radius); display:grid; place-items:center;">
                            <i class="fas fa-chart-pie" style="font-size:16px; color:var(--gray-600);"></i>
                        </div>
                        <span style="font-weight:700; color:var(--gray-900); font-size:15px;">Status Transaksi</span>
                    </div>
                </div>
                <div class="card-body" style="padding:1.5rem;">
                    <div class="table-responsive">
                        <table class="table" style="margin:0;">
                            <thead>
                                <tr>
                                    <th style="font-size:12px; text-transform:uppercase; letter-spacing:0.5px; padding:0.75rem 1rem; color:var(--gray-600); font-weight:600; border-bottom:1px solid var(--bord-light);">Status</th>
                                    <th class="text-center" style="font-size:12px; text-transform:uppercase; letter-spacing:0.5px; padding:0.75rem 1rem; color:var(--gray-600); font-weight:600; border-bottom:1px solid var(--border-light);">Jumlah</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($statusBreakdown as $status => $count)
                                    @if($count > 0)
                                    <tr style="border-bottom:1px solid var(--gray-100);">
                                        <td style="padding:1rem;">
                                            <span class="badge {{ $status == 'NEW' ? 'bg-secondary' : '' }} {{ $status == 'PROCESS' ? 'bg-primary' : '' }} {{ $status == 'READY' ? 'bg-info' : '' }} {{ $status == 'COMPLETED' ? 'bg-success' : '' }} {{ $status == 'CANCELLED' ? 'bg-danger' : '' }}">{{ $status }}</span>
                                        </td>
                                        <td class="text-center" style="padding:1rem; font-weight:700; color:var(--gray-900);">{{ $count }}</td>
                                    </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Revenue Stats - Chart Visualization -->
        <div class="col-xl-6" style="margin-bottom:1.75rem;">
            <div class="card" style="box-shadow:var(--shadow-sm); border-radius:var(--radius-lg); border:1px solid var(--border); height:100%;">
                <div class="card-header" style="background:white; border-bottom:1px solid var(--border); border-radius:var(--radius-lg) var(--radius-lg) 0 0; padding:1.25rem 1.5rem;">
                    <div style="display:flex; align-items:center; gap:0.75rem;">
                        <div style="width:36px; height:36px; background:var(--gray-50); border-radius:var(--radius); display:grid; place-items:center;">
                            <i class="fas fa-chart-bar" style="font-size:16px; color:var(--gray-600);"></i>
                        </div>
                        <span style="font-weight:700; color:var(--gray-900); font-size:15px;">Perbandingan Pendapatan</span>
                    </div>
                </div>
                <div class="card-body" style="padding:1.5rem;">
                    <canvas id="revenueChart" style="max-height:280px;"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Transactions -->
    <div class="card" style="box-shadow:var(--shadow-sm); border-radius:var(--radius-lg); border:1px solid var(--border); margin-bottom:2rem;">
        <div class="card-header" style="background:white; border-bottom:1px solid var(--border); border-radius:var(--radius-lg) var(--radius-lg) 0 0; padding:1.25rem 1.5rem;">
            <div style="display:flex; align-items:center; gap:0.75rem;">
                <div style="width:36px; height:36px; background:var(--gray-50); border-radius:var(--radius); display:grid; place-items:center;">
                    <i class="fas fa-receipt" style="font-size:16px; color:var(--gray-600);"></i>
                </div>
                <span style="font-weight:700; color:var(--gray-900); font-size:15px;">Transaksi Terakhir</span>
            </div>
        </div>
        <div class="card-body" style="padding:0;">
            <div class="table-responsive">
                <table class="table" style="margin:0;">
                    <thead style="background:var(--gray-50);">
                        <tr>
                            <th style="font-size:12px; text-transform:uppercase; letter-spacing:0.5px; padding:0.875rem 1.5rem; color:var(--gray-600); font-weight:600; border-bottom:1px solid var(--border);">Ref No</th>
                            <th style="font-size:12px; text-transform:uppercase; letter-spacing:0.5px; padding:0.875rem 1.5rem; color:var(--gray-600); font-weight:600; border-bottom:1px solid var(--border);">Tanggal</th>
                            <th style="font-size:12px; text-transform:uppercase; letter-spacing:0.5px; padding:0.875rem 1.5rem; color:var(--gray-600); font-weight:600; border-bottom:1px solid var(--border);">Pelanggan</th>
                            <th style="font-size:12px; text-transform:uppercase; letter-spacing:0.5px; padding:0.875rem 1.5rem; color:var(--gray-600); font-weight:600; border-bottom:1px solid var(--border);">Item</th>
                            <th style="font-size:12px; text-transform:uppercase; letter-spacing:0.5px; padding:0.875rem 1.5rem; color:var(--gray-600); font-weight:600; border-bottom:1px solid var(--border);">Total</th>
                            <th style="font-size:12px; text-transform:uppercase; letter-spacing:0.5px; padding:0.875rem 1.5rem; color:var(--gray-600); font-weight:600; border-bottom:1px solid var(--border);">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentTransactions as $t)
                        <tr style="border-bottom:1px solid var(--gray-100);">
                            <td style="padding:1rem 1.5rem; font-family:monospace; font-weight:600; color:var(--primary); font-size:13px;">{{ $t->ref_no }}</td>
                            <td style="padding:1rem 1.5rem; font-size:13px; color:var(--gray-700);">{{ \Carbon\Carbon::parse($t->created_at)->format('d/m/Y H:i') }}</td>
                            <td style="padding:1rem 1.5rem; font-weight:500; color:var(--gray-900);">{{ $t->client_name }}</td>
                            <td style="padding:1rem 1.5rem; font-size:13px; color:var(--gray-700);">{{ $t->items_count }} Item</td>
                            <td style="padding:1rem 1.5rem; font-weight:700; color:var(--success);">Rp {{ number_format($t->total, 0, ',', '.') }}</td>
                            <td style="padding:1rem 1.5rem;">
                                <a href="{{ route('transactions.detail', $t->ref_no) }}" class="btn btn-sm" style="height:32px; padding:0 1rem; font-size:13px; background:var(--gray-50); color:var(--gray-700); border:1px solid var(--border);">Detail</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

</div>

<!-- Chart.js Library -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

<!-- Font Awesome Icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<script>
// Revenue Chart
const ctx = document.getElementById('revenueChart');

// Format number to IDR
function formatIDR(number) {
    return 'Rp ' + number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}

new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['Hari Ini', 'Minggu Ini', 'Bulan Ini'],
        datasets: [{
            label: 'Pendapatan',
            data: [
                {{ $revenueStats['today'] }},
                {{ $revenueStats['this_week'] }},
                {{ $revenueStats['this_month'] }}
            ],
            backgroundColor: [
                'rgba(37, 99, 235, 0.8)',   // Primary blue
                'rgba(16, 185, 129, 0.8)',  // Success green
                'rgba(245, 158, 11, 0.8)'   // Warning amber
            ],
            borderColor: [
                'rgb(37, 99, 235)',
                'rgb(16, 185, 129)',
                'rgb(245, 158, 11)'
            ],
            borderWidth: 2,
            borderRadius: 8,
            borderSkipped: false,
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: false
            },
            tooltip: {
                backgroundColor: 'rgba(17, 24, 39, 0.95)',
                padding: 12,
                titleFont: {
                    size: 13,
                    weight: '600',
                    family: 'Inter'
                },
                bodyFont: {
                    size: 14,
                    weight: '700',
                    family: 'Inter'
                },
                displayColors: false,
                callbacks: {
                    label: function(context) {
                        return formatIDR(context.parsed.y);
                    }
                }
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    callback: function(value) {
                        if (value >= 1000000) {
                            return 'Rp ' + (value / 1000000).toFixed(1) + 'jt';
                        } else if (value >= 1000) {
                            return 'Rp ' + (value / 1000).toFixed(0) + 'rb';
                        }
                        return 'Rp ' + value;
                    },
                    font: {
                        size: 11,
                        family: 'Inter',
                        weight: '500'
                    },
                    color: '#6b7280'
                },
                grid: {
                    color: '#f3f4f6',
                    drawBorder: false
                },
                border: {
                    display: false
                }
            },
            x: {
                ticks: {
                    font: {
                        size: 12,
                        family: 'Inter',
                        weight: '600'
                    },
                    color: '#374151'
                },
                grid: {
                    display: false
                },
                border: {
                    display: false
                }
            }
        }
    }
});
</script>
@endsection
