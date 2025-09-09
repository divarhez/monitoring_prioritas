@extends('layouts.app')
@section('content')
<div class="container">
    <h1>Daftar Agent</h1>
    <a href="{{ route('agents.create') }}" class="btn btn-primary mb-3">Tambah Agent</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Email</th>
                <th>Telepon</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($agents as $agent)
            <tr>
                <td>{{ $agent->name }}</td>
                <td>{{ $agent->email }}</td>
                <td>{{ $agent->phone ?? '-' }}</td>
                <td>
                    <a href="{{ route('agents.edit', $agent->id) }}" class="btn btn-sm btn-warning">Edit</a>
                    <form action="{{ route('agents.destroy', $agent->id) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus agent?')">Hapus</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="text-center">Belum ada agent.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
