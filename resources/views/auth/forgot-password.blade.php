@extends('layouts.auth') 

@section('title', 'Forgot Password')

@section('content')
<div class="mb-4 text-center"> 
    <h4 class="text-light mb-2">Lost in Space?</h4>
    <p class="text-light opacity-75 mb-0 small">
        No worries! We'll send coordinates to help you find your way back to the universe.
    </p>
</div>

@if (session('status'))
    <div class="alert alert-success border-0 mb-4" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i>
        <strong>Mission Success!</strong> {{ session('status') }}
    </div>
@endif

<form method="POST" action="{{ route('password.email') }}">
    @csrf
    
    <div class="mb-4">
        <label for="email" class="form-label text-light">
            <i class="bi bi-envelope-at-fill me-2"></i>Space Command Email
        </label>
        <input type="email" class="form-control space-input @error('email') is-invalid @enderror" 
               id="email" name="email" value="{{ old('email') }}" 
               placeholder="Enter your space command email" required autofocus>
        @error('email')
            <div class="invalid-feedback">
                <i class="bi bi-exclamation-triangle me-1"></i>{{ $message }}
            </div>
        @enderror
    </div>
    
    <div class="d-grid gap-2 mb-3">
        <button type="submit" class="btn btn-primary space-btn">
            <i class="bi bi-send-fill me-2"></i>Launch Recovery Mission
        </button>
    </div>
    
    <div class="text-center">
        <a href="{{ route('login') }}" class="text-space-gold text-decoration-none">
            <i class="bi bi-arrow-left-circle me-1"></i>Return to Base Station
        </a>
    </div>
</form>

<div class="mt-4 p-3 bg-dark bg-opacity-25 rounded border border-secondary">
    <div class="d-flex align-items-center mb-2">
        <i class="bi bi-info-circle-fill text-space-gold me-2"></i>
        <h6 class="text-light mb-0">Mission Control Info</h6>
    </div>
    <small class="text-light d-block mb-1">
        <i class="bi bi-rocket-takeoff me-1"></i>
        Check your email for the recovery coordinates
    </small>
    <small class="text-light d-block">
        <i class="bi bi-shield-check me-1"></i>
        Secure space-grade encryption protocol active
    </small>
</div>

@push('styles')
<style>
    .space-input {
        background: rgba(255, 255, 255, 0.1) !important;
        border: 1px solid rgba(255, 215, 0, 0.3) !important;
        color: white !important;
        border-radius: 15px !important;
        padding: 12px 20px !important;
        transition: all 0.3s ease !important;
    }
    
    .space-input:focus {
        background: rgba(255, 255, 255, 0.15) !important;
        border-color: #ffd700 !important;
        box-shadow: 0 0 20px rgba(255, 215, 0, 0.3) !important;
        color: white !important;
        transform: translateY(-2px);
    }
    
    .space-input::placeholder {
        color: rgba(255, 255, 255, 0.6) !important;
    }
    
    .space-btn {
        background: linear-gradient(135deg, #ffd700, #ffed4e) !important;
        border: none !important;
        border-radius: 15px !important;
        padding: 15px 30px !important;
        font-weight: 600 !important;
        color: #1a1a2e !important;
        text-transform: uppercase !important;
        letter-spacing: 1px !important;
        transition: all 0.3s ease !important;
        position: relative;
        overflow: hidden;
    }
    
    .space-btn::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
        transition: left 0.6s;
    }
    
    .space-btn:hover::before {
        left: 100%;
    }
    
    .space-btn:hover {
        background: linear-gradient(135deg, #ffed4e, #ffd700) !important;
        color: #1a1a2e !important;
        box-shadow: 0 0 30px rgba(255, 215, 0, 0.7) !important;
        transform: translateY(-3px) scale(1.02) !important;
    }
    
    .alert-success {
        background: linear-gradient(135deg, rgba(40, 167, 69, 0.2), rgba(25, 135, 84, 0.2)) !important;
        border: 1px solid rgba(40, 167, 69, 0.4) !important;
        color: #d4edda !important;
        border-radius: 15px !important;
    }
    
    .text-space-gold {
        color: #ffd700 !important;
        transition: all 0.3s ease;
    }
    
    .text-space-gold:hover {
        color: #ffed4e !important;
        text-shadow: 0 0 10px rgba(255, 215, 0, 0.5);
        transform: translateX(-5px);
    }
</style>
@endpush
@endsection