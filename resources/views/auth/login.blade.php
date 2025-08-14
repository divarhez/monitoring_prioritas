@extends('layouts.app')
@section('content')
<div class="d-flex justify-content-center align-items-center" style="min-height:100vh; background:#f4f6f9;">
    <div class="card shadow-lg p-4" style="max-width:400px; width:100%; border-radius:18px;">
        <div class="text-center mb-4">
            <img src="https://www.pindad.com/assets/images/logo-pindad.png" alt="PT Pindad" style="width:64px; margin-bottom:10px;">
            <h3 class="fw-bold" style="color:#006d3c;">PT Pindad Monitoring TI</h3>
            <span class="text-muted">Silakan login untuk melanjutkan</span>
        </div>
        @if(session('status'))
            <div class="alert alert-success">{{ session('status') }}</div>
        @endif
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="mb-3 input-group">
                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" placeholder="Email" required autofocus>
            </div>
            @error('email')<span class="text-danger small">{{ $message }}</span>@enderror
            <div class="mb-3 input-group">
                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
            </div>
            @error('password')<span class="text-danger small">{{ $message }}</span>@enderror
            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="remember_me" name="remember">
                <label class="form-check-label" for="remember_me">Remember me</label>
            </div>
            <button type="submit" class="btn btn-success w-100 fw-bold" style="border-radius:8px;">Login</button>
        </form>
        <div class="mt-3 text-center">
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="text-decoration-none">Lupa password?</a>
            @endif
        </div>
        <div class="mt-2 text-center">
            <a href="{{ route('register') }}" class="text-decoration-none">Belum punya akun? <b>Register</b></a>
        </div>
        <div class="mt-4 text-center text-muted small">
            &copy; PT Pindad 2025 - Monitoring TI
        </div>
    </div>
</div>
@endsection
