@extends('layouts.app')
@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4>Checklist Maintenance</h4>
        <a href="{{ route('checklists.create') }}" class="btn btn-primary">Tambah Checklist</a>
    </div>
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Perangkat</th>
                    <th>Item Checklist</th>
                    <th>Status</th>
                    <th>Catatan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($checklists as $checklist)
                <tr>
                    <td>{{ $checklist->device->type ?? '-' }}</td>
                    <td>{{ $checklist->item }}</td>
                    <td>{{ $checklist->status ? 'Sudah Dicek' : 'Belum Dicek' }}</td>
                    <td>{{ $checklist->note }}</td>
                    <td>
                        <a href="{{ route('checklists.edit', $checklist->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('checklists.destroy', $checklist->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Hapus checklist ini?')">Hapus</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
