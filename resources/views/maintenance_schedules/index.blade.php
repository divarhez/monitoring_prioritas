@extends('layouts.app')
@section('content')
<div class="container">
    <h1>Daftar Jadwal Maintenance</h1>
    <form method="GET" action="{{ route('maintenance-schedules.index') }}" class="mb-3">
        <div class="row">
            <div class="col-md-3">
                <select name="category" class="form-control">
                    <option value="">Semua Kategori</option>
                    <option value="hardware" {{ request('category') == 'hardware' ? 'selected' : '' }}>Hardware</option>
                    <option value="software" {{ request('category') == 'software' ? 'selected' : '' }}>Software</option>
                    <option value="jaringan" {{ request('category') == 'jaringan' ? 'selected' : '' }}>Jaringan</option>
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary">Filter</button>
            </div>
        </div>
    </form>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>User</th>
                <th>Agent</th>
                <th>Kategori</th>
                <th>Tanggal</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($maintenanceSchedules as $schedule)
            <tr>
                <td>{{ $schedule->user->name ?? '-' }}</td>
                <td>{{ $schedule->agent->name ?? '-' }}</td>
                <td>{{ ucfirst($schedule->category) }}</td>
                <td>{{ $schedule->scheduled_date }}</td>
                <td>{{ ucfirst($schedule->status) }}</td>
                <td>
                    <a href="{{ route('maintenance-schedules.edit', $schedule->id) }}" class="btn btn-sm btn-warning">Edit</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
