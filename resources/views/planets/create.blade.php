@extends('layouts.app')

@section('title', 'Add New Planet')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="text-light mb-1">
            <i class="bi bi-plus-circle me-2"></i>Add New Planet
        </h1>
        <p class="text-light opacity-75 mb-0">Discover and catalog celestial bodies in our universe</p>
    </div>
    <a href="{{ route('planets.index') }}" class="btn btn-outline-light">
        <i class="bi bi-arrow-left me-2"></i>Back to Planets
    </a>
</div>

<form action="{{ route('planets.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    
    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card space-card">
                <div class="card-body">
                    <h5 class="text-light mb-4">Planet Information</h5>
                    
                    <div class="row g-3">
                        <div class="col-md-8">
                            <label for="name" class="form-label text-light">Planet Name *</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-4">
                            <label for="type" class="form-label text-light">Planet Type *</label>
                            <select class="form-select @error('type') is-invalid @enderror" id="type" name="type" required>
                                <option value="">Select Type</option>
                                <option value="terrestrial" {{ old('type') == 'terrestrial' ? 'selected' : '' }}>Terrestrial</option>
                                <option value="gas_giant" {{ old('type') == 'gas_giant' ? 'selected' : '' }}>Gas Giant</option>
                                <option value="ice_giant" {{ old('type') == 'ice_giant' ? 'selected' : '' }}>Ice Giant</option>
                                <option value="dwarf_planet" {{ old('type') == 'dwarf_planet' ? 'selected' : '' }}>Dwarf Planet</option>
                                <option value="exoplanet" {{ old('type') == 'exoplanet' ? 'selected' : '' }}>Exoplanet</option>
                                <option value="other" {{ old('type') == 'other' ? 'selected' : '' }}>Other</option>
                            </select>
                            @error('type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-12">
                            <label for="description" class="form-label text-light">Description *</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" name="description" rows="4" required>{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6">
                            <label for="size" class="form-label text-light">Size *</label>
                            <input type="text" class="form-control @error('size') is-invalid @enderror" 
                                   id="size" name="size" value="{{ old('size') }}" 
                                   placeholder="e.g., Large, Medium, Small" required>
                            @error('size')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6">
                            <label for="distance_from_sun" class="form-label text-light">Distance from Sun</label>
                            <input type="text" class="form-control @error('distance_from_sun') is-invalid @enderror" 
                                   id="distance_from_sun" name="distance_from_sun" value="{{ old('distance_from_sun') }}" 
                                   placeholder="e.g., 149.6 million km, 778.5 million km">
                            @error('distance_from_sun')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6">
                            <label for="diameter" class="form-label text-light">Diameter</label>
                            <input type="text" class="form-control @error('diameter') is-invalid @enderror" 
                                   id="diameter" name="diameter" value="{{ old('diameter') }}" 
                                   placeholder="e.g., 12,742 km, 142,984 km">
                            @error('diameter')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6">
                            <label for="mass" class="form-label text-light">Mass</label>
                            <input type="text" class="form-control @error('mass') is-invalid @enderror" 
                                   id="mass" name="mass" value="{{ old('mass') }}" 
                                   placeholder="e.g., 5.97 × 10²⁴ kg">
                            @error('mass')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6">
                            <label for="orbital_period" class="form-label text-light">Orbital Period</label>
                            <input type="text" class="form-control @error('orbital_period') is-invalid @enderror" 
                                   id="orbital_period" name="orbital_period" value="{{ old('orbital_period') }}" 
                                   placeholder="e.g., 365.25 days, 11.86 years">
                            @error('orbital_period')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6">
                            <label for="rotation_period" class="form-label text-light">Rotation Period</label>
                            <input type="text" class="form-control @error('rotation_period') is-invalid @enderror" 
                                   id="rotation_period" name="rotation_period" value="{{ old('rotation_period') }}" 
                                   placeholder="e.g., 24 hours, 9.9 hours">
                            @error('rotation_period')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6">
                            <label for="moons" class="form-label text-light">Number of Moons</label>
                            <input type="number" class="form-control @error('moons') is-invalid @enderror" 
                                   id="moons" name="moons" value="{{ old('moons') }}" min="0">
                            @error('moons')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6">
                            <label for="temperature" class="form-label text-light">Average Temperature</label>
                            <input type="text" class="form-control @error('temperature') is-invalid @enderror" 
                                   id="temperature" name="temperature" value="{{ old('temperature') }}" 
                                   placeholder="e.g., 15°C, -178°C">
                            @error('temperature')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6">
                            <label for="atmosphere" class="form-label text-light">Atmosphere</label>
                            <input type="text" class="form-control @error('atmosphere') is-invalid @enderror" 
                                   id="atmosphere" name="atmosphere" value="{{ old('atmosphere') }}" 
                                   placeholder="e.g., Nitrogen, Oxygen, Hydrogen, Helium">
                            @error('atmosphere')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6">
                            <label for="image" class="form-label text-light">Planet Image</label>
                            <input type="file" class="form-control @error('image') is-invalid @enderror" 
                                   id="image" name="image" accept="image/*">
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Max size: 2MB. Formats: JPEG, PNG, JPG, GIF</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4">
            <div class="card space-card">
                <div class="card-body">
                    <h6 class="text-light mb-3">Planet Status</h6>
                    
                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" role="switch" 
                               id="is_habitable" name="is_habitable" value="1" 
                               {{ old('is_habitable') ? 'checked' : '' }}>
                        <label class="form-check-label text-light" for="is_habitable">
                            Potentially Habitable
                        </label>
                        <small class="text-muted d-block">Check if planet is in habitable zone</small>
                    </div>
                    
                    <div class="form-check form-switch mb-4">
                        <input class="form-check-input" type="checkbox" role="switch" 
                               id="has_rings" name="has_rings" value="1" 
                               {{ old('has_rings') ? 'checked' : '' }}>
                        <label class="form-check-label text-light" for="has_rings">
                            Has Ring System
                        </label>
                        <small class="text-muted d-block">Check if planet has rings</small>
                    </div>
                    
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check me-2"></i>Create Planet
                        </button>
                        <a href="{{ route('planets.index') }}" class="btn btn-outline-light">
                            <i class="bi bi-x me-2"></i>Cancel
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Helper Info -->
            <div class="card space-card mt-4">
                <div class="card-body">
                    <h6 class="text-space-gold mb-3">
                        <i class="bi bi-info-circle me-2"></i>Planet Guidelines
                    </h6>
                    <ul class="list-unstyled small text-light opacity-75 mb-0">
                        <li class="mb-2">• Use accurate astronomical data</li>
                        <li class="mb-2">• Include proper units for measurements</li>
                        <li class="mb-2">• Specify atmospheric composition</li>
                        <li>• Add high-quality planet images when available</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</form>

<style>
.space-card {
    background: rgba(0, 0, 0, 0.7);
    border: 1px solid rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
}

.text-space-gold {
    color: #ffc107;
}

.form-control:focus,
.form-select:focus {
    border-color: #ffc107;
    box-shadow: 0 0 0 0.2rem rgba(255, 193, 7, 0.25);
}

.form-check-input:checked {
    background-color: #ffc107;
    border-color: #ffc107;
}

.form-check-input:focus {
    border-color: #ffc107;
    box-shadow: 0 0 0 0.2rem rgba(255, 193, 7, 0.25);
}

.bg-dark {
    background-color: #212529 !important;
}

.border-secondary {
    border-color: #495057 !important;
}
</style>
@endsection