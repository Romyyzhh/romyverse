<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Artoverse</title>
    
    <!-- CSS Libraries -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/lightbox2@2.11.3/dist/css/lightbox.min.css" rel="stylesheet">

    <style>
        :root {
            --primary-color: #0d6efd;
            --primary-color-rgb: 13, 110, 253;
            --secondary-color: #6c757d;
            --background-color: #f8f9fa;
            --card-background: rgba(255, 255, 255, 0.9);
            --text-color: #212529;
            --border-color: rgba(0, 0, 0, 0.125);
        }

        [data-bs-theme="dark"] {
            --primary-color: #0d6efd;
            --primary-color-rgb: 13, 110, 253;
            --secondary-color: #6c757d;
            --background-color:rgb(15, 16, 17);
            --card-background: rgba(18, 20, 22, 0.9);
            --text-color: #f8f9fa;
            --border-color: rgba(255, 255, 255, 0.125);
        }

        body {
            background-color: var(--background-color);
            color: var(--text-color);
            transition: all 0.3s ease;
        }

        .navbar {
            background: var(--card-background);
            backdrop-filter: blur(10px);
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
            border-bottom: 1px solid var(--border-color);
            transition: all 0.3s ease;
            padding: 0.75rem 0;
        }
        
        .navbar-scrolled {
            padding: 0.5rem 0;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.15);
            border-bottom: 1px solid rgba(var(--primary-color-rgb), 0.2);
            background: var(--card-background);
        }

        .navbar-brand {
            font-weight: 700;
            background: linear-gradient(45deg, #0d6efd, #0a58ca);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            position: relative;
            font-size: 1.5rem;
        }

        .navbar-brand::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 100%;
            height: 2px;
            background: linear-gradient(45deg, #0d6efd, transparent);
            transform: scaleX(0);
            transition: transform 0.3s ease;
        }

        .navbar-brand:hover::after {
            transform: scaleX(1);
        }

        .nav-link {
            position: relative;
            padding: 0.5rem 1rem;
            font-weight: 500;
            color: var(--text-color);
            transition: all 0.3s ease;
        }
        
        .nav-link:hover {
            color: var(--primary-color);
        }
        
        .nav-link::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            width: 0;
            height: 2px;
            background: var(--primary-color);
            transition: all 0.3s ease;
            transform: translateX(-50%);
        }
        
        .nav-link:hover::after {
            width: 70%;
        }
        
        .dropdown-menu {
            border: 0;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            border-radius: 0.5rem;
            background: var(--card-background);
            backdrop-filter: blur(10px);
            animation: fadeIn 0.3s ease;
        }
        
        .dropdown-item {
            padding: 0.6rem 1.5rem;
            transition: all 0.2s ease;
            color: var(--text-color);
        }
        
        .dropdown-item:hover {
            background: rgba(13, 110, 253, 0.1);
            color: var(--primary-color);
            transform: translateX(5px);
        }

        .card {
            background: var(--card-background);
            backdrop-filter: blur(10px);
            border: 1px solid var(--border-color);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .card:hover {
            transform: translateY(-10px) rotate(1deg);
            box-shadow: 0 20px 40px rgba(0,0,0,.12) !important;
        }

        .btn {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .btn::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 300%;
            height: 300%;
            background: rgba(255,255,255,0.2);
            transform: translate(-50%, -50%) scale(0);
            border-radius: 50%;
            transition: transform 0.6s;
        }

        .btn:hover::after {
            transform: translate(-50%, -50%) scale(1);
        }

        .btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }

        .fade-in {
            animation: fadeIn 0.8s cubic-bezier(0.4, 0, 0.2, 1);
        }

        @keyframes fadeIn {
            from { 
                opacity: 0; 
                transform: translateY(30px) scale(0.9); 
            }
            to { 
                opacity: 1; 
                transform: translateY(0) scale(1); 
            }
        }

        .card-img-top {
            transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .card:hover .card-img-top {
            transform: scale(1.1) rotate(-2deg);
        }

        .btn-primary {
            background: linear-gradient(45deg, #0d6efd, #0a58ca);
            border: none;
            position: relative;
        }

        .btn-primary::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(45deg, #0a58ca, #084298);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .btn-primary:hover::before {
            opacity: 1;
        }

        .floating {
            animation: floating 3s ease-in-out infinite;
        }

        @keyframes floating {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
            100% { transform: translateY(0px); }
        }

        /* Animated background shapes */
        .bg-shapes {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            overflow: hidden;
        }

        .shape {
            position: absolute;
            opacity: 0.1;
            animation: shapeFloat 15s infinite;
        }

        .shape:nth-child(1) {
            top: 20%;
            left: 10%;
            width: 50px;
            height: 50px;
            background: #0d6efd;
            border-radius: 50%;
            animation-delay: 0s;
        }

        .shape:nth-child(2) {
            top: 60%;
            right: 20%;
            width: 70px;
            height: 70px;
            background: #0a58ca;
            clip-path: polygon(50% 0%, 0% 100%, 100% 100%);
            animation-delay: -5s;
        }

        .shape:nth-child(3) {
            bottom: 20%;
            left: 30%;
            width: 60px;
            height: 60px;
            background: #084298;
            clip-path: polygon(50% 0%, 100% 50%, 50% 100%, 0% 50%);
            animation-delay: -10s;
        }

        @keyframes shapeFloat {
            0%, 100% {
                transform: translate(0, 0) rotate(0deg);
            }
            25% {
                transform: translate(50px, 50px) rotate(90deg);
            }
            50% {
                transform: translate(0, 100px) rotate(180deg);
            }
            75% {
                transform: translate(-50px, 50px) rotate(270deg);
            }
        }

        .theme-switch {
            position: relative;
            width: 60px;
            height: 30px;
            margin: 0 10px;
        }

        .theme-switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            transition: .4s;
            border-radius: 30px;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 22px;
            width: 22px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            transition: .4s;
            border-radius: 50%;
        }

        input:checked + .slider {
            background-color: var(--primary-color);
        }

        input:checked + .slider:before {
            transform: translateX(30px);
        }

        .theme-icon {
            font-size: 1.2rem;
            color: var(--text-color);
        }

        /* Search Bar Styling */
        .input-group {
            max-width: 300px;
        }
        
        .form-control {
            border: 1px solid var(--border-color);
            background-color: rgba(255, 255, 255, 0.05);
            color: var(--text-color);
            transition: all 0.3s ease;
        }
        
        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.25rem rgba(var(--primary-color-rgb), 0.25);
            background-color: rgba(255, 255, 255, 0.1);
        }
        
        .rounded-pill-start {
            border-top-left-radius: 50rem;
            border-bottom-left-radius: 50rem;
        }
        
        .rounded-pill-end {
            border-top-right-radius: 50rem;
            border-bottom-right-radius: 50rem;
        }
    </style>

    @yield('styles')
</head>
<body>
    <!-- Background Shapes -->
    <div class="bg-shapes">
        <div class="shape"></div>
        <div class="shape"></div>
        <div class="shape"></div>
    </div>

    <nav class="navbar navbar-expand-lg sticky-top mb-4">
        <div class="container">
            <a class="navbar-brand floating" href="{{ route('paintings.index') }}">
                <i class="fas fa-palette me-2"></i>Artoverse
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto align-items-center">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('paintings.index') }}">
                            <i class="fas fa-home me-1"></i>Beranda
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('paintings.create') }}">
                            <i class="fas fa-plus me-1"></i>Tambah Lukisan
                        </a>
                    </li>
                </ul>
                
                <form class="d-flex mx-auto" action="{{ route('paintings.index') }}" method="GET">
                    <div class="input-group">
                        <input name="search" class="form-control rounded-pill-start" type="search" placeholder="Cari lukisan..." aria-label="Search" value="{{ request('search') }}">
                        <button class="btn btn-primary rounded-pill-end" type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </form>
                
                <ul class="navbar-nav ms-auto align-items-center">
                    @guest
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="authDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-user me-1"></i> Akun
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="authDropdown">
                                <li>
                                    <a class="dropdown-item" href="{{ route('login') }}">
                                        <i class="fas fa-sign-in-alt me-2"></i> Login
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('register') }}">
                                        <i class="fas fa-user-plus me-2"></i> Register
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('admin.login') }}">
                                        <i class="fas fa-user-shield me-2"></i> Login Admin
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @else
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-user-circle me-1"></i> {{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <li>
                                    <a class="dropdown-item" href="{{ route('profile') }}">
                                        <i class="fas fa-user me-2"></i> Profile
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('likes.index') }}">
                                        <i class="fas fa-heart me-2"></i> Koleksi Favorit
                                    </a>
                                </li>
                                @if(Auth::user()->is_admin)
                                <li>
                                    <a class="dropdown-item" href="{{ route('admin.dashboard') }}">
                                        <i class="fas fa-tachometer-alt me-2"></i> Dashboard Admin
                                    </a>
                                </li>
                                @endif
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="dropdown-item">
                                            <i class="fas fa-sign-out-alt me-2"></i> Logout
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @endguest
                    
                    @auth
                    <li class="nav-item mx-2">
                        <a href="{{ route('notifications.index') }}" class="nav-link position-relative">
                            <i class="fas fa-bell"></i>
                            @if(Auth::user()->unreadNotificationsCount() > 0)
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                    {{ Auth::user()->unreadNotificationsCount() }}
                                    <span class="visually-hidden">unread notifications</span>
                                </span>
                            @endif
                        </a>
                    </li>
                    @endauth
                    
                    <li class="nav-item ms-2">
                        <button id="themeToggle" class="btn btn-sm rounded-pill px-3 btn-outline-primary">
                            <i id="themeIcon" class="fas fa-moon me-1"></i><span class="d-none d-md-inline">Mode</span>
                        </button>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        <div class="container mt-4">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
        </div>

    @yield('content')
    </main>

    <!-- JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/lightbox2@2.11.3/dist/js/lightbox.min.js"></script>

    <script>
        AOS.init({
            duration: 800,
            once: true
        });

        // Theme switcher
        const themeToggle = document.getElementById('themeToggle');
        const themeIcon = document.getElementById('themeIcon');
        const html = document.documentElement;

        // Check for saved theme preference
        const savedTheme = localStorage.getItem('theme');
        if (savedTheme) {
            html.setAttribute('data-bs-theme', savedTheme);
            if (savedTheme === 'dark') {
                themeIcon.classList.replace('fa-moon', 'fa-sun');
            }
        }

        themeToggle.addEventListener('click', function() {
            if (html.getAttribute('data-bs-theme') === 'dark') {
                html.setAttribute('data-bs-theme', 'light');
                localStorage.setItem('theme', 'light');
                themeIcon.classList.replace('fa-sun', 'fa-moon');
            } else {
                html.setAttribute('data-bs-theme', 'dark');
                localStorage.setItem('theme', 'dark');
                themeIcon.classList.replace('fa-moon', 'fa-sun');
            }
        });

        // Navbar scroll effect
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar');
            if (window.scrollY > 50) {
                navbar.classList.add('navbar-scrolled');
            } else {
                navbar.classList.remove('navbar-scrolled');
            }
        });

        // Delete confirmation for paintings
        document.addEventListener('DOMContentLoaded', function() {
            // For individual painting page
            const deleteForm = document.getElementById('delete-form');
            if (deleteForm) {
                deleteForm.querySelector('button').addEventListener('click', function() {
                    if (confirm('Apakah Anda yakin ingin menghapus lukisan ini?')) {
                        deleteForm.submit();
                    }
                });
            }
            
            // For index page with multiple delete buttons
            const deleteBtns = document.querySelectorAll('.delete-btn');
            deleteBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    const id = this.getAttribute('data-id');
                    const title = this.getAttribute('data-title');
                    if (confirm(`Apakah Anda yakin ingin menghapus lukisan "${title}"?`)) {
                        this.closest('form').submit();
                    }
                });
            });
            
            // For deleting users
            const deleteUserBtns = document.querySelectorAll('.delete-user-btn');
            deleteUserBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    const id = this.getAttribute('data-id');
                    const name = this.getAttribute('data-name');
                    if (confirm(`PERHATIAN: Anda akan menghapus akun pengguna "${name}" beserta SEMUA lukisan yang dimilikinya. Tindakan ini tidak dapat dibatalkan. Lanjutkan?`)) {
                        this.closest('form').submit();
                    }
                });
            });
        });
    </script>

    @yield('scripts')
</body>
</html>
