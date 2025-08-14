<html>
<head>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #333; padding: 6px; text-align: left; }
        th { background: #eee; }
    </style>
</head>
<body>
    <h2>Data Jadwal Maintenance PT Pindad</h2>
    <table>
        <thead>
            <tr>
                <th>User</th>
                <th>Agent</th>
                <th>Tanggal</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($schedules as $schedule)
            <tr>
                <td>{{ $schedule->user->name ?? '-' }}</td>
                <td>{{ $schedule->agent->name ?? '-' }}</td>
                <td>{{ $schedule->scheduled_date }}</td>
                <td>{{ $schedule->status }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
