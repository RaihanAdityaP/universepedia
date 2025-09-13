@extends('layouts.app')

@section('title', $planet->name)

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="card space-card">
            @if($planet->image)
                <img src="{{ $planet->image_url }}" class="card-img-top" alt="{{ $planet->name }}" style="height: 400px; object-fit: cover;">
            @else
                <div class="bg-gradient bg-secondary d-flex align-items-center justify-content-center" style="height: 400px;">
                    <i class="bi bi-globe text-light display-1 opacity-25"></i>
                </div>
            @endif
            
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <h1 class="text-light mb-0">{{ $planet->name }}</h1>
                    <div>
                        <span class="badge bg-{{ $planet->type_color }} me-2">
                            {{ ucfirst(str_replace('_', ' ', $planet->type)) }}
                        </span>
                        @if($planet->is_habitable)
                            <span class="badge bg-success">
                                <i class="bi bi-check-circle me-1"></i>Potentially Habitable
                            </span>
                        @endif
                    </div>
                </div>
                
                <p class="text-light opacity-75 lead mb-4">{{ $planet->description }}</p>
                
                <div class="row g-4 mb-4">
                    <div class="col-md-6">
                        <div class="bg-dark bg-opacity-25 rounded p-3">
                            <h6 class="text-space-gold mb-2">
                                <i class="bi bi-rulers me-2"></i>Physical Characteristics
                            </h6>
                            <ul class="list-unstyled mb-0 text-light">
                                <li><strong>Size:</strong> {{ $planet->size }}</li>
                                @if($planet->mass)
                                    <li><strong>Mass:</strong> {{ $planet->mass }}</li>
                                @endif
                                @if($planet->temperature)
                                    <li><strong>Temperature:</strong> {{ $planet->temperature }}</li>
                                @endif
                                <li><strong>Moons:</strong> {{ $planet->moons }}</li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="bg-dark bg-opacity-25 rounded p-3">
                            <h6 class="text-space-gold mb-2">
                                <i class="bi bi-arrow-repeat me-2"></i>Orbital Information
                            </h6>
                            <ul class="list-unstyled mb-0 text-light">
                                <li><strong>Distance from Sun:</strong> {{ $planet->distance_from_sun }}</li>
                                @if($planet->orbital_period)
                                    <li><strong>Orbital Period:</strong> {{ $planet->orbital_period }}</li>
                                @endif
                                @if($planet->rotation_period)
                                    <li><strong>Rotation Period:</strong> {{ $planet->rotation_period }}</li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <!-- Actions -->
        <div class="card space-card mb-4">
            <div class="card-body">
                <h6 class="text-light mb-3">Actions</h6>
                <div class="d-grid gap-2">
                    <a href="{{ route('planets.edit', $planet) }}" class="btn btn-warning">
                        <i class="bi bi-pencil me-2"></i>Edit Planet
                    </a>
                    <form action="{{ route('planets.destroy', $planet) }}" method="POST" 
                          onsubmit="return confirm('Are you sure you want to delete this planet?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger w-100">
                            <i class="bi bi-trash me-2"></i>Delete Planet
                        </button>
                    </form>
                    <a href="{{ route('planets.index') }}" class="btn btn-outline-light">
                        <i class="bi bi-arrow-left me-2"></i>Back to Planets
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Quick Stats -->
        <div class="card space-card">
            <div class="card-body">
                <h6 class="text-light mb-3">Quick Facts</h6>
                <div class="row g-3 text-center">
                    <div class="col-6">
                        <div class="bg-dark bg-opacity-25 rounded p-2">
                            <div class="text-space-gold h5 mb-1">{{ $planet->moons }}</div>
                            <small class="text-muted">Moons</small>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="bg-dark bg-opacity-25 rounded p-2">
                            <div class="text-space-gold h5 mb-1">{{ $planet->is_habitable ? 'Yes' : 'No' }}</div>
                            <small class="text-muted">Habitable</small>
                        </div>
                    </div>
                </div>
                
                <hr class="border-secondary">
                
                <small class="text-muted d-block">Added {{ $planet->created_at->diffForHumans() }}</small>
                @if($planet->updated_at != $planet->created_at)
                    <small class="text-muted d-block">Updated {{ $planet->updated_at->diffForHumans() }}</small>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection