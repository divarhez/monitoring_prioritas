@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-6">Laporan Maintenance</h1>

    <div class="mb-4">
        @if(Auth::check())
            @if(Auth::user()->role === 'admin')
                <a href="{{ route('maintenance-schedules.create') }}" class="btn btn-success mr-2">
                    <i class="fas fa-calendar-plus"></i> Tambah Jadwal
                </a>
            @elseif(Auth::user()->role === 'agent')
                <a href="{{ route('maintenance-report.create') }}" class="btn btn-success mr-2">
                    <i class="fas fa-plus-circle"></i> Tambah Laporan
                </a>
            @endif
        @endif
        <a href="?export=pdf" class="btn btn-primary">
            <i class="fas fa-file-pdf"></i> Export PDF
        </a>
    </div>

    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Agent</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Device</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($reports as $report)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $report->device->user->name ?? '-' }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $report->schedule?->agent?->name ?? '-' }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        @if($report->device)
                            {{ $report->device->type }}{{ $report->device->brand ? ' - '.$report->device->brand : '' }}
                        @else
                            -
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $report->status }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $report->created_at->format('d/m/Y') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
