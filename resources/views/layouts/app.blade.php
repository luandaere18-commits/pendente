<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MC Comercial - @yield('title')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">

    <style>
        /* =========================================
           DESIGN SYSTEM — PI TOKENS
           ========================================= */
        :root {
            --pi-primary: #3366cc;
            --pi-primary-dark: #2a57b3;
            --pi-primary-light: rgba(51, 102, 204, 0.1);
            --pi-primary-gradient: linear-gradient(135deg, #3366cc 0%, #2a57b3 100%);
            --pi-success: #2e9e6b;
            --pi-success-light: rgba(46, 158, 107, 0.1);
            --pi-warning: #e89a0c;
            --pi-warning-light: rgba(232, 154, 12, 0.1);
            --pi-danger: #dc3545;
            --pi-danger-light: rgba(220, 53, 69, 0.1);
            --pi-info: #0ea5e9;
            --pi-info-light: rgba(14, 165, 233, 0.1);
            --pi-muted: #6b7a8d;
            --pi-border: #e2e6ec;
            --pi-bg: #f4f6f9;
            --pi-card: #ffffff;
            --pi-text: #1a2332;
            --pi-text-muted: #6b7a8d;
            --pi-radius: 0.75rem;
            --pi-radius-sm: 0.5rem;
            --pi-shadow: 0 1px 3px rgba(0,0,0,0.06), 0 1px 2px rgba(0,0,0,0.04);
            --pi-shadow-lg: 0 4px 12px rgba(0,0,0,0.08);
            --pi-sidebar-width: 260px;
            --pi-sidebar-collapsed: 0px;
            --pi-navbar-height: 60px;
            --pi-transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* =========================================
           RESET & BASE
           ========================================= */
        *, *::before, *::after { box-sizing: border-box; }

        body {
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            background-color: var(--pi-bg);
            color: var(--pi-text);
            margin: 0;
            padding: 0;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        /* =========================================
           NAVBAR
           ========================================= */
        .pi-navbar {
            position: fixed;
            top: 0;
            left: var(--pi-sidebar-width);
            right: 0;
            height: var(--pi-navbar-height);
            background: var(--pi-card);
            border-bottom: 1px solid var(--pi-border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 1.5rem;
            z-index: 1001;
            transition: var(--pi-transition);
        }

        .pi-navbar-left {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .pi-navbar-toggle {
            display: none;
            width: 2.25rem;
            height: 2.25rem;
            border: 1px solid var(--pi-border);
            border-radius: var(--pi-radius-sm);
            background: transparent;
            color: var(--pi-text);
            font-size: 1rem;
            cursor: pointer;
            align-items: center;
            justify-content: center;
            transition: var(--pi-transition);
        }
        .pi-navbar-toggle:hover {
            background: var(--pi-primary-light);
            border-color: var(--pi-primary);
            color: var(--pi-primary);
        }

        .pi-navbar-brand-mobile {
            display: none;
            align-items: center;
            gap: 0.5rem;
            font-weight: 700;
            font-size: 1rem;
            color: var(--pi-primary);
            text-decoration: none;
        }
        .pi-navbar-brand-mobile .brand-icon {
            width: 2rem;
            height: 2rem;
            background: var(--pi-primary);
            border-radius: var(--pi-radius-sm);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 0.75rem;
            font-weight: 700;
        }

        .pi-navbar-search {
            position: relative;
            max-width: 280px;
            flex: 1;
        }
        .pi-navbar-search input {
            width: 100%;
            height: 2.25rem;
            padding: 0 0.75rem 0 2.25rem;
            border: 1px solid var(--pi-border);
            border-radius: 9999px;
            font-size: 0.8125rem;
            background: var(--pi-bg);
            color: var(--pi-text);
            transition: var(--pi-transition);
        }
        .pi-navbar-search input:focus {
            outline: none;
            border-color: var(--pi-primary);
            box-shadow: 0 0 0 3px var(--pi-primary-light);
            background: #fff;
        }
        .pi-navbar-search input::placeholder { color: var(--pi-text-muted); }
        .pi-navbar-search .search-icon {
            position: absolute;
            left: 0.75rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--pi-text-muted);
            font-size: 0.8125rem;
            pointer-events: none;
        }

        .pi-navbar-right {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .pi-navbar-icon-btn {
            width: 2.25rem;
            height: 2.25rem;
            border: none;
            border-radius: var(--pi-radius-sm);
            background: transparent;
            color: var(--pi-text-muted);
            font-size: 0.9375rem;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            transition: var(--pi-transition);
        }
        .pi-navbar-icon-btn:hover {
            background: var(--pi-primary-light);
            color: var(--pi-primary);
        }
        .pi-navbar-icon-btn .badge-dot {
            position: absolute;
            top: 0.375rem;
            right: 0.375rem;
            width: 0.5rem;
            height: 0.5rem;
            background: var(--pi-danger);
            border-radius: 50%;
            border: 2px solid var(--pi-card);
        }

        /* User dropdown */
        .pi-user-dropdown {
            position: relative;
        }
        .pi-user-btn {
            display: flex;
            align-items: center;
            gap: 0.625rem;
            padding: 0.375rem 0.625rem;
            border: 1px solid var(--pi-border);
            border-radius: 9999px;
            background: transparent;
            cursor: pointer;
            transition: var(--pi-transition);
        }
        .pi-user-btn:hover {
            background: var(--pi-bg);
            border-color: var(--pi-primary);
        }
        .pi-user-avatar {
            width: 2rem;
            height: 2rem;
            border-radius: 50%;
            background: var(--pi-primary);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.75rem;
            font-weight: 700;
        }
        .pi-user-info {
            text-align: left;
            line-height: 1.2;
        }
        .pi-user-name {
            font-size: 0.8125rem;
            font-weight: 600;
            color: var(--pi-text);
        }
        .pi-user-role {
            font-size: 0.6875rem;
            color: var(--pi-text-muted);
        }
        .pi-user-chevron {
            font-size: 0.625rem;
            color: var(--pi-text-muted);
            margin-left: 0.125rem;
        }

        .pi-user-menu {
            position: absolute;
            top: calc(100% + 0.5rem);
            right: 0;
            width: 220px;
            background: var(--pi-card);
            border: 1px solid var(--pi-border);
            border-radius: var(--pi-radius);
            box-shadow: var(--pi-shadow-lg);
            opacity: 0;
            visibility: hidden;
            transform: translateY(-8px);
            transition: var(--pi-transition);
            z-index: 2000;
            overflow: hidden;
        }
        .pi-user-dropdown.open .pi-user-menu {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }
        .pi-user-menu-header {
            padding: 0.875rem 1rem;
            border-bottom: 1px solid var(--pi-border);
            background: var(--pi-bg);
        }
        .pi-user-menu-header .name {
            font-size: 0.875rem;
            font-weight: 600;
            color: var(--pi-text);
        }
        .pi-user-menu-header .email {
            font-size: 0.75rem;
            color: var(--pi-text-muted);
        }
        .pi-user-menu-item {
            display: flex;
            align-items: center;
            gap: 0.625rem;
            padding: 0.625rem 1rem;
            font-size: 0.8125rem;
            color: var(--pi-text);
            text-decoration: none;
            transition: var(--pi-transition);
            cursor: pointer;
            border: none;
            background: none;
            width: 100%;
            text-align: left;
        }
        .pi-user-menu-item:hover {
            background: var(--pi-bg);
            color: var(--pi-primary);
        }
        .pi-user-menu-item i {
            width: 1rem;
            text-align: center;
            color: var(--pi-text-muted);
            font-size: 0.8125rem;
        }
        .pi-user-menu-item:hover i { color: var(--pi-primary); }
        .pi-user-menu-divider {
            height: 1px;
            background: var(--pi-border);
            margin: 0.25rem 0;
        }
        .pi-user-menu-item.danger { color: var(--pi-danger); }
        .pi-user-menu-item.danger i { color: var(--pi-danger); }
        .pi-user-menu-item.danger:hover { background: var(--pi-danger-light); }

        /* =========================================
           SIDEBAR
           ========================================= */
        .pi-sidebar {
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            width: var(--pi-sidebar-width);
            background: var(--pi-card);
            border-right: 1px solid var(--pi-border);
            z-index: 1002;
            display: flex;
            flex-direction: column;
            transition: var(--pi-transition);
            overflow: hidden;
        }

        /* Sidebar header / brand */
        .pi-sidebar-brand {
            height: var(--pi-navbar-height);
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0 1.25rem;
            border-bottom: 1px solid var(--pi-border);
            flex-shrink: 0;
        }
        .pi-sidebar-brand .brand-icon {
            width: 2.25rem;
            height: 2.25rem;
            background: var(--pi-primary);
            border-radius: var(--pi-radius-sm);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 0.875rem;
            font-weight: 700;
            flex-shrink: 0;
        }
        .pi-sidebar-brand .brand-text {
            display: flex;
            flex-direction: column;
            line-height: 1.2;
        }
        .pi-sidebar-brand .brand-name {
            font-size: 0.9375rem;
            font-weight: 700;
            color: var(--pi-text);
            letter-spacing: -0.01em;
        }
        .pi-sidebar-brand .brand-sub {
            font-size: 0.6875rem;
            color: var(--pi-text-muted);
            font-weight: 400;
        }

        /* Sidebar navigation */
        .pi-sidebar-nav {
            flex: 1;
            overflow-y: auto;
            padding: 0.75rem 0;
        }
        .pi-sidebar-nav::-webkit-scrollbar { width: 4px; }
        .pi-sidebar-nav::-webkit-scrollbar-track { background: transparent; }
        .pi-sidebar-nav::-webkit-scrollbar-thumb { background: var(--pi-border); border-radius: 4px; }

        .pi-sidebar-section {
            padding: 0 0.75rem;
            margin-bottom: 0.5rem;
        }
        .pi-sidebar-section-label {
            font-size: 0.6875rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: var(--pi-text-muted);
            padding: 0.5rem 0.75rem 0.375rem;
        }

        .pi-nav-link {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.5rem 0.75rem;
            margin: 0.125rem 0;
            border-radius: var(--pi-radius-sm);
            font-size: 0.8125rem;
            font-weight: 500;
            color: var(--pi-text-muted);
            text-decoration: none;
            transition: var(--pi-transition);
            position: relative;
        }
        .pi-nav-link:hover {
            background: var(--pi-bg);
            color: var(--pi-text);
        }
        .pi-nav-link.active {
            background: var(--pi-primary-light);
            color: var(--pi-primary);
            font-weight: 600;
        }
        .pi-nav-link.active::before {
            content: '';
            position: absolute;
            left: -0.75rem;
            top: 0.375rem;
            bottom: 0.375rem;
            width: 3px;
            background: var(--pi-primary);
            border-radius: 0 3px 3px 0;
        }
        .pi-nav-link .nav-icon {
            width: 1.5rem;
            text-align: center;
            font-size: 0.9375rem;
            flex-shrink: 0;
        }
        .pi-nav-link .nav-badge {
            margin-left: auto;
            background: var(--pi-primary-light);
            color: var(--pi-primary);
            font-size: 0.6875rem;
            font-weight: 600;
            padding: 0.125rem 0.5rem;
            border-radius: 9999px;
        }

        /* Sidebar footer */
        .pi-sidebar-footer {
            padding: 0.75rem 1rem;
            border-top: 1px solid var(--pi-border);
            flex-shrink: 0;
        }
        .pi-sidebar-footer-info {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.75rem;
            color: var(--pi-text-muted);
        }
        .pi-sidebar-footer-info .status-dot {
            width: 0.5rem;
            height: 0.5rem;
            background: var(--pi-success);
            border-radius: 50%;
        }

        /* =========================================
           SIDEBAR OVERLAY (mobile)
           ========================================= */
        .pi-sidebar-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.4);
            z-index: 1001;
            backdrop-filter: blur(2px);
            transition: var(--pi-transition);
        }

        /* =========================================
           MAIN CONTENT
           ========================================= */
        .pi-main {
            margin-left: var(--pi-sidebar-width);
            padding-top: var(--pi-navbar-height);
            min-height: 100vh;
            transition: var(--pi-transition);
        }
        .pi-main-inner {
            padding: 1.5rem 2rem;
        }

        /* =========================================
           ALERTS
           ========================================= */
        .pi-alert {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.875rem 1.25rem;
            border-radius: var(--pi-radius);
            margin-bottom: 1rem;
            font-size: 0.875rem;
            font-weight: 500;
            border: 1px solid transparent;
            animation: piSlideDown 0.3s ease;
        }
        @keyframes piSlideDown {
            from { opacity: 0; transform: translateY(-8px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .pi-alert-success {
            background: var(--pi-success-light);
            color: #1e6e49;
            border-color: rgba(46, 158, 107, 0.2);
        }
        .pi-alert-error {
            background: var(--pi-danger-light);
            color: #b91c1c;
            border-color: rgba(220, 53, 69, 0.2);
        }
        .pi-alert .alert-icon {
            font-size: 1rem;
            flex-shrink: 0;
        }
        .pi-alert .alert-text { flex: 1; }
        .pi-alert .alert-close {
            border: none;
            background: transparent;
            color: inherit;
            opacity: 0.6;
            cursor: pointer;
            font-size: 0.875rem;
            padding: 0.25rem;
            transition: var(--pi-transition);
        }
        .pi-alert .alert-close:hover { opacity: 1; }

        /* =========================================
           GLOBAL OVERRIDES — Bootstrap harmony
           ========================================= */
        .card {
            border: 1px solid var(--pi-border);
            border-radius: var(--pi-radius);
            box-shadow: var(--pi-shadow);
            transition: var(--pi-transition);
        }
        .card:hover {
            box-shadow: var(--pi-shadow-lg);
            transform: none; /* remove heavy hover lift */
        }

        .btn {
            border-radius: var(--pi-radius-sm);
            font-weight: 500;
            font-size: 0.875rem;
            padding: 0.5rem 1rem;
            transition: var(--pi-transition);
        }
        .btn:hover { transform: none; }
        .btn-primary {
            background: var(--pi-primary);
            border-color: var(--pi-primary);
        }
        .btn-primary:hover {
            background: var(--pi-primary-dark);
            border-color: var(--pi-primary-dark);
        }

        .table th {
            background: rgba(51, 102, 204, 0.08);
            color: var(--pi-primary);
            border-bottom: 1px solid var(--pi-border);
            font-size: 0.8125rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.03em;
        }
        .table td {
            vertical-align: middle;
            border-bottom: 1px solid #f0f2f5;
            font-size: 0.875rem;
        }

        .badge {
            padding: 0.25rem 0.625rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .alert {
            border-radius: var(--pi-radius);
            border: 1px solid transparent;
        }

        .modal-content {
            border-radius: var(--pi-radius);
            border: 1px solid var(--pi-border);
            box-shadow: 0 25px 50px -12px rgba(0,0,0,0.15);
        }
        .modal-header {
            border-bottom: 1px solid var(--pi-border);
            padding: 1.25rem 1.5rem;
        }
        .modal-body { padding: 1.25rem 1.5rem; }
        .modal-footer {
            border-top: 1px solid var(--pi-border);
            padding: 1rem 1.5rem;
        }

        .form-control, .form-select {
            border-radius: var(--pi-radius-sm);
            border-color: var(--pi-border);
            font-size: 0.875rem;
        }
        .form-control:focus, .form-select:focus {
            border-color: var(--pi-primary);
            box-shadow: 0 0 0 3px var(--pi-primary-light);
        }

        .form-label {
            font-size: 0.8125rem;
            font-weight: 500;
            margin-bottom: 0.375rem;
        }

        /* DataTables overrides */
        .dataTables_wrapper .dataTables_filter input {
            border-radius: var(--pi-radius-sm) !important;
            border-color: var(--pi-border) !important;
            font-size: 0.875rem !important;
        }
        .dataTables_wrapper .dataTables_length select {
            border-radius: var(--pi-radius-sm) !important;
            border-color: var(--pi-border) !important;
        }
        .dataTables_wrapper .dataTables_info,
        .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_filter {
            font-size: 0.8125rem;
            color: var(--pi-text-muted);
        }
        .dataTables_wrapper .dataTables_paginate .paginate_button {
            border-radius: var(--pi-radius-sm) !important;
            font-size: 0.8125rem !important;
        }
        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            background: var(--pi-primary) !important;
            border-color: var(--pi-primary) !important;
            color: #fff !important;
        }

        /* =========================================
           RESPONSIVE
           ========================================= */
        @media (max-width: 991.98px) {
            .pi-sidebar {
                transform: translateX(-100%);
            }
            .pi-sidebar.open {
                transform: translateX(0);
            }
            .pi-sidebar.open ~ .pi-sidebar-overlay {
                display: block;
            }
            .pi-navbar {
                left: 0;
            }
            .pi-navbar-toggle {
                display: flex;
            }
            .pi-navbar-brand-mobile {
                display: flex;
            }
            .pi-main {
                margin-left: 0;
            }
        }

        @media (max-width: 767.98px) {
            .pi-main-inner {
                padding: 1rem 0.75rem;
            }
            .pi-navbar {
                padding: 0 0.75rem;
            }
            .pi-navbar-search {
                display: none;
            }
            .pi-user-info {
                display: none;
            }
            .pi-user-chevron {
                display: none;
            }
        }

        @media (max-width: 575.98px) {
            .pi-main-inner {
                padding: 0.75rem 0.5rem;
            }
        }
    </style>

    @yield('styles')
</head>
<body>

    {{-- ============================================= --}}
    {{-- SIDEBAR                                       --}}
    {{-- ============================================= --}}
    <aside class="pi-sidebar" id="sidebar">
        {{-- Brand --}}
        <div class="pi-sidebar-brand">
            <div class="brand-icon">
                <i class="fas fa-store"></i>
            </div>
            <div class="brand-text">
                <span class="brand-name">MC-COMERCIAL</span>
                <span class="brand-sub">Sistema de Gestão</span>
            </div>
        </div>

        {{-- Navigation --}}
        <nav class="pi-sidebar-nav">
            <div class="pi-sidebar-section">
                <div class="pi-sidebar-section-label">Principal</div>
                <a href="{{ route('dashboard') }}" class="pi-nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <i class="fas fa-chart-pie nav-icon"></i>
                    <span>Dashboard</span>
                </a>
            </div>

            <div class="pi-sidebar-section">
                <div class="pi-sidebar-section-label">Formação</div>
                <a href="{{ route('cursos.index') }}" class="pi-nav-link {{ request()->routeIs('cursos.*') ? 'active' : '' }}">
                    <i class="fas fa-graduation-cap nav-icon"></i>
                    <span>Cursos</span>
                </a>
                <a href="{{ route('centros.index') }}" class="pi-nav-link {{ request()->routeIs('centros.*') ? 'active' : '' }}">
                    <i class="fas fa-building nav-icon"></i>
                    <span>Centros</span>
                </a>
                <a href="{{ route('formadores.index') }}" class="pi-nav-link {{ request()->routeIs('formadores.*') ? 'active' : '' }}">
                    <i class="fas fa-chalkboard-teacher nav-icon"></i>
                    <span>Formadores</span>
                </a>
                <a href="{{ route('turmas.index') }}" class="pi-nav-link {{ request()->routeIs('turmas.*') ? 'active' : '' }}">
                    <i class="fas fa-users nav-icon"></i>
                    <span>Turmas</span>
                </a>
                <a href="{{ route('pre-inscricoes.index') }}" class="pi-nav-link {{ request()->routeIs('pre-inscricoes.*') ? 'active' : '' }}">
                    <i class="fas fa-clipboard-list nav-icon"></i>
                    <span>Pré-Inscrições</span>
                </a>
            </div>

            <div class="pi-sidebar-section">
                <div class="pi-sidebar-section-label">Loja</div>
                <a href="{{ route('categorias.index') }}" class="pi-nav-link {{ request()->routeIs('categorias.*') ? 'active' : '' }}">
                    <i class="fas fa-tags nav-icon"></i>
                    <span>Categorias</span>
                </a>
                <a href="{{ route('produtos.index') }}" class="pi-nav-link {{ request()->routeIs('produtos.*') ? 'active' : '' }}">
                    <i class="fas fa-box nav-icon"></i>
                    <span>Produtos</span>
                </a>
            </div>
        </nav>

        {{-- Footer --}}
        <div class="pi-sidebar-footer">
            <div class="pi-sidebar-footer-info">
                <span class="status-dot"></span>
                <span>Sistema online</span>
            </div>
        </div>
    </aside>

    {{-- Overlay for mobile --}}
    <div class="pi-sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>

    {{-- ============================================= --}}
    {{-- NAVBAR                                        --}}
    {{-- ============================================= --}}
    <header class="pi-navbar">
        <div class="pi-navbar-left">
            <button class="pi-navbar-toggle" onclick="toggleSidebar()" type="button" aria-label="Menu">
                <i class="fas fa-bars"></i>
            </button>
            <a href="{{ route('dashboard') }}" class="pi-navbar-brand-mobile">
                <span class="brand-icon"><i class="fas fa-store"></i></span>
                MC-COMERCIAL
            </a>
            <div class="pi-navbar-search">
                <i class="fas fa-search search-icon"></i>
                <input type="text" placeholder="Pesquisar..." aria-label="Pesquisar">
            </div>
        </div>

        <div class="pi-navbar-right">
            <button class="pi-navbar-icon-btn" title="Notificações" type="button">
                <i class="fas fa-bell"></i>
                {{-- <span class="badge-dot"></span> --}}
            </button>

            <div class="pi-user-dropdown" id="userDropdown">
                <button class="pi-user-btn" onclick="toggleUserMenu()" type="button">
                    <div class="pi-user-avatar">
                        <i class="fas fa-user"></i>
                    </div>
                    <div class="pi-user-info">
                        <div class="pi-user-name">Administrador</div>
                        <div class="pi-user-role">Admin</div>
                    </div>
                    <i class="fas fa-chevron-down pi-user-chevron"></i>
                </button>

                <div class="pi-user-menu">
                    <div class="pi-user-menu-header">
                        <div class="name">Administrador</div>
                        <div class="email">admin@mc-comercial.ao</div>
                    </div>
                    <a href="#" class="pi-user-menu-item">
                        <i class="fas fa-user-circle"></i> Perfil
                    </a>
                    <a href="#" class="pi-user-menu-item">
                        <i class="fas fa-cog"></i> Configurações
                    </a>
                    <div class="pi-user-menu-divider"></div>
                    <button class="pi-user-menu-item danger" onclick="logout()">
                        <i class="fas fa-sign-out-alt"></i> Sair
                    </button>
                </div>
            </div>
        </div>
    </header>

    {{-- ============================================= --}}
    {{-- MAIN CONTENT                                  --}}
    {{-- ============================================= --}}
    <main class="pi-main">
        <div class="pi-main-inner">
            {{-- Flash messages --}}
            @if(session('success'))
                <div class="pi-alert pi-alert-success" id="alertSuccess">
                    <i class="fas fa-check-circle alert-icon"></i>
                    <span class="alert-text">{{ session('success') }}</span>
                    <button type="button" class="alert-close" onclick="this.closest('.pi-alert').remove()">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            @endif

            @if(session('error'))
                <div class="pi-alert pi-alert-error" id="alertError">
                    <i class="fas fa-exclamation-circle alert-icon"></i>
                    <span class="alert-text">{{ session('error') }}</span>
                    <button type="button" class="alert-close" onclick="this.closest('.pi-alert').remove()">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            @endif

            @yield('content')
        </div>
    </main>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('js/datatables-pt.js') }}"></script>
    <!-- Auth manager temporariamente desabilitado -->
    <!-- <script src="{{ asset('js/auth-manager.js') }}"></script> -->

    <script>
        /**
         * Toggle sidebar (mobile)
         */
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebarOverlay');
            sidebar.classList.toggle('open');
            if (sidebar.classList.contains('open')) {
                overlay.style.display = 'block';
            } else {
                overlay.style.display = 'none';
            }
        }

        /**
         * Toggle user dropdown
         */
        function toggleUserMenu() {
            document.getElementById('userDropdown').classList.toggle('open');
        }

        // Close user menu when clicking outside
        document.addEventListener('click', function(e) {
            const dropdown = document.getElementById('userDropdown');
            if (dropdown && !dropdown.contains(e.target)) {
                dropdown.classList.remove('open');
            }
        });

        // Close sidebar on overlay click (already handled via onclick)

        // Auto-dismiss alerts after 5s
        setTimeout(function() {
            document.querySelectorAll('.pi-alert').forEach(function(el) {
                el.style.transition = 'opacity 0.3s ease, transform 0.3s ease';
                el.style.opacity = '0';
                el.style.transform = 'translateY(-8px)';
                setTimeout(function() { el.remove(); }, 300);
            });
        }, 5000);

        // Setup CSRF token for AJAX requests
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        /**
         * Função para fazer logout
         */
        function logout() {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '/logout';

            const csrfInput = document.createElement('input');
            csrfInput.type = 'hidden';
            csrfInput.name = '_token';
            csrfInput.value = $('meta[name="csrf-token"]').attr('content');
            form.appendChild(csrfInput);

            document.body.appendChild(form);
            form.submit();
        }

        /**
         * Confirm delete
         */
        function confirmDelete(url, message = 'Esta ação não pode ser desfeita!') {
            Swal.fire({
                title: 'Tem certeza?',
                text: message,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6b7a8d',
                confirmButtonText: 'Sim, eliminar!',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = url;
                }
            });
        }
    </script>

    @yield('scripts')
</body>
</html>
