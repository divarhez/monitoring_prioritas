@extends('layouts.app')

@section('content')
<div class="container-fluid px-4 py-5">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Tambah Checklist Maintenance</h1>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Form Tambah Checklist</h6>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('checklists.store') }}">
                @csrf
                <div class="form-group">
                    <label for="device_id">Perangkat</label>
                    <select class="form-control" id="device_id" name="device_id" required>
                        @foreach($devices as $device)
                            <option value="{{ $device->id }}">{{ $device->type }} - {{ $device->brand }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="item">Item Checklist</label>
                    <input type="text" class="form-control" id="item" name="item" required>
                </div>
                <div class="form-group">
                    <label for="status">Status</label>
                    <select class="form-control" id="status" name="status">
                        <option value="1">Sudah Dicek</option>
                        <option value="0">Belum Dicek</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="note">Catatan</label>
                    <textarea class="form-control" id="note" name="note"></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('checklists.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>
@endsection
