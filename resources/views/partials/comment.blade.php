<div class="comment-item {{ isset($isReply) && $isReply ? 'comment-reply' : '' }}">
    <div class="comment-header">
        <div>
            <span class="comment-author">{{ $comment->user->name }}</span>
            @if($comment->user->isAdmin())
                <span class="ml-2 px-2 py-1 text-xs bg-yellow-100 text-yellow-800 rounded">Admin</span>
            @endif
            @if($comment->trashed())
                <span class="ml-2 px-2 py-1 text-xs bg-red-100 text-red-800 rounded">Deleted</span>
            @endif
        </div>
        <span class="comment-date">{{ $comment->created_at->diffForHumans() }}</span>
    </div>
    
    <div class="comment-content">{!! $comment->content !!}</div>
    
    <div class="comment-actions">
        @if(!$comment->trashed())
            <button onclick="toggleReply({{ $comment->id }})">Reply</button>
        @endif
        
        @if(auth()->id() === $comment->user_id || auth()->user()->isAdmin())
            @if(!$comment->trashed())
                <form action="{{ route('comments.destroy', $comment) }}" method="POST" style="display: inline;" onsubmit="return confirm('Delete this comment?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" style="color: #ef4444;">Delete</button>
                </form>
            @else
                @if(auth()->user()->isAdmin())
                    <form action="{{ route('comments.restore', $comment->id) }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" style="color: #10b981;">Restore</button>
                    </form>
                    
                    <form action="{{ route('comments.force-delete', $comment->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Permanently delete? This cannot be undone!')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" style="color: #ef4444;">Delete Forever</button>
                    </form>
                @endif
            @endif
        @endif
    </div>
    
    @if(!$comment->trashed())
        <!-- Reply Form -->
        <div class="reply-form" id="reply-form-{{ $comment->id }}">
            <form action="{{ route('comments.store') }}" method="POST" class="mt-3">
                @csrf
                <input type="hidden" name="type" value="{{ $type }}">
                <input type="hidden" name="id" value="{{ $itemId }}">
                <input type="hidden" name="parent_id" value="{{ $comment->id }}">
                
                <textarea name="content" class="reply-editor w-full border rounded p-2" placeholder="Write a reply..."></textarea>
                
                <button type="submit" class="mt-2 px-4 py-2 bg-purple-600 text-white rounded hover:bg-purple-700 transition text-sm">
                    Post Reply
                </button>
            </form>
        </div>
    @endif
    
    <!-- Nested Replies -->
    @if($comment->replies->count() > 0)
        <div class="mt-3">
            @foreach($comment->replies as $reply)
                @include('partials.comment', ['comment' => $reply, 'type' => $type, 'itemId' => $itemId, 'isReply' => true])
            @endforeach
        </div>
    @endif
</div>