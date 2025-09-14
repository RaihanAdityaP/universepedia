@extends('layouts.app')

@section('title', $planet->name)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="text-light mb-1">
            <i class="bi bi-globe me-2"></i>{{ $planet->name }}
        </h1>
        <p class="text-light opacity-75 mb-0">Detailed exploration of this celestial body</p>
        <nav aria-label="breadcrumb" class="mt-2">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard') }}" class="text-space-gold text-decoration-none">
                        <i class="bi bi-house me-1"></i>Dashboard
                    </a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('planets.index') }}" class="text-space-gold text-decoration-none">
                        <i class="bi bi-globe me-1"></i>Planets
                    </a>
                </li>
                <li class="breadcrumb-item active text-light" aria-current="page">{{ $planet->name }}</li>
            </ol>
        </nav>
    </div>
    <div class="text-end">
        <p class="text-light opacity-75 mb-0">{{ now()->format('l, F j, Y') }}</p>
        <p class="text-space-gold mb-0">{{ now()->format('g:i A') }}</p>
        <small class="text-muted d-block">Local Time</small>
    </div>
</div>

<div class="row g-4">
    <!-- Main Content -->
    <div class="col-lg-8">
        <!-- Hero Image & Basic Info -->
        <div class="card space-card mb-4">
            <div class="position-relative">
                @if($planet->image)
                    <img src="{{ $planet->image_url }}" class="card-img-top" alt="{{ $planet->name }}" style="height: 400px; object-fit: cover;">
                @else
                    <div class="bg-gradient-space d-flex align-items-center justify-content-center" style="height: 400px;">
                        <i class="bi bi-globe text-light display-1 opacity-25"></i>
                    </div>
                @endif
                
                <!-- Overlay badges -->
                <div class="position-absolute top-0 end-0 m-3">
                    <span class="badge bg-{{ $planet->type_color }} planet-type-badge shadow me-2">
                        {{ ucfirst(str_replace('_', ' ', $planet->type)) }}
                    </span>
                    @if($planet->is_habitable)
                        <span class="badge bg-success shadow">
                            <i class="bi bi-check-circle me-1"></i>Potentially Habitable
                        </span>
                    @endif
                </div>
            </div>
            
            <div class="card-body">
                <div class="mb-4">
                    <h2 class="text-light mb-3">About {{ $planet->name }}</h2>
                    <p class="text-light opacity-85 lead">{{ $planet->description }}</p>
                </div>
            </div>
        </div>
        
        <!-- Detailed Information -->
        <div class="row g-4">
            <!-- Physical Characteristics -->
            <div class="col-md-6">
                <div class="card space-card h-100">
                    <div class="card-header bg-transparent border-bottom border-secondary">
                        <h6 class="text-light mb-0">
                            <i class="bi bi-rulers me-2"></i>Physical Characteristics
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="info-grid">
                            <div class="info-item d-flex justify-content-between align-items-center py-2 border-bottom border-secondary">
                                <span class="text-muted">
                                    <i class="bi bi-arrows-fullscreen me-2"></i>Size
                                </span>
                                <span class="text-light fw-semibold">{{ $planet->size }}</span>
                            </div>
                            
                            @if($planet->mass)
                                <div class="info-item d-flex justify-content-between align-items-center py-2 border-bottom border-secondary">
                                    <span class="text-muted">
                                        <i class="bi bi-weight me-2"></i>Mass
                                    </span>
                                    <span class="text-light fw-semibold">{{ $planet->mass }}</span>
                                </div>
                            @endif
                            
                            @if($planet->temperature)
                                <div class="info-item d-flex justify-content-between align-items-center py-2 border-bottom border-secondary">
                                    <span class="text-muted">
                                        <i class="bi bi-thermometer me-2"></i>Temperature
                                    </span>
                                    <span class="text-light fw-semibold">{{ $planet->temperature }}</span>
                                </div>
                            @endif
                            
                            <div class="info-item d-flex justify-content-between align-items-center py-2">
                                <span class="text-muted">
                                    <i class="bi bi-moon me-2"></i>Moons
                                </span>
                                <span class="text-light fw-semibold">
                                    {{ $planet->moons }}
                                    @if($planet->moons > 0)
                                        <small class="text-space-gold ms-1">natural satellites</small>
                                    @endif
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Orbital Information -->
            <div class="col-md-6">
                <div class="card space-card h-100">
                    <div class="card-header bg-transparent border-bottom border-secondary">
                        <h6 class="text-light mb-0">
                            <i class="bi bi-arrow-repeat me-2"></i>Orbital Information
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="info-grid">
                            <div class="info-item d-flex justify-content-between align-items-center py-2 border-bottom border-secondary">
                                <span class="text-muted">
                                    <i class="bi bi-sun me-2"></i>Distance from Sun
                                </span>
                                <span class="text-light fw-semibold">{{ $planet->distance_from_sun }}</span>
                            </div>
                            
                            @if($planet->orbital_period)
                                <div class="info-item d-flex justify-content-between align-items-center py-2 border-bottom border-secondary">
                                    <span class="text-muted">
                                        <i class="bi bi-arrow-clockwise me-2"></i>Orbital Period
                                    </span>
                                    <span class="text-light fw-semibold">{{ $planet->orbital_period }}</span>
                                </div>
                            @endif
                            
                            @if($planet->rotation_period)
                                <div class="info-item d-flex justify-content-between align-items-center py-2">
                                    <span class="text-muted">
                                        <i class="bi bi-arrow-counterclockwise me-2"></i>Rotation Period
                                    </span>
                                    <span class="text-light fw-semibold">{{ $planet->rotation_period }}</span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Sidebar -->
    <div class="col-lg-4">
        <!-- Quick Stats -->
        <div class="card space-card mb-4">
            <div class="card-header bg-transparent border-bottom border-secondary">
                <h6 class="text-light mb-0">
                    <i class="bi bi-graph-up me-2"></i>Quick Facts
                </h6>
            </div>
            <div class="card-body">
                <div class="row g-3 text-center">
                    <div class="col-6">
                        <div class="stat-box bg-dark bg-opacity-25 rounded p-3 border border-primary border-opacity-25">
                            <div class="text-primary h4 mb-1">{{ $planet->moons }}</div>
                            <small class="text-muted">Natural<br>Satellites</small>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="stat-box bg-dark bg-opacity-25 rounded p-3 border border-{{ $planet->is_habitable ? 'success' : 'secondary' }} border-opacity-25">
                            <div class="text-{{ $planet->is_habitable ? 'success' : 'secondary' }} h4 mb-1">
                                @if($planet->is_habitable)
                                    <i class="bi bi-check-circle"></i>
                                @else
                                    <i class="bi bi-x-circle"></i>
                                @endif
                            </div>
                            <small class="text-muted">Potentially<br>Habitable</small>
                        </div>
                    </div>
                </div>
                
                <hr class="border-secondary my-3">
                
                <!-- Planet Type Info -->
                <div class="text-center mb-3">
                    <span class="badge bg-{{ $planet->type_color }} planet-type-badge-large">
                        <i class="bi bi-tag me-1"></i>{{ ucfirst(str_replace('_', ' ', $planet->type)) }}
                    </span>
                </div>
                
                <hr class="border-secondary my-3">
                
                <!-- Timestamps -->
                <div class="text-center">
                    <small class="text-muted d-block mb-1">
                        <i class="bi bi-calendar-plus me-1"></i>
                        Added {{ $planet->created_at->format('M j, Y') }}
                    </small>
                    <small class="text-muted d-block mb-1">
                        {{ $planet->created_at->diffForHumans() }}
                    </small>
                    @if($planet->updated_at != $planet->created_at)
                        <small class="text-muted d-block">
                            <i class="bi bi-clock-history me-1"></i>
                            Updated {{ $planet->updated_at->diffForHumans() }}
                        </small>
                    @endif
                </div>
            </div>
        </div>
        
        <!-- Actions -->
        <div class="card space-card">
            <div class="card-header bg-transparent border-bottom border-secondary">
                <h6 class="text-light mb-0">
                    <i class="bi bi-gear me-2"></i>Actions
                </h6>
            </div>
            <div class="card-body">
                <div class="d-grid gap-3">
                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('planets.edit', $planet) }}" class="btn btn-warning">
                            <i class="bi bi-pencil me-2"></i>Edit Planet
                        </a>
                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">
                            <i class="bi bi-trash me-2"></i>Delete Planet
                        </button>
                        <hr class="border-secondary">
                    @endif
                    <a href="{{ route('planets.index') }}" class="btn btn-outline-light">
                        <i class="bi bi-arrow-left me-2"></i>Back to Planets
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Modal -->
@if(auth()->user()->isAdmin())
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-dark text-light border border-danger">
            <div class="modal-header border-bottom border-danger">
                <h5 class="modal-title">
                    <i class="bi bi-exclamation-triangle text-danger me-2"></i>Delete Planet
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p class="mb-3">Are you sure you want to permanently delete <strong>{{ $planet->name }}</strong>?</p>
                <div class="bg-dark bg-opacity-50 p-3 rounded border border-danger border-opacity-25">
                    <div class="d-flex align-items-center">
                        @if($planet->image)
                            <img src="{{ $planet->image_url }}" class="rounded me-3 border" width="60" height="60" style="object-fit: cover;">
                        @else
                            <div class="rounded bg-gradient-space d-flex align-items-center justify-content-center me-3 border" style="width: 60px; height: 60px;">
                                <i class="bi bi-globe text-white"></i>
                            </div>
                        @endif
                        <div>
                            <h6 class="text-light mb-1">{{ $planet->name }}</h6>
                            <small class="text-muted">{{ ucfirst(str_replace('_', ' ', $planet->type)) }} Planet</small>
                            @if($planet->is_habitable)
                                <div class="mt-1">
                                    <span class="badge bg-success badge-sm">Habitable</span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <p class="text-danger mt-3 mb-0">
                    <i class="bi bi-exclamation-triangle me-1"></i>
                    This action cannot be undone. All planet data will be permanently removed.
                </p>
            </div>
            <div class="modal-footer border-top border-secondary">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    Cancel
                </button>
                <form action="{{ route('planets.destroy', $planet) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="bi bi-trash me-1"></i>Delete Forever
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endif

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

.planet-type-badge {
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.1);
}

.planet-type-badge-large {
    padding: 0.5rem 1rem;
    font-size: 0.9rem;
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.1);
}

.info-item {
    transition: all 0.2s ease;
}

.info-item:hover {
    background-color: rgba(255, 255, 255, 0.05);
    transform: translateX(3px);
}

.stat-box {
    transition: all 0.3s ease;
}

.stat-box:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
}

.info-grid .info-item:last-child {
    border-bottom: none !important;
}

.badge-sm {
    font-size: 0.7rem;
    padding: 0.25rem 0.5rem;
}
</style>
@endsection