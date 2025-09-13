@extends('layouts.app')

@section('title', 'Edit ' . $planet->name)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="text-light mb-1">
            <i class="bi bi-pencil me-2"></i>Edit Planet: {{ $planet->name }}
        </h1>
        <p class="text-light opacity-75 mb-0">Update planet information and details</p>
    </div>
    <div>
        <a href="{{ route('planets.show', $planet) }}" class="btn btn-outline-light me-2">
            <i class="bi bi-eye me-2"></i>View Planet
        </a>
        <a href="{{ route('planets.index') }}" class="btn btn-outline-light">
            <i class="bi bi-arrow-left me-2"></i>Back to Planets
        </a>
    </div>
</div>

<form action="{{ route('planets.update', $planet) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    
    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card space-card">
                <div class="card-body">
                    <h5 class="text-light mb-4">Planet Information</h5>
                    
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="name" class="form-label text-light">Planet Name *</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name', $planet->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6">
                            <label for="type" class="form-label text-light">Planet Type *</label>
                            <select class="form-select @error('type') is-invalid @enderror" id="type" name="type" required>
                                <option value="">Select Type</option>
                                <option value="terrestrial" {{ old('type', $planet->type) == 'terrestrial' ? 'selected' : '' }}>Terrestrial</option>
                                <option value="gas_giant" {{ old('type', $planet->type) == 'gas_giant' ? 'selected' : '' }}>Gas Giant</option>
                                <option value="ice_giant" {{ old('type', $planet->type) == 'ice_giant' ? 'selected' : '' }}>Ice Giant</option>
                                <option value="dwarf" {{ old('type', $planet->type) == 'dwarf' ? 'selected' : '' }}>Dwarf Planet</option>
                            </select>
                            @error('type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-12">
                            <label for="description" class="form-label text-light">Description *</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" name="description" rows="4" required>{{ old('description', $planet->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6">
                            <label for="size" class="form-label text-light">Size (Diameter) *</label>
                            <input type="text" class="form-control @error('size') is-invalid @enderror" 
                                   id="size" name="size" value="{{ old('size', $planet->size) }}" 
                                   placeholder="e.g., 12,756 km" required>
                            @error('size')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6">
                            <label for="distance_from_sun" class="form-label text-light">Distance from Sun *</label>
                            <input type="text" class="form-control @error('distance_from_sun') is-invalid @enderror" 
                                   id="distance_from_sun" name="distance_from_sun" value="{{ old('distance_from_sun', $planet->distance_from_sun) }}" 
                                   placeholder="e.g., 1 AU (150 million km)" required>
                            @error('distance_from_sun')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6">
                            <label for="mass" class="form-label text-light">Mass</label>
                            <input type="text" class="form-control @error('mass') is-invalid @enderror" 
                                   id="mass" name="mass" value="{{ old('mass', $planet->mass) }}" 
                                   placeholder="e.g., 5.97 × 10²⁴ kg">
                            @error('mass')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6">
                            <label for="temperature" class="form-label text-light">Temperature Range</label>
                            <input type="text" class="form-control @error('temperature') is-invalid @enderror" 
                                   id="temperature" name="temperature" value="{{ old('temperature', $planet->temperature) }}" 
                                   placeholder="e.g., -89°C to 58°C">
                            @error('temperature')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6">
                            <label for="orbital_period" class="form-label text-light">Orbital Period</label>
                            <input type="text" class="form-control @error('orbital_period') is-invalid @enderror" 
                                   id="orbital_period" name="orbital_period" value="{{ old('orbital_period', $planet->orbital_period) }}" 
                                   placeholder="e.g., 365.25 days">
                            @error('orbital_period')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6">
                            <label for="rotation_period" class="form-label text-light">Rotation Period</label>
                            <input type="text" class="form-control @error('rotation_period') is-invalid @enderror" 
                                   id="rotation_period" name="rotation_period" value="{{ old('rotation_period', $planet->rotation_period) }}" 
                                   placeholder="e.g., 24 hours">
                            @error('rotation_period')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6">
                            <label for="moons" class="form-label text-light">Number of Moons</label>
                            <input type="number" class="form-control @error('moons') is-invalid @enderror" 
                                   id="moons" name="moons" value="{{ old('moons', $planet->moons) }}" min="0">
                            @error('moons')
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
                            @if($planet->image)
                                <div class="mt-2">
                                    <small class="text-success">Current image: {{ basename($planet->image) }}</small>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4">
            <!-- Current Image -->
            @if($planet->image)
                <div class="card space-card mb-4">
                    <img src="{{ $planet->image_url }}" class="card-img-top" alt="{{ $planet->name }}" style="height: 200px; object-fit: cover;">
                    <div class="card-body">
                        <h6 class="text-light mb-0">Current Image</h6>
                        <small class="text-muted">Upload a new image to replace this one</small>
                    </div>
                </div>
            @endif
            
            <div class="card space-card">
                <div class="card-body">
                    <h6 class="text-light mb-3">Additional Options</h6>
                    
                    <div class="form-check form-switch mb-4">
                        <input class="form-check-input" type="checkbox" role="switch" 
                               id="is_habitable" name="is_habitable" value="1" 
                               {{ old('is_habitable', $planet->is_habitable) ? 'checked' : '' }}>
                        <label class="form-check-label text-light" for="is_habitable">
                            Potentially Habitable
                        </label>
                        <small class="text-muted d-block">Check if this planet might support life</small>
                    </div>
                    
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-check me-2"></i>Update Planet
                        </button>
                        <a href="{{ route('planets.show', $planet) }}" class="btn btn-outline-light">
                            <i class="bi bi-x me-2"></i>Cancel
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Meta Info -->
            <div class="card space-card mt-4">
                <div class="card-body">
                    <h6 class="text-space-gold mb-3">
                        <i class="bi bi-info-circle me-2"></i>Planet Info
                    </h6>
                    <small class="text-muted d-block mb-2">Created: {{ $planet->created_at->format('M d, Y g:i A') }}</small>
                    @if($planet->updated_at != $planet->created_at)
                        <small class="text-muted d-block">Last Updated: {{ $planet->updated_at->format('M d, Y g:i A') }}</small>
                    @endif
                </div>
            </div>
        </div>
    </div>
</form>
@endsection