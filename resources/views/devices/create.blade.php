@extends('layouts.app')
@section('content')
<div class="container">
    <h2>Tambah Perangkat</h2>
    <form method="POST" action="{{ route('devices.store') }}">
        @csrf
        <div class="mb-3">
            <label for="user_id" class="form-label">User Prioritas</label>
            <select class="form-control" id="user_id" name="user_id" required>
                @foreach($users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="type" class="form-label">Tipe Perangkat</label>
            <input type="text" class="form-control" id="type" name="type" required>
        </div>
        <div class="mb-3">
            <label for="brand" class="form-label">Merk</label>
            <input type="text" class="form-control" id="brand" name="brand">
        </div>
        <div class="mb-3">
            <label for="model" class="form-label">Model</label>
            <input type="text" class="form-control" id="model" name="model">
        </div>
        <div class="mb-3">
            <label for="serial_number" class="form-label">Serial Number</label>
            <input type="text" class="form-control" id="serial_number" name="serial_number">
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Deskripsi</label>
            <textarea class="form-control" id="description" name="description"></textarea>
        </div>
        <div class="mb-3">
            <label for="category" class="form-label">Kategori Maintenance</label>
            <select class="form-control" id="category" name="category" required>
                <option value="hardware">Perangkat Keras (Hardware)</option>
                <option value="software">Perangkat Lunak (Software)</option>
                <option value="jaringan">Jaringan</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>
@endsection
