@extends('layouts.app')

@section('content')
<div class="container-fluid px-4 py-5">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit Perangkat</h1>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Form Edit Perangkat</h6>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('devices.update', $device->id) }}">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="user_id">User Prioritas</label>
                    <select class="form-control" id="user_id" name="user_id" required>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ $device->user_id == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="type">Tipe Perangkat</label>
                    <input type="text" class="form-control" id="type" name="type" value="{{ $device->type }}" required>
                </div>
                <div class="form-group">
                    <label for="brand">Merk</label>
                    <input type="text" class="form-control" id="brand" name="brand" value="{{ $device->brand }}">
                </div>
                <div class="form-group">
                    <label for="model">Model</label>
                    <input type="text" class="form-control" id="model" name="model" value="{{ $device->model }}">
                </div>
                <div class="form-group">
                    <label for="serial_number">Serial Number</label>
                    <input type="text" class="form-control" id="serial_number" name="serial_number" value="{{ $device->serial_number }}">
                </div>
                <div class="form-group">
                    <label for="description">Deskripsi</label>
                    <textarea class="form-control" id="description" name="description">{{ $device->description }}</textarea>
                </div>
                <div class="form-group">
                    <label for="category">Kategori Maintenance</label>
                    <select class="form-control" id="category" name="category" required>
                        <option value="hardware" {{ $device->category == 'hardware' ? 'selected' : '' }}>Perangkat Keras (Hardware)</option>
                        <option value="software" {{ $device->category == 'software' ? 'selected' : '' }}>Perangkat Lunak (Software)</option>
                        <option value="jaringan" {{ $device->category == 'jaringan' ? 'selected' : '' }}>Jaringan</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{ route('devices.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>
@endsection
