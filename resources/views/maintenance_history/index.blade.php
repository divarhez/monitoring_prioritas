@extends('layouts.app')
@section('content')
<div class="card">
    <div class="card-header bg-info text-white d-flex align-items-center justify-content-between">
        <h4 class="mb-0"><i class="fas fa-history"></i> Histori Maintenance Terbaru</h4>
        <small class="text-white-50">Urut terbaru berdasarkan tanggal jadwal</small>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="thead-light">
                    <tr>
                        <th style="width:140px;">Tanggal</th>
                        <th>User</th>
                        <th>Agent</th>
                        <th>Kategori</th>
                        <th style="width:140px;">Status</th>
                        <th style="width:160px;">File PDF Laporan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($histories as $h)
                        @php
                            $latestReport = $h->reports->first();
                        @endphp
                        <tr>
                            <td>{{ \Illuminate\Support\Carbon::parse($h->scheduled_date)->format('d/m/Y') }}</td>
                            <td>{{ $h->user->name ?? '-' }}</td>
                            <td>{{ $h->agent->name ?? '-' }}</td>
                            <td>{{ ucfirst($h->category) }}</td>
                            <td>
                                @php
                                    $badge = match(($h->status ?? 'scheduled')) {
                                        'done' => 'badge-success',
                                        'missed' => 'badge-danger',
                                        default => 'badge-warning'
                                    };
                                    $statusText = match(($h->status ?? 'scheduled')) {
                                        'done' => 'Sudah di maintenance',
                                        'missed' => 'Terlewat',
                                        default => 'Terjadwal'
                                    };
                                @endphp
                                <span class="badge {{ $badge }}">{{ $statusText }}</span>
                            </td>
                            <td>
                                @if($latestReport && $latestReport->report_pdf)
                                    <a class="btn btn-sm btn-outline-primary"
                                       href="{{ route('maintenance-report.download', $latestReport->id) }}">
                                        <i class="fas fa-file-pdf"></i> Download PDF
                                    </a>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted">Belum ada histori maintenance.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if(Auth::check() && Auth::user()->role === 'admin')
            <a href="{{ route('maintenance-schedules.create') }}" class="btn btn-success">
                <i class="fas fa-calendar-plus"></i> Tambah Jadwal
            </a>
        @endif
    </div>
</div>
@endsection
