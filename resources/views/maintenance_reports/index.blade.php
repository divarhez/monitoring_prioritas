@extends('layouts.app')

@section('content')
<div class="container-fluid px-4 py-5">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Laporan Maintenance</h1>
        <div>
            @if(Auth::check())
                @if(Auth::user()->role === 'admin')
                    <a href="{{ route('maintenance-schedules.create') }}" class="btn btn-success btn-sm shadow-sm mr-2">
                        <i class="fas fa-calendar-plus fa-sm text-white-50"></i> Tambah Jadwal
                    </a>
                @elseif(Auth::user()->role === 'agent')
                    <a href="{{ route('maintenance-report.create') }}" class="btn btn-success btn-sm shadow-sm mr-2">
                        <i class="fas fa-plus-circle fa-sm text-white-50"></i> Tambah Laporan
                    </a>
                @endif
            @endif
            <a href="?export=pdf" class="btn btn-primary btn-sm shadow-sm">
                <i class="fas fa-file-pdf fa-sm text-white-50"></i> Export PDF
            </a>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Laporan Maintenance</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>User</th>
                            <th>Agent</th>
                            <th>Devices</th>
                            <th>Status Perbaikan (Bermasalah)</th>
                            <th>Status</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($reports as $report)
                        <tr>
                            <td>{{ $report->schedule->user->name ?? '-' }}</td>
                            <td>{{ $report->schedule?->agent?->name ?? '-' }}</td>
                            <td>
                                @if($report->devices->count() > 0)
                                    <ul class="list-unstyled mb-0">
                                        @foreach($report->devices as $device)
                                            <li>- {{ $device->type }}{{ $device->brand ? ' ('.$device->brand.')' : '' }}</li>
                                        @endforeach
                                    </ul>
                                @else
                                    -
                                @endif
                            </td>
                            <td>
                                @if($report->devices->where('pivot.is_problematic', true)->count() > 0)
                                    @if(Auth::check() && Auth::user()->role === 'agent')
                                        @foreach($report->devices->where('pivot.is_problematic', true) as $device)
                                            <div class="mb-2 d-flex align-items-center">
                                                <select name="repair_status" data-report-id="{{ $report->id }}" data-device-id="{{ $device->id }}" class="repair-status-select form-control form-control-sm mr-2" style="width: 150px;">
                                                    <option value="in_progress" {{ $device->pivot->repair_status === 'in_progress' ? 'selected' : '' }}>Sedang Dikerjakan</option>
                                                    <option value="completed" {{ $device->pivot->repair_status === 'completed' ? 'selected' : '' }}>Selesai Diperbaiki</option>
                                                </select>
                                                <small class="text-muted">{{ $device->type }}</small>
                                            </div>
                                        @endforeach
                                    @else
                                        @foreach($report->devices->where('pivot.is_problematic', true) as $device)
                                            <div class="mb-2">
                                                <span class="badge badge-{{ $device->pivot->repair_status === 'completed' ? 'success' : 'warning' }}">
                                                    {{ $device->pivot->repair_status === 'completed' ? 'Selesai' : 'Dikerjakan' }}
                                                </span>
                                                <small class="text-muted">{{ $device->type }}</small>
                                            </div>
                                        @endforeach
                                    @endif
                                @else
                                    <span class="text-muted">Tidak ada perangkat bermasalah</span>
                                @endif
                            </td>
                            <td><span class="badge badge-info">{{ $report->status }}</span></td>
                            <td>{{ $report->created_at->format('d M Y, H:i') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>
<script>
$(document).ready(function() {
    $('#dataTable').DataTable();

    $('#dataTable').on('change', '.repair-status-select', function() {
        var select = $(this);
        var reportId = select.data('report-id');
        var deviceId = select.data('device-id');
        var newStatus = select.val();

        select.prop('disabled', true);

        $.ajax({
            url: '/maintenance-report/' + reportId + '/device/' + deviceId + '/update-repair-status',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                repair_status: newStatus
            },
            success: function(response) {
                toastr.success('Status perbaikan berhasil diupdate.');
                select.prop('disabled', false);
            },
            error: function(xhr) {
                toastr.error('Gagal mengupdate status perbaikan. Silakan coba lagi.');
                select.prop('disabled', false);
            }
        });
    });
});
</script>
@endpush

@push('styles')
<link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap4.min.css" rel="stylesheet">
@endpush
