@extends('layouts.app')

@section('content')
<div class="container-fluid px-4 py-5">

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
        <a href="{{ route('dashboard.report') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
    </div>

    <div class="row">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">User Prioritas</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $userCount ?? 0 }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Agent</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $agentCount ?? 0 }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-secret fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Perangkat</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $deviceCount ?? 0 }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-desktop fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Jadwal Maintenance (Bulan Ini)</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $scheduleCount ?? 0 }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar-check fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-12 col-xl-8 mb-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0 text-gray-800">Grafik Maintenance per Bulan</h5>
                    <i class="fas fa-chart-line text-gray-400"></i>
                </div>
                <div class="card-body">
                    <div class="w-100" style="height:320px;">
                        <canvas id="maintenanceChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-xl-4 mb-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0 text-gray-800">Maintenance per Kategori</h5>
                    <i class="fas fa-chart-pie text-gray-400"></i>
                </div>
                <div class="card-body">
                    <div class="w-100" style="height:320px;">
                        <canvas id="categoryChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Data from controller
        const categoryStats = @json($categoryStats ?? ['hardware' => 0, 'software' => 0, 'jaringan' => 0]);
        const maintenanceStats = @json($maintenanceStats ?? ['labels' => [], 'data' => []]);

        // 1. Maintenance per Kategori (Pie Chart)
        const categoryCtx = document.getElementById('categoryChart').getContext('2d');
        const categoryChart = new Chart(categoryCtx, {
            type: 'doughnut',
            data: {
                labels: Object.keys(categoryStats),
                datasets: [{
                    label: 'Jumlah Maintenance',
                    data: Object.values(categoryStats),
                    backgroundColor: ['#4e73df', '#1cc88a', '#36b9cc'],
                    hoverBackgroundColor: ['#2e59d9', '#17a673', '#2c9faf'],
                    hoverBorderColor: "rgba(234, 236, 244, 1)",
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: { boxWidth: 12, padding: 20 }
                    }
                },
                cutout: '80%',
                onClick: function(event, elements) {
                    if (elements.length > 0) {
                        const chartElement = elements[0];
                        const category = this.data.labels[chartElement.index];
                        window.location.href = '/maintenance-report?category=' + category;
                    }
                }
            }
        });

        // 2. Grafik Maintenance per Bulan (Line Chart)
        const maintenanceCtx = document.getElementById('maintenanceChart').getContext('2d');
        const maintenanceChart = new Chart(maintenanceCtx, {
            type: 'line',
            data: {
                labels: maintenanceStats.labels,
                datasets: [{
                    label: 'Jumlah Laporan',
                    data: maintenanceStats.data,
                    fill: true,
                    backgroundColor: 'rgba(78, 115, 223, 0.05)',
                    borderColor: 'rgba(78, 115, 223, 1)',
                    tension: 0.3,
                    pointRadius: 3,
                    pointBackgroundColor: "rgba(78, 115, 223, 1)",
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
                },
                onClick: function(event, elements) {
                    if (elements.length > 0) {
                        const chartElement = elements[0];
                        const month = this.data.labels[chartElement.index];
                        window.location.href = '/maintenance-report?month=' + month;
                    }
                }
            }
        });
    });
</script>
@endpush
