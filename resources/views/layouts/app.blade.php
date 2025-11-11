<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dentista Muelitas')</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    
    <style>
        body {
            margin: 0;
            padding: 0;
        }
        
        /* Cabecera superior */
        .top-header {
            background: linear-gradient(135deg, #f8a5c2 0%, #f78fb3 100%);
            color: #fff;
            padding: 0.75rem 2rem;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            position: fixed;
            top: 0;
            left: 250px; /* Empieza después del sidebar */
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
        
        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                position: relative;
                min-height: auto;
            }
            .top-header,
            .footer-bar {
                left: 0;
            }
            .main-content-wrapper {
                margin-left: 0;
            }
        }
    </style>
</head>
<body class="bg-light">
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

    <!-- Sidebar (ocupa toda la altura lateral) -->
    <nav class="sidebar p-3">
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
                
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">
                            <i class="bi bi-house-door"></i> Inicio
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('pacientes.*') ? 'active' : '' }}" href="{{ route('pacientes.index') }}">
                            <i class="bi bi-people"></i> Pacientes
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('citas.*') ? 'active' : '' }}" href="{{ route('citas.index') }}">
                            <i class="bi bi-calendar-check"></i> Citas
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('tratamientos.*') ? 'active' : '' }}" href="{{ route('tratamientos.index') }}">
                            <i class="bi bi-clipboard2-pulse"></i> Tratamientos
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('expedientes.*') ? 'active' : '' }}" href="{{ route('expedientes.index') }}">
                            <i class="bi bi-file-medical"></i> Expedientes
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('materiales.*') ? 'active' : '' }}" href="{{ route('materiales.index') }}">
                            <i class="bi bi-box-seam"></i> Materiales
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('facturas.*') ? 'active' : '' }}" href="{{ route('facturas.index') }}">
                            <i class="bi bi-receipt"></i> Facturas
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('reportes.*') ? 'active' : '' }}" href="{{ route('reportes.facturas') }}">
                            <i class="bi bi-graph-up"></i> Reportes
                        </a>
                    </li>
                    
                    @if(Auth::user()->rol === 'gerente')
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('usuarios.*') ? 'active' : '' }}" href="{{ route('usuarios.index') }}">
                            <i class="bi bi-people-fill"></i> Usuarios
                        </a>
                    </li>
                    @endif
                </ul>
                
                <hr class="text-white-50 my-4">
                
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="bi bi-gear"></i> Configuración
                        </a>
                    </li>
                    <li class="nav-item">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="nav-link border-0 bg-transparent text-start w-100" style="color: rgba(255, 255, 255, 0.8);">
                                <i class="bi bi-box-arrow-right"></i> Cerrar Sesión
                            </button>
                        </form>
                    </li>
                </ul>
            </nav>

    <!-- Main content -->
    <main class="px-4 py-4 main-content-wrapper">
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

                <!-- Alerts -->
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="bi bi-check-circle me-2"></i>
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-triangle me-2"></i>
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-triangle me-2"></i>
                        <strong>Por favor corrige los siguientes errores:</strong>
                        <ul class="mb-0 mt-2">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <!-- Page Content -->
                @yield('content')
            </main>

    <!-- Pie de página -->
    <footer class="footer-bar">
        <div class="footer-left">
            <span>Copyright © 2025 <strong>Dentista Muelitas</strong>. Todos los derechos reservados</span>
        </div>
        <div class="footer-right">
            <span>vistas.reportes.php</span>
            <span>dinamico.php</span>
            <span>index.php</span>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    @stack('scripts')
</body>
</html>
