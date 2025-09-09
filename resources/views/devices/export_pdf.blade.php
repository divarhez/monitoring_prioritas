@extends('components.pdf.base')

@section('title', 'Data Perangkat')
@section('header_title', 'PT Pindad - Data Perangkat')

@section('content')
    <h2>Data Perangkat PT Pindad</h2>
    <table>
        <thead>
            <tr>
                <th>User</th>
                <th>Tipe</th>
                <th>Merk</th>
                <th>Model</th>
                <th>Serial Number</th>
                <th>Deskripsi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($devices as $device)
            <tr>
                <td>{{ $device->user->name ?? '-' }}</td>
                <td>{{ $device->type ?? '-' }}</td>
                <td>{{ $device->brand ?? '-' }}</td>
                <td>{{ $device->model ?? '-' }}</td>
                <td>{{ $device->serial_number ?? '-' }}</td>
                <td>{{ $device->description ?? '-' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
@endsection
