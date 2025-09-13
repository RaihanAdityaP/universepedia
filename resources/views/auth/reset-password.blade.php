@extends('layouts.auth')

@section('title', 'Reset Password')

@section('content')
<div class="mb-4 text-center">
    <h4 class="text-light mb-2">Reset Password</h4>
    <p class="text-light opacity-75 mb-0 small">
        Enter your new password below.
    </p>
</div>

<form method="POST" action="{{ route('password.store') }}">
    @csrf
    
    <!-- Password Reset Token -->
    <input type="hidden" name="token" value="{{ $token }}">
    
    <div class="mb-3">
        <label for="email" class="form-label text-light">
            <i class="bi bi-envelope me-2"></i>Email Address
        </label>
        <input type="email" class="form-control @error('email') is-invalid @enderror" 
               id="email" name="email" value="{{ old('email', $email) }}" required readonly>
        @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    
    <div class="mb-3">
        <label for="password" class="form-label text-light">
            <i class="bi bi-lock me-2"></i>New Password
        </label>
        <input type="password" class="form-control @error('password') is-invalid @enderror" 
               id="password" name="password" placeholder="Enter new password" required>
        @error('password')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    
    <div class="mb-4">
        <label for="password_confirmation" class="form-label text-light">
            <i class="bi bi-lock-fill me-2"></i>Confirm Password
        </label>
        <input type="password" class="form-control" 
               id="password_confirmation" name="password_confirmation" 
               placeholder="Confirm new password" required>
    </div>
    
    <div class="d-grid gap-2 mb-3">
        <button type="submit" class="btn btn-primary">
            <i class="bi bi-check me-2"></i>Reset Password
        </button>
    </div>
    
    <div class="text-center">
        <a href="{{ route('login') }}" class="text-space-gold text-decoration-none">
            <i class="bi bi-arrow-left me-1"></i>Back to Login
        </a>
    </div>
</form>
@endsection