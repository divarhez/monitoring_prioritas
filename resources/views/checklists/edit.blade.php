@extends('layouts.app')

@section('content')
<div class="container-fluid px-4 py-5">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit Checklist Maintenance</h1>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Form Edit Checklist</h6>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('checklists.update', $checklist->id) }}">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="device_id">Perangkat</label>
                    <select class="form-control" id="device_id" name="device_id" required>
                        @foreach($devices as $device)
                            <option value="{{ $device->id }}" {{ $checklist->device_id == $device->id ? 'selected' : '' }}>{{ $device->type }} - {{ $device->brand }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="item">Item Checklist</label>
                    <input type="text" class="form-control" id="item" name="item" value="{{ $checklist->item }}" required>
                </div>
                <div class="form-group">
                    <label for="status">Status</label>
                    <select class="form-control" id="status" name="status">
                        <option value="1" {{ $checklist->status ? 'selected' : '' }}>Sudah Dicek</option>
                        <option value="0" {{ !$checklist->status ? 'selected' : '' }}>Belum Dicek</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="note">Catatan</label>
                    <textarea class="form-control" id="note" name="note">{{ $checklist->note }}</textarea>
                </div>
                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{ route('checklists.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>
@endsection
