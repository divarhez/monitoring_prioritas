<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Report</title>
    <style>
        body {
            font-family: sans-serif;
        }
        .container {
            width: 100%;
            margin: 0 auto;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h1 {
            margin: 0;
        }
        .summary {
            display: flex;
            justify-content: space-around;
            margin-bottom: 20px;
        }
        .summary .card {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: center;
            width: 22%;
        }
        .chart-container {
            width: 100%;
            margin-bottom: 20px;
        }
        .chart-container h2 {
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Dashboard Report</h1>
            <p>{{ date('d F Y') }}</p>
        </div>

        <div class="summary">
            <div class="card">
                <h3>{{ $userCount ?? 0 }}</h3>
                <p>User Prioritas</p>
            </div>
            <div class="card">
                <h3>{{ $agentCount ?? 0 }}</h3>
                <p>Agent</p>
            </div>
            <div class="card">
                <h3>{{ $deviceCount ?? 0 }}</h3>
                <p>Perangkat</p>
            </div>
            <div class="card">
                <h3>{{ $scheduleCount ?? 0 }}</h3>
                <p>Jadwal Maintenance Bulan Ini</p>
            </div>
        </div>

        <div class="chart-container">
            <h2>Maintenance per Kategori</h2>
            <img src="" alt="Category Chart">
        </div>

        <div class="chart-container">
            <h2>Maintenance per Bulan</h2>
            <img src="" alt="Maintenance Chart">
        </div>
    </div>
</body>
</html>
