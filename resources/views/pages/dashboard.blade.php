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
        <div class="col-lg-6 col-md-6" style="margin-bottom:1.25rem;">
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
        <div class="col-lg-6 col-md-6" style="margin-bottom:1.25rem;">
            <div style="background:white; border:1px solid var(--border); border-radius:var(--radius-lg); padding:1.5rem; transition:all 0.2s ease; box-shadow:var(--shadow-xs);" onmouseover="this.style.boxShadow='var(--shadow-md)'; this.style.borderColor='#d1fae5'" onmouseout="this.style.boxShadow='var(--shadow-xs)'; this.style.borderColor='var(--border)'">
                <div style="display:flex; align-items:flex-start; justify-content:space-between; margin-bottom:1rem;">
                    <div style="width:48px; height:48px; background:#10b981; border-radius:var(--radius); display:grid; place-items:center;">
                        <i class="fas fa-dollar-sign" style="font-size:20px; color:white !important;"></i>
                    </div>
                </div>
                <div style="color:var(--text-secondary); font-size:13px; font-weight:600; margin-bottom:0.375rem; text-transform:uppercase; letter-spacing:0.5px;">Pendapatan Hari Ini</div>
                <div style="font-size:28px; font-weight:700; color:var(--gray-900); line-height:1; letter-spacing:-0.5px;">Rp {{ number_format($metrics['total_revenue'], 0, ',', '.') }}</div>
            </div>
        </div>

        <!-- Pending Payment -->
        <div class="col-lg-6 col-md-6" style="margin-bottom:1.25rem;">
            <div style="background:white; border:1px solid var(--border); border-radius:var(--radius-lg); padding:1.5rem; transition:all 0.2s ease; box-shadow:var(--shadow-xs);" onmouseover="this.style.boxShadow='var(--shadow-md)'; this.style.borderColor='#fed7aa'" onmouseout="this.style.boxShadow='var(--shadow-xs)'; this.style.borderColor='var(--border)'">
                <div style="display:flex; align-items:flex-start; justify-content:space-between; margin-bottom:1rem;">
                    <div style="width:48px; height:48px; background:#fed7aa; border-radius:var(--radius); display:grid; place-items:center;">
                        <i class="fas fa-clock" style="font-size:20px; color:var(--warning);"></i>
                    </div>
                </div>
                <div style="color:var(--text-secondary); font-size:13px; font-weight:600; margin-bottom:0.375rem; text-transform:uppercase; letter-spacing:0.5px;">Pending Payment</div>
                <div style="font-size:28px; font-weight:700; color:var(--gray-900); line-height:1; letter-spacing:-0.5px;">Rp {{ number_format($metrics['pending_payments']['total'], 0, ',', '.') }}</div>
            </div>
        </div>

        <!-- Total Item -->
        <div class="col-lg-6 col-md-6" style="margin-bottom:1.25rem;">
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

    <!-- Revenue Chart - Full Width -->
    <div class="card" style="box-shadow:var(--shadow-sm); border-radius:var(--radius-lg); border:1px solid var(--border); margin-bottom:1.75rem;">
        <div class="card-header" style="background:white; border-bottom:1px solid var(--border); border-radius:var(--radius-lg) var(--radius-lg) 0 0; padding:1.25rem 1.5rem;">
            <div style="display:flex; align-items:center; justify-content:space-between; width:100%;">
                <div style="display:flex; align-items:center; gap:0.75rem;">
                    <div style="width:36px; height:36px; background:var(--gray-50); border-radius:var(--radius); display:grid; place-items:center;">
                        <i class="fas fa-chart-bar" style="font-size:16px; color:var(--gray-600);"></i>
                    </div>
                    <span style="font-weight:700; color:var(--gray-900); font-size:15px;">Perbandingan Pendapatan</span>
                </div>
                <form action="{{ route('dashboard') }}" method="GET" style="margin:0;">
                    <select name="month" class="input" style="height:36px; padding:0 2rem 0 1rem; font-size:13px; border-radius:var(--radius); background-color:var(--gray-50); border-color:var(--border);" onchange="this.form.submit()">
                        @foreach($availableMonths as $m)
                            <option value="{{ $m['value'] }}" {{ $selectedMonth == $m['value'] ? 'selected' : '' }}>{{ $m['label'] }}</option>
                        @endforeach
                    </select>
                </form>
            </div>
        </div>
        <div class="card-body" style="padding:1.5rem;">
            <div id="revenueChart"></div>
        </div>
    </div>

    <!-- Recent Transactions -->
    <div class="card" style="box-shadow:var(--shadow-sm); border-radius:var(--radius-lg); border:1px solid var(--border); margin-bottom:2rem;">
        <div class="card-header" style="background:white; border-bottom:1px solid var(--border); border-radius:var(--radius-lg) var(--radius-lg) 0 0; padding:1.25rem 1.5rem;">
            <div style="display:flex; align-items:center; justify-content:space-between; width:100%;">
                <div style="display:flex; align-items:center; gap:0.75rem;">
                    <div style="width:36px; height:36px; background:var(--gray-50); border-radius:var(--radius); display:grid; place-items:center;">
                        <i class="fas fa-receipt" style="font-size:16px; color:var(--gray-600);"></i>
                    </div>
                    <span style="font-weight:700; color:var(--gray-900); font-size:15px;">Transaksi Terakhir</span>
                </div>
                <a href="{{ route('list.page') }}" style="display:inline-flex; align-items:center; gap:0.5rem; font-size:12px; font-weight:600; color:var(--primary); text-decoration:none; background:var(--primary-pale); padding:0.5rem 1rem; border-radius:99px; transition:all 0.2s;" onmouseover="this.style.background='var(--primary)'; this.style.color='white'" onmouseout="this.style.background='var(--primary-pale)'; this.style.color='var(--primary)'">
                    Lihat Semua <i class="fas fa-arrow-right" style="font-size:10px;"></i>
                </a>
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

<!-- ApexCharts Library -->
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

<!-- Font Awesome Icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Dynamic Data from Controller
    const chartData = @json($chartData);
    const revenueData = chartData.map(item => item.total);
    const categories = chartData.map(item => item.date);
    
    // Create trend line (slightly smoothed)
    const trendData = revenueData.map((val, idx) => {
        if (idx === 0) return val;
        return (revenueData[idx - 1] + val) / 2;
    });

    const options = {
        series: [
            {
                name: 'Pendapatan Aktual',
                type: 'bar',
                data: revenueData
            },
            {
                name: 'Trend',
                type: 'line',
                data: trendData
            }
        ],
        chart: {
            type: 'line',
            height: 400,
            fontFamily: 'Inter, -apple-system, BlinkMacSystemFont, sans-serif',
            toolbar: {
                show: false
            },
            animations: {
                enabled: true,
                easing: 'easeinout',
                speed: 1400,
                animateGradually: {
                    enabled: true,
                    delay: 250
                },
                dynamicAnimation: {
                    enabled: true,
                    speed: 500
                }
            },
            dropShadow: {
                enabled: true,
                top: 8,
                left: 0,
                blur: 14,
                opacity: 0.2,
                color: '#000'
            }
        },
        plotOptions: {
            bar: {
                borderRadius: 10,
                borderRadiusApplication: 'end',
                columnWidth: '45%',
                distributed: false,
                dataLabels: {
                    position: 'top'
                }
            }
        },
        dataLabels: {
            enabled: true,
            enabledOnSeries: [0], // Only on bars
            formatter: function (val) {
                if (val >= 1000000) {
                    return 'Rp ' + (val / 1000000).toFixed(1) + 'jt';
                } else if (val >= 1000) {
                    return 'Rp ' + (val / 1000).toFixed(0) + 'rb';
                }
                return 'Rp ' + val;
            },
            offsetY: -28,
            style: {
                fontSize: '13px',
                fontWeight: 800,
                colors: ['#334155']
            },
            background: {
                enabled: true,
                foreColor: '#ffffff',
                borderRadius: 6,
                padding: 8,
                opacity: 1,
                borderWidth: 2,
                borderColor: '#e2e8f0',
                dropShadow: {
                    enabled: true,
                    top: 2,
                    left: 0,
                    blur: 4,
                    opacity: 0.15
                }
            }
        },
        stroke: {
            width: [0, 4], // Bar: 0, Line: 4px
            curve: 'smooth',
            dashArray: [0, 0]
        },
        legend: {
            show: true,
            position: 'top',
            horizontalAlign: 'right',
            floating: true,
            offsetY: -10,
            offsetX: -10,
            fontSize: '13px',
            fontWeight: 600,
            markers: {
                width: 12,
                height: 12,
                radius: 4
            },
            itemMargin: {
                horizontal: 12,
                vertical: 0
            }
        },
        colors: ['#3b82f6', '#f59e0b'], // Blue bars, Amber line
        fill: {
            type: ['gradient', 'solid'],
            gradient: {
                shade: 'light',
                type: 'vertical',
                shadeIntensity: 0.5,
                gradientToColors: ['#93c5fd', undefined],
                inverseColors: false,
                opacityFrom: [1, 1],
                opacityTo: [0.8, 1],
                stops: [0, 100],
                colorStops: [
                    [
                        { offset: 0, color: '#3b82f6', opacity: 1 },
                        { offset: 50, color: '#60a5fa', opacity: 0.95 },
                        { offset: 100, color: '#93c5fd', opacity: 0.85 }
                    ]
                ]
            }
        },
        markers: {
            size: [0, 6], // Bar: no markers, Line: 6px
            colors: ['#fff'],
            strokeColors: '#f59e0b',
            strokeWidth: 3,
            hover: {
                size: 8
            }
        },
        xaxis: {
            categories: categories,
            labels: {
                style: {
                    colors: '#475569',
                    fontSize: '14px',
                    fontWeight: 700
                }
            },
            axisBorder: {
                show: false
            },
            axisTicks: {
                show: false
            }
        },
        yaxis: {
            labels: {
                formatter: function (val) {
                    if (val >= 1000000) {
                        return 'Rp ' + (val / 1000000).toFixed(1) + 'jt';
                    } else if (val >= 1000) {
                        return 'Rp ' + (val / 1000).toFixed(0) + 'rb';
                    }
                    return 'Rp ' + val;
                },
                style: {
                    colors: '#64748b',
                    fontSize: '12px',
                    fontWeight: 600
                }
            }
        },
        grid: {
            borderColor: '#e2e8f0',
            strokeDashArray: 5,
            xaxis: {
                lines: {
                    show: false
                }
            },
            yaxis: {
                lines: {
                    show: true
                }
            },
            padding: {
                top: 10,
                right: 20,
                bottom: 0,
                left: 15
            }
        },
        tooltip: {
            shared: true,
            intersect: false,
            theme: 'dark',
            y: {
                formatter: function (val) {
                    return 'Rp ' + val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
                }
            },
            style: {
                fontSize: '14px',
                fontFamily: 'Inter, sans-serif'
            },
            marker: {
                show: true
            },
            x: {
                show: true
            }
        },
        states: {
            hover: {
                filter: {
                    type: 'lighten',
                    value: 0.1
                }
            },
            active: {
                filter: {
                    type: 'darken',
                    value: 0.05
                }
            }
        },
        responsive: [{
            breakpoint: 768,
            options: {
                chart: {
                    height: 300
                },
                plotOptions: {
                    bar: {
                        columnWidth: '55%'
                    }
                },
                legend: {
                    position: 'bottom'
                }
            }
        }]
    };

    const chart = new ApexCharts(document.querySelector('#revenueChart'), options);
    chart.render();

    // Add custom styling for premium effect
    const chartContainer = document.querySelector('#revenueChart');
    if (chartContainer) {
        chartContainer.style.background = 'linear-gradient(135deg, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0.05) 100%)';
        chartContainer.style.borderRadius = '12px';
        chartContainer.style.padding = '0.5rem';
    }
});
</script>
@endsection
