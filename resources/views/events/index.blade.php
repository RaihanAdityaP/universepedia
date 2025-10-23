@extends('layouts.app')

@section('title', 'Cosmic Events - Universepedia')

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
    
    .event-section {
        position: relative;
        width: 100vw;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    
    .event-card {
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 20px;
        padding: 1.5rem;
        max-width: 400px;
        text-align: center;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
        transform: scale(0.9);
        opacity: 0;
        transition: all 0.5s ease;
    }
    
    .event-card.active {
        transform: scale(1);
        opacity: 1;
    }
    
    .event-image {
        width: 180px;
        height: 180px;
        margin: 0 auto 1.5rem;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid rgba(255, 255, 255, 0.3);
        box-shadow: 0 0 30px rgba(255, 255, 255, 0.2);
    }
    
    .event-placeholder {
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
    
    .event-name {
        font-size: 2.5rem;
        font-weight: bold;
        color: white;
        margin-bottom: 1rem;
        text-shadow: 0 2px 10px rgba(0, 0, 0, 0.5);
    }
    
    .event-info {
        color: rgba(255, 255, 255, 0.9);
        font-size: 1.1rem;
        margin: 0.8rem 0;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
    }
    
    .date-indicator {
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
    
    .date-value {
        font-size: 1.8rem;
        font-weight: bold;
        color: #FDB813;
        margin-bottom: 0.5rem;
    }
    
    .date-label {
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
            <a href="{{ route('events.create') }}" class="create-btn">+ Create New Event</a>
        </div>
    @endif
    
    <!-- Page & Date Indicator -->
    <div class="date-indicator">
        <div class="date-value" id="pageIndicator">1 / {{ $events->count() }}</div>
        <div class="date-label">Page</div>
        <div class="date-value" style="margin-top: 1rem; font-size: 1.5rem;" id="dateValue">Loading...</div>
        <div class="date-label" id="dateLabel">Event Type</div>
    </div>
    
    <!-- Journey Track -->
    <div class="journey-track" id="journeyTrack">
        @php
            // Sort events by date
            $sortedEvents = $events->sortBy('date');
        @endphp
        
        @foreach($sortedEvents as $event)
            <div class="event-section" data-date="{{ $event->date->format('F d, Y') }}" data-type="{{ $event->getFormattedType() }}">
                <div class="event-card">
                    @if($event->image)
                        <img src="{{ asset('storage/' . $event->image) }}" alt="{{ $event->title }}" class="event-image">
                    @else
                        <div class="event-placeholder">🌌</div>
                    @endif
                    
                    <h2 class="event-name">{{ $event->title }}</h2>
                    
                    <div class="event-info">
                        <span>🌟</span>
                        <span>{{ $event->getFormattedType() }}</span>
                    </div>
                    
                    <div class="event-info">
                        <span>📅</span>
                        <span>{{ $event->date->format('F d, Y') }}</span>
                    </div>
                    
                    <div class="event-info" style="font-size: 0.9rem; opacity: 0.7;">
                        <span>Created by {{ $event->creator->name }}</span>
                    </div>
                    
                    <a href="{{ route('events.show', $event) }}" class="view-details-btn">
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
    const sections = document.querySelectorAll('.event-section');
    const prevBtn = document.getElementById('prevBtn');
    const nextBtn = document.getElementById('nextBtn');
    const dateValue = document.getElementById('dateValue');
    const dateLabel = document.getElementById('dateLabel');
    const progressFill = document.getElementById('progressFill');
    const pageIndicator = document.getElementById('pageIndicator');
    
    let currentIndex = 0;
    const totalSections = sections.length;
    
    function updateJourney() {
        // Move track
        journeyTrack.style.left = -currentIndex * 100 + 'vw';
        
        // Update active card
        document.querySelectorAll('.event-card').forEach(card => {
            card.classList.remove('active');
        });
        const currentCard = sections[currentIndex].querySelector('.event-card');
        if (currentCard) {
            setTimeout(() => currentCard.classList.add('active'), 300);
        }
        
        // Update page indicator
        pageIndicator.textContent = `${currentIndex + 1} / ${totalSections}`;
        
        // Update date
        const date = sections[currentIndex].dataset.date;
        const type = sections[currentIndex].dataset.type;
        dateValue.textContent = date;
        dateLabel.textContent = type;
        
        // Update buttons
        prevBtn.disabled = currentIndex === 0;
        nextBtn.disabled = currentIndex === totalSections - 1;
        
        // Update progress
        const progress = totalSections > 1 ? (currentIndex / (totalSections - 1)) * 100 : 0;
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

@if($events->count() === 0)
<div style="position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); text-align: center; z-index: 1000;">
    <div style="background: rgba(0, 0, 0, 0.8); padding: 3rem; border-radius: 20px; border: 1px solid rgba(255, 255, 255, 0.2);">
        <p style="color: white; font-size: 1.5rem; margin-bottom: 1rem;">No cosmic events found yet.</p>
        @if(auth()->user()->isAdmin())
            <a href="{{ route('events.create') }}" class="view-details-btn">Create First Event</a>
        @endif
    </div>
</div>
@endif
@endsection