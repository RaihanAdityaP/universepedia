@extends('layouts.app')

@section('title', 'Edit Event')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="text-light mb-1">
            <i class="bi bi-pencil-square me-2"></i>Edit Event
        </h1>
        <p class="text-light opacity-75 mb-0">Update astronomical event information</p>
    </div>
    <a href="{{ route('events.index') }}" class="btn btn-outline-light">
        <i class="bi bi-arrow-left me-2"></i>Back to Events
    </a>
</div>

<form action="{{ route('events.update', $event->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    
    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card space-card">
                <div class="card-body">
                    <h5 class="text-light mb-4">Event Information</h5>
                    
                    <div class="row g-3">
                        <div class="col-md-8">
                            <label for="title" class="form-label text-light">Event Title *</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                   id="title" name="title" value="{{ old('title', $event->title) }}" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-4">
                            <label for="type" class="form-label text-light">Event Type *</label>
                            <select class="form-select @error('type') is-invalid @enderror" id="type" name="type" required>
                                <option value="">Select Type</option>
                                <option value="meteor_shower" {{ old('type', $event->type) == 'meteor_shower' ? 'selected' : '' }}>Meteor Shower</option>
                                <option value="eclipse" {{ old('type', $event->type) == 'eclipse' ? 'selected' : '' }}>Eclipse</option>
                                <option value="planet_alignment" {{ old('type', $event->type) == 'planet_alignment' ? 'selected' : '' }}>Planet Alignment</option>
                                <option value="supernova" {{ old('type', $event->type) == 'supernova' ? 'selected' : '' }}>Supernova</option>
                                <option value="asteroid_flyby" {{ old('type', $event->type) == 'asteroid_flyby' ? 'selected' : '' }}>Asteroid Flyby</option>
                                <option value="other" {{ old('type', $event->type) == 'other' ? 'selected' : '' }}>Other</option>
                            </select>
                            @error('type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-12">
                            <label for="description" class="form-label text-light">Description *</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" name="description" rows="4" required>{{ old('description', $event->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6">
                            <label for="date" class="form-label text-light">Event Date *</label>
                            <input type="date" class="form-control @error('date') is-invalid @enderror" 
                                   id="date" name="date" value="{{ old('date', $event->date) }}" required>
                            @error('date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6">
                            <label for="time" class="form-label text-light">Event Time</label>
                            <input type="time" class="form-control @error('time') is-invalid @enderror" 
                                   id="time" name="time" value="{{ old('time', $event->time) }}">
                            @error('time')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6">
                            <label for="location" class="form-label text-light">Location *</label>
                            <input type="text" class="form-control @error('location') is-invalid @enderror" 
                                   id="location" name="location" value="{{ old('location', $event->location) }}" 
                                   placeholder="e.g., Worldwide, North America" required>
                            @error('location')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6">
                            <label for="duration" class="form-label text-light">Duration</label>
                            <input type="text" class="form-control @error('duration') is-invalid @enderror" 
                                   id="duration" name="duration" value="{{ old('duration', $event->duration) }}" 
                                   placeholder="e.g., 2 hours, All night">
                            @error('duration')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6">
                            <label for="visibility" class="form-label text-light">Visibility</label>
                            <input type="text" class="form-control @error('visibility') is-invalid @enderror" 
                                   id="visibility" name="visibility" value="{{ old('visibility', $event->visibility) }}" 
                                   placeholder="e.g., Best from Northern Hemisphere">
                            @error('visibility')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6">
                            <label for="image" class="form-label text-light">Event Image</label>
                            @if ($event->image)
                                <div class="mb-2">
                                    <img src="{{ asset('storage/'.$event->image) }}" alt="{{ $event->title }}" 
                                         class="img-thumbnail d-block" style="max-width: 150px; max-height: 150px;">
                                    <small class="text-muted">Current image</small>
                                </div>
                            @endif
                            <input type="file" class="form-control @error('image') is-invalid @enderror" 
                                   id="image" name="image" accept="image/*">
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Max size: 2MB. Formats: JPEG, PNG, JPG, GIF. Leave empty to keep current image.</small>
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
                               {{ old('is_recurring', $event->is_recurring) ? 'checked' : '' }}>
                        <label class="form-check-label text-light" for="is_recurring">
                            Recurring Event
                        </label>
                        <small class="text-muted d-block">Check if this event happens regularly</small>
                    </div>
                    
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-check me-2"></i>Update Event
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
                        <i class="bi bi-info-circle me-2"></i>Update Guidelines
                    </h6>
                    <ul class="list-unstyled small text-light opacity-75 mb-0">
                        <li class="mb-2">• Verify astronomical data accuracy</li>
                        <li class="mb-2">• Update timezone information when relevant</li>
                        <li class="mb-2">• Check visibility conditions</li>
                        <li>• Replace image only if higher quality available</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection