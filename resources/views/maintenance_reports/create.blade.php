@extends('layouts.app')
@section('content')
<div class="container">
    <h2>Tambah Laporan Maintenance</h2>
    <form method="POST" action="{{ route('maintenance-reports.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="maintenance_schedule_id" class="form-label">Jadwal Maintenance</label>
            <select class="form-control" id="maintenance_schedule_id" name="maintenance_schedule_id" required>
                @foreach($schedules as $schedule)
                    <option value="{{ $schedule->id }}">{{ $schedule->scheduled_date }} - {{ $schedule->user->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="device_id" class="form-label">Perangkat</label>
            <select class="form-control" id="device_id" name="device_id" required>
                @foreach($devices as $device)
                    <option value="{{ $device->id }}">{{ $device->type }} - {{ $device->brand }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="result" class="form-label">Hasil Maintenance</label>
            <textarea class="form-control" id="result" name="result" required></textarea>
        </div>
        <div class="mb-3">
            <label for="recommendation" class="form-label">Rekomendasi</label>
            <textarea class="form-control" id="recommendation" name="recommendation"></textarea>
        </div>
        <div class="mb-3">
            <label for="photo" class="form-label">Upload Foto</label>
            <input type="file" class="form-control" id="photo" name="photo" accept="image/*">
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>
@endsection
