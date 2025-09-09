@extends('layouts.app')
@section('content')
<div class="d-flex justify-content-center align-items-center" style="min-height:100vh; background:#f4f6f9;">
    <div class="card shadow-lg p-4" style="max-width:400px; width:100%; border-radius:18px;">
        <div class="text-center mb-4">
            <img src="https://www.pindad.com/assets/images/logo-pindad.png" alt="PT Pindad" style="width:64px; margin-bottom:10px;">
            <h3 class="fw-bold" style="color:#006d3c;">PT Pindad Monitoring TI</h3>
            <span class="text-muted">Silakan daftar untuk akses aplikasi</span>
        </div>
        <form method="POST" action="{{ route('register') }}">
            @csrf
            <div class="mb-3 input-group">
                <span class="input-group-text"><i class="fas fa-user"></i></span>
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" placeholder="Nama" required autofocus autocomplete="name" inputmode="text">
            </div>
            @error('name')<span class="text-danger small">{{ $message }}</span>@enderror
            <div class="mb-3 input-group">
                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" placeholder="Email" required autocomplete="email" inputmode="email">
            </div>
            @error('email')<span class="text-danger small">{{ $message }}</span>@enderror
            <div class="mb-3 input-group">
                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                <input type="password" class="form-control" id="password" name="password" placeholder="Password" required autocomplete="new-password">
            </div>
            @error('password')<span class="text-danger small">{{ $message }}</span>@enderror
            <div class="mb-3 input-group">
                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Konfirmasi Password" required autocomplete="new-password">
            </div>
            @error('password_confirmation')<span class="text-danger small">{{ $message }}</span>@enderror
            <div class="mb-3">
                <label for="role" class="form-label">Role</label>
                <select id="role" name="role" class="form-control" required>
                    <option value="user">User Prioritas</option>
                    <option value="agent">Agent</option>
                    <option value="admin">Admin</option>
                </select>
            </div>
            @error('role')<span class="text-danger small">{{ $message }}</span>@enderror
            <button type="submit" class="btn btn-success w-100 fw-bold" style="border-radius:8px;">Register</button>
        </form>
        <div class="mt-3 text-center">
            <a href="{{ route('login') }}" class="text-decoration-none">Sudah punya akun? <b>Login</b></a>
        </div>
        <div class="mt-4 text-center text-muted small">
            &copy; PT Pindad 2025 - Monitoring TI
        </div>
    </div>
</div>
@endsection
