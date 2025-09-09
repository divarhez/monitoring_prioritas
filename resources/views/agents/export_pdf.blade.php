@extends('components.pdf.base')

@section('title', 'Data Agent')
@section('header_title', 'PT Pindad - Data Agent')

@section('content')
    <h2>Data Agent PT Pindad</h2>
    <table>
        <thead>
            <tr>
                <th>Nama</th>
                <th>Email</th>
                <th>No HP</th>
            </tr>
        </thead>
        <tbody>
            @foreach($agents as $agent)
            <tr>
                <td>{{ $agent->name ?? '-' }}</td>
                <td>{{ $agent->email ?? '-' }}</td>
                <td>{{ $agent->phone ?? '-' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
@endsection
