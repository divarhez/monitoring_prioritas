@extends('layouts.app')

@section('content')
<div class="container-fluid px-4 py-5">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Data Perangkat</h1>
        @if(Auth::user() && Auth::user()->role === 'admin')
            <a href="{{ route('devices.create') }}" class="btn btn-success btn-sm shadow-sm">
                <i class="fas fa-plus fa-sm text-white-50"></i> Tambah Device
            </a>
        @endif
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Data Perangkat</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>User</th>
                            <th>Tipe</th>
                            <th>Merk</th>
                            <th>Model</th>
                            <th>Serial Number</th>
                            <th>Deskripsi</th>
                            <th>Kategori</th>
                            <th>Aksi</th>
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
                            <td>{{ ucfirst($device->category) }}</td>
                            <td>
                                <a href="{{ route('devices.edit', $device->id) }}" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
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
