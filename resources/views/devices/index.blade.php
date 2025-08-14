@extends('layouts.app')
@section('content')
<div class="container">
    <h2>Data Perangkat</h2>
    <form method="GET" action="" class="mb-3">
        <div class="row">
            <div class="col-md-4">
                <select name="category" class="form-control" onchange="this.form.submit()">
                    <option value="">-- Filter Kategori --</option>
                    <option value="hardware" {{ request('category') == 'hardware' ? 'selected' : '' }}>Perangkat Keras (Hardware)</option>
                    <option value="software" {{ request('category') == 'software' ? 'selected' : '' }}>Perangkat Lunak (Software)</option>
                    <option value="jaringan" {{ request('category') == 'jaringan' ? 'selected' : '' }}>Jaringan</option>
                </select>
            </div>
        </div>
    </form>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>User</th>
                <th>Tipe</th>
                <th>Merk</th>
                <th>Model</th>
                <th>Serial Number</th>
                <th>Deskripsi</th>
                <th>Kategori</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($devices as $device)
            <tr>
                <td>{{ $device->user->name ?? '-' }}</td>
                <td>{{ $device->type }}</td>
                <td>{{ $device->brand }}</td>
                <td>{{ $device->model }}</td>
                <td>{{ $device->serial_number }}</td>
                <td>{{ $device->description }}</td>
                <td>{{ ucfirst($device->category) }}</td>
                <td>
                    <a href="{{ route('devices.edit', $device->id) }}" class="btn btn-warning btn-sm">Edit</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
