@extends('layouts.app')

@section('title', 'Edit Profile')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="text-light mb-1">
            <i class="bi bi-pencil-square me-2"></i>Edit Profile
        </h1>
        <p class="text-light opacity-75 mb-0">Update your cosmic profile and personal information</p>
        <small class="badge bg-info mt-2">
            <i class="bi bi-shield-check me-1"></i>Secure Profile Management
        </small>
    </div>
    <div class="text-end">
        <p class="text-light opacity-75 mb-0">{{ now()->format('l, F j, Y') }}</p>
        <p class="text-space-gold mb-0">{{ now()->format('g:i A') }}</p>
        <small class="text-muted d-block">Last updated: {{ auth()->user()->updated_at->diffForHumans() }}</small>
    </div>
</div>

<form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="row g-4">
        <!-- Basic Information -->
        <div class="col-lg-8">
            <div class="card space-card">
                <div class="card-header bg-transparent border-bottom border-secondary">
                    <h5 class="text-light mb-0">
                        <i class="bi bi-person-badge me-2"></i>Basic Information
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="name" class="form-label text-light">
                                <i class="bi bi-person me-1"></i>Full Name *
                            </label>
                            <input type="text" 
                                   id="name"
                                   name="name" 
                                   value="{{ old('name', auth()->user()->name) }}" 
                                   class="form-control @error('name') is-invalid @enderror"
                                   placeholder="Enter your full name"
                                   required>
                            @error('name') 
                                <div class="invalid-feedback">{{ $message }}</div> 
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="email" class="form-label text-light">
                                <i class="bi bi-envelope me-1"></i>Email Address *
                            </label>
                            <input type="email" 
                                   id="email"
                                   name="email" 
                                   value="{{ old('email', auth()->user()->email) }}" 
                                   class="form-control @error('email') is-invalid @enderror"
                                   placeholder="Enter your email address"
                                   required>
                            @error('email') 
                                <div class="invalid-feedback">{{ $message }}</div> 
                            @enderror
                        </div>

                        <div class="col-12">
                            <label for="bio" class="form-label text-light">
                                <i class="bi bi-chat-quote me-1"></i>Biography
                            </label>
                            <textarea id="bio"
                                      name="bio" 
                                      class="form-control @error('bio') is-invalid @enderror"
                                      rows="4" 
                                      placeholder="Tell us about your cosmic journey and interests...">{{ old('bio', auth()->user()->bio) }}</textarea>
                            @error('bio') 
                                <div class="invalid-feedback">{{ $message }}</div> 
                            @enderror
                            <small class="text-muted">Share your passion for astronomy and space exploration</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Avatar Section -->
        <div class="col-lg-4">
            <div class="card space-card h-100">
                <div class="card-header bg-transparent border-bottom border-secondary">
                    <h5 class="text-light mb-0">
                        <i class="bi bi-image me-2"></i>Profile Avatar
                    </h5>
                </div>
                <div class="card-body text-center">
                    <div class="mb-3">
                        @if(auth()->user()->avatar)
                            <img src="{{ asset('storage/' . auth()->user()->avatar) }}" 
                                 class="rounded-circle border border-3 border-space-gold shadow mb-3" 
                                 width="120" height="120" 
                                 style="object-fit: cover;"
                                 id="avatar-preview">
                        @else
                            <div class="rounded-circle bg-gradient-space d-flex align-items-center justify-content-center shadow mb-3 mx-auto" 
                                 style="width: 120px; height: 120px;"
                                 id="avatar-placeholder">
                                <i class="bi bi-person-circle text-white" style="font-size: 4rem;"></i>
                            </div>
                        @endif
                        <p class="text-muted mb-0">Current Avatar</p>
                    </div>

                    <div class="mb-3">
                        <label for="avatar" class="form-label text-light">
                            <i class="bi bi-upload me-1"></i>Upload New Avatar
                        </label>
                        <input type="file" 
                               id="avatar"
                               name="avatar" 
                               class="form-control @error('avatar') is-invalid @enderror"
                               accept="image/*"
                               onchange="previewAvatar(this)">
                        @error('avatar') 
                            <div class="invalid-feedback">{{ $message }}</div> 
                        @enderror
                        <small class="text-muted d-block mt-2">Max size: 2MB. Formats: JPEG, PNG, JPG</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Security Section -->
        <div class="col-12">
            <div class="card space-card">
                <div class="card-header bg-transparent border-bottom border-secondary">
                    <h5 class="text-light mb-0">
                        <i class="bi bi-shield-lock me-2"></i>Security & Password
                    </h5>
                    <small class="text-muted">Leave password fields empty to keep current password</small>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label for="current_password" class="form-label text-light">
                                <i class="bi bi-key me-1"></i>Current Password
                            </label>
                            <input type="password" 
                                   id="current_password"
                                   name="current_password" 
                                   class="form-control @error('current_password') is-invalid @enderror"
                                   placeholder="Enter current password">
                            @error('current_password') 
                                <div class="invalid-feedback">{{ $message }}</div> 
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label for="password" class="form-label text-light">
                                <i class="bi bi-lock me-1"></i>New Password
                            </label>
                            <input type="password" 
                                   id="password"
                                   name="password" 
                                   class="form-control @error('password') is-invalid @enderror"
                                   placeholder="Enter new password">
                            @error('password') 
                                <div class="invalid-feedback">{{ $message }}</div> 
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label for="password_confirmation" class="form-label text-light">
                                <i class="bi bi-lock-fill me-1"></i>Confirm New Password
                            </label>
                            <input type="password" 
                                   id="password_confirmation"
                                   name="password_confirmation" 
                                   class="form-control"
                                   placeholder="Confirm new password">
                        </div>
                    </div>

                    <div class="mt-3 p-3 bg-warning bg-opacity-10 border border-warning border-opacity-25 rounded">
                        <h6 class="text-warning mb-2">
                            <i class="bi bi-exclamation-triangle me-1"></i>Password Security Tips
                        </h6>
                        <ul class="small text-light opacity-75 mb-0">
                            <li>Use at least 8 characters</li>
                            <li>Include uppercase and lowercase letters</li>
                            <li>Add numbers and special characters</li>
                            <li>Avoid common words and personal information</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="col-12">
            <div class="card space-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <a href="{{ route('profile.show') }}" class="btn btn-outline-light">
                                <i class="bi bi-arrow-left me-1"></i>Cancel Changes
                            </a>
                        </div>
                        <div>
                            <button type="submit" class="btn btn-success btn-lg">
                                <i class="bi bi-save me-1"></i>Save Changes
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<style>
.bg-gradient-space {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.card:hover {
    transform: translateY(-2px);
    transition: all 0.3s ease;
}

.form-control:focus {
    border-color: #ffc107;
    box-shadow: 0 0 0 0.2rem rgba(255, 193, 7, 0.25);
}
</style>

<script>
function previewAvatar(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        
        reader.onload = function(e) {
            // Create image element if it doesn't exist
            var preview = document.getElementById('avatar-preview');
            var placeholder = document.getElementById('avatar-placeholder');
            
            if (!preview) {
                preview = document.createElement('img');
                preview.id = 'avatar-preview';
                preview.className = 'rounded-circle border border-3 border-space-gold shadow mb-3';
                preview.style.width = '120px';
                preview.style.height = '120px';
                preview.style.objectFit = 'cover';
                
                if (placeholder) {
                    placeholder.parentNode.replaceChild(preview, placeholder);
                } else {
                    document.querySelector('.card-body').prepend(preview);
                }
            }
            
            preview.src = e.target.result;
        }
        
        reader.readAsDataURL(input.files[0]);
    }
}

// Form validation
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');
    const newPassword = document.getElementById('password');
    const confirmPassword = document.getElementById('password_confirmation');
    
    // Real-time password confirmation validation
    confirmPassword.addEventListener('input', function() {
        if (newPassword.value !== confirmPassword.value) {
            confirmPassword.setCustomValidity('Passwords do not match');
        } else {
            confirmPassword.setCustomValidity('');
        }
    });
});
</script>
@endsection