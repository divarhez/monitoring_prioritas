<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Maintenance #{{ $report->id }}</title>
    <style>
        @page { margin: 32px 32px 48px 32px; }
        body { font-family: DejaVu Sans, Arial, Helvetica, sans-serif; font-size: 12px; color: #111; }
        .header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 12px; }
        .brand { display: flex; align-items: center; gap: 10px; }
        .brand h2 { margin: 0; font-size: 16px; }
        .muted { color: #555; }
        .title { text-align: center; margin: 8px 0 16px; font-size: 18px; text-transform: uppercase; }
        .meta, .section { width: 100%; border-collapse: collapse; margin-bottom: 12px; }
        .meta td { padding: 6px 8px; vertical-align: top; }
        .meta td.key { width: 180px; color: #333; }
        .section th { text-align: left; padding: 8px; background: #f0f0f0; border: 1px solid #ddd; }
        .section td { padding: 8px; border: 1px solid #ddd; }
        .footer { position: fixed; bottom: 0; left: 0; right: 0; text-align: center; font-size: 10px; color: #666; }
        .code { font-family: Consolas, monospace; font-size: 11px; color: #333; }
        .small { font-size: 11px; }
        .sign-row { display: flex; justify-content: space-between; margin-top: 28px; }
        .sign-box { width: 32%; text-align: center; }
        .sign-line { margin-top: 56px; border-top: 1px solid #333; padding-top: 4px; }
    </style>
</head>
<body>
    <div class="header">
        <div class="brand">
            <div style="display:flex;align-items:center;gap:10px;">
                @php $__pindadLogo = public_path('images/logo-pindad.png'); @endphp
                @if (file_exists($__pindadLogo))
                    <img src="{{ $__pindadLogo }}" alt="PT Pindad" style="height:28px;">
                @endif
                <div>
                    <h2>PT Pindad</h2>
                    <div class="small muted">Direktorat TIK</div>
                </div>
            </div>
        </div>
        <div class="small muted">Tanggal Cetak: {{ now()->format('d/m/Y H:i') }}</div>
    </div>

    <div class="title">Laporan Maintenance</div>

    <table class="meta">
        <tr>
            <td class="key">Nomor Laporan</td>
            <td class="code">#{{ $report->id }}</td>
            <td class="key">Tanggal Laporan</td>
            <td>{{ optional($report->created_at)->format('d/m/Y H:i') }}</td>
        </tr>
        <tr>
            <td class="key">User Prioritas</td>
            <td>{{ $report->schedule->user->name ?? '-' }}</td>
            <td class="key">Agent</td>
            <td>{{ $report->schedule?->agent?->name ?? '-' }}</td>
        </tr>
        <tr>
            <td class="key">Jadwal Maintenance</td>
            <td>{{ optional($report->schedule)->scheduled_date }}</td>
            <td class="key">Kategori</td>
            <td>{{ ucfirst($report->schedule->category ?? '-') }}</td>
        </tr>
    </table>

    <table class="section">
        <thead>
            <tr>
                <th colspan="3">Detail Perangkat</th>
            </tr>
        </thead>
        <tbody>
            @foreach($report->devices as $device)
            <tr>
                <td style="width: 180px;">Tipe / Jenis</td>
                <td>{{ $device->type ?? '-' }}</td>
                <td>{{ $device->brand ?? '-' }}</td>
            </tr>
            @endforeach
            <tr>
                <td colspan="3" class="small muted">Perangkat terkait yang dikerjakan pada jadwal ini.</td>
            </tr>
        </tbody>
    </table>

    <table class="section">
        <thead>
            <tr>
                <th colspan="2">Hasil Maintenance</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td style="width: 180px;">Ringkasan Hasil</td>
                <td>{!! nl2br(e($report->result)) !!}</td>
            </tr>
            <tr>
                <td>Rekomendasi</td>
                <td>{!! nl2br(e($report->recommendation ?? '-')) !!}</td>
            </tr>
        </tbody>
    </table>

    <div class="sign-row">
        <div class="sign-box">
            <div class="small">Dibuat oleh (Agent)</div>
            <div class="sign-line">{{ $report->schedule?->agent?->name ?? '-' }}</div>
        </div>
        <div class="sign-box">
            <div class="small">Diverifikasi (User)</div>
            <div class="sign-line">{{ $report->schedule->user->name ?? '-' }}</div>
        </div>
        <div class="sign-box">
            <div class="small">Mengetahui (Admin)</div>
            <div class="sign-line">&nbsp;</div>
        </div>
    </div>

    <div class="footer">
        PT Pindad &copy; {{ date('Y') }} - Laporan Maintenance | Laporan #{{ $report->id }}
    </div>
</body>
</html>
