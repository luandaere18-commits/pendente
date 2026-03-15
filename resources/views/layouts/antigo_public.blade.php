<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - MC-COMERCIAL</title>
    <meta name="description" content="Centro de formação profissional especializado em diversas áreas do conhecimento">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --primary-color: #1e3a8a;
            --secondary-color: #334155;
            --accent-color: #3b82f6;
            --light-gray: #f1f5f9;
            --dark-gray: #475569;
            --white: #ffffff;
            --text-color: #1e293b;
            --success-color: #16a34a;
            --warning-color: #ca8a04;
            --error-color: #dc2626;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        html {
            scroll-behavior: smooth;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: var(--text-color);
            background-color: var(--white);
        }
        
        /* ===================== ANIMATIONS ===================== */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        
        @keyframes slideInLeft {
            from {
                opacity: 0;
                transform: translateX(-40px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
        
        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(40px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
        
        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }
        
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        .animate-fade-in-up {
            animation: fadeInUp 0.6s ease-out forwards;
        }
        
        .animate-fade-in {
            animation: fadeIn 0.6s ease-out forwards;
        }
        
        .animate-slide-in-left {
            animation: slideInLeft 0.6s ease-out forwards;
        }
        
        .animate-slide-in-right {
            animation: slideInRight 0.6s ease-out forwards;
        }
        
        /* ===================== HEADER ===================== */
        .main-header {
            background: var(--white);
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            transition: all 0.3s ease;
        }
        
        .main-header.scrolled {
            box-shadow: 0 4px 25px rgba(0, 0, 0, 0.15);
        }
        
        .top-bar {
            background: linear-gradient(135deg, var(--primary-color), #2553c7);
            color: white;
            padding: 0.6rem 0;
            font-size: 0.875rem;
        }
        
        .top-bar i {
            margin-right: 0.5rem;
        }
        
        .navbar {
            padding: 1rem 0;
        }
        
        .navbar-brand {
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--primary-color) !important;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            transition: transform 0.3s ease;
        }
        
        .navbar-brand:hover {
            transform: scale(1.05);
        }
        
        .navbar-brand img {
            transition: transform 0.3s ease;
        }
        
        .navbar-brand:hover img {
            transform: rotate(5deg);
        }
        
        .navbar-nav .nav-link {
            font-weight: 500;
            color: var(--text-color) !important;
            padding: 0.75rem 1.25rem !important;
            transition: all 0.3s ease;
            border-radius: 0.375rem;
            margin: 0 0.25rem;
            position: relative;
        }
        
        .navbar-nav .nav-link::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 0;
            height: 2px;
            background: var(--accent-color);
            transition: width 0.3s ease;
        }
        
        .navbar-nav .nav-link:hover::after,
        .navbar-nav .nav-link.active::after {
            width: 100%;
        }
        
        .navbar-nav .nav-link:hover,
        .navbar-nav .nav-link.active {
            color: var(--primary-color) !important;
            background-color: rgba(59, 130, 246, 0.1);
        }
        
        .btn-login {
            background: linear-gradient(135deg, var(--accent-color), #2563eb);
            border: none;
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .btn-login:hover {
            background: linear-gradient(135deg, var(--primary-color), #1945b5);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(30, 58, 138, 0.3);
        }
        
        /* ===================== MAIN CONTENT ===================== */
        .main-content {
            margin-top: 160px;
            min-height: calc(100vh - 160px);
        }
        
        /* ===================== HERO SECTION ===================== */
        .hero-section {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--accent-color) 100%);
            color: white;
            padding: 6rem 0 4rem;
            position: relative;
            overflow: hidden;
        }
        
        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 100" fill="white" opacity="0.05"><polygon points="0,0 1000,0 1000,100 0,20"/></svg>');
            background-size: cover;
            animation: float 6s ease-in-out infinite;
        }
        
        .hero-content {
            position: relative;
            z-index: 2;
        }
        
        .hero-title {
            font-size: 3.5rem;
            font-weight: 800;
            margin-bottom: 1.5rem;
            line-height: 1.2;
            animation: slideInLeft 0.8s ease-out;
        }
        
        .hero-subtitle {
            font-size: 1.25rem;
            margin-bottom: 2rem;
            opacity: 0.95;
            animation: slideInLeft 0.8s ease-out 0.2s both;
        }
        
        .hero-cta {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
            animation: slideInLeft 0.8s ease-out 0.4s both;
        }
        
        .hero-image {
            animation: slideInRight 0.8s ease-out 0.2s both;
        }
        
        .hero-image img {
            border-radius: 1rem;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            max-height: 400px;
            object-fit: cover;
            transition: transform 0.3s ease;
        }
        
        .hero-image:hover img {
            transform: scale(1.02);
        }
        
        /* ===================== SECTIONS ===================== */
        .section {
            padding: 5rem 0;
            position: relative;
        }
        
        .section:nth-child(even) {
            background-color: var(--light-gray);
        }
        
        .section-title {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 1rem;
            position: relative;
            text-align: center;
        }
        
        .section-title::after {
            content: '';
            position: absolute;
            bottom: -1rem;
            left: 50%;
            transform: translateX(-50%);
            width: 100px;
            height: 4px;
            background: linear-gradient(135deg, var(--accent-color), var(--primary-color));
            border-radius: 2px;
        }
        
        .section-subtitle {
            font-size: 1.125rem;
            color: var(--dark-gray);
            margin-bottom: 3rem;
            text-align: center;
        }
        
        /* ===================== CARDS ===================== */
        .card {
            border: none;
            border-radius: 1rem;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
            overflow: hidden;
            background: white;
        }
        
        .card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 50px rgba(0, 0, 0, 0.15);
        }
        
        .card-img-top {
            height: 220px;
            object-fit: cover;
            transition: transform 0.3s ease;
        }
        
        .card:hover .card-img-top {
            transform: scale(1.08);
        }
        
        /* ===================== BUTTONS ===================== */
        .btn {
            border-radius: 0.5rem;
            font-weight: 600;
            padding: 0.75rem 2rem;
            transition: all 0.3s ease;
            border: 2px solid transparent;
            cursor: pointer;
            position: relative;
            overflow: hidden;
        }
        
        .btn::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.3);
            transform: translate(-50%, -50%);
            transition: width 0.6s, height 0.6s;
        }
        
        .btn:active::before {
            width: 300px;
            height: 300px;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, var(--accent-color), #2563eb);
            border-color: var(--accent-color);
            color: white;
        }
        
        .btn-primary:hover {
            background: linear-gradient(135deg, var(--primary-color), #1945b5);
            border-color: var(--primary-color);
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(30, 58, 138, 0.3);
        }
        
        .btn-outline-primary {
            color: var(--accent-color);
            border-color: var(--accent-color);
        }
        
        .btn-outline-primary:hover {
            background: var(--accent-color);
            border-color: var(--accent-color);
            transform: translateY(-2px);
        }
        
        /* ===================== FEATURES ===================== */
        .feature-card {
            text-align: center;
            padding: 2rem;
            height: 100%;
            border-radius: 1rem;
            transition: all 0.3s ease;
        }
        
        .feature-card:hover {
            background-color: rgba(59, 130, 246, 0.05);
        }
        
        .feature-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.1), rgba(30, 58, 138, 0.1));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            font-size: 2rem;
            color: var(--accent-color);
            transition: all 0.3s ease;
        }
        
        .feature-card:hover .feature-icon {
            background: linear-gradient(135deg, var(--accent-color), var(--primary-color));
            color: white;
            transform: scale(1.15) rotate(5deg);
        }
        
        /* ===================== FOOTER ===================== */
        .footer {
            background: linear-gradient(135deg, var(--secondary-color), #1e3a5f);
            color: white;
            padding: 4rem 0 1rem;
            position: relative;
        }
        
        .footer::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
        }
        
        .footer h5 {
            color: white;
            margin-bottom: 1.5rem;
            font-weight: 600;
        }
        
        .footer-link {
            color: #cbd5e1;
            text-decoration: none;
            transition: all 0.3s ease;
            display: block;
            padding: 0.25rem 0;
        }
        
        .footer-link:hover {
            color: white;
            padding-left: 0.5rem;
        }
        
        .social-links a {
            width: 40px;
            height: 40px;
            background: var(--accent-color);
            color: white;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-right: 0.75rem;
            transition: all 0.3s ease;
        }
        
        .social-links a:hover {
            background: var(--primary-color);
            transform: translateY(-5px) rotate(10deg);
        }
        
        .copyright {
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            margin-top: 2rem;
            padding-top: 2rem;
            text-align: center;
            color: #94a3b8;
        }
        
        /* ===================== MODALS ===================== */
        .modal-content {
            border: none;
            border-radius: 1rem;
            box-shadow: 0 25px 75px rgba(0, 0, 0, 0.3);
        }
        
        .modal-header {
            background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
            color: white;
            border: none;
            padding: 1.5rem 2rem;
            border-radius: 1rem 1rem 0 0;
        }
        
        .modal-header .btn-close {
            filter: brightness(0) invert(1);
        }
        
        .modal-body {
            padding: 2rem;
        }
        
        .modal-footer {
            border-top: 1px solid #e2e8f0;
            padding: 1.5rem 2rem;
        }
        
        /* ===================== FORMS ===================== */
        .form-control,
        .form-select {
            border: 1px solid #cbd5e1;
            border-radius: 0.5rem;
            padding: 0.75rem 1rem;
            transition: all 0.3s ease;
        }
        
        .form-control:focus,
        .form-select:focus {
            border-color: var(--accent-color);
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }
        
        .form-label {
            color: var(--text-color);
            font-weight: 600;
            margin-bottom: 0.5rem;
        }
        
        /* ===================== BADGES ===================== */
        .badge {
            padding: 0.5rem 0.75rem;
            border-radius: 0.375rem;
            font-weight: 600;
        }
        
        .badge-success {
            background-color: var(--success-color);
        }
        
        .badge-warning {
            background-color: var(--warning-color);
            color: white;
        }
        
        .badge-primary {
            background: linear-gradient(135deg, var(--accent-color), var(--primary-color));
        }
        
        /* ===================== LOADING ===================== */
        .loading {
            text-align: center;
            padding: 3rem;
            color: var(--dark-gray);
        }
        
        .spinner {
            width: 3rem;
            height: 3rem;
            border: 3px solid var(--light-gray);
            border-top: 3px solid var(--accent-color);
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin: 0 auto 1rem;
        }
        
        .skeleton {
            background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
            background-size: 200% 100%;
            animation: loading 1.5s infinite;
        }
        
        @keyframes loading {
            0% { background-position: 200% 0; }
            100% { background-position: -200% 0; }
        }
        
        /* ===================== WHATSAPP BUTTON ===================== */
        .whatsapp-btn {
            position: fixed;
            bottom: 2rem;
            right: 2rem;
            width: 60px;
            height: 60px;
            background: #25d366;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.5rem;
            box-shadow: 0 4px 20px rgba(37, 211, 102, 0.4);
            transition: all 0.3s ease;
            z-index: 999;
            animation: float 3s ease-in-out infinite;
        }
        
        .whatsapp-btn:hover {
            transform: scale(1.1);
            box-shadow: 0 8px 30px rgba(37, 211, 102, 0.6);
        }
        
        /* ===================== RESPONSIVE ===================== */
        @media (max-width: 768px) {
            .main-content {
                margin-top: 140px;
            }
            
            .hero-section {
                padding: 3rem 0 2rem;
            }
            
            .hero-title {
                font-size: 2rem;
            }
            
            .hero-subtitle {
                font-size: 1rem;
            }
            
            .section {
                padding: 3rem 0;
            }
            
            .section-title {
                font-size: 1.75rem;
            }
            
            .card-img-container {
                height: 200px;
            }
            
            .whatsapp-btn {
                bottom: 1rem;
                right: 1rem;
                width: 50px;
                height: 50px;
                font-size: 1.2rem;
            }
        }
        
        /* ===================== UTILITY ===================== */
        .text-gradient {
            background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .shadow-lg-custom {
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
        }
        
        .transition-smooth {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
    </style>
    
    @yield('styles')
</head>
<body>
    <!-- Top Bar -->
    <div class="top-bar">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <i class="fas fa-envelope me-2"></i>mucuanha.chineva@gmail.com
                    <span class="mx-3">|</span>
                    <i class="fas fa-phone me-2"></i>+244 929-643-510
                </div>
                <div class="col-md-6 text-md-end">
                    <i class="fas fa-clock me-2"></i>Seg - Sex: 9h00 - 18h00
                </div>
            </div>
        </div>
    </div>

    <!-- Main Header -->
    <header class="main-header">
        <nav class="navbar navbar-expand-lg navbar-light">
            <div class="container">
                <a class="navbar-brand d-flex align-items-center" href="{{ route('site.home') }}">
                    <div class="text-center">
                        <img src="{{ asset('images/logo.png') }}" alt="MC-COMERCIAL" style="height: 40px; max-height: 40px; width: auto; display: block; margin: 0 auto;">
                        <div style="font-size: 0.75rem; font-weight: 600; color: var(--primary-color); line-height: 1; margin-top: 2px;">MC-COMERCIAL</div>
                    </div>
                </a>
                
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('site.home') ? 'active' : '' }}" href="{{ route('site.home') }}">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('site.centros*') ? 'active' : '' }}" href="{{ route('site.centros') }}">Centros</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('site.cursos') ? 'active' : '' }}" href="{{ route('site.cursos') }}">Cursos</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('site.sobre') ? 'active' : '' }}" href="{{ route('site.sobre') }}">Sobre Nós</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('site.contactos') ? 'active' : '' }}" href="{{ route('site.contactos') }}">Contactos</a>
                        </li>
                    </ul>
                    
                    <a href="{{ route('login') }}" class="btn btn-login">
                        <i class="fas fa-sign-in-alt me-2"></i>login
                    </a>
                </div>
            </div>
        </nav>
    </header>

    <!-- Main Content -->
    <main class="main-content">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 mb-4">
                    <div class="text-center mb-3">
                        <img src="{{ asset('images/logo.png') }}" alt="MC-COMERCIAL" style="height: 35px; max-height: 35px; width: auto; display: block; margin: 0 auto;">
                        <h5 style="margin-top: 0.5rem; margin-bottom: 0; color: var(--primary-color);"></h5>
                    </div>
                    <p style="color: #fff;">
    Centro de formação profissional com mais de 10 anos de experiência 
    na preparação de profissionais qualificados para o mercado de trabalho.
</p>
                    <div class="social-links mt-3">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-linkedin-in"></i></a>
                        <a href="#"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>
                
                <div class="col-lg-2 col-md-6 mb-4">
                    <h5>Links Rápidos</h5>
                    <a href="{{ route('site.home') }}" class="footer-link">Home</a>
                    <a href="{{ route('site.centros') }}" class="footer-link">Centros</a>
                    <a href="{{ route('site.sobre') }}" class="footer-link">Sobre Nós</a>
                    <a href="{{ route('site.contactos') }}" class="footer-link">Contactos</a>
                </div>
                
                <div class="col-lg-3 col-md-6 mb-4">
                    <h5>Contactos</h5>
                    <p class="footer-link mb-2">
                        <i class="fas fa-map-marker-alt me-2"></i>
                        Rua A, Bairro 1º de Maio <br> Nº 05, 1º Andar, Luanda-Viana
                    </p>
                    <p class="footer-link mb-2">
                        <i class="fas fa-phone me-2"></i>+244 929-643-510
                        <i class="fas fa-phone me-2"></i>+244 928-966-002
                    </p>
                    <p class="footer-link mb-2">
                        <i class="fas fa-envelope me-2"></i>mucuanha.chineva@gmail.com
                    </p>
                </div>
                
                <div class="col-lg-3 col-md-6 mb-4">
                    <h5>Horário de Funcionamento</h5>
                    <p class="footer-link mb-1">Segunda - Sexta: 8h00 - 18h00</p>
                    <p class="footer-link mb-1">Sábado: 9h00 - 16h00</p>
                    <p class="footer-link mb-3">Domingo: Encerrado</p>
                    
                    <a href="{{ route('login') }}" class="btn btn-outline-light btn-sm">
                        <i class="fas fa-user-shield me-2"></i>login
                    </a>
                </div>
            </div>
            
            <div class="copyright">
                <p>&copy; {{ date('Y') }} MC-COMERCIAL. Todos os direitos reservados.</p>
            </div>
        </div>
    </footer>
    
    <!-- WhatsApp Button -->
    <a href="https://wa.me/244929643510?text=Olá%2C%20gostaria%20de%20saber%20mais%20sobre%20os%20cursos%20da%20MC-COMERCIAL" target="_blank" class="whatsapp-btn" title="Contacte-nos no WhatsApp">
        <i class="fab fa-whatsapp"></i>
    </a>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.min.js"></script>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" />
    
    <script>
        // Setup CSRF token for AJAX requests
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        
        // Initialize AOS (Animate On Scroll)
        AOS.init({
            duration: 800,
            easing: 'ease-in-out',
            once: true,
            offset: 100
        });
        
        // Header scroll effect
        window.addEventListener('scroll', function() {
            const header = document.querySelector('.main-header');
            if (window.scrollY > 100) {
                header.classList.add('scrolled');
            } else {
                header.classList.remove('scrolled');
            }
        });
        
        // Smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
        
        // Active navigation
        $(document).ready(function() {
            $('.navbar-nav .nav-link').each(function() {
                if (this.href === window.location.href) {
                    $(this).addClass('active');
                }
            });
            
            // Intersection Observer para animações ao scroll
            const observerOptions = {
                threshold: 0.1,
                rootMargin: '0px 0px -100px 0px'
            };
            
            const observer = new IntersectionObserver(function(entries) {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.animationPlayState = 'running';
                    }
                });
            }, observerOptions);
            
            document.querySelectorAll('[data-animate]').forEach(el => {
                observer.observe(el);
            });
        });
        
        // Toast notification helper
        function showToast(message, type = 'success') {
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: type,
                title: message,
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            });
        }
        
        // Error notification helper
        function showError(message) {
            showToast(message, 'error');
        }
    </script>
    
    @yield('scripts')
</body>
</html>
