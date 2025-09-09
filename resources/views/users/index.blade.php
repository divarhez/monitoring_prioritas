@extends('layouts.app')
@section('content')
<div class="container">
    <!-- Form jadwal maintenance dihapus karena fitur sudah tidak digunakan -->
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="mb-0">User Prioritas</h1>
        @if(Auth::user() && Auth::user()->role === 'admin')
            <a href="{{ route('users.create') }}" class="btn btn-success mb-0">Tambah User Prioritas</a>
        @endif
    </div>
    <form method="GET" action="{{ route('users.index') }}" class="mb-3 mt-2">
        <div class="input-group">
            <input type="text" name="q" class="form-control" placeholder="Cari nama/departemen/jabatan/telepon" value="{{ request('q') }}">
            <div class="input-group-append">
                <button class="btn btn-primary" type="submit"><i class="fas fa-search"></i> Cari</button>
                <a href="{{ route('users.index') }}" class="btn btn-secondary">Reset</a>
            </div>
        </div>
    </form>
    <table class="table table-bordered mb-4">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Departemen</th>
                <th>Jabatan</th>
                <th>No Tlp</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr>
                <td>{{ $user->name }}</td>
                <td>{{ $user->department ?? '-' }}</td>
                <td>{{ $user->position ?? '-' }}</td>
                <td>{{ $user->phone ?? '-' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="d-flex justify-content-end">{{ $users->links() }}</div>
    <h2>Jadwal Visit/Maintenance</h2>
    <form method="GET" action="{{ route('users.index') }}" class="mb-3">
        <div class="row">
            <div class="col-md-2">
                <select name="agent_id" class="form-control">
                    <option value="">Semua Agent</option>
                    @foreach($agents as $agent)
                        <option value="{{ $agent->id }}" {{ request('agent_id') == $agent->id ? 'selected' : '' }}>{{ $agent->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <select name="category" class="form-control">
                    <option value="">Semua Kategori</option>
                    <option value="hardware" {{ request('category') == 'hardware' ? 'selected' : '' }}>Hardware</option>
                    <option value="software" {{ request('category') == 'software' ? 'selected' : '' }}>Software</option>
                    <option value="jaringan" {{ request('category') == 'jaringan' ? 'selected' : '' }}>Jaringan</option>
                </select>
            </div>
            <div class="col-md-2">
                <select name="status" class="form-control">
                    <option value="">Semua Status</option>
                    <option value="scheduled" {{ request('status') == 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                    <option value="done" {{ request('status') == 'done' ? 'selected' : '' }}>Done</option>
                    <option value="missed" {{ request('status') == 'missed' ? 'selected' : '' }}>Missed</option>
                </select>
            </div>
            <div class="col-md-2">
                <input type="date" name="date_from" class="form-control" value="{{ request('date_from') }}" placeholder="Dari Tanggal">
            </div>
            <div class="col-md-2">
                <input type="date" name="date_to" class="form-control" value="{{ request('date_to') }}" placeholder="Sampai Tanggal">
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary btn-block">Filter</button>
                <a href="{{ route('users.index') }}" class="btn btn-secondary btn-block mt-2">Reset</a>
            </div>
        </div>
    </form>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>User Prioritas</th>
                <th>Agent</th>
                <th>Tanggal</th>
                <th>Kategori</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($schedules as $schedule)
                <tr>
                    <td>{{ $schedule->user->name ?? '-' }}</td>
                    <td>{{ $schedule->agent->name ?? '-' }}</td>
                    <td>{{ $schedule->scheduled_date }}</td>
                    <td>{{ ucfirst($schedule->category) }}</td>
                    <td>{{ ucfirst($schedule->status) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="d-flex justify-content-end">{{ $schedules->links() }}</div>
</div>
@endsection
