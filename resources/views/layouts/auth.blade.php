<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>{{ config('app.name', 'Universepedia') }} - @yield('title')</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f4c75 100%);
            min-height: 100vh;
            position: relative;
            overflow-x: hidden;
            margin: 0;
            padding: 0;
        }
        
        /* Animated Background */
        .bg-animation {
            position: fixed;
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
            pointer-events: none;
        }
        
        @keyframes twinkle {
            0% { opacity: 0.3; }
            100% { opacity: 0.8; }
        }
        
        /* Floating Elements */
        .floating-planet {
            position: fixed;
            border-radius: 50%;
            opacity: 0.15;
            animation: float 6s ease-in-out infinite;
            z-index: 2;
            pointer-events: none;
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
        
        /* Character/Astronaut */
        .astronaut {
            position: fixed;
            right: 10%;
            top: 50%;
            transform: translateY(-50%);
            font-size: 8rem;
            opacity: 0.8;
            z-index: 3;
            animation: astronaut-float 4s ease-in-out infinite;
            pointer-events: none;
        }
        
        @keyframes astronaut-float {
            0%, 100% { 
                transform: translateY(-50%) rotate(-2deg); 
            }
            50% { 
                transform: translateY(-60%) rotate(2deg); 
            }
        }
        
        .auth-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
            position: relative;
            z-index: 10;
        }
        
        .main-container {
            position: relative;
            z-index: 10;
            min-height: 100vh;
        }
        
        .form-control {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: white;
            border-radius: 10px;
        }
        
        .form-control:focus {
            background: rgba(255, 255, 255, 0.15);
            border-color: #3282b8;
            box-shadow: 0 0 0 0.2rem rgba(50, 130, 184, 0.25);
            color: white;
        }
        
        .form-control::placeholder {
            color: rgba(255, 255, 255, 0.7);
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #3282b8 0%, #0f4c75 100%);
            border: none;
            border-radius: 10px;
            padding: 12px 30px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(50, 130, 184, 0.4);
        }
        
        .text-space-gold {
            color: #ffd700;
        }
        
        .brand-title {
            background: linear-gradient(135deg, #ffd700 0%, #ffed4e 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-weight: 700;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .astronaut {
                font-size: 4rem;
                right: 5%;
            }
            
            .floating-planet {
                display: none;
            }
            
            .planet-1, .planet-2 {
                display: block;
            }
            
            .planet-1 {
                width: 60px;
                height: 60px;
            }
            
            .planet-2 {
                width: 50px;
                height: 50px;
            }
        }
    </style>
    
    @stack('styles')
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
    
    <div class="main-container">
        <div class="container-fluid d-flex align-items-center justify-content-center min-vh-100">
            <div class="row w-100 justify-content-center">
                <div class="col-md-6 col-lg-4">
                    <div class="auth-card p-5">
                        <div class="text-center mb-4">
                            <h1 class="brand-title h2 mb-2">
                                <i class="bi bi-rocket-takeoff me-2"></i>
                                Universepedia
                            </h1>
                            <p class="text-light mb-0">Space Exploration Platform</p>
                        </div>
                        
                        @if(session('error'))
                            <div class="alert alert-danger" role="alert">
                                <i class="bi bi-exclamation-triangle me-2"></i>
                                {{ session('error') }}
                            </div>
                        @endif
                        
                        @if(session('success'))
                            <div class="alert alert-success" role="alert">
                                <i class="bi bi-check-circle me-2"></i>
                                {{ session('success') }}
                            </div>
                        @endif
                        
                        @yield('content')
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>