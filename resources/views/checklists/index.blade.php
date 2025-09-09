<!-- Halaman checklist akan dibangun ulang sesuai instruksi. -->
@extends('layouts.app')
@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4>Checklist Maintenance</h4>
        @if(Auth::user()->role == 'admin' || Auth::user()->role == 'agent')
            <a href="{{ route('checklists.create') }}" class="btn btn-primary">Tambah Checklist</a>
        @endif
    </div>
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        <table class="table table-bordered">
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
                            <a href="{{ route('checklists.edit', $checklist->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('checklists.destroy', $checklist->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Hapus checklist ini?')">Hapus</button>
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
@endsection
