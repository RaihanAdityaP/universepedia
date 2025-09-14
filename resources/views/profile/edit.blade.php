@extends('layouts.app')

@section('title', 'Edit Profile')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="text-light mb-1">
            <i class="bi bi-pencil-square me-2"></i>Edit Profile
        </h1>
        <p class="text-light opacity-75 mb-0">Update your personal information</p>
    </div>
    <div class="text-end">
        <p class="text-light opacity-75 mb-0">{{ now()->format('l, F j, Y') }}</p>
        <p class="text-space-gold mb-0">{{ now()->format('g:i A') }}</p>
    </div>
</div>

<div class="card space-card">
    <div class="card-body">
        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label text-light">Name</label>
                <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}" 
                       class="form-control @error('name') is-invalid @enderror">
                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label class="form-label text-light">Email</label>
                <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}" 
                       class="form-control @error('email') is-invalid @enderror">
                @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label text-light">Current Password</label>
                    <input type="password" name="current_password" 
                           class="form-control @error('current_password') is-invalid @enderror">
                    @error('current_password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label text-light">New Password</label>
                    <input type="password" name="password" 
                           class="form-control @error('password') is-invalid @enderror">
                    @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label text-light">Confirm New Password</label>
                <input type="password" name="password_confirmation" class="form-control">
            </div>

            <div class="mb-3">
                <label class="form-label text-light">Avatar</label>
                <input type="file" name="avatar" 
                       class="form-control @error('avatar') is-invalid @enderror">
                @error('avatar') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label class="form-label text-light">Bio</label>
                <textarea name="bio" class="form-control @error('bio') is-invalid @enderror"
                          rows="3">{{ old('bio', auth()->user()->bio) }}</textarea>
                @error('bio') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="d-flex justify-content-between mt-4">
                <a href="{{ route('profile.show') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left me-1"></i>Cancel
                </a>
                <button type="submit" class="btn btn-success">
                    <i class="bi bi-save me-1"></i>Save Changes
                </button>
            </div>
        </form>
    </div>
</div>
@endsection