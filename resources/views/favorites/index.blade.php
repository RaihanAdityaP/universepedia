@extends('layouts.app')

@section('title', 'My Favorites - Universepedia')

@section('content')
<style>
    body {
        background: linear-gradient(to bottom, #000000, #0a0a1a, #1a0a2e) !important;
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
    }

    .glass-card {
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        transition: all 0.3s ease;
    }

    .glass-card:hover {
        transform: translateY(-5px);
        border-color: rgba(102, 126, 234, 0.5);
        box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
    }

    .gradient-bg {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }

    .btn-view {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        transition: all 0.3s ease;
    }

    .btn-view:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(118, 75, 162, 0.4);
    }

    .btn-remove {
        background: rgba(255, 255, 255, 0.1);
        color: #ff6b6b;
        border: 1px solid rgba(255, 255, 255, 0.3);
        transition: all 0.3s ease;
    }

    .btn-remove:hover {
        background: rgba(255, 255, 255, 0.2);
        transform: translateY(-2px);
    }
</style>

<!-- Stars Background -->
<div class="stars-bg" id="starsBg"></div>

<div class="content-wrapper">
    <div class="mb-8">
        <h1 class="text-4xl font-bold text-white mb-2">⭐ My Favorites</h1>
        <p class="text-gray-300">Your collection of favorite cosmic events and planets</p>
    </div>

    @if($favorites->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
            @foreach($favorites as $favorite)
                @php
                    $item = $favorite->favoritable;
                    $isEvent = $item instanceof \App\Models\Event;
                @endphp
                
                <div class="glass-card rounded-2xl overflow-hidden">
                    @if($item->image)
                        <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->title ?? $item->name }}" class="w-full h-48 object-cover">
                    @else
                        <div class="w-full h-48 gradient-bg flex items-center justify-center text-white text-6xl">
                            {{ $isEvent ? '🌌' : '🪐' }}
                        </div>
                    @endif
                    
                    <div class="p-6">
                        @if($isEvent)
                            <span class="inline-block px-3 py-1 text-xs font-semibold text-purple-300 bg-purple-500 bg-opacity-20 rounded-full mb-2 border border-purple-400">
                                {{ $item->getFormattedType() }}
                            </span>
                        @else
                            <span class="inline-block px-3 py-1 text-xs font-semibold text-blue-300 bg-blue-500 bg-opacity-20 rounded-full mb-2 border border-blue-400">
                                Planet
                            </span>
                        @endif
                        
                        <h3 class="text-xl font-bold text-white mb-2">{{ $item->title ?? $item->name }}</h3>
                        <p class="text-gray-300 text-sm mb-4">{{ Str::limit($item->description, 100) }}</p>
                        
                        @if($isEvent)
                            <p class="text-sm text-gray-400 mb-4">📅 {{ $item->date->format('F d, Y') }}</p>
                        @else
                            <p class="text-sm text-gray-400">📏 {{ $item->size }}</p>
                            <p class="text-sm text-gray-400 mb-4">🌍 {{ $item->distance }}</p>
                        @endif
                        
                        <div class="flex gap-2">
                            <a href="{{ $isEvent ? route('events.show', $item) : route('planets.show', $item) }}" 
                               class="flex-1 text-center px-4 py-2 text-white rounded-lg btn-view font-semibold">
                                View Details
                            </a>
                            
                            <form action="{{ route('favorites.toggle') }}" method="POST" class="inline">
                                @csrf
                                <input type="hidden" name="type" value="{{ $isEvent ? 'event' : 'planet' }}">
                                <input type="hidden" name="id" value="{{ $item->id }}">
                                <button 
                                    type="submit" 
                                    class="px-4 py-2 rounded-lg btn-remove font-semibold"
                                    title="Remove from favorites"
                                >
                                    ✕
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{ $favorites->links() }}
    @else
        <div class="glass-card p-12 rounded-2xl text-center">
            <div class="text-6xl mb-4">⭐</div>
            <p class="text-gray-300 text-lg mb-4">You haven't added any favorites yet.</p>
            <p class="text-gray-400 mb-6">Start exploring events and planets to build your collection!</p>
            <div class="flex gap-4 justify-center">
                <a href="{{ route('events.index') }}" class="px-6 py-3 rounded-lg text-white btn-view font-semibold">
                    Browse Events
                </a>
                <a href="{{ route('planets.index') }}" class="px-6 py-3 rounded-lg bg-purple-700 hover:bg-purple-800 text-white font-semibold transition">
                    Browse Planets
                </a>
            </div>
        </div>
    @endif
</div>

<script>
// Generate stars background
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