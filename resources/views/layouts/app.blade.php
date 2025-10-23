<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Universepedia - Explore the Universe')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .card-hover:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Navigation -->
    <nav class="gradient-bg text-white shadow-lg">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center py-4">
                <a href="{{ route('dashboard') }}" class="text-2xl font-bold">
                    🌌 Universepedia
                </a>
                
                <div class="hidden md:flex space-x-6">
                    <a href="{{ route('dashboard') }}" class="hover:text-purple-200 transition">Dashboard</a>
                    <a href="{{ route('events.index') }}" class="hover:text-purple-200 transition">Events</a>
                    <a href="{{ route('planets.index') }}" class="hover:text-purple-200 transition">Planets</a>
                    <a href="{{ route('favorites.index') }}" class="hover:text-purple-200 transition">Favorites</a>
                    
                    @auth
                        @if(auth()->user()->isAdmin())
                            <a href="{{ route('admin.activity-logs') }}" class="hover:text-purple-200 transition">Activity Logs</a>
                            <a href="{{ route('admin.trash') }}" class="hover:text-purple-200 transition">Trash</a>
                        @endif
                    @endauth
                </div>

                <div class="flex items-center space-x-4">
                    @auth
                        <span class="text-sm">
                            {{ auth()->user()->name }} 
                            <span class="px-2 py-1 text-xs rounded-full {{ auth()->user()->isAdmin() ? 'bg-yellow-400 text-purple-900' : 'bg-purple-300 text-purple-900' }}">
                                {{ ucfirst(auth()->user()->role) }}
                            </span>
                        </span>
                        <form action="{{ route('logout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="bg-white text-purple-700 px-4 py-2 rounded-lg hover:bg-purple-100 transition">
                                Logout
                            </button>
                        </form>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Flash Messages -->
    @if(session('success'))
        <div class="container mx-auto px-4 mt-4">
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="container mx-auto px-4 mt-4">
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        </div>
    @endif

    <!-- Main Content -->
    <main class="container mx-auto px-4 py-8">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="gradient-bg text-white mt-16 py-8">
        <div class="container mx-auto px-4 text-center">
            <p>&copy; 2025 Universepedia. Explore the wonders of the universe.</p>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>