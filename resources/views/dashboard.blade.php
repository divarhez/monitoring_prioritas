@extends('layouts.app')
@section('content')
<div class="row">
    <div class="col-6 col-md-3 mb-3">
        <div class="card shadow-lg border-0 animate__animated animate__fadeInUp" style="background:#e3fcec;">
            <div class="card-body text-center">
                <i class="fas fa-users fa-2x mb-2 text-success"></i>
                <h3 class="fw-bold">{{ $userCount ?? 0 }}</h3>
                <p class="mb-0">User Prioritas</p>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3 mb-3">
        <div class="card shadow-lg border-0 animate__animated animate__fadeInUp" style="background:#e6f7ff;">
            <div class="card-body text-center">
                <i class="fas fa-user-secret fa-2x mb-2 text-info"></i>
                <h3 class="fw-bold">{{ $agentCount ?? 0 }}</h3>
                <p class="mb-0">Agent</p>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3 mb-3">
        <div class="card shadow-lg border-0 animate__animated animate__fadeInUp" style="background:#fffbe6;">
            <div class="card-body text-center">
                <i class="fas fa-desktop fa-2x mb-2 text-warning"></i>
                <h3 class="fw-bold">{{ $deviceCount ?? 0 }}</h3>
                <p class="mb-0">Perangkat</p>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3 mb-3">
        <div class="card shadow-lg border-0 animate__animated animate__fadeInUp" style="background:#ffeaea;">
            <div class="card-body text-center">
                <i class="fas fa-calendar-check fa-2x mb-2 text-danger"></i>
                <h3 class="fw-bold">{{ $scheduleCount ?? 0 }}</h3>
                <p class="mb-0">Jadwal Maintenance Bulan Ini</p>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-12 col-xl-6 mb-3">
        <div class="card shadow-sm border-0 h-100 animate__animated animate__fadeIn">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Grafik Maintenance per Kategori</h5>
                <i class="fas fa-chart-bar"></i>
            </div>
            <div class="card-body">
                <div class="w-100" style="height:320px;">
                    <canvas id="categoryChart"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-xl-6 mb-3">
        <div class="card shadow-sm border-0 h-100 animate__animated animate__fadeIn">
            <div class="card-header bg-warning text-dark d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Grafik Perangkat Bermasalah</h5>
                <i class="fas fa-chart-pie"></i>
            </div>
            <div class="card-body">
                <div class="w-100" style="height:320px;">
                    <canvas id="deviceChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Catatan: Bagian "Histori Maintenance Terbaru" dihapus sesuai permintaan -->

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    (function () {
        // Pastikan canvas responsive
        const categoryStats = @json($categoryStats ?? ['hardware'=>0,'software'=>0,'jaringan'=>0]);
        const deviceStats = @json($deviceStats ?? ['labels'=>[],'data'=>[]]);

        const categoryCtx = document.getElementById('categoryChart').getContext('2d');
        new Chart(categoryCtx, {
            type: 'bar',
            data: {
                labels: Object.keys(categoryStats),
                datasets: [{
                    label: 'Jumlah Maintenance',
                    data: Object.values(categoryStats),
                    backgroundColor: ['#007bff', '#ffc107', '#28a745']
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { precision: 0 }
                    }
                }
            }
        });

        const deviceCtx = document.getElementById('deviceChart').getContext('2d');
        new Chart(deviceCtx, {
            type: 'pie',
            data: {
                labels: deviceStats.labels,
                datasets: [{
                    label: 'Perangkat Bermasalah',
                    data: deviceStats.data,
                    backgroundColor: ['#007bff', '#17a2b8', '#ffc107', '#28a745', '#dc3545']
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: { boxWidth: 12 }
                    }
                }
            }
        });
    })();
</script>
@endsection
