@extends('layouts.app')

@section('title', 'Activity Logs - Universepedia')

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
    }
    
    .input-field {
        background: rgba(255, 255, 255, 0.9);
        border: 1px solid rgba(255, 255, 255, 0.3);
        transition: all 0.3s ease;
        color: #1a202c;
    }
    
    .input-field:focus {
        background: rgba(255, 255, 255, 1);
        border-color: #667eea;
        box-shadow: 0 0 20px rgba(102, 126, 234, 0.3);
        outline: none;
    }
    
    .gradient-bg {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }
    
    .btn-filter {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        transition: all 0.3s ease;
    }
    
    .btn-filter:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 30px rgba(102, 126, 234, 0.4);
    }
    
    .btn-clear {
        background: rgba(255, 255, 255, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.3);
        color: white;
        transition: all 0.3s ease;
    }
    
    .btn-clear:hover {
        background: rgba(255, 255, 255, 0.2);
        transform: translateY(-2px);
    }
    
    .table-row {
        background: rgba(0, 0, 0, 0.3);
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        transition: all 0.3s ease;
    }
    
    .table-row:hover {
        background: rgba(102, 126, 234, 0.2);
    }
    
    .stat-card {
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        transition: all 0.3s ease;
    }
    
    .stat-card:hover {
        transform: translateY(-5px);
        border-color: rgba(102, 126, 234, 0.5);
        box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
    }
    
    .badge {
        backdrop-filter: blur(10px);
        border: 1px solid;
    }

    /* === Modal Section (Updated for better readability) === */
    .modal-overlay {
        background: rgba(0, 0, 0, 0.85);
        backdrop-filter: blur(5px);
    }

    .modal-content {
        background: #ffffff !important;
        color: #1a1a1a !important;
        backdrop-filter: none !important;
    }

    .modal-content pre {
        background: #f8f9fa;
        color: #212529;
        border-radius: 8px;
        padding: 10px;
        line-height: 1.4;
        overflow-x: auto;
        font-size: 13px;
    }

    .modal-content .text-gray-700,
    .modal-content .text-gray-600 {
        color: #333 !important;
    }
</style>

<!-- Stars Background -->
<div class="stars-bg" id="starsBg"></div>

<div class="content-wrapper">
    <div class="mb-8">
        <h1 class="text-4xl font-bold text-white mb-2">📋 Activity Logs</h1>
        <p class="text-gray-300">Monitor all user activities and system changes</p>
    </div>

    <!-- Filter -->
    <div class="glass-card p-6 rounded-2xl mb-8">
        <form action="{{ route('admin.activity-logs') }}" method="GET" class="flex flex-wrap gap-4">
            <input 
                type="text" 
                name="search" 
                value="{{ $search }}"
                placeholder="Search by user or description..." 
                class="input-field flex-1 min-w-[200px] px-4 py-3 rounded-lg"
            >
            
            <select name="action" class="input-field px-4 py-3 rounded-lg">
                <option value="">All Actions</option>
                <option value="create" {{ $actionFilter == 'create' ? 'selected' : '' }}>Create</option>
                <option value="update" {{ $actionFilter == 'update' ? 'selected' : '' }}>Update</option>
                <option value="delete" {{ $actionFilter == 'delete' ? 'selected' : '' }}>Delete</option>
                <option value="favorite" {{ $actionFilter == 'favorite' ? 'selected' : '' }}>Favorite</option>
                <option value="unfavorite" {{ $actionFilter == 'unfavorite' ? 'selected' : '' }}>Unfavorite</option>
                <option value="login" {{ $actionFilter == 'login' ? 'selected' : '' }}>Login</option>
                <option value="logout" {{ $actionFilter == 'logout' ? 'selected' : '' }}>Logout</option>
                <option value="register" {{ $actionFilter == 'register' ? 'selected' : '' }}>Register</option>
                <option value="view" {{ $actionFilter == 'view' ? 'selected' : '' }}>View</option>
            </select>

            <button type="submit" class="btn-filter px-6 py-3 text-white rounded-lg font-semibold">
                Filter
            </button>
            
            @if($search || $actionFilter)
                <a href="{{ route('admin.activity-logs') }}" class="btn-clear px-6 py-3 rounded-lg font-semibold">
                    Clear
                </a>
            @endif
        </form>
    </div>

    @if($logs->count() > 0)
        <div class="glass-card rounded-2xl overflow-hidden mb-8">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="gradient-bg text-white">
                        <tr>
                            <th class="px-6 py-4 text-left text-sm font-semibold">User ID</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold">User</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold">Role</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold">Action</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold">Model</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold">Model ID</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold">Description</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold">Changes</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold">Date & Time</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($logs as $log)
                            <tr class="table-row">
                                <td class="px-6 py-4 text-gray-400 text-sm">#{{ $log->user_id }}</td>
                                <td class="px-6 py-4">
                                    <p class="font-semibold text-white">{{ $log->user->name }}</p>
                                    <p class="text-xs text-gray-400">{{ $log->user->email }}</p>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="badge inline-block px-3 py-1 text-xs font-semibold rounded-full {{ $log->user->role === 'admin' ? 'bg-purple-500 bg-opacity-20 text-purple-300 border-purple-400' : 'bg-gray-500 bg-opacity-20 text-gray-300 border-gray-400' }}">
                                        {{ ucfirst($log->user->role) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="badge inline-block px-3 py-1 text-xs font-semibold rounded-full
                                        {{ $log->action === 'create' ? 'bg-green-500 bg-opacity-20 text-green-300 border-green-400' : '' }}
                                        {{ $log->action === 'update' ? 'bg-blue-500 bg-opacity-20 text-blue-300 border-blue-400' : '' }}
                                        {{ $log->action === 'delete' ? 'bg-red-500 bg-opacity-20 text-red-300 border-red-400' : '' }}
                                        {{ $log->action === 'favorite' ? 'bg-yellow-500 bg-opacity-20 text-yellow-300 border-yellow-400' : '' }}
                                        {{ $log->action === 'unfavorite' ? 'bg-gray-500 bg-opacity-20 text-gray-300 border-gray-400' : '' }}
                                        {{ $log->action === 'login' ? 'bg-indigo-500 bg-opacity-20 text-indigo-300 border-indigo-400' : '' }}
                                        {{ $log->action === 'logout' ? 'bg-pink-500 bg-opacity-20 text-pink-300 border-pink-400' : '' }}
                                        {{ $log->action === 'register' ? 'bg-teal-500 bg-opacity-20 text-teal-300 border-teal-400' : '' }}
                                        {{ $log->action === 'view' ? 'bg-cyan-500 bg-opacity-20 text-cyan-300 border-cyan-400' : '' }}
                                    ">
                                        {{ $log->getFormattedAction() }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-gray-300 text-sm">{{ $log->model ?? '-' }}</td>
                                <td class="px-6 py-4 text-gray-400 text-sm">{{ $log->model_id ?? '-' }}</td>
                                <td class="px-6 py-4 text-gray-300 text-sm">{{ $log->description }}</td>
                                <td class="px-6 py-4">
                                    @if($log->old_value || $log->new_value)
                                        <button onclick="showChanges({{ $log->id }})" class="text-blue-400 hover:text-blue-300 text-sm font-medium flex items-center gap-1 transition">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                            View Changes
                                        </button>

                                        <!-- Modal -->
                                        <div id="modal-{{ $log->id }}" class="modal-overlay hidden fixed inset-0 z-50 items-center justify-center p-4">
                                            <div class="modal-content rounded-2xl shadow-xl max-w-4xl w-full max-h-[90vh] overflow-y-auto">
                                                <div class="gradient-bg text-white px-6 py-4 flex justify-between items-center sticky top-0 rounded-t-2xl">
                                                    <h3 class="text-lg font-semibold">📝 Value Changes - {{ $log->getFormattedAction() }}</h3>
                                                    <button onclick="hideChanges({{ $log->id }})" class="text-white hover:text-gray-200 transition">
                                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                        </svg>
                                                    </button>
                                                </div>
                                                <div class="p-6">
                                                    <div class="mb-4">
                                                        <p class="text-sm text-gray-600"><strong>Action:</strong> {{ $log->getFormattedAction() }}</p>
                                                        <p class="text-sm text-gray-600"><strong>Model:</strong> {{ $log->model ?? 'N/A' }}</p>
                                                        <p class="text-sm text-gray-600"><strong>Description:</strong> {{ $log->description }}</p>
                                                    </div>
                                                    
                                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                        <div>
                                                            <h4 class="font-semibold text-gray-700 mb-2 flex items-center gap-2">
                                                                <span class="inline-block w-3 h-3 bg-red-500 rounded-full"></span>
                                                                Old Value
                                                            </h4>
                                                            <div class="bg-red-50 border border-red-200 rounded-lg p-4 text-sm max-h-96 overflow-y-auto">
                                                                @if($log->old_value)
                                                                    <pre class="whitespace-pre-wrap text-gray-700 font-mono text-xs">{{ json_encode(json_decode($log->old_value), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) }}</pre>
                                                                @else
                                                                    <span class="text-gray-400 italic">No previous value</span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        
                                                        <div>
                                                            <h4 class="font-semibold text-gray-700 mb-2 flex items-center gap-2">
                                                                <span class="inline-block w-3 h-3 bg-green-500 rounded-full"></span>
                                                                New Value
                                                            </h4>
                                                            <div class="bg-green-50 border border-green-200 rounded-lg p-4 text-sm max-h-96 overflow-y-auto">
                                                                @if($log->new_value)
                                                                    <pre class="whitespace-pre-wrap text-gray-700 font-mono text-xs">{{ json_encode(json_decode($log->new_value), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) }}</pre>
                                                                @else
                                                                    <span class="text-gray-400 italic">No new value</span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        <span class="text-gray-500 text-sm">-</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <p class="text-sm text-gray-300">{{ $log->created_at->format('M d, Y') }}</p>
                                    <p class="text-xs text-gray-500">{{ $log->created_at->format('h:i A') }}</p>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-6">
            {{ $logs->appends(['search' => $search, 'action' => $actionFilter])->links() }}
        </div>
    @else
        <div class="glass-card p-12 rounded-2xl text-center mb-8">
            <p class="text-gray-300 text-lg">No activity logs found.</p>
        </div>
    @endif

    <!-- Statistics -->
    <div class="grid grid-cols-1 md:grid-cols-5 gap-4 mt-8">
        @php
            $totalLogs = \App\Models\ActivityLog::count();
            $creates = \App\Models\ActivityLog::where('action', 'create')->count();
            $updates = \App\Models\ActivityLog::where('action', 'update')->count();
            $deletes = \App\Models\ActivityLog::where('action', 'delete')->count();
            $favorites = \App\Models\ActivityLog::whereIn('action', ['favorite', 'unfavorite'])->count();
        @endphp
        
        <div class="stat-card p-6 rounded-2xl text-center">
            <p class="text-3xl font-bold text-purple-400">{{ $totalLogs }}</p>
            <p class="text-gray-400 text-sm mt-2">Total Activities</p>
        </div>
        
        <div class="stat-card p-6 rounded-2xl text-center">
            <p class="text-3xl font-bold text-green-400">{{ $creates }}</p>
            <p class="text-gray-400 text-sm mt-2">Created</p>
        </div>
        
        <div class="stat-card p-6 rounded-2xl text-center">
            <p class="text-3xl font-bold text-blue-400">{{ $updates }}</p>
            <p class="text-gray-400 text-sm mt-2">Updated</p>
        </div>
        
        <div class="stat-card p-6 rounded-2xl text-center">
            <p class="text-3xl font-bold text-red-400">{{ $deletes }}</p>
            <p class="text-gray-400 text-sm mt-2">Deleted</p>
        </div>
        
        <div class="stat-card p-6 rounded-2xl text-center">
            <p class="text-3xl font-bold text-yellow-400">{{ $favorites }}</p>
            <p class="text-gray-400 text-sm mt-2">Favorites</p>
        </div>
    </div>
</div>

<script>
function showChanges(id) {
    document.getElementById(`modal-${id}`).classList.remove('hidden');
    document.getElementById(`modal-${id}`).classList.add('flex');
}

function hideChanges(id) {
    document.getElementById(`modal-${id}`).classList.add('hidden');
    document.getElementById(`modal-${id}`).classList.remove('flex');
}

const starsBg = document.getElementById('starsBg');
for (let i = 0; i < 150; i++) {
    const star = document.createElement('div');
    star.className = 'star';
    const size = Math.random() * 2;
    star.style.width = `${size}px`;
    star.style.height = `${size}px`;
    star.style.top = `${Math.random() * 100}%`;
    star.style.left = `${Math.random() * 100}%`;
    star.style.animationDelay = `${Math.random() * 3}s`;
    starsBg.appendChild(star);
}
</script>
@endsection