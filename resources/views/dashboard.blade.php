@extends('layouts.app')
@section('content')
<div class="row">
    <div class="col-md-3 mb-3">
        <div class="card shadow-lg border-0 animate__animated animate__fadeInUp" style="background:#e3fcec;">
            <div class="card-body text-center">
                <i class="fas fa-users fa-2x mb-2 text-success"></i>
                <h3 class="fw-bold">{{ $userCount ?? 0 }}</h3>
                <p class="mb-0">User Prioritas</p>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card shadow-lg border-0 animate__animated animate__fadeInUp" style="background:#e6f7ff;">
            <div class="card-body text-center">
                <i class="fas fa-user-secret fa-2x mb-2 text-info"></i>
                <h3 class="fw-bold">{{ $agentCount ?? 0 }}</h3>
                <p class="mb-0">Agent</p>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card shadow-lg border-0 animate__animated animate__fadeInUp" style="background:#fffbe6;">
            <div class="card-body text-center">
                <i class="fas fa-desktop fa-2x mb-2 text-warning"></i>
                <h3 class="fw-bold">{{ $deviceCount ?? 0 }}</h3>
                <p class="mb-0">Perangkat</p>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
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
    <div class="col-md-6 mb-3">
        <div class="card shadow-sm border-0 animate__animated animate__fadeIn">
            <div class="card-header bg-primary text-white">
                <h5 class="card-title mb-0">Grafik Maintenance per Kategori</h5>
            </div>
            <div class="card-body">
                <canvas id="categoryChart"></canvas>
            </div>
        </div>
    </div>
    <div class="col-md-6 mb-3">
        <div class="card shadow-sm border-0 animate__animated animate__fadeIn">
            <div class="card-header bg-warning text-dark">
                <h5 class="card-title mb-0">Grafik Perangkat Bermasalah</h5>
            </div>
            <div class="card-body">
                <canvas id="deviceChart"></canvas>
            </div>
        </div>
    </div>
</div>
<div class="card mt-4">
    <div class="card-header">
        <h4>Histori Maintenance Terbaru</h4>
    </div>
    <div class="card-body">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>User</th>
                    <th>Agent</th>
                    <th>Perangkat</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentMaintenances ?? [] as $maintenance)
                    <tr>
                        <td>{{ $maintenance->scheduled_date }}</td>
                        <td>{{ $maintenance->user->name ?? '-' }}</td>
                        <td>{{ $maintenance->agent->name ?? '-' }}</td>
                        <td>{{ $maintenance->device->type ?? '-' }}</td>
                        <td>{{ $maintenance->status }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">Belum ada histori maintenance.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<!-- Chart.js & Animate.css -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Data kategori maintenance dari controller
    const categoryData = {
        labels: ['Hardware', 'Software', 'Jaringan'],
        datasets: [{
            label: 'Jumlah Maintenance',
            data: [
                {{ $categoryStats['hardware'] ?? 0 }},
                {{ $categoryStats['software'] ?? 0 }},
                {{ $categoryStats['jaringan'] ?? 0 }}
            ],
            backgroundColor: ['#007bff', '#28a745', '#ffc107'],
            borderRadius: 8,
        }]
    };
    const deviceData = {
        labels: ['Laptop', 'Jaringan', 'Printer'],
        datasets: [{
            label: 'Bermasalah',
            data: [3, 1, 2],
            backgroundColor: ['#007bff', '#17a2b8', '#6f42c1'],
            borderWidth: 2,
        }]
    };
    new Chart(document.getElementById('categoryChart'), {
        type: 'bar',
        data: categoryData,
        options: {
            plugins: {legend: {display: false}},
            animation: {duration: 1200, easing: 'easeOutBounce'},
        }
    });
    new Chart(document.getElementById('deviceChart'), {
        type: 'pie',
        data: deviceData,
        options: {
            animation: {duration: 1200, easing: 'easeOutBounce'},
        }
    });
</script>
@endsection
