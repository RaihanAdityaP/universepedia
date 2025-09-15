@extends('layouts.app')

@section('title', 'Planets')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="text-light mb-1">
            <i class="bi bi-globe me-2"></i>Planets
        </h1>
        <p class="text-light opacity-75 mb-0">Explore the wonders of our solar system and beyond</p>
        <nav aria-label="breadcrumb" class="mt-2">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard') }}" class="text-space-gold text-decoration-none">
                        <i class="bi bi-house me-1"></i>Dashboard
                    </a>
                </li>
                <li class="breadcrumb-item active text-light" aria-current="page">Planets</li>
            </ol>
        </nav>
    </div>
    <div class="text-end">
        <div class="mb-2">
            @if(auth()->user()->isAdmin())
                <a href="{{ route('planets.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus me-2"></i>Add Planet
                </a>
            @endif
        </div>
        <p class="text-light opacity-75 mb-0">{{ now()->format('l, F j, Y') }}</p>
        <p class="text-space-gold mb-0">{{ now()->format('g:i A') }}</p>
        <small class="text-muted d-block">Local Time</small>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="card space-card">
            <div class="card-body text-center">
                <i class="bi bi-globe display-6 text-primary mb-2"></i>
                <h4 class="text-light mb-1">{{ $planets->total() ?? $planets->count() }}</h4>
                <small class="text-muted">Total Planets</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card space-card">
            <div class="card-body text-center">
                <i class="bi bi-check-circle display-6 text-success mb-2"></i>
                <h4 class="text-light mb-1">{{ $planets->where('is_habitable', true)->count() }}</h4>
                <small class="text-muted">Habitable Worlds</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card space-card">
            <div class="card-body text-center">
                <i class="bi bi-collection display-6 text-info mb-2"></i>
                <h4 class="text-light mb-1">{{ $types->count() }}</h4>
                <small class="text-muted">Planet Types</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card space-card">
            <div class="card-body text-center">
                <i class="bi bi-moon display-6 text-warning mb-2"></i>
                <h4 class="text-light mb-1">{{ $planets->sum('moons') }}</h4>
                <small class="text-muted">Total Moons</small>
            </div>
        </div>
    </div>
</div>

<!-- Search and Filter -->
<div class="card space-card mb-4">
    <div class="card-header bg-transparent border-bottom border-secondary">
        <h6 class="text-light mb-0">
            <i class="bi bi-funnel me-2"></i>Explore & Filter
        </h6>
    </div>
    <div class="card-body">
        <form method="GET" action="{{ route('planets.index') }}" class="row g-3">
            <div class="col-md-5">
                <label class="form-label text-light small mb-2">
                    <i class="bi bi-search me-1"></i>Search Planets
                </label>
                <div class="input-group">
                    <span class="input-group-text bg-dark border-secondary text-light">
                        <i class="bi bi-search"></i>
                    </span>
                    <input type="text" class="form-control bg-dark border-secondary text-light" 
                           name="search" value="{{ request('search') }}" 
                           placeholder="Search by name or description...">
                </div>
            </div>
            <div class="col-md-4">
                <label class="form-label text-light small mb-2">
                    <i class="bi bi-tag me-1"></i>Planet Type
                </label>
                <select name="type" class="form-select bg-dark border-secondary text-light">
                    <option value="">All Types</option>
                    @foreach($types as $type)
                        <option value="{{ $type }}" {{ request('type') == $type ? 'selected' : '' }}>
                            {{ ucfirst(str_replace('_', ' ', $type)) }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label text-light small mb-2 d-block">&nbsp;</label>
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-outline-light">
                        <i class="bi bi-funnel me-1"></i>Apply Filters
                    </button>
                </div>
            </div>
        </form>
        
        @if(request()->hasAny(['search', 'type']))
            <div class="mt-3 pt-3 border-top border-secondary">
                <div class="d-flex justify-content-between align-items-center">
                    <small class="text-muted">
                        <i class="bi bi-info-circle me-1"></i>
                        Showing filtered results for: 
                        @if(request('search'))
                            <span class="text-light">"{{ request('search') }}"</span>
                        @endif
                        @if(request('type'))
                            <span class="badge bg-secondary ms-1">{{ ucfirst(str_replace('_', ' ', request('type'))) }}</span>
                        @endif
                    </small>
                    <a href="{{ route('planets.index') }}" class="btn btn-outline-secondary btn-sm">
                        <i class="bi bi-x me-1"></i>Clear Filters
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>

<!-- Planets Grid -->
<div class="row g-4">
    @forelse($planets as $planet)
        <div class="col-lg-4 col-md-6">
            <div class="card space-card h-100 planet-card">
                <div class="position-relative">
                    @if($planet->image)
                        <img src="{{ $planet->image_url }}" class="card-img-top" alt="{{ $planet->name }}" style="height: 200px; object-fit: cover;">
                    @else
                        <div class="bg-gradient-space d-flex align-items-center justify-content-center" style="height: 200px;">
                            <i class="bi bi-globe text-light display-1 opacity-25"></i>
                        </div>
                    @endif
                    
                    <!-- Planet Type Badge -->
                    <div class="position-absolute top-0 end-0 m-2">
                        <span class="badge bg-{{ $planet->type_color }} planet-type-badge shadow">
                            {{ ucfirst(str_replace('_', ' ', $planet->type)) }}
                        </span>
                    </div>
                    
                    <!-- Status Indicators -->
                    <div class="position-absolute top-0 start-0 m-2">
                        @if($planet->is_habitable)
                            <span class="badge bg-success shadow mb-1 d-block">
                                <i class="bi bi-check-circle me-1"></i>Habitable
                            </span>
                        @endif
                        @if($planet->has_rings)
                            <span class="badge bg-warning text-dark shadow">
                                <i class="bi bi-circle me-1"></i>Rings
                            </span>
                        @endif
                    </div>
                </div>
                
                <div class="card-body d-flex flex-column">
                    <div class="mb-3">
                        <h5 class="card-title text-light mb-2">{{ $planet->name }}</h5>
                        <p class="card-text text-light opacity-75 flex-grow-1">
                            {{ Str::limit($planet->description, 120) }}
                        </p>
                    </div>
                    
                    <!-- Planet Info Grid -->
                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <div class="info-box bg-dark bg-opacity-25 rounded p-2 text-center">
                                <i class="bi bi-rulers text-space-gold d-block mb-1"></i>
                                <small class="text-muted d-block">Distance</small>
                                <small class="text-light fw-semibold">{{ Str::limit($planet->distance_from_sun ?? 'Unknown', 20) }}</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="info-box bg-dark bg-opacity-25 rounded p-2 text-center">
                                <i class="bi bi-moon text-space-gold d-block mb-1"></i>
                                <small class="text-muted d-block">Moons</small>
                                <small class="text-light fw-semibold">{{ $planet->moons ?? 0 }}</small>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Action Buttons -->
                    <div class="mt-auto">
                        <div class="d-grid gap-2">
                            <a href="{{ route('planets.show', $planet) }}" class="btn btn-outline-light btn-sm">
                                <i class="bi bi-eye me-1"></i>Explore Planet
                            </a>
                            @if(auth()->user()->isAdmin())
                                <div class="btn-group btn-group-sm" role="group">
                                    <a href="{{ route('planets.edit', $planet) }}" class="btn btn-outline-warning">
                                        <i class="bi bi-pencil me-1"></i>Edit
                                    </a>
                                    <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $planet->id }}">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Delete Modal -->
        @if(auth()->user()->isAdmin())
        <div class="modal fade" id="deleteModal{{ $planet->id }}" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content bg-dark text-light border border-danger">
                    <div class="modal-header border-bottom border-danger">
                        <h5 class="modal-title">
                            <i class="bi bi-exclamation-triangle text-danger me-2"></i>Delete Planet
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <p class="mb-3">Are you sure you want to delete <strong>{{ $planet->name }}</strong>?</p>
                        <div class="bg-dark bg-opacity-50 p-3 rounded">
                            <div class="d-flex align-items-center">
                                @if($planet->image)
                                    <img src="{{ $planet->image_url }}" class="rounded me-3" width="60" height="60" style="object-fit: cover;">
                                @else
                                    <div class="rounded bg-gradient-space d-flex align-items-center justify-content-center me-3" style="width: 60px; height: 60px;">
                                        <i class="bi bi-globe text-white"></i>
                                    </div>
                                @endif
                                <div>
                                    <h6 class="text-light mb-1">{{ $planet->name }}</h6>
                                    <small class="text-muted">{{ ucfirst(str_replace('_', ' ', $planet->type)) }}</small>
                                    <div class="mt-1">
                                        @if($planet->is_habitable)
                                            <span class="badge bg-success badge-sm me-1">Habitable</span>
                                        @endif
                                        @if($planet->has_rings)
                                            <span class="badge bg-warning text-dark badge-sm">Rings</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <p class="text-danger mt-3 mb-0">
                            <i class="bi bi-info-circle me-1"></i>This action cannot be undone.
                        </p>
                    </div>
                    <div class="modal-footer border-top border-secondary">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                        <form action="{{ route('planets.destroy', $planet) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">
                                <i class="bi bi-trash me-1"></i>Delete Planet
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endif
    @empty
        <div class="col-12">
            <div class="card space-card">
                <div class="card-body text-center py-5">
                    <i class="bi bi-globe text-muted display-1 mb-4"></i>
                    <h4 class="text-light mb-3">No Planets Found</h4>
                    <p class="text-muted mb-4">
                        {{ request()->hasAny(['search', 'type']) ? 'No planets match your search criteria.' : 'Start exploring the universe by adding your first planet!' }}
                    </p>
                    @if(!request()->hasAny(['search', 'type']) && auth()->user()->isAdmin())
                        <a href="{{ route('planets.create') }}" class="btn btn-primary">
                            <i class="bi bi-plus me-2"></i>Add First Planet
                        </a>
                    @elseif(request()->hasAny(['search', 'type']))
                        <a href="{{ route('planets.index') }}" class="btn btn-outline-light">
                            <i class="bi bi-arrow-left me-2"></i>View All Planets
                        </a>
                    @endif
                </div>
            </div>
        </div>
    @endforelse
</div>

<style>
.space-card {
    background: rgba(0, 0, 0, 0.7);
    border: 1px solid rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
}

.text-space-gold {
    color: #ffc107;
}

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

.planet-card {
    transition: all 0.3s ease;
    overflow: hidden;
}

.planet-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
}

.planet-type-badge {
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.1);
}

.info-box {
    transition: all 0.2s ease;
    border: 1px solid rgba(255, 255, 255, 0.1);
}

.info-box:hover {
    background-color: rgba(255, 255, 255, 0.05) !important;
    border-color: rgba(255, 193, 7, 0.3);
}

.form-control:focus,
.form-select:focus {
    border-color: #ffc107;
    box-shadow: 0 0 0 0.2rem rgba(255, 193, 7, 0.25);
}

.badge-sm {
    font-size: 0.7rem;
    padding: 0.25rem 0.5rem;
}
</style>
@endsection