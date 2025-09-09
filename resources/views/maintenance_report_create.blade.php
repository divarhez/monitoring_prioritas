@extends('layouts.app')
@section('content')
<div class="card mb-4">
    <div class="card-header">
        <h4>Input Laporan Maintenance</h4>
    </div>
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        <form action="{{ route('maintenance-report.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="user_id" class="form-label">User Prioritas</label>
                <select name="user_id" id="user_id" class="form-control" required>
                    <option value="">-- Pilih User --</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="device_id" class="form-label">Perangkat</label>
                <select name="device_id" id="device_id" class="form-control" required>
                    <option value="">-- Pilih Perangkat --</option>
                    @foreach($devices as $device)
                        <option value="{{ $device->id }}">{{ $device->type }} - {{ $device->brand }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select name="status" id="status" class="form-control" required>
                    <option value="">-- Pilih Status --</option>
                    <option value="aman">Aman</option>
                    <option value="perlu perbaikan">Perlu Perbaikan</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="detail" class="form-label">Detail Kerusakan</label>
                <textarea name="detail" id="detail" class="form-control" rows="3" placeholder="Isi jika ada kerusakan"></textarea>
            </div>
            <div class="mb-3">
                <label for="recommendation" class="form-label">Rekomendasi</label>
                <textarea name="recommendation" id="recommendation" class="form-control" rows="2" placeholder="Rekomendasi perbaikan"></textarea>
            </div>
            <div class="mb-3">
                <label for="photo" class="form-label">Foto (opsional)</label>
                <input type="file" name="photo" id="photo" class="form-control">
            </div>
            <button type="submit" class="btn btn-primary">Simpan Laporan</button>
        </form>
    </div>
</div>
@endsection
