@extends('layouts.app')

@section('title', 'Add New Event')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="text-light mb-1">
            <i class="bi bi-plus-circle me-2"></i>Add New Event
        </h1>
        <p class="text-light opacity-75 mb-0">Track astronomical phenomena and space missions</p>
    </div>
    <a href="{{ route('events.index') }}" class="btn btn-outline-light">
        <i class="bi bi-arrow-left me-2"></i>Back to Events
    </a>
</div>

<form action="{{ route('events.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    
    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card space-card">
                <div class="card-body">
                    <h5 class="text-light mb-4">Event Information</h5>
                    
                    <div class="row g-3">
                        <div class="col-md-8">
                            <label for="title" class="form-label text-light">Event Title *</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                   id="title" name="title" value="{{ old('title') }}" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-4">
                            <label for="type" class="form-label text-light">Event Type *</label>
                            <select class="form-select @error('type') is-invalid @enderror" id="type" name="type" required>
                                <option value="">Select Type</option>
                                <option value="meteor_shower" {{ old('type') == 'meteor_shower' ? 'selected' : '' }}>Meteor Shower</option>
                                <option value="eclipse" {{ old('type') == 'eclipse' ? 'selected' : '' }}>Eclipse</option>
                                <option value="planet_alignment" {{ old('type') == 'planet_alignment' ? 'selected' : '' }}>Planet Alignment</option>
                                <option value="supernova" {{ old('type') == 'supernova' ? 'selected' : '' }}>Supernova</option>
                                <option value="asteroid_flyby" {{ old('type') == 'asteroid_flyby' ? 'selected' : '' }}>Asteroid Flyby</option>
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
                            <label for="date" class="form-label text-light">Event Date *</label>
                            <input type="date" class="form-control @error('date') is-invalid @enderror" 
                                   id="date" name="date" value="{{ old('date') }}" required>
                            @error('date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6">
                            <label for="time" class="form-label text-light">Event Time</label>
                            <input type="time" class="form-control @error('time') is-invalid @enderror" 
                                   id="time" name="time" value="{{ old('time') }}">
                            @error('time')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6">
                            <label for="location" class="form-label text-light">Location *</label>
                            <input type="text" class="form-control @error('location') is-invalid @enderror" 
                                   id="location" name="location" value="{{ old('location') }}" 
                                   placeholder="e.g., Worldwide, North America" required>
                            @error('location')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6">
                            <label for="duration" class="form-label text-light">Duration</label>
                            <input type="text" class="form-control @error('duration') is-invalid @enderror" 
                                   id="duration" name="duration" value="{{ old('duration') }}" 
                                   placeholder="e.g., 2 hours, All night">
                            @error('duration')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6">
                            <label for="visibility" class="form-label text-light">Visibility</label>
                            <input type="text" class="form-control @error('visibility') is-invalid @enderror" 
                                   id="visibility" name="visibility" value="{{ old('visibility') }}" 
                                   placeholder="e.g., Best from Northern Hemisphere">
                            @error('visibility')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6">
                            <label for="image" class="form-label text-light">Event Image</label>
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
                    <h6 class="text-light mb-3">Event Options</h6>
                    
                    <div class="form-check form-switch mb-4">
                        <input class="form-check-input" type="checkbox" role="switch" 
                               id="is_recurring" name="is_recurring" value="1" 
                               {{ old('is_recurring') ? 'checked' : '' }}>
                        <label class="form-check-label text-light" for="is_recurring">
                            Recurring Event
                        </label>
                        <small class="text-muted d-block">Check if this event happens regularly</small>
                    </div>
                    
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check me-2"></i>Create Event
                        </button>
                        <a href="{{ route('events.index') }}" class="btn btn-outline-light">
                            <i class="bi bi-x me-2"></i>Cancel
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Helper Info -->
            <div class="card space-card mt-4">
                <div class="card-body">
                    <h6 class="text-space-gold mb-3">
                        <i class="bi bi-info-circle me-2"></i>Event Guidelines
                    </h6>
                    <ul class="list-unstyled small text-light opacity-75 mb-0">
                        <li class="mb-2">• Use accurate astronomical data</li>
                        <li class="mb-2">• Include timezone information when relevant</li>
                        <li class="mb-2">• Specify visibility conditions</li>
                        <li>• Add high-quality images when available</li>
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