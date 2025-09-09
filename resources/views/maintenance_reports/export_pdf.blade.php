@extends('components.pdf.base')

@section('title', 'Data Laporan Maintenance')
@section('header_title', 'PT Pindad - Data Laporan Maintenance')

@section('content')
    <h2>Data Laporan Maintenance PT Pindad</h2>
    <table>
        <thead>
            <tr>
                <th>User</th>
                <th>Agent</th>
                <th>Device</th>
                <th>Hasil</th>
                <th>Rekomendasi</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($reports as $report)
            <tr>
                <td>{{ $report->device->user->name ?? '-' }}</td>
                <td>{{ $report->schedule?->agent?->name ?? '-' }}</td>
                <td>
                    @if($report->device)
                        {{ $report->device->type }}{{ $report->device->brand ? ' - '.$report->device->brand : '' }}
                    @else
                        -
                    @endif
                </td>
                <td>{{ $report->result }}</td>
                <td>{{ $report->recommendation ?? '-' }}</td>
                <td>{{ optional($report->created_at)->format('d/m/Y') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
@endsection
