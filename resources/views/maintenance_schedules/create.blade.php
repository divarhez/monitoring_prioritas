@extends('layouts.app')

@section('content')
<div class="container-fluid px-4 py-5">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Tambah Jadwal Maintenance</h1>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Form Tambah Jadwal</h6>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('maintenance-schedules.store') }}">
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
                    <label for="agent_id">Agent</label>
                    <select class="form-control" id="agent_id" name="agent_id" required>
                        @foreach($agents as $agent)
                            <option value="{{ $agent->id }}">{{ $agent->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="scheduled_date">Tanggal</label>
                    <input type="date" class="form-control" id="scheduled_date" name="scheduled_date" required>
                </div>
                <div class="form-group">
                    <label for="category">Kategori</label>
                    <select class="form-control" id="category" name="category" required>
                        <option value="hardware">Hardware</option>
                        <option value="software">Software</option>
                        <option value="jaringan">Jaringan</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('maintenance-schedules.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>
@endsection
