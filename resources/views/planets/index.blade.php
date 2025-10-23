@extends('layouts.app')

@section('title', 'Planets - Universepedia')

@section('content')
<style>
    body {
        overflow: hidden;
    }
    
    .space-container {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100vh;
        background: linear-gradient(to bottom, #000000, #0a0a1a, #1a0a2e);
        overflow: hidden;
    }
    
    .stars {
        position: absolute;
        width: 100%;
        height: 100%;
        overflow: hidden;
    }
    
    .star {
        position: absolute;
        background: white;
        border-radius: 50%;
        animation: twinkle 3s infinite;
    }
    
    @keyframes twinkle {
        0%, 100% { opacity: 0.3; }
        50% { opacity: 1; }
    }
    
    .journey-track {
        position: absolute;
        top: 50%;
        left: 0;
        height: 100vh;
        transform: translateY(-50%);
        transition: left 0.8s cubic-bezier(0.4, 0, 0.2, 1);
        display: flex;
        align-items: center;
    }
    
    .sun-section {
        position: relative;
        width: 100vw;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    
    .sun {
        width: 200px;
        height: 200px;
        background: radial-gradient(circle, #FDB813, #FF8C00, #FF4500);
        border-radius: 50%;
        box-shadow: 0 0 100px #FDB813, 0 0 150px #FF8C00;
        animation: pulse 4s infinite;
    }
    
    @keyframes pulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.05); }
    }
    
    .planet-section {
        position: relative;
        width: 100vw;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    
    .planet-card {
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 20px;
        padding: 2rem;
        max-width: 500px;
        text-align: center;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
        transform: scale(0.9);
        opacity: 0;
        transition: all 0.5s ease;
    }
    
    .planet-card.active {
        transform: scale(1);
        opacity: 1;
    }
    
    .planet-image {
        width: 180px;
        height: 180px;
        margin: 0 auto 1.5rem;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid rgba(255, 255, 255, 0.3);
        box-shadow: 0 0 30px rgba(255, 255, 255, 0.2);
    }
    
    .planet-placeholder {
        width: 180px;
        height: 180px;
        margin: 0 auto 1.5rem;
        border-radius: 50%;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 5rem;
        box-shadow: 0 0 30px rgba(102, 126, 234, 0.4);
    }
    
    .planet-name {
        font-size: 2.5rem;
        font-weight: bold;
        color: white;
        margin-bottom: 1rem;
        text-shadow: 0 2px 10px rgba(0, 0, 0, 0.5);
    }
    
    .planet-info {
        color: rgba(255, 255, 255, 0.9);
        font-size: 1.1rem;
        margin: 0.8rem 0;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
    }
    
    .distance-indicator {
        position: fixed;
        top: 2rem;
        right: 2rem;
        background: rgba(0, 0, 0, 0.7);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 15px;
        padding: 1.5rem;
        color: white;
        z-index: 100;
        min-width: 250px;
    }
    
    .distance-value {
        font-size: 2rem;
        font-weight: bold;
        color: #FDB813;
        margin-bottom: 0.5rem;
    }
    
    .distance-label {
        font-size: 0.9rem;
        color: rgba(255, 255, 255, 0.7);
    }
    
    .navigation {
        position: fixed;
        top: 50%;
        right: 2rem;
        transform: translateY(-50%);
        display: flex;
        flex-direction: column;
        gap: 1rem;
        z-index: 100;
    }
    
    .nav-btn {
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.3);
        color: white;
        padding: 1rem 2rem;
        border-radius: 50px;
        cursor: pointer;
        font-size: 1.1rem;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .nav-btn:hover:not(:disabled) {
        background: rgba(255, 255, 255, 0.2);
        transform: translateY(-2px);
    }
    
    .nav-btn:disabled {
        opacity: 0.3;
        cursor: not-allowed;
    }
    
    .progress-bar {
        position: fixed;
        bottom: 0;
        left: 0;
        width: 100%;
        height: 4px;
        background: rgba(255, 255, 255, 0.1);
        z-index: 100;
    }
    
    .progress-fill {
        height: 100%;
        background: linear-gradient(90deg, #FDB813, #667eea);
        transition: width 0.8s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .view-details-btn {
        margin-top: 1.5rem;
        padding: 0.8rem 2rem;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
        border-radius: 50px;
        font-size: 1rem;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-block;
    }
    
    .view-details-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 20px rgba(102, 126, 234, 0.4);
    }
    
    .home-btn {
        position: fixed;
        top: 2rem;
        left: 2rem;
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.3);
        color: white;
        padding: 0.8rem 1.5rem;
        border-radius: 50px;
        text-decoration: none;
        transition: all 0.3s ease;
        z-index: 100;
    }
    
    .home-btn:hover {
        background: rgba(255, 255, 255, 0.2);
    }
    
    .admin-controls {
        position: fixed;
        top: 2rem;
        left: 50%;
        transform: translateX(-50%);
        z-index: 100;
    }
    
    .create-btn {
        background: rgba(102, 126, 234, 0.9);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.3);
        color: white;
        padding: 0.8rem 1.5rem;
        border-radius: 50px;
        text-decoration: none;
        transition: all 0.3s ease;
    }
    
    .create-btn:hover {
        background: rgba(102, 126, 234, 1);
        transform: translateY(-2px);
    }
</style>

<div class="space-container">
    <!-- Stars Background -->
    <div class="stars" id="starsContainer"></div>
    
    <!-- Home Button -->
    <a href="/" class="home-btn">← Back to Home</a>
    
    <!-- Admin Controls -->
    @if(auth()->user()->isAdmin())
        <div class="admin-controls">
            <a href="{{ route('planets.create') }}" class="create-btn">+ Create New Planet</a>
        </div>
    @endif
    
    <!-- Page & Distance Indicator -->
    <div class="distance-indicator">
        <div class="distance-value" id="pageIndicator">1 / {{ $planets->count() + 1 }}</div>
        <div class="distance-label">Page</div>
        <div class="distance-value" style="margin-top: 1rem; font-size: 1.5rem;" id="distanceValue">The Sun ☀️</div>
        <div class="distance-label">from the Sun</div>
    </div>
    
    <!-- Journey Track -->
    <div class="journey-track" id="journeyTrack">
        <!-- Sun -->
        <div class="sun-section" data-distance="0">
            <div class="sun"></div>
        </div>
        
        <!-- Planets -->
        @php
            // Sort planets by distance from sun
            $sortedPlanets = $planets->sortBy(function($planet) {
                $distance = $planet->distance;
                // Extract numeric value from distance string
                if (strpos($distance, 'miliar') !== false) {
                    $num = (float) preg_replace('/[^0-9.,]/', '', $distance);
                    $num = str_replace(',', '.', $num);
                    return $num * 1000; // Convert billion to million for comparison
                } else {
                    $num = (float) preg_replace('/[^0-9.,]/', '', $distance);
                    return str_replace(',', '.', $num);
                }
            });
        @endphp
        
        @foreach($sortedPlanets as $planet)
            <div class="planet-section" data-distance="{{ $planet->distance }}">
                <div class="planet-card">
                    @if($planet->image)
                        <img src="{{ asset('storage/' . $planet->image) }}" alt="{{ $planet->name }}" class="planet-image">
                    @else
                        <div class="planet-placeholder">🪐</div>
                    @endif
                    
                    <h2 class="planet-name">{{ $planet->name }}</h2>
                    
                    <div class="planet-info">
                        <span>📏</span>
                        <span>Size: {{ $planet->size }}</span>
                    </div>
                    
                    <div class="planet-info">
                        <span>🌍</span>
                        <span>Distance: {{ $planet->distance }}</span>
                    </div>
                    
                    <div class="planet-info" style="font-size: 0.9rem; opacity: 0.7;">
                        <span>Created by {{ $planet->creator->name }}</span>
                    </div>
                    
                    <a href="{{ route('planets.show', $planet) }}" class="view-details-btn">
                        View Full Details →
                    </a>
                </div>
            </div>
        @endforeach
    </div>
    
    <!-- Navigation -->
    <div class="navigation">
        <button class="nav-btn" id="prevBtn" disabled>
            ← Previous
        </button>
        <button class="nav-btn" id="nextBtn">
            Next →
        </button>
    </div>
    
    <!-- Progress Bar -->
    <div class="progress-bar">
        <div class="progress-fill" id="progressFill" style="width: 0%"></div>
    </div>
</div>

<script>
    // Generate stars
    const starsContainer = document.getElementById('starsContainer');
    for (let i = 0; i < 200; i++) {
        const star = document.createElement('div');
        star.className = 'star';
        star.style.left = Math.random() * 100 + '%';
        star.style.top = Math.random() * 100 + '%';
        star.style.width = Math.random() * 3 + 1 + 'px';
        star.style.height = star.style.width;
        star.style.animationDelay = Math.random() * 3 + 's';
        starsContainer.appendChild(star);
    }
    
    // Journey navigation
    const journeyTrack = document.getElementById('journeyTrack');
    const sections = document.querySelectorAll('.sun-section, .planet-section');
    const prevBtn = document.getElementById('prevBtn');
    const nextBtn = document.getElementById('nextBtn');
    const distanceValue = document.getElementById('distanceValue');
    const progressFill = document.getElementById('progressFill');
    const pageIndicator = document.getElementById('pageIndicator');
    
    let currentIndex = 0;
    const totalSections = sections.length;
    
    function updateJourney() {
        // Move track
        journeyTrack.style.left = -currentIndex * 100 + 'vw';
        
        // Update active card
        document.querySelectorAll('.planet-card').forEach(card => {
            card.classList.remove('active');
        });
        const currentCard = sections[currentIndex].querySelector('.planet-card');
        if (currentCard) {
            setTimeout(() => currentCard.classList.add('active'), 300);
        }
        
        // Update page indicator
        pageIndicator.textContent = `${currentIndex + 1} / ${totalSections}`;
        
        // Update distance
        const distance = sections[currentIndex].dataset.distance;
        distanceValue.textContent = distance === '0' ? 'The Sun ☀️' : distance;
        
        // Update buttons
        prevBtn.disabled = currentIndex === 0;
        nextBtn.disabled = currentIndex === totalSections - 1;
        
        // Update progress
        const progress = (currentIndex / (totalSections - 1)) * 100;
        progressFill.style.width = progress + '%';
    }
    
    prevBtn.addEventListener('click', () => {
        if (currentIndex > 0) {
            currentIndex--;
            updateJourney();
        }
    });
    
    nextBtn.addEventListener('click', () => {
        if (currentIndex < totalSections - 1) {
            currentIndex++;
            updateJourney();
        }
    });
    
    // Keyboard navigation
    document.addEventListener('keydown', (e) => {
        if (e.key === 'ArrowLeft') {
            prevBtn.click();
        } else if (e.key === 'ArrowRight') {
            nextBtn.click();
        }
    });
    
    // Touch/swipe support
    let touchStartX = 0;
    let touchEndX = 0;
    
    journeyTrack.addEventListener('touchstart', (e) => {
        touchStartX = e.changedTouches[0].screenX;
    });
    
    journeyTrack.addEventListener('touchend', (e) => {
        touchEndX = e.changedTouches[0].screenX;
        handleSwipe();
    });
    
    function handleSwipe() {
        if (touchEndX < touchStartX - 50) {
            nextBtn.click();
        }
        if (touchEndX > touchStartX + 50) {
            prevBtn.click();
        }
    }
    
    // Initialize
    updateJourney();
</script>

@if($planets->count() === 0)
<div style="position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); text-align: center; z-index: 1000;">
    <div style="background: rgba(0, 0, 0, 0.8); padding: 3rem; border-radius: 20px; border: 1px solid rgba(255, 255, 255, 0.2);">
        <p style="color: white; font-size: 1.5rem; margin-bottom: 1rem;">No planets found in the solar system yet.</p>
        @if(auth()->user()->isAdmin())
            <a href="{{ route('planets.create') }}" class="view-details-btn">Create First Planet</a>
        @endif
    </div>
</div>
@endif
@endsection