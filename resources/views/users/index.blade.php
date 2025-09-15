@extends('layouts.app')

@section('title', 'User Management')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="text-light mb-1">
            <i class="bi bi-people me-2"></i>User Management
        </h1>
        <p class="text-light opacity-75 mb-0">Manage space explorers and administrators</p>
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" class="mt-2">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard') }}" class="text-space-gold text-decoration-none">
                        <i class="bi bi-house me-1"></i>Dashboard
                    </a>
                </li>
                <li class="breadcrumb-item active text-light" aria-current="page">Users</li>
            </ol>
        </nav>
    </div>
    <div class="text-end">
        <p class="text-light opacity-75 mb-0">{{ now()->format('l, F j, Y') }}</p>
        <p class="text-space-gold mb-0">{{ now()->format('g:i A') }}</p>
        <small class="text-muted d-block">Local Time</small>
    </div>
</div>

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show d-flex align-items-center" role="alert">
    <i class="bi bi-check-circle me-2"></i>
    <div>{{ session('success') }}</div>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

@if(session('error'))
<div class="alert alert-danger alert-dismissible fade show d-flex align-items-center" role="alert">
    <i class="bi bi-exclamation-triangle me-2"></i>
    <div>{{ session('error') }}</div>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

<!-- Statistics Cards -->
<div class="row g-4 mb-4">
    <div class="col-md-4">
        <div class="card space-card stats-card">
            <div class="card-body text-center">
                <i class="bi bi-people display-6 text-primary mb-2"></i>
                <h4 class="text-light mb-1">{{ $users->total() }}</h4>
                <small class="text-muted">Total Users</small>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card space-card stats-card">
            <div class="card-body text-center">
                <i class="bi bi-shield-check display-6 text-warning mb-2"></i>
                <h4 class="text-light mb-1">{{ $users->where('role', 'admin')->count() }}</h4>
                <small class="text-muted">Administrators</small>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card space-card stats-card">
            <div class="card-body text-center">
                <i class="bi bi-rocket display-6 text-info mb-2"></i>
                <h4 class="text-light mb-1">{{ $users->where('role', 'user')->count() }}</h4>
                <small class="text-muted">Space Explorers</small>
            </div>
        </div>
    </div>
</div>

<div class="card space-card">
    <div class="card-header bg-transparent border-bottom border-secondary d-flex justify-content-between align-items-center">
        <h5 class="text-light mb-0">
            <i class="bi bi-list me-2"></i>User Directory
        </h5>
        <div class="d-flex gap-2">
            <small class="text-muted align-self-center">{{ $users->count() }} of {{ $users->total() }} users</small>
        </div>
    </div>
    <div class="card-body p-0">
        @if($users->count() > 0)
        <div class="table-responsive">
            <table class="table table-dark table-hover mb-0 align-middle">
                <thead class="table-secondary">
                    <tr>
                        <th class="ps-4" style="width: 60px;">
                            <i class="bi bi-hash"></i>
                        </th>
                        <th style="width: 250px;">
                            <i class="bi bi-person me-1"></i>User
                        </th>
                        <th>
                            <i class="bi bi-envelope me-1"></i>Email
                        </th>
                        <th style="width: 120px;">
                            <i class="bi bi-shield me-1"></i>Role
                        </th>
                        <th style="width: 140px;">
                            <i class="bi bi-calendar-plus me-1"></i>Joined
                        </th>
                        <th style="width: 160px;" class="text-center">
                            <i class="bi bi-gear me-1"></i>Actions
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $index => $user)
                    <tr class="user-row">
                        <td class="ps-4">
                            <span class="text-muted fw-semibold">{{ ($users->currentPage() - 1) * $users->perPage() + $index + 1 }}</span>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                @if($user->avatar)
                                <img src="{{ asset('storage/' . $user->avatar) }}" 
                                     class="rounded-circle me-3 border border-2 border-space-gold" 
                                     width="40" height="40" style="object-fit: cover;">
                                @else
                                <div class="rounded-circle bg-gradient-space d-flex align-items-center justify-content-center me-3" 
                                     style="width: 40px; height: 40px;">
                                    <i class="bi bi-person text-white"></i>
                                </div>
                                @endif
                                <div>
                                    <h6 class="text-light mb-0 fw-semibold">{{ $user->name }}</h6>
                                    @if($user->id === auth()->id())
                                        <small class="text-success">
                                            <i class="bi bi-person-check me-1"></i>You
                                        </small>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="text-light">{{ $user->email }}</span>
                        </td>
                        <td>
                            @if($user->role === 'admin')
                                <span class="badge bg-warning text-dark">
                                    <i class="bi bi-shield-check me-1"></i>Administrator
                                </span>
                            @else
                                <span class="badge bg-info">
                                    <i class="bi bi-rocket me-1"></i>Space Explorer
                                </span>
                            @endif
                        </td>
                        <td>
                            <div>
                                <span class="text-light d-block">{{ $user->created_at->format('M j, Y') }}</span>
                                <small class="text-muted">{{ $user->created_at->diffForHumans() }}</small>
                            </div>
                        </td>
                        <td class="text-center">
                            <!-- FIXED: Removed btn-group yang menyebabkan tombol tidak clickable -->
                            <div class="d-flex gap-1 justify-content-center">
                                <a href="{{ route('users.edit', $user->id) }}" 
                                   class="btn btn-outline-primary btn-sm"
                                   title="Edit User">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                @if($user->id !== auth()->id())
                                    <button type="button" 
                                            class="btn btn-outline-danger btn-sm delete-user-btn" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#deleteModal{{ $user->id }}"
                                            title="Delete User"
                                            style="z-index: 10; position: relative;">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="text-center py-5">
            <i class="bi bi-people text-muted display-1 mb-3"></i>
            <h5 class="text-muted">No Users Found</h5>
            <p class="text-muted mb-0">The user directory is currently empty.</p>
        </div>
        @endif
    </div>

    @if($users->hasPages())
    <div class="card-footer bg-transparent border-top border-secondary">
        <div class="d-flex justify-content-between align-items-center">
            <small class="text-muted">
                Showing {{ $users->firstItem() }} to {{ $users->lastItem() }} of {{ $users->total() }} users
            </small>
            <div>
                {{ $users->links() }}
            </div>
        </div>
    </div>
    @endif
</div>

<!-- Delete Modals - Moved outside the table -->
@foreach($users as $user)
    @if($user->id !== auth()->id())
    <div class="modal fade" id="deleteModal{{ $user->id }}" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content bg-dark text-light border border-danger">
                <div class="modal-header border-bottom border-danger">
                    <h5 class="modal-title">
                        <i class="bi bi-exclamation-triangle text-danger me-2"></i>Confirm Deletion
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p class="mb-3">Are you sure you want to delete this user?</p>
                    <div class="bg-dark bg-opacity-50 p-3 rounded">
                        <div class="d-flex align-items-center">
                            @if($user->avatar)
                                <img src="{{ asset('storage/' . $user->avatar) }}" 
                                     class="rounded-circle me-3 border" 
                                     width="50" height="50" style="object-fit: cover;">
                            @else
                                <div class="rounded-circle bg-gradient-space d-flex align-items-center justify-content-center me-3" 
                                     style="width: 50px; height: 50px;">
                                    <i class="bi bi-person text-white"></i>
                                </div>
                            @endif
                            <div>
                                <h6 class="text-light mb-1">{{ $user->name }}</h6>
                                <small class="text-muted">{{ $user->email }}</small>
                            </div>
                        </div>
                    </div>
                    <p class="text-danger mt-3 mb-0">
                        <i class="bi bi-info-circle me-1"></i>
                        This action cannot be undone.
                    </p>
                </div>
                <div class="modal-footer border-top border-secondary">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        Cancel
                    </button>
                    <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="bi bi-trash me-1"></i>Delete User
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endif
@endforeach

<style>
.space-card {
    background: rgba(0, 0, 0, 0.7);
    border: 1px solid rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
}

.text-space-gold {
    color: #ffc107;
}

.border-space-gold {
    border-color: #ffc107 !important;
}

.bg-gradient-space {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.stats-card {
    transition: all 0.3s ease;
}

.stats-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
}

.user-row {
    transition: all 0.2s ease;
}

.user-row:hover {
    transform: translateX(5px);
    background-color: rgba(255, 255, 255, 0.05) !important;
}

/* FIXED: Better button styling tanpa btn-group yang bermasalah */
.delete-user-btn {
    cursor: pointer !important;
    pointer-events: auto !important;
}

.delete-user-btn:hover {
    background-color: #dc3545 !important;
    color: white !important;
    border-color: #dc3545 !important;
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

/* Ensure buttons are always clickable */
.btn {
    cursor: pointer !important;
    pointer-events: auto !important;
    z-index: 1;
}

.table td {
    position: relative;
}
</style>

@push('scripts')
<script>
// Additional JavaScript to ensure delete buttons work
document.addEventListener('DOMContentLoaded', function() {
    // Force enable all delete buttons
    document.querySelectorAll('.delete-user-btn').forEach(function(btn) {
        btn.style.pointerEvents = 'auto';
        btn.style.cursor = 'pointer';
        
        // Add click handler as backup
        btn.addEventListener('click', function(e) {
            e.stopPropagation();
            console.log('Delete button clicked for modal:', this.getAttribute('data-bs-target'));
        });
    });
    
    console.log('Delete buttons initialized:', document.querySelectorAll('.delete-user-btn').length);
});
</script>
@endpush
@endsection