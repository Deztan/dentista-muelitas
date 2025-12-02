<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dentista Muelitas')</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <!-- ESTÁNDARES DE DISEÑO - Manual de Calidad -->
    <link rel="stylesheet" href="{{ asset('css/estandares.css') }}">
    
    <style>
        body {
            margin: 0;
            padding: 0;
        }
        
        /* ACCESIBILIDAD: Focus visible para navegación por teclado */
        *:focus {
            outline: 3px solid #0d6efd;
            outline-offset: 2px;
        }
        
        /* Evitar outline en clicks de ratón, solo con teclado */
        *:focus:not(:focus-visible) {
            outline: none;
        }
        
        /* Cabecera superior - WCAG: Contraste mejorado */
        .top-header {
            background: linear-gradient(135deg, #d63384 0%, #c2185b 100%);
            color: #fff;
            padding: 0.75rem 2rem;
            box-shadow: 0 2px 8px rgba(0,0,0,0.15);
            position: fixed;
            top: 0;
            left: 250px;
            right: 0;
            z-index: 1020;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .top-header h5 {
            margin: 0;
            font-weight: 600;
            text-shadow: 0 1px 2px rgba(0,0,0,0.2);
        }
        
        /* Botón para toggle del sidebar en móvil */
        .sidebar-toggle {
            display: none;
            position: fixed;
            top: 10px;
            left: 10px;
            z-index: 1040;
            background: #0d6efd;
            color: white;
            border: none;
            border-radius: 0.375rem;
            padding: 0.5rem 0.75rem;
            cursor: pointer;
            box-shadow: 0 2px 8px rgba(0,0,0,0.2);
        }
        .sidebar-toggle:hover {
            background: #0a58ca;
        }
        
        /* Sidebar ocupa toda la altura */
        .sidebar {
            min-height: 100vh;
            height: 100vh;
            background: linear-gradient(180deg, #0d6efd 0%, #0a58ca 100%);
            position: fixed;
            top: 0;
            left: 0;
            width: 250px;
            overflow-y: auto;
            z-index: 1030;
        }
        .sidebar .nav-link {
            color: rgba(255, 255, 255, 0.8);
            padding: 0.75rem 1rem;
            margin: 0.25rem 0;
            border-radius: 0.375rem;
        }
        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            color: #fff;
            background-color: rgba(255, 255, 255, 0.1);
        }
        .sidebar .nav-link i {
            margin-right: 0.5rem;
        }
        
        /* Contenido principal ajustado */
        .main-content-wrapper {
            margin-left: 250px; /* Empieza después del sidebar */
            margin-top: 50px; /* Espacio para la cabecera fija */
            padding-bottom: 50px; /* Espacio para el pie fijo */
            min-height: calc(100vh - 90px);
        }
        
        /* Pie de página (no cubre el sidebar) */
        .footer-bar {
            background: linear-gradient(90deg, #13B28D 0%, #0e9d7a 100%);
            color: #fff;
            padding: 0.5rem 2rem;
            position: fixed;
            bottom: 0;
            left: 250px; /* Empieza después del sidebar */
            right: 0;
            z-index: 1020;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-size: 0.8rem;
        }
        .footer-bar .footer-left {
            display: flex;
            align-items: center;
        }
        .footer-bar .footer-right {
            display: flex;
            gap: 1.5rem;
            align-items: center;
        }
        
        /* ACCESIBILIDAD: Tablas responsive con scroll horizontal */
        @media (max-width: 992px) {
            .table-responsive {
                border: 1px solid #dee2e6;
                border-radius: 0.5rem;
            }
            
            .table-responsive table {
                font-size: 0.875rem;
            }
        }
        
        /* RESPONSIVE: Móvil - sidebar colapsable con overlay */
        @media (max-width: 768px) {
            .sidebar-toggle {
                display: block;
            }
            
            .sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s ease-in-out;
                width: 280px;
                box-shadow: 2px 0 10px rgba(0,0,0,0.3);
            }
            
            .sidebar.show {
                transform: translateX(0);
            }
            
            .sidebar-overlay {
                display: none;
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: rgba(0,0,0,0.5);
                z-index: 1025;
            }
            
            .sidebar-overlay.show {
                display: block;
            }
            
            .top-header {
                left: 0;
                padding-left: 60px;
            }
            
            .footer-bar {
                left: 0;
                font-size: 0.75rem;
                padding: 0.5rem 1rem;
            }
            
            .footer-bar .footer-right {
                gap: 0.5rem;
            }
            
            .footer-bar .footer-right span:not(:first-child) {
                display: none;
            }
            
            .main-content-wrapper {
                margin-left: 0;
            }
            
            /* Tablas en móvil: modo card */
            .table-responsive table {
                border: 0;
            }
            
            .table-responsive thead {
                display: none;
            }
            
            .table-responsive tr {
                display: block;
                margin-bottom: 1rem;
                border: 1px solid #dee2e6;
                border-radius: 0.5rem;
                background: white;
            }
            
            .table-responsive td {
                display: block;
                text-align: right;
                padding: 0.75rem;
                border-bottom: 1px solid #f0f0f0;
            }
            
            .table-responsive td:last-child {
                border-bottom: 0;
            }
            
            .table-responsive td::before {
                content: attr(data-label);
                float: left;
                font-weight: 600;
                color: #495057;
            }
        }
    </style>
</head>
<body class="bg-light">
    <!-- ACCESIBILIDAD: Skip to main content para navegación por teclado -->
    <a href="#main-content" class="skip-to-content">Saltar al contenido principal</a>
    
    <!-- Cabecera superior -->
    <header class="top-header">
        <div class="d-flex align-items-center">
            <i class="bi bi-hospital me-2" style="font-size: 1.5rem;"></i>
            <h5>DENTISTA MUELITAS</h5>
        </div>
        <div class="d-flex align-items-center">
            <span class="me-3">{{ Auth::user()->nombre_completo }}</span>
            <i class="bi bi-person-circle" style="font-size: 1.8rem;"></i>
        </div>
    </header>

    <!-- Botón toggle para sidebar en móvil -->
    <button class="sidebar-toggle" id="sidebarToggle" aria-label="Abrir menú de navegación">
        <i class="bi bi-list" style="font-size: 1.5rem;"></i>
    </button>
    
    <!-- Overlay para cerrar sidebar en móvil -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>
    
    <!-- Sidebar (ocupa toda la altura lateral) - ACCESIBILIDAD: roles y labels -->
    <nav class="sidebar p-3" id="sidebar" role="navigation" aria-label="Menú principal">
                <div class="text-center mb-4">
                    <h4 class="text-white">
                        <i class="bi bi-hospital"></i>
                        Dentista Muelitas
                    </h4>
                    <p class="text-white-50 small">Sistema de Gestión</p>
                </div>

                <!-- Información del usuario logueado -->
                <div class="card bg-white bg-opacity-10 text-white mb-3">
                    <div class="card-body p-2">
                        <div class="d-flex align-items-center">
                            <div class="bg-white bg-opacity-25 rounded-circle p-2 me-2">
                                <i class="bi bi-person-circle fs-4"></i>
                            </div>
                            <div class="flex-grow-1">
                                <div class="fw-bold small">{{ Auth::user()->nombre_completo }}</div>
                                <div class="text-white-50" style="font-size: 0.75rem;">
                                    {{ ucfirst(str_replace('_', ' ', Auth::user()->rol)) }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <ul class="nav flex-column" role="list">
                    <li class="nav-item" role="listitem">
                        <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" 
                           href="{{ route('home') }}"
                           aria-label="Ir a la página de inicio"
                           aria-current="{{ request()->routeIs('home') ? 'page' : 'false' }}">
                            <i class="bi bi-house-door" aria-hidden="true"></i> Inicio
                        </a>
                    </li>
                    <li class="nav-item" role="listitem">
                        <a class="nav-link {{ request()->routeIs('pacientes.*') ? 'active' : '' }}" 
                           href="{{ route('pacientes.index') }}"
                           aria-label="Gestionar pacientes"
                           aria-current="{{ request()->routeIs('pacientes.*') ? 'page' : 'false' }}">
                            <i class="bi bi-people" aria-hidden="true"></i> Pacientes
                        </a>
                    </li>
                    <li class="nav-item" role="listitem">
                        <a class="nav-link {{ request()->routeIs('citas.*') ? 'active' : '' }}" 
                           href="{{ route('citas.index') }}"
                           aria-label="Gestionar agenda de citas"
                           aria-current="{{ request()->routeIs('citas.*') ? 'page' : 'false' }}">
                            <i class="bi bi-calendar-check" aria-hidden="true"></i> Citas
                        </a>
                    </li>
                    <li class="nav-item" role="listitem">
                        <a class="nav-link {{ request()->routeIs('tratamientos.*') ? 'active' : '' }}" 
                           href="{{ route('tratamientos.index') }}"
                           aria-label="Gestionar catálogo de tratamientos"
                           aria-current="{{ request()->routeIs('tratamientos.*') ? 'page' : 'false' }}">
                            <i class="bi bi-clipboard2-pulse" aria-hidden="true"></i> Tratamientos
                        </a>
                    </li>
                    <li class="nav-item" role="listitem">
                        <a class="nav-link {{ request()->routeIs('expedientes.*') ? 'active' : '' }}" 
                           href="{{ route('expedientes.index') }}"
                           aria-label="Gestionar expedientes médicos"
                           aria-current="{{ request()->routeIs('expedientes.*') ? 'page' : 'false' }}">
                            <i class="bi bi-file-medical" aria-hidden="true"></i> Expedientes
                        </a>
                    </li>
                    <li class="nav-item" role="listitem">
                        <a class="nav-link {{ request()->routeIs('materiales.*') ? 'active' : '' }}" 
                           href="{{ route('materiales.index') }}"
                           aria-label="Gestionar inventario de materiales"
                           aria-current="{{ request()->routeIs('materiales.*') ? 'page' : 'false' }}">
                            <i class="bi bi-box-seam" aria-hidden="true"></i> Materiales
                        </a>
                    </li>
                    <li class="nav-item" role="listitem">
                        <a class="nav-link {{ request()->routeIs('facturas.*') ? 'active' : '' }}" 
                           href="{{ route('facturas.index') }}"
                           aria-label="Gestionar facturación"
                           aria-current="{{ request()->routeIs('facturas.*') ? 'page' : 'false' }}">
                            <i class="bi bi-receipt" aria-hidden="true"></i> Facturas
                        </a>
                    </li>
                    <li class="nav-item" role="listitem">
                        <a class="nav-link {{ request()->routeIs('reportes.*') ? 'active' : '' }}" 
                           href="{{ route('reportes.index') }}"
                           aria-label="Ver reportes estadísticos"
                           aria-current="{{ request()->routeIs('reportes.*') ? 'page' : 'false' }}">
                            <i class="bi bi-graph-up" aria-hidden="true"></i> Reportes
                        </a>
                    </li>
                    
                    @if(Auth::user()->rol === 'gerente')
                    <li class="nav-item" role="listitem">
                        <a class="nav-link {{ request()->routeIs('usuarios.*') ? 'active' : '' }}" 
                           href="{{ route('usuarios.index') }}"
                           aria-label="Administrar usuarios del sistema"
                           aria-current="{{ request()->routeIs('usuarios.*') ? 'page' : 'false' }}">
                            <i class="bi bi-people-fill" aria-hidden="true"></i> Usuarios
                        </a>
                    </li>
                    <li class="nav-item" role="listitem">
                        <a class="nav-link {{ request()->routeIs('logs.*') ? 'active' : '' }}" 
                           href="{{ route('logs.index') }}"
                           aria-label="Ver logs del sistema"
                           aria-current="{{ request()->routeIs('logs.*') ? 'page' : 'false' }}">
                            <i class="bi bi-journal-text" aria-hidden="true"></i> Logs
                        </a>
                    </li>
                    <li class="nav-item" role="listitem">
                        <a class="nav-link {{ request()->routeIs('backups.*') ? 'active' : '' }}" 
                           href="{{ route('backups.index') }}"
                           aria-label="Gestionar backups de base de datos"
                           aria-current="{{ request()->routeIs('backups.*') ? 'page' : 'false' }}">
                            <i class="bi bi-database" aria-hidden="true"></i> Backups
                        </a>
                    </li>
                    @endif
                </ul>
                
                <hr class="text-white-50 my-4">
                
                <ul class="nav flex-column" role="list">
                    <li class="nav-item" role="listitem">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" 
                                    class="nav-link border-0 bg-transparent text-start w-100" 
                                    style="color: rgba(255, 255, 255, 0.8);"
                                    aria-label="Cerrar sesión y salir del sistema">
                                <i class="bi bi-box-arrow-right" aria-hidden="true"></i> Cerrar Sesión
                            </button>
                        </form>
                    </li>
                </ul>
            </nav>

    <!-- Main content -->
    <main id="main-content" class="px-4 py-4 main-content-wrapper" role="main">
                <!-- Breadcrumb -->
                @if(isset($breadcrumbs))
                <nav aria-label="breadcrumb" class="mb-3">
                    <ol class="breadcrumb">
                        @foreach($breadcrumbs as $breadcrumb)
                            @if($loop->last)
                                <li class="breadcrumb-item active" aria-current="page">{{ $breadcrumb['name'] }}</li>
                            @else
                                <li class="breadcrumb-item"><a href="{{ $breadcrumb['url'] }}">{{ $breadcrumb['name'] }}</a></li>
                            @endif
                        @endforeach
                    </ol>
                </nav>
                @endif

                <!-- ALERTAS - ESTÁNDAR: En parte superior con iconos de error/éxito -->
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show shadow-sm" 
                         role="alert" 
                         aria-live="polite" 
                         aria-atomic="true">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-check-circle-fill me-3" style="font-size: 1.5rem;" aria-hidden="true"></i>
                            <div class="flex-grow-1">
                                <strong>¡Éxito!</strong> {{ session('success') }}
                            </div>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar alerta"></button>
                        </div>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show shadow-sm" 
                         role="alert" 
                         aria-live="assertive" 
                         aria-atomic="true">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-exclamation-triangle-fill me-3" style="font-size: 1.5rem;" aria-hidden="true"></i>
                            <div class="flex-grow-1">
                                <strong>¡Error!</strong> {{ session('error') }}
                            </div>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar alerta"></button>
                        </div>
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show shadow-sm" 
                         role="alert" 
                         aria-live="assertive" 
                         aria-atomic="true">
                        <div class="d-flex align-items-start">
                            <i class="bi bi-exclamation-triangle-fill me-3" style="font-size: 1.5rem;" aria-hidden="true"></i>
                            <div class="flex-grow-1">
                                <strong>Por favor corrige los siguientes errores:</strong>
                                <ul class="mb-0 mt-2" role="list">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar alerta"></button>
                        </div>
                    </div>
                @endif

                <!-- Page Content -->
                @yield('content')
            </main>

    <!-- PIE DE PÁGINA - ESTÁNDAR: Footer en parte inferior con información del sistema -->
    <footer class="footer-bar">
        <div class="footer-left">
            <span><i class="bi bi-c-circle me-1"></i> 2025 <strong>Dentista Muelitas</strong> - Sistema de Gestión Odontológica</span>
        </div>
        <div class="footer-right">
            <span><i class="bi bi-code-square me-1"></i> Versión 1.0.0</span>
            <span><i class="bi bi-person-badge me-1"></i> Usuario: {{ Auth::user()->nombre_completo }}</span>
            <span><i class="bi bi-clock me-1"></i> {{ now()->format('H:i') }}</span>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- ACCESIBILIDAD: Script para sidebar responsive -->
    <script>
        (function() {
            const sidebarToggle = document.getElementById('sidebarToggle');
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebarOverlay');
            
            if (sidebarToggle && sidebar && overlay) {
                // Abrir sidebar
                sidebarToggle.addEventListener('click', function() {
                    sidebar.classList.add('show');
                    overlay.classList.add('show');
                    sidebarToggle.setAttribute('aria-expanded', 'true');
                });
                
                // Cerrar sidebar al hacer click en overlay
                overlay.addEventListener('click', function() {
                    sidebar.classList.remove('show');
                    overlay.classList.remove('show');
                    sidebarToggle.setAttribute('aria-expanded', 'false');
                });
                
                // Cerrar con tecla Escape (accesibilidad)
                document.addEventListener('keydown', function(e) {
                    if (e.key === 'Escape' && sidebar.classList.contains('show')) {
                        sidebar.classList.remove('show');
                        overlay.classList.remove('show');
                        sidebarToggle.setAttribute('aria-expanded', 'false');
                    }
                });
            }
        })();
    </script>
    
    @stack('scripts')
</body>
</html>
