@extends('layouts.app')
@section('content')
<div class="card">
    <div class="card-header">
        <h4>Detail Checklist Maintenance</h4>
    </div>
    <div class="card-body">
        <ul class="list-group">
            <li class="list-group-item"><strong>Perangkat:</strong> {{ $checklist->device->type ?? '-' }}</li>
            <li class="list-group-item"><strong>Item Checklist:</strong> {{ $checklist->item }}</li>
            <li class="list-group-item"><strong>Status:</strong> {{ $checklist->status ? 'Sudah Dicek' : 'Belum Dicek' }}</li>
            <li class="list-group-item"><strong>Catatan:</strong> {{ $checklist->note }}</li>
        </ul>
        <a href="{{ route('checklists.index') }}" class="btn btn-secondary mt-3">Kembali</a>
    </div>
</div>
@endsection
