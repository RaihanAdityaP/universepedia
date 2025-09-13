@extends('layouts.auth')

@section('title', 'Register')

@section('content')
<form method="POST" action="{{ route('register') }}">
    @csrf
    
    <div class="mb-3">
        <label for="name" class="form-label text-light">
            <i class="bi bi-person me-2"></i>Full Name
        </label>
        <input type="text" class="form-control @error('name') is-invalid @enderror" 
               id="name" name="name" value="{{ old('name') }}" 
               placeholder="Enter your full name" required autofocus>
        @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    
    <div class="mb-3">
        <label for="email" class="form-label text-light">
            <i class="bi bi-envelope me-2"></i>Email Address
        </label>
        <input type="email" class="form-control @error('email') is-invalid @enderror" 
               id="email" name="email" value="{{ old('email') }}" 
               placeholder="Enter your email" required>
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
    
    <div class="mb-3">
        <label for="password_confirmation" class="form-label text-light">
            <i class="bi bi-lock-fill me-2"></i>Confirm Password
        </label>
        <input type="password" class="form-control" 
               id="password_confirmation" name="password_confirmation" 
               placeholder="Confirm your password" required>
    </div>
    
    <div class="d-grid gap-2 mb-3">
        <button type="submit" class="btn btn-primary">
            <i class="bi bi-person-plus me-2"></i>Create Account
        </button>
    </div>
    
    <div class="text-center">
        <p class="text-light mb-0">
            Already have an account? 
            <a href="{{ route('login') }}" class="text-space-gold text-decoration-none">
                Sign In
            </a>
        </p>
    </div>
</form>
@endsection