@extends('layouts.app')

@section('content')
<div class="container-fluid px-4 py-5">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit Jadwal Maintenance</h1>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Form Edit Jadwal</h6>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('maintenance-schedules.update', $schedule->id) }}">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="user_id">User Prioritas</label>
                    <select class="form-control" id="user_id" name="user_id" required>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ $schedule->user_id == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="agent_id">Agent</label>
                    <select class="form-control" id="agent_id" name="agent_id" required>
                        @foreach($agents as $agent)
                            <option value="{{ $agent->id }}" {{ $schedule->agent_id == $agent->id ? 'selected' : '' }}>{{ $agent->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="scheduled_date">Tanggal</label>
                    <input type="date" class="form-control" id="scheduled_date" name="scheduled_date" value="{{ $schedule->scheduled_date }}" required>
                </div>
                <div class="form-group">
                    <label for="category">Kategori</label>
                    <select class="form-control" id="category" name="category" required>
                        <option value="hardware" {{ $schedule->category == 'hardware' ? 'selected' : '' }}>Hardware</option>
                        <option value="software" {{ $schedule->category == 'software' ? 'selected' : '' }}>Software</option>
                        <option value="jaringan" {{ $schedule->category == 'jaringan' ? 'selected' : '' }}>Jaringan</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="status">Status</label>
                    <select class="form-control" id="status" name="status" required>
                        <option value="scheduled" {{ $schedule->status == 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                        <option value="done" {{ $schedule->status == 'done' ? 'selected' : '' }}>Done</option>
                        <option value="missed" {{ $schedule->status == 'missed' ? 'selected' : '' }}>Missed</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{ route('maintenance-schedules.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>
@endsection
