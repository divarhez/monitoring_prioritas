<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Laporan')</title>
    <style>
        @page { margin: 32px 32px 48px 32px; }
        body { font-family: DejaVu Sans, Arial, Helvetica, sans-serif; font-size: 12px; color: #111; }
        h1, h2, h3, h4 { margin: 0 0 6px 0; }
        .brand { display: flex; align-items: center; justify-content: space-between; margin-bottom: 8px; }
        .brand .left { display:flex; align-items:center; gap:10px; }
        .brand .title { font-size: 16px; font-weight: bold; }
        .muted { color: #666; }
        .content { margin-top: 8px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #333; padding: 6px; text-align: left; }
        th { background: #f2f2f2; }
        .footer {
            position: fixed;
            bottom: 0; left: 0; right: 0;
            text-align: center;
            font-size: 10px;
            color: #666;
        }
        .page-number:after { content: counter(page); }
        .total-pages:after { content: counter(pages); }
    </style>
    @yield('styles')
</head>
<body>
    <div class="brand">
        <div class="left">
            @php $__pindadLogo = public_path('images/logo-pindad.png'); @endphp
            @if (file_exists($__pindadLogo))
                <img src="{{ $__pindadLogo }}" alt="PT Pindad" style="height:28px;">
            @endif
            <div class="title">@yield('header_title', 'PT Pindad - Monitoring TI')</div>
        </div>
        <div class="muted">@yield('header_right', 'Tanggal Cetak: '){{ now()->format('d/m/Y H:i') }}</div>
    </div>

    <div class="content">
        @yield('content')
    </div>

    <div class="footer">
        @yield('footer_text', 'PT Pindad - Monitoring TI') | Halaman <span class="page-number"></span> dari <span class="total-pages"></span>
    </div>
</body>
</html>
