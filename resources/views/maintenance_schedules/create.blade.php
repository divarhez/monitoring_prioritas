@extends('layouts.app')
@section('content')
<div class="container">
    <h2>Tambah Jadwal Maintenance</h2>
    <form method="POST" action="{{ route('maintenance-schedules.store') }}">
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
            <label for="agent_id" class="form-label">Agent</label>
            <select class="form-control" id="agent_id" name="agent_id" required>
                @foreach($agents as $agent)
                    <option value="{{ $agent->id }}">{{ $agent->name }}</option>
                @endforeach
            </select>
        </div>
            <div class="mb-3">
                <label for="category" class="form-label">Kategori Maintenance</label>
                <select class="form-control" id="category" name="category" required>
                    <option value="hardware">Hardware</option>
                    <option value="software">Software</option>
                    <option value="jaringan">Jaringan</option>
                </select>
            </div>
        <div class="mb-3">
            <label for="scheduled_date" class="form-label">Tanggal Maintenance</label>
            <input type="date" class="form-control" id="scheduled_date" name="scheduled_date" required>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>
@endsection
