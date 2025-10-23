@extends('layouts.app')

@section('title', 'Trash - Admin Panel')

@section('content')
<div class="max-w-7xl mx-auto">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">🗑️ Trash Management</h1>
    <p class="text-gray-600 mb-6">Manage soft-deleted items. You can restore or permanently delete them.</p>

    <!-- Events -->
    <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
        <h2 class="text-2xl font-bold text-gray-800 mb-4">Deleted Events ({{ $events->count() }})</h2>
        
        @if($events->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Title</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Type</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Deleted At</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($events as $event)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $event->title }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 py-1 text-xs bg-purple-100 text-purple-800 rounded">{{ $event->getFormattedType() }}</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $event->deleted_at->diffForHumans() }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm flex gap-2">
                                    <form action="{{ route('events.restore', $event->id) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="px-3 py-1 bg-green-600 text-white rounded hover:bg-green-700">
                                            Restore
                                        </button>
                                    </form>
                                    
                                    <form action="{{ route('events.force-delete', $event->id) }}" method="POST" class="inline" onsubmit="return confirm('Permanently delete? This cannot be undone!')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700">
                                            Delete Forever
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-gray-500 text-center py-4">No deleted events.</p>
        @endif
    </div>

    <!-- Planets -->
    <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
        <h2 class="text-2xl font-bold text-gray-800 mb-4">Deleted Planets ({{ $planets->count() }})</h2>
        
        @if($planets->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Size</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Deleted At</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($planets as $planet)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $planet->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $planet->size }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $planet->deleted_at->diffForHumans() }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm flex gap-2">
                                    <form action="{{ route('planets.restore', $planet->id) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="px-3 py-1 bg-green-600 text-white rounded hover:bg-green-700">
                                            Restore
                                        </button>
                                    </form>
                                    
                                    <form action="{{ route('planets.force-delete', $planet->id) }}" method="POST" class="inline" onsubmit="return confirm('Permanently delete? This cannot be undone!')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700">
                                            Delete Forever
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-gray-500 text-center py-4">No deleted planets.</p>
        @endif
    </div>

    <!-- Comments -->
    <div class="bg-white rounded-lg shadow-lg p-6">
        <h2 class="text-2xl font-bold text-gray-800 mb-4">Deleted Comments ({{ $comments->count() }})</h2>
        
        @if($comments->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">User</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Content</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Deleted At</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($comments as $comment)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $comment->user->name }}</td>
                                <td class="px-6 py-4">
                                    <div class="max-w-md truncate">{!! Str::limit($comment->content, 100) !!}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $comment->deleted_at->diffForHumans() }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm flex gap-2">
                                    <form action="{{ route('comments.restore', $comment->id) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="px-3 py-1 bg-green-600 text-white rounded hover:bg-green-700">
                                            Restore
                                        </button>
                                    </form>
                                    
                                    <form action="{{ route('comments.force-delete', $comment->id) }}" method="POST" class="inline" onsubmit="return confirm('Permanently delete? This cannot be undone!')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700">
                                            Delete Forever
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-gray-500 text-center py-4">No deleted comments.</p>
        @endif
    </div>
</div>
@endsection