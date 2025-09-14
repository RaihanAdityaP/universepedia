@extends('layouts.app')

@section('title', 'My Profile')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="text-light mb-1">
            <i class="bi bi-person-circle me-2"></i>My Profile
        </h1>
        <p class="text-light opacity-75 mb-0">Manage your cosmic journey and account information</p>
        <div class="mt-2">
            @if(auth()->user()->isAdmin())
                <small class="badge bg-warning text-dark me-2">
                    <i class="bi bi-shield-check me-1"></i>Administrator
                </small>
            @else
                <small class="badge bg-info me-2">
                    <i class="bi bi-rocket me-1"></i>Space Explorer
                </small>
            @endif
            <small class="badge bg-success">
                <i class="bi bi-calendar-check me-1"></i>Member since {{ auth()->user()->created_at->format('M Y') }}
            </small>
        </div>
    </div>
    <div class="text-end">
        <p class="text-light opacity-75 mb-0">{{ now()->format('l, F j, Y') }}</p>
        <p class="text-space-gold mb-0">{{ now()->format('g:i A') }}</p>
        <small class="text-muted d-block">Local Time</small>
    </div>
</div>

<div class="row g-4">
    <!-- Avatar and Quick Info -->
    <div class="col-lg-4">
        <div class="card space-card h-100">
            <div class="card-body text-center">
                <div class="position-relative d-inline-block mb-3">
                    @if(auth()->user()->avatar)
                        <img src="{{ asset('storage/' . auth()->user()->avatar) }}" 
                             class="rounded-circle border border-3 border-space-gold shadow" 
                             width="120" height="120" style="object-fit: cover;">
                    @else
                        <div class="rounded-circle bg-gradient-space d-flex align-items-center justify-content-center shadow" 
                             style="width: 120px; height: 120px;">
                            <i class="bi bi-person-circle text-white" style="font-size: 4rem;"></i>
                        </div>
                    @endif
                    <span class="position-absolute bottom-0 end-0 bg-success rounded-circle border border-2 border-white" 
                          style="width: 20px; height: 20px;" title="Online"></span>
                </div>
                
                <h5 class="text-light mb-1">{{ auth()->user()->name }}</h5>
                <p class="text-muted mb-2">{{ auth()->user()->email }}</p>
                
                @if(auth()->user()->bio)
                    <div class="mt-3 p-3 bg-dark bg-opacity-25 rounded">
                        <small class="text-light opacity-75">
                            <i class="bi bi-quote me-1"></i>{{ auth()->user()->bio }}
                        </small>
                    </div>
                @endif
                
                <div class="mt-3">
                    <a href="{{ route('profile.edit') }}" class="btn btn-primary btn-sm">
                        <i class="bi bi-pencil-square me-1"></i>Edit Profile
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Profile Details -->
    <div class="col-lg-8">
        <div class="card space-card h-100">
            <div class="card-header bg-transparent border-bottom border-secondary">
                <h5 class="text-light mb-0">
                    <i class="bi bi-person-badge me-2"></i>Account Information
                </h5>
            </div>
            <div class="card-body">
                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="info-item p-3 rounded bg-dark bg-opacity-25">
                            <div class="d-flex align-items-center mb-2">
                                <i class="bi bi-person-fill text-space-gold me-2"></i>
                                <small class="text-muted text-uppercase fw-bold">Full Name</small>
                            </div>
                            <p class="text-light mb-0">{{ auth()->user()->name }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-item p-3 rounded bg-dark bg-opacity-25">
                            <div class="d-flex align-items-center mb-2">
                                <i class="bi bi-envelope-fill text-space-gold me-2"></i>
                                <small class="text-muted text-uppercase fw-bold">Email Address</small>
                            </div>
                            <p class="text-light mb-0">{{ auth()->user()->email }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-item p-3 rounded bg-dark bg-opacity-25">
                            <div class="d-flex align-items-center mb-2">
                                <i class="bi bi-calendar-plus text-space-gold me-2"></i>
                                <small class="text-muted text-uppercase fw-bold">Joined Date</small>
                            </div>
                            <p class="text-light mb-0">{{ auth()->user()->created_at->format('F j, Y') }}</p>
                            <small class="text-muted">{{ auth()->user()->created_at->diffForHumans() }}</small>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-item p-3 rounded bg-dark bg-opacity-25">
                            <div class="d-flex align-items-center mb-2">
                                <i class="bi bi-clock-history text-space-gold me-2"></i>
                                <small class="text-muted text-uppercase fw-bold">Last Updated</small>
                            </div>
                            <p class="text-light mb-0">{{ auth()->user()->updated_at->format('M j, Y') }}</p>
                            <small class="text-muted">{{ auth()->user()->updated_at->diffForHumans() }}</small>
                        </div>
                    </div>
                </div>
                
                @if(auth()->user()->bio)
                    <div class="mt-4">
                        <div class="info-item p-3 rounded bg-dark bg-opacity-25">
                            <div class="d-flex align-items-center mb-2">
                                <i class="bi bi-chat-quote text-space-gold me-2"></i>
                                <small class="text-muted text-uppercase fw-bold">Biography</small>
                            </div>
                            <p class="text-light mb-0">{{ auth()->user()->bio }}</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Activity Stats -->
<div class="row g-4 mt-2">
    <div class="col-12">
        <div class="card space-card">
            <div class="card-header bg-transparent border-bottom border-secondary">
                <h5 class="text-light mb-0">
                    <i class="bi bi-graph-up me-2"></i>Space Explorer Statistics
                </h5>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-3">
                        <div class="stat-card text-center p-3 rounded bg-primary bg-opacity-10 border border-primary border-opacity-25">
                            <i class="bi bi-calendar-event display-6 text-primary mb-2"></i>
                            <h4 class="text-light mb-1">{{ \App\Models\Event::count() }}</h4>
                            <small class="text-muted">Total Events</small>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stat-card text-center p-3 rounded bg-info bg-opacity-10 border border-info border-opacity-25">
                            <i class="bi bi-globe display-6 text-info mb-2"></i>
                            <h4 class="text-light mb-1">{{ \App\Models\Planet::count() }}</h4>
                            <small class="text-muted">Planets Cataloged</small>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stat-card text-center p-3 rounded bg-success bg-opacity-10 border border-success border-opacity-25">
                            <i class="bi bi-person-check display-6 text-success mb-2"></i>
                            <h4 class="text-light mb-1">{{ \App\Models\User::count() }}</h4>
                            <small class="text-muted">Fellow Explorers</small>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stat-card text-center p-3 rounded bg-warning bg-opacity-10 border border-warning border-opacity-25">
                            <i class="bi bi-star display-6 text-warning mb-2"></i>
                            <h4 class="text-light mb-1">{{ floor(auth()->user()->created_at->diffInDays()) }}</h4>
                            <small class="text-muted">Days Exploring</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="row g-4 mt-2">
    <div class="col-12">
        <div class="card space-card">
            <div class="card-header bg-transparent border-bottom border-secondary">
                <h5 class="text-light mb-0">
                    <i class="bi bi-lightning me-2"></i>Quick Actions
                </h5>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    @if(auth()->user()->role === 'admin')
                        <div class="col-md-4">
                            <a href="{{ route('users.index') }}" class="btn btn-outline-success w-100 h-100 d-flex flex-column align-items-center justify-content-center py-3">
                                <i class="bi bi-people mb-2" style="font-size: 2rem;"></i>
                                <span>Manage Users</span>
                            </a>
                        </div>
                        <div class="col-md-4">
                            <a href="{{ route('events.index') }}" class="btn btn-outline-primary w-100 h-100 d-flex flex-column align-items-center justify-content-center py-3">
                                <i class="bi bi-calendar-event mb-2" style="font-size: 2rem;"></i>
                                <span>View Events</span>
                            </a>
                        </div>
                        <div class="col-md-4">
                            <a href="{{ route('planets.index') }}" class="btn btn-outline-warning w-100 h-100 d-flex flex-column align-items-center justify-content-center py-3">
                                <i class="bi bi-globe mb-2" style="font-size: 2rem;"></i>
                                <span>View Planets</span>
                            </a>
                        </div>
                    @else
                        <div class="col-md-6">
                            <a href="{{ route('events.index') }}" class="btn btn-outline-primary w-100 h-100 d-flex flex-column align-items-center justify-content-center py-3">
                                <i class="bi bi-calendar-event mb-2" style="font-size: 2rem;"></i>
                                <span>View Events</span>
                            </a>
                        </div>
                        <div class="col-md-6">
                            <a href="{{ route('planets.index') }}" class="btn btn-outline-warning w-100 h-100 d-flex flex-column align-items-center justify-content-center py-3">
                                <i class="bi bi-globe mb-2" style="font-size: 2rem;"></i>
                                <span>View Planets</span>
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.bg-gradient-space {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.info-item {
    transition: all 0.3s ease;
}

.info-item:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(0,0,0,0.2);
}

.stat-card {
    transition: all 0.3s ease;
    min-height: 150px;
    display: flex;
    flex-direction: column;
    justify-content: center;
}

.stat-card:hover {
    transform: translateY(-5px);
}
</style>
@endsection