@extends('layouts.app')
@section('content')
<div class="container">
    <h2>Tambah Checklist Maintenance</h2>
    <form method="POST" action="{{ route('checklists.store') }}">
        @csrf
        <div class="mb-3">
            <label for="device_id" class="form-label">Perangkat</label>
            <select class="form-control" id="device_id" name="device_id" required>
                @foreach($devices as $device)
                    <option value="{{ $device->id }}">{{ $device->type }} - {{ $device->brand }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="item" class="form-label">Item Checklist</label>
            <input type="text" class="form-control" id="item" name="item" required>
        </div>
        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select class="form-control" id="status" name="status">
                <option value="1">Sudah Dicek</option>
                <option value="0">Belum Dicek</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="note" class="form-label">Catatan</label>
            <textarea class="form-control" id="note" name="note"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>
@endsection
