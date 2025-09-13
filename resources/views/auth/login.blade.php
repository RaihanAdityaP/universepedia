@extends('layouts.auth')

@section('title', 'Login')

@section('content')
<form method="POST" action="{{ route('login') }}">
    @csrf
    
    <div class="mb-3">
        <label for="email" class="form-label text-light">
            <i class="bi bi-envelope me-2"></i>Email Address
        </label>
        <input type="email" class="form-control @error('email') is-invalid @enderror" 
               id="email" name="email" value="{{ old('email') }}" 
               placeholder="Enter your email" required autofocus>
        @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    
    <div class="mb-3">
        <label for="password" class="form-label text-light">
            <i class="bi bi-lock me-2"></i>Password
        </label>
        <input type="password" class="form-control @error('password') is-invalid @enderror" 
               id="password" name="password" placeholder="Enter your password" required>
        @error('password')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    
    <div class="mb-3 form-check">
        <input type="checkbox" class="form-check-input" id="remember" name="remember">
        <label class="form-check-label text-light" for="remember">
            Remember me
        </label>
    </div>
    
    <div class="d-grid gap-2 mb-3">
        <button type="submit" class="btn btn-primary">
            <i class="bi bi-box-arrow-in-right me-2"></i>Sign In
        </button>
    </div>
    
    <div class="text-center mb-3">
        <a href="{{ route('password.request') }}" class="text-space-gold text-decoration-none small">
            <i class="bi bi-question-circle me-1"></i>Forgot your password?
        </a>
    </div>
    
    <div class="text-center">
        <p class="text-light mb-0">
            Don't have an account? 
            <a href="{{ route('register') }}" class="text-space-gold text-decoration-none">
                Create Account
            </a>
        </p>
    </div>
</form>

<div class="mt-4 p-3 bg-dark bg-opacity-25 rounded">
    <h6 class="text-light mb-2">
        <i class="bi bi-info-circle me-2"></i>Demo Accounts:
    </h6>
    <small class="text-light d-block mb-1">
        <i class="bi bi-person-gear me-1"></i>
        <strong>Admin:</strong> admin@universepedia.com / password
    </small>
    <small class="text-light d-block">
        <i class="bi bi-person me-1"></i>
        <strong>User:</strong> user@universepedia.com / password
    </small>
</div>
@endsection