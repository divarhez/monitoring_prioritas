@extends('layouts.app')
@section('content')
<div class="card">
    <div class="card-header">
        <h4>Edit Checklist Maintenance</h4>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('checklists.update', $checklist->id) }}">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="device_id" class="form-label">Perangkat</label>
                <select class="form-control" id="device_id" name="device_id" required>
                    @foreach($devices as $device)
                        <option value="{{ $device->id }}" {{ $checklist->device_id == $device->id ? 'selected' : '' }}>{{ $device->type }} - {{ $device->brand }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="item" class="form-label">Item Checklist</label>
                <input type="text" class="form-control" id="item" name="item" value="{{ $checklist->item }}" required>
            </div>
            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select class="form-control" id="status" name="status">
                    <option value="1" {{ $checklist->status ? 'selected' : '' }}>Sudah Dicek</option>
                    <option value="0" {{ !$checklist->status ? 'selected' : '' }}>Belum Dicek</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="note" class="form-label">Catatan</label>
                <textarea class="form-control" id="note" name="note">{{ $checklist->note }}</textarea>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
</div>
@endsection
