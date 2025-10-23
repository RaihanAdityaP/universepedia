@extends('layouts.app')

@section('title', 'Dashboard - Universepedia')

@section('content')
<style>
    body {
        background: linear-gradient(to bottom, #000000, #0a0a1a, #1a0a2e);
        min-height: 100vh;
        position: relative;
        overflow-x: hidden;
    }
    
    .stars-bg {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        pointer-events: none;
        z-index: 0;
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
    
    .content-wrapper {
        position: relative;
        z-index: 1;
        padding: 2rem;
        max-width: 1400px;
        margin: 0 auto;
    }
    
    .glass-card {
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 20px;
        padding: 1.5rem;
        transition: all 0.3s ease;
    }
    
    .glass-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 40px rgba(102, 126, 234, 0.3);
        border-color: rgba(102, 126, 234, 0.5);
    }
    
    .rating-stars {
        color: #FDB813;
        font-size: 0.9rem;
        display: flex;
        align-items: center;
        gap: 0.2rem;
    }
    
    .rating-info {
        color: rgba(255, 255, 255, 0.7);
        font-size: 0.75rem;
        margin-top: 0.2rem;
    }
</style>

<div class="stars-bg" id="starsBg"></div>

<div class="content-wrapper">
    <div class="welcome-card" style="background: linear-gradient(135deg, rgba(102, 126, 234, 0.2) 0%, rgba(118, 75, 162, 0.2) 100%); backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.2); border-radius: 20px; padding: 2rem; margin-bottom: 2rem; color: white;">
        <h1 style="font-size: 2.5rem; font-weight: bold; margin-bottom: 0.5rem;">Welcome to Universepedia! 🚀</h1>
        <p style="color: rgba(255, 255, 255, 0.8); font-size: 1.1rem;">Explore cosmic events and discover the wonders of our universe</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div style="background: rgba(0, 0, 0, 0.5); backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.2); border-radius: 15px; padding: 2rem; text-align: center; transition: all 0.3s ease;">
            <div style="font-size: 3rem; margin-bottom: 1rem;">👥</div>
            <div style="font-size: 2.5rem; font-weight: bold; color: #FDB813; margin-bottom: 0.5rem;">{{ \App\Models\User::count() }}</div>
            <div style="color: rgba(255, 255, 255, 0.8); font-size: 1rem;">Space Explorers</div>
        </div>
        
        <div style="background: rgba(0, 0, 0, 0.5); backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.2); border-radius: 15px; padding: 2rem; text-align: center; transition: all 0.3s ease;">
            <div style="font-size: 3rem; margin-bottom: 1rem;">🌍</div>
            <div style="font-size: 2.5rem; font-weight: bold; color: #FDB813; margin-bottom: 0.5rem;">{{ \App\Models\Planet::count() }}</div>
            <div style="color: rgba(255, 255, 255, 0.8); font-size: 1rem;">Planets Cataloged</div>
        </div>
        
        <div style="background: rgba(0, 0, 0, 0.5); backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.2); border-radius: 15px; padding: 2rem; text-align: center; transition: all 0.3s ease;">
            <div style="font-size: 3rem; margin-bottom: 1rem;">📅</div>
            <div style="font-size: 2.5rem; font-weight: bold; color: #FDB813; margin-bottom: 0.5rem;">{{ \App\Models\Event::count() }}</div>
            <div style="color: rgba(255, 255, 255, 0.8); font-size: 1rem;">Total Events</div>
        </div>
    </div>

    <div class="mb-8">
        <div class="flex justify-between items-center mb-6">
            <h2 style="color: white; font-size: 2rem; font-weight: bold; display: flex; align-items: center; gap: 0.5rem;">
                <span>🪐</span>
                <span>Featured Planets</span>
            </h2>
            <div class="flex gap-3">
                <a href="{{ route('planets.index') }}" style="color: #FDB813; text-decoration: none; font-weight: 500;">View All →</a>
                @if(auth()->user()->isAdmin())
                    <a href="{{ route('planets.create') }}" style="background: rgba(102, 126, 234, 0.9); color: white; padding: 0.7rem 1.5rem; border-radius: 10px; text-decoration: none;">+ Add Planet</a>
                @endif
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse(\App\Models\Planet::latest()->take(3)->get() as $planet)
                <div class="glass-card">
                    @if($planet->image)
                        <img src="{{ asset('storage/' . $planet->image) }}" alt="{{ $planet->name }}" style="width: 100%; height: 150px; object-fit: cover; border-radius: 10px; margin-bottom: 1rem; border: 2px solid rgba(255, 255, 255, 0.2);">
                    @else
                        <div style="width: 100%; height: 150px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 4rem; margin-bottom: 1rem;">🪐</div>
                    @endif
                    
                    <h3 style="color: white; font-size: 1.3rem; font-weight: bold; margin-bottom: 0.5rem;">{{ $planet->name }}</h3>
                    
                    <div class="rating-stars">
                        @php
                            $avg = $planet->averageRating();
                            $fullStars = floor($avg);
                            $hasHalf = ($avg - $fullStars) >= 0.5;
                        @endphp
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <= $fullStars)
                                ★
                            @elseif($i == $fullStars + 1 && $hasHalf)
                                ☆
                            @else
                                ☆
                            @endif
                        @endfor
                        <span style="margin-left: 0.3rem;">{{ number_format($avg, 1) }}</span>
                    </div>
                    <div class="rating-info">({{ $planet->totalRatings() }} ratings)</div>
                    
                    <p style="color: rgba(255, 255, 255, 0.7); font-size: 0.9rem; margin: 1rem 0; line-height: 1.5;">{{ Str::limit($planet->description, 80) }}</p>
                    
                    <a href="{{ route('planets.show', $planet) }}" style="display: inline-block; width: 100%; padding: 0.7rem; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; text-align: center; border-radius: 10px; text-decoration: none; font-weight: 500; margin-top: 1rem;">
                        View Details →
                    </a>
                </div>
            @empty
                <div class="col-span-3 glass-card text-center" style="padding: 3rem;">
                    <p style="color: rgba(255, 255, 255, 0.7); font-size: 1.1rem;">No planets found yet.</p>
                </div>
            @endforelse
        </div>
    </div>

    <div class="mb-8">
        <div class="flex justify-between items-center mb-6">
            <h2 style="color: white; font-size: 2rem; font-weight: bold; display: flex; align-items: center; gap: 0.5rem;">
                <span>🌠</span>
                <span>Recent Space Events</span>
            </h2>
            <div class="flex gap-3">
                <a href="{{ route('events.index') }}" style="color: #FDB813; text-decoration: none; font-weight: 500;">View All →</a>
                @if(auth()->user()->isAdmin())
                    <a href="{{ route('events.create') }}" style="background: rgba(102, 126, 234, 0.9); color: white; padding: 0.7rem 1.5rem; border-radius: 10px; text-decoration: none;">+ Add Event</a>
                @endif
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse(\App\Models\Event::latest()->take(6)->get() as $event)
                <div class="glass-card">
                    @if($event->image)
                        <img src="{{ asset('storage/' . $event->image) }}" alt="{{ $event->title }}" style="width: 100%; height: 150px; object-fit: cover; border-radius: 10px; margin-bottom: 1rem; border: 2px solid rgba(255, 255, 255, 0.2);">
                    @else
                        <div style="width: 100%; height: 150px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 4rem; margin-bottom: 1rem;">🌌</div>
                    @endif
                    
                    <span style="display: inline-block; padding: 0.3rem 0.8rem; border-radius: 20px; font-size: 0.75rem; font-weight: 600; text-transform: uppercase; background: rgba(253, 184, 19, 0.2); color: #FDB813; border: 1px solid rgba(253, 184, 19, 0.3);">{{ $event->getFormattedType() }}</span>
                    
                    <h3 style="color: white; font-size: 1.3rem; font-weight: bold; margin: 0.5rem 0;">{{ $event->title }}</h3>
                    
                    <div class="rating-stars">
                        @php
                            $avg = $event->averageRating();
                            $fullStars = floor($avg);
                            $hasHalf = ($avg - $fullStars) >= 0.5;
                        @endphp
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <= $fullStars)
                                ★
                            @elseif($i == $fullStars + 1 && $hasHalf)
                                ☆
                            @else
                                ☆
                            @endif
                        @endfor
                        <span style="margin-left: 0.3rem;">{{ number_format($avg, 1) }}</span>
                    </div>
                    <div class="rating-info">({{ $event->totalRatings() }} ratings)</div>
                    
                    <p style="color: rgba(255, 255, 255, 0.7); font-size: 0.9rem; margin: 1rem 0; line-height: 1.5;">{{ Str::limit($event->description, 80) }}</p>
                    
                    <a href="{{ route('events.show', $event) }}" style="display: inline-block; width: 100%; padding: 0.7rem; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; text-align: center; border-radius: 10px; text-decoration: none; font-weight: 500; margin-top: 1rem;">
                        View Details →
                    </a>
                </div>
            @empty
                <div class="col-span-3 glass-card text-center" style="padding: 3rem;">
                    <p style="color: rgba(255, 255, 255, 0.7); font-size: 1.1rem;">No events found yet.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>

<script>
    const starsBg = document.getElementById('starsBg');
    for (let i = 0; i < 150; i++) {
        const star = document.createElement('div');
        star.className = 'star';
        star.style.left = Math.random() * 100 + '%';
        star.style.top = Math.random() * 100 + '%';
        star.style.width = Math.random() * 3 + 1 + 'px';
        star.style.height = star.style.width;
        star.style.animationDelay = Math.random() * 3 + 's';
        starsBg.appendChild(star);
    }
</script>
@endsection