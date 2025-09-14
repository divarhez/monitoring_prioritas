@extends('layouts.app')

@section('content')
<div class="container-fluid px-4 py-5">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Tambah Perangkat</h1>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Form Tambah Perangkat</h6>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('devices.store') }}">
                @csrf
                <div class="form-group">
                    <label for="user_id">User Prioritas</label>
                    <select class="form-control" id="user_id" name="user_id" required>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="type">Tipe Perangkat</label>
                    <input type="text" class="form-control" id="type" name="type" required>
                </div>
                <div class="form-group">
                    <label for="brand">Merk</label>
                    <input type="text" class="form-control" id="brand" name="brand">
                </div>
                <div class="form-group">
                    <label for="model">Model</label>
                    <input type="text" class="form-control" id="model" name="model">
                </div>
                <div class="form-group">
                    <label for="serial_number">Serial Number</label>
                    <input type="text" class="form-control" id="serial_number" name="serial_number">
                </div>
                <div class="form-group">
                    <label for="description">Deskripsi</label>
                    <textarea class="form-control" id="description" name="description"></textarea>
                </div>
                <div class="form-group">
                    <label for="category">Kategori Device</label>
                    <select class="form-control" id="category" name="category" required>
                        <option value="komputer">Komputer</option>
                        <option value="laptop">Laptop</option>
                        <option value="printer">Printer</option>
                        <option value="jaringan">Jaringan</option>
                        <option value="software">Software</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('devices.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>
@endsection
