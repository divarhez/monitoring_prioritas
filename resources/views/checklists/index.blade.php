@extends('layouts.app')

@section('content')
<div class="container-fluid px-4 py-5">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Checklist Maintenance</h1>
        @if(Auth::user()->role == 'admin' || Auth::user()->role == 'agent')
            <a href="{{ route('checklists.create') }}" class="btn btn-success btn-sm shadow-sm">
                <i class="fas fa-plus fa-sm text-white-50"></i> Tambah Checklist
            </a>
        @endif
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Data Checklist</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Perangkat</th>
                            <th>Item Checklist</th>
                            <th>Status</th>
                            <th>Catatan</th>
                            @if(Auth::user()->role == 'admin' || Auth::user()->role == 'agent')
                                <th>Aksi</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($checklists as $checklist)
                        <tr>
                            <td>{{ $checklist->device->type ?? '-' }}</td>
                            <td>{{ $checklist->item }}</td>
                            <td>{{ $checklist->status ? 'Sudah Dicek' : 'Belum Dicek' }}</td>
                            <td>{{ $checklist->note }}</td>
                            @if(Auth::user()->role == 'admin' || Auth::user()->role == 'agent')
                                <td>
                                    <a href="{{ route('checklists.edit', $checklist->id) }}" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                                    <form action="{{ route('checklists.destroy', $checklist->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Hapus checklist ini?')"><i class="fas fa-trash"></i></button>
                                    </form>
                                </td>
                            @endif
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center">Belum ada data checklist.</td>
                        </tr>
                        @endforelse
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
