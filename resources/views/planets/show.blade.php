@extends('layouts.app')

@section('title', $planet->name . ' - Universepedia')

@section('content')
<style>
    .rating-container {
        display: flex;
        gap: 0.5rem;
        align-items: center;
        margin: 1rem 0;
    }
    
    .star-rating {
        display: flex;
        gap: 0.25rem;
        cursor: pointer;
    }
    
    .star-rating .star {
        font-size: 2rem;
        color: #ddd;
        transition: color 0.2s;
    }
    
    .star-rating .star.active,
    .star-rating .star:hover,
    .star-rating .star:hover ~ .star {
        color: #FDB813;
    }
    
    .comment-section {
        background: #f9fafb;
        border-radius: 10px;
        padding: 1.5rem;
        margin-top: 2rem;
    }
    
    .comment-item {
        background: white;
        border-radius: 8px;
        padding: 1rem;
        margin-bottom: 1rem;
        border: 1px solid #e5e7eb;
    }
    
    .comment-reply {
        margin-left: 2rem;
        margin-top: 0.5rem;
    }
    
    .comment-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 0.5rem;
    }
    
    .comment-author {
        font-weight: 600;
        color: #374151;
    }
    
    .comment-date {
        font-size: 0.875rem;
        color: #6b7280;
    }
    
    .comment-content {
        color: #4b5563;
        line-height: 1.6;
    }
    
    .comment-actions {
        margin-top: 0.5rem;
        display: flex;
        gap: 1rem;
    }
    
    .comment-actions button {
        font-size: 0.875rem;
        color: #6366f1;
        background: none;
        border: none;
        cursor: pointer;
        padding: 0;
    }
    
    .comment-actions button:hover {
        text-decoration: underline;
    }
    
    .reply-form {
        margin-top: 0.5rem;
        display: none;
    }
    
    .reply-form.active {
        display: block;
    }
    
    .ck-editor__editable {
        min-height: 150px;
    }
</style>

<div class="max-w-4xl mx-auto">
    <div class="mb-6">
        <a href="{{ route('planets.index') }}" class="text-purple-600 hover:text-purple-800 font-semibold">
            ← Back to Planets
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
        @if($planet->image)
            <img src="{{ asset('storage/' . $planet->image) }}" alt="{{ $planet->name }}" class="w-full h-96 object-cover">
        @else
            <div class="w-full h-96 gradient-bg flex items-center justify-center text-white text-9xl">
                🪐
            </div>
        @endif

        <div class="p-8">
            <div class="flex justify-between items-start mb-4">
                <div>
                    <h1 class="text-4xl font-bold text-gray-800 mb-2">{{ $planet->name }}</h1>
                    <p class="text-gray-400 text-sm mt-2">Created by: {{ $planet->creator->name }}</p>
                    
                    <div class="rating-container">
                        <div style="color: #FDB813; font-size: 1.2rem;">
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
                        </div>
                        <span class="text-gray-600">{{ number_format($avg, 1) }} ({{ $planet->totalRatings() }} ratings)</span>
                    </div>
                </div>

                <form action="{{ route('favorites.toggle') }}" method="POST" id="favoriteForm">
                    @csrf
                    <input type="hidden" name="type" value="planet">
                    <input type="hidden" name="id" value="{{ $planet->id }}">
                    <button 
                        type="submit" 
                        class="px-6 py-3 rounded-lg transition {{ auth()->user()->hasFavorited($planet) ? 'bg-yellow-400 text-yellow-900 hover:bg-yellow-500' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}"
                        id="favoriteBtn"
                    >
                        {{ auth()->user()->hasFavorited($planet) ? '★ Favorited' : '☆ Add to Favorites' }}
                    </button>
                </form>
            </div>

            <div class="border-t border-gray-200 pt-6 mt-6">
                <h2 class="text-2xl font-bold text-gray-800 mb-4">Rate This Planet</h2>
                <form action="{{ route('ratings.store') }}" method="POST" id="ratingForm">
                    @csrf
                    <input type="hidden" name="type" value="planet">
                    <input type="hidden" name="id" value="{{ $planet->id }}">
                    <input type="hidden" name="rating" id="ratingValue" value="{{ $userRating->rating ?? 0 }}">
                    
                    <div class="star-rating" id="starRating">
                        @for($i = 1; $i <= 5; $i++)
                            <span class="star {{ $userRating && $i <= $userRating->rating ? 'active' : '' }}" data-rating="{{ $i }}">★</span>
                        @endfor
                    </div>
                    <p class="text-sm text-gray-500 mt-2">{{ $userRating ? 'Your rating: ' . $userRating->rating . ' stars' : 'Click to rate' }}</p>
                </form>
            </div>

            <div class="border-t border-gray-200 pt-6 mt-6">
                <h2 class="text-2xl font-bold text-gray-800 mb-4">About {{ $planet->name }}</h2>
                <div class="text-gray-700 leading-relaxed">{!! $planet->description !!}</div>
            </div>

            <div class="border-t border-gray-200 pt-6 mt-6">
                <h3 class="text-xl font-bold text-gray-800 mb-3">Planet Specifications</h3>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-gray-500 text-sm">Size</p>
                        <p class="text-gray-800 font-semibold">{{ $planet->size }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm">Distance from Sun</p>
                        <p class="text-gray-800 font-semibold">{{ $planet->distance }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm">Favorited By</p>
                        <p class="text-gray-800 font-semibold">{{ $planet->favorites()->count() }} users</p>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm">Added On</p>
                        <p class="text-gray-800 font-semibold">{{ $planet->created_at->format('M d, Y') }}</p>
                    </div>
                </div>
            </div>

            @if(auth()->user()->isAdmin())
                <div class="border-t border-gray-200 pt-6 mt-6 flex gap-4">
                    <a href="{{ route('planets.edit', $planet) }}" class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                        Edit Planet
                    </a>
                    <form action="{{ route('planets.destroy', $planet) }}" method="POST" onsubmit="return confirm('This will soft delete. You can restore it later.')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-6 py-3 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
                            Delete Planet
                        </button>
                    </form>
                </div>
            @endif

            <!-- Comments Section -->
            <div class="comment-section">
                <h2 class="text-2xl font-bold text-gray-800 mb-4">Comments ({{ $planet->comments->count() }})</h2>
                
                <!-- Add Comment Form -->
                <form action="{{ route('comments.store') }}" method="POST" class="mb-6">
                    @csrf
                    <input type="hidden" name="type" value="planet">
                    <input type="hidden" name="id" value="{{ $planet->id }}">
                    
                    <label class="block text-gray-700 font-semibold mb-2">Add a Comment</label>
                    <textarea name="content" id="commentEditor" class="w-full"></textarea>
                    
                    <button type="submit" class="mt-3 px-6 py-2 gradient-bg text-white rounded-lg hover:opacity-90 transition">
                        Post Comment
                    </button>
                </form>

                <!-- Comments List -->
                <div class="space-y-4">
                    @forelse($planet->comments as $comment)
                        @include('partials.comment', ['comment' => $comment, 'type' => 'planet', 'itemId' => $planet->id])
                    @empty
                        <p class="text-gray-500 text-center py-4">No comments yet. Be the first to comment!</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.ckeditor.com/ckeditor5/40.1.0/classic/ckeditor.js"></script>
<script>
    // CKEditor for comment
    ClassicEditor
        .create(document.querySelector('#commentEditor'), {
            toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', '|', 'undo', 'redo']
        })
        .catch(error => {
            console.error(error);
        });

    // Favorite
    document.getElementById('favoriteForm').addEventListener('submit', async function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        const btn = document.getElementById('favoriteBtn');
        
        try {
            const response = await fetch(this.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                },
                body: formData
            });
            
            const data = await response.json();
            
            if (data.status === 'favorited') {
                btn.className = 'px-6 py-3 rounded-lg transition bg-yellow-400 text-yellow-900 hover:bg-yellow-500';
                btn.textContent = '★ Favorited';
            } else {
                btn.className = 'px-6 py-3 rounded-lg transition bg-gray-200 text-gray-700 hover:bg-gray-300';
                btn.textContent = '☆ Add to Favorites';
            }
        } catch (error) {
            console.error('Error:', error);
            this.submit();
        }
    });

    // Star Rating
    const stars = document.querySelectorAll('.star-rating .star');
    const ratingForm = document.getElementById('ratingForm');
    const ratingValue = document.getElementById('ratingValue');

    stars.forEach(star => {
        star.addEventListener('click', async function() {
            const rating = this.dataset.rating;
            ratingValue.value = rating;

            stars.forEach(s => s.classList.remove('active'));
            this.classList.add('active');
            let prev = this.previousElementSibling;
            while (prev) {
                prev.classList.add('active');
                prev = prev.previousElementSibling;
            }

            const formData = new FormData(ratingForm);
            
            try {
                const response = await fetch(ratingForm.action, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                    },
                    body: formData
                });
                
                const data = await response.json();
                if (data.success) {
                    location.reload();
                }
            } catch (error) {
                console.error('Error:', error);
            }
        });
    });

    // Reply toggle
    function toggleReply(commentId) {
        const replyForm = document.getElementById('reply-form-' + commentId);
        replyForm.classList.toggle('active');
    }

    // CKEditor for replies
    document.querySelectorAll('.reply-editor').forEach(textarea => {
        ClassicEditor
            .create(textarea, {
                toolbar: ['bold', 'italic', 'link', '|', 'undo', 'redo']
            })
            .catch(error => {
                console.error(error);
            });
    });
</script>
@endpush
@endsection