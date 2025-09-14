@extends('layouts.app')
@section('content')
<div class="card">
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

        @if(Auth::user()->role == 'admin' || Auth::user()->role == 'agent')
        <form action="{{ route('maintenance-report.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="schedule_id" class="form-label">Jadwal Maintenance</label>
                <select name="schedule_id" id="schedule_id" class="form-control" required>
                    <option value="">-- Pilih Jadwal --</option>
                    @foreach($schedules as $schedule)
                        <option value="{{ $schedule->id }}">{{ $schedule->scheduled_date }} - {{ $schedule->user->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Perangkat (Pilih satu atau lebih)</label>
                <div class="row">
                    @foreach($devices as $device)
                        <div class="col-md-6">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="device_ids[]" value="{{ $device->id }}" id="device_{{ $device->id }}">
                                <label class="form-check-label" for="device_{{ $device->id }}">
                                    {{ $device->type }}{{ $device->brand ? ' - '.$device->brand : '' }}
                                </label>
                                <div class="form-check form-check-inline ml-3">
                                    <input class="form-check-input" type="checkbox" name="problematic_devices[]" value="{{ $device->id }}" id="problematic_{{ $device->id }}">
                                    <label class="form-check-label text-danger" for="problematic_{{ $device->id }}">
                                        Bermasalah (Perlu Perbaikan)
                                    </label>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="mb-3">
                <label for="result" class="form-label">Hasil Maintenance</label>
                <textarea name="result" id="result" class="form-control" rows="3" required>{{ old('result') }}</textarea>
            </div>
            <div class="mb-3">
                <label for="recommendation" class="form-label">Rekomendasi (opsional)</label>
                <textarea name="recommendation" id="recommendation" class="form-control" rows="2">{{ old('recommendation') }}</textarea>
            </div>
            <div class="mb-3">
                <label for="photo" class="form-label">Foto (opsional)</label>
                <input type="file" name="photo" id="photo" class="form-control">
            </div>
            <div class="mb-3">
                <label for="report_pdf" class="form-label">File PDF Laporan (opsional)</label>
                <input type="file" name="report_pdf" id="report_pdf" class="form-control" accept="application/pdf">
            </div>
            <button type="submit" class="btn btn-success">Simpan Laporan</button>
        </form>
        @else
            <div class="alert alert-warning">Hanya admin dan agent yang dapat menginput laporan maintenance.</div>
        @endif
    </div>
</div>
@endsection
