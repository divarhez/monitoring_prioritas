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
    <h2>Data Perangkat PT Pindad</h2>
    <table>
        <thead>
            <tr>
                <th>User</th>
                <th>Tipe</th>
                <th>Merk</th>
                <th>Model</th>
                <th>Serial Number</th>
                <th>Deskripsi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($devices as $device)
            <tr>
                <td>{{ $device->user->name ?? '-' }}</td>
                <td>{{ $device->type }}</td>
                <td>{{ $device->brand }}</td>
                <td>{{ $device->model }}</td>
                <td>{{ $device->serial_number }}</td>
                <td>{{ $device->description }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
