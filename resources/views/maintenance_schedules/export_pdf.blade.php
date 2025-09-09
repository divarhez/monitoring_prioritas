@extends('components.pdf.base')

@section('title', 'Data Jadwal Maintenance')
@section('header_title', 'PT Pindad - Data Jadwal Maintenance')

@section('content')
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
                <td>{{ \Illuminate\Support\Carbon::parse($schedule->scheduled_date)->format('d/m/Y') }}</td>
                <td>{{ ucfirst($schedule->status ?? '-') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
@endsection
