@extends('layouts.app')

@section('content')
<div class="container-fluid px-4 py-5">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Daftar Jadwal Maintenance</h1>
        <a href="{{ route('maintenance-schedules.create') }}" class="btn btn-success btn-sm shadow-sm">
            <i class="fas fa-plus fa-sm text-white-50"></i> Tambah Jadwal
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Data Jadwal Maintenance</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
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
                        @foreach($schedules as $schedule)
                        <tr>
                            <td>{{ $schedule->user->name ?? '-' }}</td>
                            <td>{{ $schedule->agent->name ?? '-' }}</td>
                            <td>{{ ucfirst($schedule->category) }}</td>
                            <td>{{ $schedule->scheduled_date }}</td>
                            <td>{{ ucfirst($schedule->status) }}</td>
                            <td>
                                <a href="{{ route('maintenance-schedules.edit', $schedule->id) }}" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                                <form action="{{ route('maintenance-schedules.destroy', $schedule->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus jadwal ini?')"><i class="fas fa-trash"></i></button>
                                </form>
                            </td>
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
});
</script>
@endpush

@push('styles')
<link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap4.min.css" rel="stylesheet">
@endpush
