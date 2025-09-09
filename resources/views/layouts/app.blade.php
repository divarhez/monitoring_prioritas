
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Monitoring TI</title>
    <!-- AdminLTE CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5.15.4/css/all.min.css">
    <!-- Toastr CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="/" class="nav-link">Dashboard</a>
            </li>
        </ul>
        <ul class="navbar-nav ml-auto">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-user-circle"></i> {{ Auth::user()->name ?? '' }} <span class="badge badge-info">{{ Auth::user()->role ?? '' }}</span>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                    <a class="dropdown-item" href="{{ route('profile.edit') }}"><i class="fas fa-user"></i> Profile</a>
                    <div class="dropdown-divider"></div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="dropdown-item" type="submit"><i class="fas fa-sign-out-alt"></i> Logout</button>
                    </form>
                </div>
            </li>
        </ul>
    </nav>
    <!-- Sidebar -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <a href="/" class="brand-link">
            <img src="{{ asset('images/logo-pindad.png') }}" alt="PT Pindad" class="brand-image img-circle elevation-3" style="opacity: .8; width:32px; margin-right:15px;">
            <span class="brand-text font-weight-bold">PT Pindad Monitoring TI</span>
        </a>
        <div class="sidebar">
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">
                    <li class="nav-item">
                        <a href="/" class="nav-link {{ request()->is('/') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-tachometer-alt"></i><p>Dashboard</p>
                        </a>
                    </li>

                    @if(Auth::user() && Auth::user()->role === 'admin')
                        <li class="nav-item"><a href="/agents" class="nav-link {{ request()->is('agents*') ? 'active' : '' }}"><i class="nav-icon fas fa-user-secret"></i><p>Agents</p></a></li>

                        <li class="nav-item"><a href="/users" class="nav-link {{ request()->is('users') ? 'active' : '' }}"><i class="nav-icon fas fa-users"></i><p>User Prioritas</p></a></li>


                        <li class="nav-item"><a href="/devices" class="nav-link {{ request()->is('devices*') ? 'active' : '' }}"><i class="nav-icon fas fa-desktop"></i><p>Devices</p></a></li>
                        <li class="nav-item"><a href="/maintenance-report" class="nav-link {{ request()->is('maintenance-report*') ? 'active' : '' }}"><i class="nav-icon fas fa-file-alt"></i><p>Laporan Maintenance</p></a></li>
                        <li class="nav-item"><a href="/maintenance-history" class="nav-link {{ request()->is('maintenance-history*') ? 'active' : '' }}"><i class="nav-icon fas fa-history"></i><p>Histori Maintenance</p></a></li>

                    @elseif(Auth::user() && Auth::user()->role === 'agent')
                        <li class="nav-item"><a href="/devices" class="nav-link {{ request()->is('devices*') ? 'active' : '' }}"><i class="nav-icon fas fa-desktop"></i><p>Devices</p></a></li>
                        <li class="nav-item"><a href="/maintenance-report" class="nav-link {{ request()->is('maintenance-report*') ? 'active' : '' }}"><i class="nav-icon fas fa-file-alt"></i><p>Laporan Maintenance</p></a></li>
                        <li class="nav-item"><a href="/maintenance-history" class="nav-link {{ request()->is('maintenance-history*') ? 'active' : '' }}"><i class="nav-icon fas fa-history"></i><p>Histori Maintenance</p></a></li>
                    @elseif(Auth::user() && Auth::user()->role === 'user')
                        <li class="nav-item"><a href="/devices" class="nav-link {{ request()->is('devices*') ? 'active' : '' }}"><i class="nav-icon fas fa-desktop"></i><p>Devices</p></a></li>

                        <li class="nav-item"><a href="/maintenance-report" class="nav-link {{ request()->is('maintenance-report*') ? 'active' : '' }}"><i class="nav-icon fas fa-file-alt"></i><p>Laporan Maintenance</p></a></li>
                    @endif
                    @if(Auth::check())
                        <li class="nav-item mt-3">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="btn btn-danger w-100"><i class="fas fa-sign-out-alt"></i> Logout</button>
                            </form>
                        </li>
                    @endif
                </ul>
            </nav>
        </div>
    </aside>
    <!-- Content Wrapper -->
    <div class="content-wrapper">
        <section class="content pt-3">
            <div class="container-fluid">
                @yield('content')
            </div>
        </section>
    </div>
    <!-- Footer -->
    <footer class="main-footer text-center">
        <strong>PT Pindad &copy; 2025 - Monitoring TI</strong>
    </footer>
</div>
<!-- Core JS (order matters): jQuery -> Bootstrap Bundle -> AdminLTE -->
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
<!-- Toastr JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script>
    $(function() {
        @if(session('success'))
            toastr.success("{{ session('success') }}");
        @endif
        @if(session('error'))
            toastr.error("{{ session('error') }}");
        @endif
        @if(session('info'))
            toastr.info("{{ session('info') }}");
        @endif
        @if(session('warning'))
            toastr.warning("{{ session('warning') }}");
        @endif
    });
</script>
</body>
</html>
