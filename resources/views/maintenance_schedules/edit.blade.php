@extends('layouts.app')
@section('content')
<div class="container">
    <h1>Edit Jadwal Maintenance</h1>
    <form method="POST" action="{{ route('maintenance-schedules.update', $maintenanceSchedule->id) }}">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="user_id" class="form-label">User Prioritas</label>
            <select class="form-control" id="user_id" name="user_id" required>
                @foreach($users as $user)
                    <option value="{{ $user->id }}" {{ $maintenanceSchedule->user_id == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="agent_id" class="form-label">Agent</label>
            <select class="form-control" id="agent_id" name="agent_id" required>
                @foreach($agents as $agent)
                    <option value="{{ $agent->id }}" {{ $maintenanceSchedule->agent_id == $agent->id ? 'selected' : '' }}>{{ $agent->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="category" class="form-label">Kategori Maintenance</label>
            <select class="form-control" id="category" name="category" required>
                <option value="hardware" {{ $maintenanceSchedule->category == 'hardware' ? 'selected' : '' }}>Hardware</option>
                <option value="software" {{ $maintenanceSchedule->category == 'software' ? 'selected' : '' }}>Software</option>
                <option value="jaringan" {{ $maintenanceSchedule->category == 'jaringan' ? 'selected' : '' }}>Jaringan</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="scheduled_date" class="form-label">Tanggal Maintenance</label>
            <input type="date" class="form-control" id="scheduled_date" name="scheduled_date" value="{{ $maintenanceSchedule->scheduled_date }}" required>
        </div>
        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select class="form-control" id="status" name="status" required>
                <option value="scheduled" {{ $maintenanceSchedule->status == 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                <option value="done" {{ $maintenanceSchedule->status == 'done' ? 'selected' : '' }}>Done</option>
                <option value="missed" {{ $maintenanceSchedule->status == 'missed' ? 'selected' : '' }}>Missed</option>
            </select>
        </div>
        <button type="submit" class="btn btn-success">Update Jadwal</button>
    </form>
</div>
@endsection
