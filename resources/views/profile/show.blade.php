@extends('layouts.app')

@section('title', 'My Profile')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="text-light mb-1">
            <i class="bi bi-person-circle me-2"></i>My Profile
        </h1>
        <p class="text-light opacity-75 mb-0">Manage your account information</p>
        <small class="badge bg-info">
            <i class="bi bi-rocket me-1"></i>Space Explorer
        </small>
    </div>
    <div class="text-end">
        <p class="text-light opacity-75 mb-0">{{ now()->format('l, F j, Y') }}</p>
        <p class="text-space-gold mb-0">{{ now()->format('g:i A') }}</p>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-6">
        <div class="card space-card">
            <div class="card-body">
                <h5 class="mb-3"><i class="bi bi-person-badge me-2"></i>Profile Details</h5>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item bg-transparent border-secondary text-light">
                        <strong>Name:</strong> {{ auth()->user()->name }}
                    </li>
                    <li class="list-group-item bg-transparent border-secondary text-light">
                        <strong>Email:</strong> {{ auth()->user()->email }}
                    </li>
                    <li class="list-group-item bg-transparent border-secondary text-light">
                        <strong>Bio:</strong> {{ auth()->user()->bio ?? '-' }}
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="col-lg-6 text-center">
        <div class="card space-card h-100">
            <div class="card-body d-flex flex-column align-items-center justify-content-center">
                @if(auth()->user()->avatar)
                    <img src="{{ asset('storage/' . auth()->user()->avatar) }}" 
                         class="rounded-circle mb-3" width="120" height="120">
                @else
                    <i class="bi bi-person-circle text-muted display-1 mb-3"></i>
                @endif
                <h6 class="text-light mb-0">{{ auth()->user()->name }}</h6>
                <small class="text-muted">{{ auth()->user()->email }}</small>
            </div>
        </div>
    </div>
</div>

<div class="mt-4 text-end">
    <a href="{{ route('profile.edit') }}" class="btn btn-primary">
        <i class="bi bi-pencil-square me-1"></i>Edit Profile
    </a>
</div>
@endsection