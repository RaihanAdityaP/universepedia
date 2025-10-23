<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Universepedia</title>
    <script src="https://cdn.tailwindcss.com"></script>
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
        
        .glass-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            position: relative;
            z-index: 1;
        }
        
        .input-field {
            background: rgba(255, 255, 255, 0.9);
            border: 1px solid rgba(255, 255, 255, 0.3);
            transition: all 0.3s ease;
        }
        
        .input-field:focus {
            background: rgba(255, 255, 255, 1);
            border-color: #667eea;
            box-shadow: 0 0 20px rgba(102, 126, 234, 0.3);
        }
        
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        
        .btn-gradient:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.4);
        }
    </style>
</head>
<body class="flex items-center justify-center py-12">
    <!-- Stars Background -->
    <div class="stars-bg" id="starsBg"></div>

    <div class="glass-card p-8 rounded-2xl shadow-2xl w-full max-w-md mx-4">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-white mb-2">🌌 Universepedia</h1>
            <p class="text-gray-300">Create your account</p>
        </div>

        @if($errors->any())
            <div class="bg-red-500 bg-opacity-20 border border-red-400 text-red-200 px-4 py-3 rounded-lg mb-4 backdrop-blur-sm">
                @foreach($errors->all() as $error)
                    <p class="text-sm">{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form action="{{ route('register') }}" method="POST">
            @csrf
            
            <div class="mb-4">
                <label for="name" class="block text-white font-semibold mb-2">Full Name</label>
                <input 
                    type="text" 
                    name="name" 
                    id="name" 
                    value="{{ old('name') }}"
                    class="input-field w-full px-4 py-3 rounded-lg focus:outline-none"
                    required
                >
            </div>

            <div class="mb-4">
                <label for="email" class="block text-white font-semibold mb-2">Email</label>
                <input 
                    type="email" 
                    name="email" 
                    id="email" 
                    value="{{ old('email') }}"
                    class="input-field w-full px-4 py-3 rounded-lg focus:outline-none"
                    required
                >
            </div>

            <div class="mb-4">
                <label for="password" class="block text-white font-semibold mb-2">Password</label>
                <input 
                    type="password" 
                    name="password" 
                    id="password" 
                    class="input-field w-full px-4 py-3 rounded-lg focus:outline-none"
                    required
                >
            </div>

            <div class="mb-6">
                <label for="password_confirmation" class="block text-white font-semibold mb-2">Confirm Password</label>
                <input 
                    type="password" 
                    name="password_confirmation" 
                    id="password_confirmation" 
                    class="input-field w-full px-4 py-3 rounded-lg focus:outline-none"
                    required
                >
            </div>

            <button 
                type="submit" 
                class="w-full gradient-bg text-white py-3 rounded-lg font-semibold btn-gradient transition-all duration-300"
            >
                Register
            </button>
        </form>

        <div class="text-center mt-6">
            <p class="text-gray-300">
                Already have an account? 
                <a href="{{ route('login') }}" class="text-purple-400 font-semibold hover:text-purple-300 transition">Login here</a>
            </p>
        </div>
    </div>

    <script>
        // Generate stars
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
</body>
</html>