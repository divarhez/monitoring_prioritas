@extends('layouts.app')
@section('content')
<div class="container">
    <h2>Edit Perangkat</h2>
    <form method="POST" action="{{ route('devices.update', $device->id) }}">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="user_id" class="form-label">User Prioritas</label>
            <select class="form-control" id="user_id" name="user_id" required>
                @foreach($users as $user)
                    <option value="{{ $user->id }}" {{ $device->user_id == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="type" class="form-label">Tipe Perangkat</label>
            <input type="text" class="form-control" id="type" name="type" value="{{ $device->type }}" required>
        </div>
        <div class="mb-3">
            <label for="brand" class="form-label">Merk</label>
            <input type="text" class="form-control" id="brand" name="brand" value="{{ $device->brand }}">
        </div>
        <div class="mb-3">
            <label for="model" class="form-label">Model</label>
            <input type="text" class="form-control" id="model" name="model" value="{{ $device->model }}">
        </div>
        <div class="mb-3">
            <label for="serial_number" class="form-label">Serial Number</label>
            <input type="text" class="form-control" id="serial_number" name="serial_number" value="{{ $device->serial_number }}">
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Deskripsi</label>
            <textarea class="form-control" id="description" name="description">{{ $device->description }}</textarea>
        </div>
        <div class="mb-3">
            <label for="category" class="form-label">Kategori Maintenance</label>
            <select class="form-control" id="category" name="category" required>
                <option value="hardware" {{ $device->category == 'hardware' ? 'selected' : '' }}>Perangkat Keras (Hardware)</option>
                <option value="software" {{ $device->category == 'software' ? 'selected' : '' }}>Perangkat Lunak (Software)</option>
                <option value="jaringan" {{ $device->category == 'jaringan' ? 'selected' : '' }}>Jaringan</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
@endsection
