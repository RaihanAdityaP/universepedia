@extends('layouts.app')

@section('title', 'Planets')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="text-light mb-1 fw-bold">
            <i class="bi bi-globe me-2"></i>Planets
        </h1>
        <p class="text-light opacity-75 mb-0 fw-medium">Explore the wonders of our solar system and beyond</p>
    </div>
    @if(auth()->user()->isAdmin())
        <a href="{{ route('planets.create') }}" class="btn btn-primary">
            <i class="bi bi-plus me-2"></i>Add Planet
        </a>
    @endif
</div>

<!-- Search and Filter -->
<div class="card space-card mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('planets.index') }}" class="row g-3">
            <div class="col-md-6">
                <div class="input-group">
                    <span class="input-group-text bg-dark border-secondary text-light fw-bold">
                        <i class="bi bi-search"></i>
                    </span>
                    <input type="text" class="form-control bg-dark border-secondary text-light fw-medium" 
                           name="search" value="{{ request('search') }}" 
                           placeholder="Search planets..."
                           style="color: #ffffff !important;">
                </div>
            </div>
            <div class="col-md-4">
                <select name="type" class="form-select bg-dark border-secondary text-light fw-medium" 
                        style="color: #ffffff !important;">
                    <option value="" style="color: #ffffff;">All Types</option>
                    @foreach($types as $type)
                        <option value="{{ $type }}" {{ request('type') == $type ? 'selected' : '' }} style="color: #ffffff;">
                            {{ ucfirst(str_replace('_', ' ', $type)) }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-outline-light w-100 fw-semibold">
                    <i class="bi bi-funnel me-1"></i>Filter
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Planets Grid -->
<div class="row g-4">
    @forelse($planets as $planet)
        <div class="col-lg-4 col-md-6">
            <div class="card space-card h-100">
                @if($planet->image)
                    <img src="{{ $planet->image_url }}" class="card-img-top" alt="{{ $planet->name }}" style="height: 200px; object-fit: cover;">
                @else
                    <div class="bg-gradient bg-secondary d-flex align-items-center justify-content-center" style="height: 200px;">
                        <i class="bi bi-globe text-light display-1 opacity-25"></i>
                    </div>
                @endif
                
                <div class="card-body d-flex flex-column">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <h5 class="card-title text-light mb-0 fw-bold">{{ $planet->name }}</h5>
                        <span class="badge bg-{{ $planet->type_color }} planet-type-badge">
                            {{ ucfirst(str_replace('_', ' ', $planet->type)) }}
                        </span>
                    </div>
                    
                    <p class="card-text text-light opacity-75 flex-grow-1 fw-medium">
                        {{ Str::limit($planet->description, 100) }}
                    </p>
                    
                    <div class="row text-center mb-3">
                        <div class="col-6">
                            <small class="text-muted d-block fw-bold">Distance from Sun</small>
                            <small class="text-light fw-semibold">{{ $planet->distance_from_sun }}</small>
                        </div>
                        <div class="col-6">
                            <small class="text-muted d-block fw-bold">Moons</small>
                            <small class="text-light fw-semibold">{{ $planet->moons }}</small>
                        </div>
                    </div>
                    
                    @if($planet->is_habitable)
                        <div class="mb-3">
                            <span class="badge bg-success fw-semibold">
                                <i class="bi bi-check-circle me-1"></i>Potentially Habitable
                            </span>
                        </div>
                    @endif
                    
                    <div class="d-grid gap-2">
                        <a href="{{ route('planets.show', $planet) }}" class="btn btn-outline-light btn-sm fw-semibold">
                            <i class="bi bi-eye me-1"></i>View Details
                        </a>
                        @if(auth()->user()->isAdmin())
                            <div class="btn-group btn-group-sm" role="group">
                                <a href="{{ route('planets.edit', $planet) }}" class="btn btn-outline-warning fw-semibold">
                                    <i class="bi bi-pencil me-1"></i>Edit
                                </a>
                                <form action="{{ route('planets.destroy', $planet) }}" method="POST" class="d-inline" 
                                      onsubmit="return confirm('Are you sure you want to delete this planet?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger fw-semibold">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12">
            <div class="card space-card">
                <div class="card-body text-center py-5">
                    <i class="bi bi-globe text-muted display-1 mb-4"></i>
                    <h4 class="text-light mb-3 fw-bold">No Planets Found</h4>
                    <p class="text-muted mb-4 fw-medium">{{ request()->hasAny(['search', 'type']) ? 'No planets match your search criteria.' : 'Start exploring the universe by adding your first planet!' }}</p>
                    @if(!request()->hasAny(['search', 'type']) && auth()->user()->isAdmin())
                        <a href="{{ route('planets.create') }}" class="btn btn-primary fw-semibold">
                            <i class="bi bi-plus me-2"></i>Add First Planet
                        </a>
                    @elseif(request()->hasAny(['search', 'type']))
                        <a href="{{ route('planets.index') }}" class="btn btn-outline-light fw-semibold">
                            <i class="bi bi-arrow-left me-2"></i>View All Planets
                        </a>
                    @endif
                </div>
            </div>
        </div>
    @endforelse
</div>

<!-- Pagination -->
@if($planets->hasPages())
    <div class="d-flex justify-content-center mt-4">
        {{ $planets->links() }}
    </div>
@endif
@endsection