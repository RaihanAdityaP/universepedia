<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Universepedia - Space Exploration Platform</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700;900&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Inter', sans-serif;
            margin: 0;
            padding: 0;
            height: 100vh;
            overflow: hidden;
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f4c75 100%);
            position: relative;
        }
        
        /* Animated Background */
        .bg-animation {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: 
                radial-gradient(circle at 10% 20%, rgba(255, 255, 255, 0.1) 1px, transparent 1px),
                radial-gradient(circle at 80% 80%, rgba(255, 255, 255, 0.1) 1px, transparent 1px),
                radial-gradient(circle at 40% 60%, rgba(255, 255, 255, 0.05) 2px, transparent 2px),
                radial-gradient(circle at 90% 30%, rgba(255, 255, 255, 0.08) 1px, transparent 1px);
            background-size: 150px 150px, 200px 200px, 300px 300px, 180px 180px;
            animation: twinkle 8s ease-in-out infinite alternate;
            z-index: 1;
        }
        
        @keyframes twinkle {
            0% { opacity: 0.3; }
            100% { opacity: 0.8; }
        }
        
        /* Floating Elements */
        .floating-planet {
            position: absolute;
            border-radius: 50%;
            opacity: 0.15;
            animation: float 6s ease-in-out infinite;
            z-index: 2;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }
        
        .planet-1 {
            top: 10%;
            right: 15%;
            width: 100px;
            height: 100px;
            background: linear-gradient(135deg, #ff6b6b, #ee5a52);
            animation-delay: -2s;
        }
        
        .planet-2 {
            bottom: 20%;
            left: 10%;
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #4ecdc4, #44a08d);
            animation-delay: -4s;
        }
        
        .planet-3 {
            top: 30%;
            left: 5%;
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #45b7d1, #96c93d);
            animation-delay: -1s;
        }
        
        .planet-4 {
            top: 50%;
            right: 25%;
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #f093fb, #f5576c);
            animation-delay: -3s;
        }
        
        /* Main Content */
        .main-content {
            position: relative;
            z-index: 10;
            height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            padding: 2rem;
        }
        
        .game-title {
            font-family: 'Orbitron', monospace;
            font-size: 4rem;
            font-weight: 900;
            color: #ffffff;
            margin-bottom: 1rem;
            text-shadow: 0 0 30px rgba(255, 215, 0, 0.5);
            letter-spacing: 3px;
        }
        
        .game-subtitle {
            font-family: 'Orbitron', monospace;
            font-size: 1.5rem;
            font-weight: 400;
            color: #ffd700;
            margin-bottom: 3rem;
            text-shadow: 0 0 20px rgba(255, 215, 0, 0.3);
            letter-spacing: 2px;
        }
        
        .btn-game {
            font-family: 'Orbitron', monospace;
            font-size: 1.1rem;
            font-weight: 600;
            padding: 15px 40px;
            margin: 0 10px 10px 0;
            border: 2px solid #ffd700;
            border-radius: 0;
            background: transparent;
            color: #ffd700;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        
        .btn-game::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 215, 0, 0.2), transparent);
            transition: left 0.5s;
        }
        
        .btn-game:hover::before {
            left: 100%;
        }
        
        .btn-game:hover {
            background: rgba(255, 215, 0, 0.1);
            color: #ffffff;
            box-shadow: 0 0 30px rgba(255, 215, 0, 0.5);
            transform: translateY(-2px);
        }
        
        .btn-game.primary {
            background: linear-gradient(135deg, #ffd700, #ffed4e);
            color: #1a1a2e;
            border-color: #ffd700;
        }
        
        .btn-game.primary:hover {
            background: linear-gradient(135deg, #ffed4e, #ffd700);
            color: #1a1a2e;
            box-shadow: 0 0 30px rgba(255, 215, 0, 0.7);
        }
        
        @keyframes bounce {
            0%, 20%, 50%, 80%, 100% {
                transform: translateY(0);
            }
            40% {
                transform: translateY(-10px);
            }
            60% {
                transform: translateY(-5px);
            }
        }
        
        /* Character/Astronaut */
        .astronaut {
            position: absolute;
            right: 10%;
            top: 50%;
            transform: translateY(-50%);
            font-size: 8rem;
            opacity: 0.8;
            z-index: 3;
            animation: astronaut-float 4s ease-in-out infinite;
        }
        
        @keyframes astronaut-float {
            0%, 100% { 
                transform: translateY(-50%) rotate(-2deg); 
            }
            50% { 
                transform: translateY(-60%) rotate(2deg); 
            }
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .game-title {
                font-size: 2.5rem;
            }
            
            .game-subtitle {
                font-size: 1.1rem;
            }
            
            .astronaut {
                font-size: 4rem;
                right: 5%;
            }
            
            .btn-game {
                font-size: 0.9rem;
                padding: 12px 30px;
                display: block;
                margin: 10px auto;
            }
        }
    </style>
</head>
<body>
    <!-- Animated Background -->
    <div class="bg-animation"></div>
    
    <!-- Floating Planets -->
    <div class="floating-planet planet-1"></div>
    <div class="floating-planet planet-2"></div>
    <div class="floating-planet planet-3"></div>
    <div class="floating-planet planet-4"></div>
    
    <!-- Astronaut Character -->
    <div class="astronaut">
        🚀
    </div>
    
    <!-- Main Content -->
    <div class="main-content">
        <h1 class="game-title">Explore Beyond</h1>
        <h2 class="game-subtitle">Learn Without Limits</h2>
        
        <div class="mt-4">
            @auth
                <a href="{{ route('dashboard') }}" class="btn btn-game primary">
                    <i class="bi bi-rocket-takeoff me-2"></i>Enter Universe
                </a>
            @else
                <a href="{{ route('login') }}" class="btn btn-game primary">
                    <i class="bi bi-box-arrow-in-right me-2"></i>LOGIN
                </a>
                <a href="{{ route('register') }}" class="btn btn-game">
                    <i class="bi bi-person-plus me-2"></i>REGISTER
                </a>
            @endauth
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>