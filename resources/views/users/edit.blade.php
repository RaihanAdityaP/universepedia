@extends('layouts.app')

@section('title', 'Edit User')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="text-light mb-1">
            <i class="bi bi-person-gear me-2"></i>Edit User
        </h1>
        <p class="text-light opacity-75 mb-0">Modify user information and permissions</p>
        <nav aria-label="breadcrumb" class="mt-2">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard') }}" class="text-space-gold text-decoration-none">
                        <i class="bi bi-house me-1"></i>Dashboard
                    </a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('users.index') }}" class="text-space-gold text-decoration-none">
                        <i class="bi bi-people me-1"></i>Users
                    </a>
                </li>
                <li class="breadcrumb-item active text-light" aria-current="page">Edit</li>
            </ol>
        </nav>
    </div>
    <div class="text-end">
        <p class="text-light opacity-75 mb-0">{{ now()->format('l, F j, Y') }}</p>
        <p class="text-space-gold mb-0">{{ now()->format('g:i A') }}</p>
        <small class="text-muted d-block">Local Time</small>
    </div>
</div>

@if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="bi bi-exclamation-triangle me-2"></i>
        <strong>Please fix the following errors:</strong>
        <ul class="mb-0 mt-2">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="row g-4">
    <!-- User Info Card -->
    <div class="col-lg-4">
        <div class="card space-card h-100">
            <div class="card-header bg-transparent border-bottom border-secondary">
                <h6 class="text-light mb-0">
                    <i class="bi bi-info-circle me-2"></i>User Information
                </h6>
            </div>
            <div class="card-body text-center">
                <div class="position-relative d-inline-block mb-3">
                    @if($user->avatar)
                        <img src="{{ asset('storage/' . $user->avatar) }}" 
                             class="rounded-circle border border-3 border-space-gold shadow" 
                             width="100" height="100" style="object-fit: cover;">
                    @else
                        <div class="rounded-circle bg-gradient-space d-flex align-items-center justify-content-center shadow" 
                             style="width: 100px; height: 100px;">
                            <i class="bi bi-person text-white" style="font-size: 3rem;"></i>
                        </div>
                    @endif
                    <span class="position-absolute bottom-0 end-0 bg-{{ $user->role === 'admin' ? 'warning' : 'info' }} rounded-circle border border-2 border-white" 
                          style="width: 24px; height: 24px;" 
                          title="{{ $user->role === 'admin' ? 'Administrator' : 'Space Explorer' }}">
                        <i class="bi bi-{{ $user->role === 'admin' ? 'shield-check' : 'rocket' }} text-{{ $user->role === 'admin' ? 'dark' : 'white' }}" style="font-size: 0.7rem; margin-top: 3px; margin-left: 3px;"></i>
                    </span>
                </div>
                
                <h6 class="text-light mb-1">{{ $user->name }}</h6>
                <p class="text-muted mb-2">{{ $user->email }}</p>
                
                @if($user->role === 'admin')
                    <span class="badge bg-warning text-dark">
                        <i class="bi bi-shield-check me-1"></i>Administrator
                    </span>
                @else
                    <span class="badge bg-info">
                        <i class="bi bi-rocket me-1"></i>Space Explorer
                    </span>
                @endif
                
                <div class="mt-3 pt-3 border-top border-secondary">
                    <small class="text-muted d-block">
                        <i class="bi bi-calendar-plus me-1"></i>
                        Member since {{ $user->created_at->format('M j, Y') }}
                    </small>
                    <small class="text-muted d-block mt-1">
                        <i class="bi bi-clock-history me-1"></i>
                        Last updated {{ $user->updated_at->diffForHumans() }}
                    </small>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Edit Form -->
    <div class="col-lg-8">
        <div class="card space-card h-100">
            <div class="card-header bg-transparent border-bottom border-secondary">
                <h6 class="text-light mb-0">
                    <i class="bi bi-pencil-square me-2"></i>Edit Details
                </h6>
            </div>
            <div class="card-body">
                <form action="{{ route('users.update', $user->id) }}" method="POST" id="editUserForm">
                    @csrf
                    @method('PUT')

                    <div class="row g-4">
                        <div class="col-md-12">
                            <label for="name" class="form-label text-light">
                                <i class="bi bi-person me-1"></i>Full Name
                            </label>
                            <input type="text" 
                                   name="name" 
                                   id="name" 
                                   value="{{ old('name', $user->name) }}" 
                                   class="form-control bg-dark text-light border-secondary @error('name') is-invalid @enderror" 
                                   required
                                   placeholder="Enter full name">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-12">
                            <label for="email" class="form-label text-light">
                                <i class="bi bi-envelope me-1"></i>Email Address
                            </label>
                            <input type="email" 
                                   name="email" 
                                   id="email" 
                                   value="{{ old('email', $user->email) }}" 
                                   class="form-control bg-dark text-light border-secondary @error('email') is-invalid @enderror" 
                                   required
                                   placeholder="Enter email address">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-12">
                            <label for="role" class="form-label text-light">
                                <i class="bi bi-shield me-1"></i>User Role
                            </label>
                            <select name="role" 
                                    id="role" 
                                    class="form-select bg-dark text-light border-secondary @error('role') is-invalid @enderror" 
                                    required>
                                <option value="">Select role...</option>
                                <option value="user" {{ old('role', $user->role) === 'user' ? 'selected' : '' }}>
                                    Space Explorer (User)
                                </option>
                                <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>
                                    Administrator (Admin)
                                </option>
                            </select>
                            @error('role')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">
                                <i class="bi bi-info-circle me-1"></i>
                                Administrators have full system access. Space Explorers can view content only.
                            </small>
                        </div>

                        @if($user->bio)
                        <div class="col-md-12">
                            <label class="form-label text-light">
                                <i class="bi bi-chat-quote me-1"></i>Current Biography
                            </label>
                            <div class="bg-dark bg-opacity-50 p-3 rounded border border-secondary">
                                <p class="text-light mb-0">{{ $user->bio }}</p>
                            </div>
                            <small class="form-text text-muted">
                                Biography can be edited from the profile page
                            </small>
                        </div>
                        @endif
                    </div>

                    <div class="d-flex justify-content-between align-items-center mt-4 pt-4 border-top border-secondary">
                        <div>
                            @if($user->id === auth()->id())
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-exclamation-triangle text-warning me-2"></i>
                                    <small class="text-warning">You are editing your own account</small>
                                </div>
                            @endif
                        </div>
                        <div class="d-flex gap-2">
                            <a href="{{ route('users.index') }}" class="btn btn-outline-secondary">
                                <i class="bi bi-arrow-left me-1"></i>Cancel
                            </a>
                            <button type="submit" class="btn btn-success" id="updateBtn">
                                <i class="bi bi-check2 me-1"></i>Update User
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Confirmation Modal for Role Changes -->
<div class="modal fade" id="roleChangeModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-dark text-light border border-warning">
            <div class="modal-header border-bottom border-warning">
                <h5 class="modal-title">
                    <i class="bi bi-exclamation-triangle text-warning me-2"></i>Confirm Role Change
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p class="mb-3">You are about to change this user's role. This will affect their system permissions.</p>
                <div class="bg-warning bg-opacity-10 p-3 rounded border border-warning border-opacity-25">
                    <p class="text-warning mb-2">
                        <i class="bi bi-info-circle me-1"></i><strong>Important:</strong>
                    </p>
                    <ul class="text-light mb-0">
                        <li><strong>Administrator:</strong> Full system access, can manage all content</li>
                        <li><strong>Space Explorer:</strong> View-only access to planets and events</li>
                    </ul>
                </div>
                <p class="text-light mt-3 mb-0">Do you want to continue?</p>
            </div>
            <div class="modal-footer border-top border-secondary">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    Cancel
                </button>
                <button type="button" class="btn btn-warning" id="confirmRoleChange">
                    <i class="bi bi-check2 me-1"></i>Confirm Changes
                </button>
            </div>
        </div>
    </div>
</div>

<style>
.bg-gradient-space {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.breadcrumb {
    background: transparent;
    padding: 0;
    margin: 0;
}

.breadcrumb-item + .breadcrumb-item::before {
    content: "›";
    color: #6c757d;
}

.form-control:focus,
.form-select:focus {
    border-color: #ffc107;
    box-shadow: 0 0 0 0.2rem rgba(255, 193, 7, 0.25);
}

.is-invalid {
    border-color: #dc3545 !important;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('editUserForm');
    const roleSelect = document.getElementById('role');
    const updateBtn = document.getElementById('updateBtn');
    const roleChangeModal = new bootstrap.Modal(document.getElementById('roleChangeModal'));
    const confirmBtn = document.getElementById('confirmRoleChange');
    
    let originalRole = '{{ $user->role }}';
    let formSubmissionPending = false;
    
    form.addEventListener('submit', function(e) {
        if (formSubmissionPending) return;
        
        const currentRole = roleSelect.value;
        
        // Check if role has changed
        if (currentRole !== originalRole) {
            e.preventDefault();
            roleChangeModal.show();
            return;
        }
        
        // Normal submission
        updateBtn.innerHTML = '<i class="bi bi-hourglass-split me-1"></i>Updating...';
        updateBtn.disabled = true;
    });
    
    confirmBtn.addEventListener('click', function() {
        formSubmissionPending = true;
        roleChangeModal.hide();
        updateBtn.innerHTML = '<i class="bi bi-hourglass-split me-1"></i>Updating...';
        updateBtn.disabled = true;
        form.submit();
    });
});
</script>
@endsection