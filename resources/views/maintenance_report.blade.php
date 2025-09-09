@extends('layouts.app')
@section('content')
<div class="card mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4>Laporan Maintenance Detail</h4>
        @if(Auth::user()->role == 'agent')
            <a href="{{ route('maintenance-report.create') }}" class="btn btn-primary">Input Laporan</a>
        @endif
    </div>
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>User Prioritas</th>
                    <th>Agent</th>
                    <th>Perangkat</th>
                    <th>Kategori</th>
                    <th>Status</th>
                    <th>Detail Kerusakan</th>
                    <th>Rekomendasi</th>
                    <th>Foto</th>
                </tr>
            </thead>
            <tbody>
                @forelse($reports as $report)
                <tr>
                    <td>{{ $report->created_at->format('d-m-Y H:i') }}</td>
                    <td>{{ $report->user->name ?? '-' }}</td>
                    <td>{{ $report->agent->name ?? '-' }}</td>
                    <td>{{ $report->device->type ?? '-' }} - {{ $report->device->brand ?? '-' }}</td>
                    <td>{{ $report->device->category ?? '-' }}</td>
                    <td>{{ $report->status ?? '-' }}</td>
                    <td>{{ $report->detail ?? '-' }}</td>
                    <td>{{ $report->recommendation ?? '-' }}</td>
                    <td>
                        @if($report->photo)
                            <img src="{{ asset('storage/' . $report->photo) }}" alt="Foto" width="80">
                        @else
                            -
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="text-center">Belum ada laporan maintenance.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
