<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Conecta Cidade - Plataforma de participação cidadã em mobilidade urbana">
    <title>@yield('title', 'Conecta Cidade - Participação Cidadã')</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- CSS -->
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary-color: #2563eb;
            --primary-dark: #1e40af;
            --secondary-color: #10b981;
            --danger-color: #ef4444;
            --warning-color: #f59e0b;
            --dark: #1f2937;
            --gray: #6b7280;
            --light-gray: #f3f4f6;
            --white: #ffffff;
            --sidebar-width: 280px;
        }

        body {
            font-family: 'Inter', sans-serif;
            line-height: 1.6;
            color: var(--dark);
            background-color: #f9fafb;
        }

        /* Layout Principal com Sidebar */
        .layout-container {
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar */
        .sidebar {
            width: var(--sidebar-width);
            background: linear-gradient(180deg, #1e40af 0%, #1e3a8a 100%);
            color: white;
            position: fixed;
            height: 100vh;
            overflow-y: auto;
            z-index: 1000;
            transition: transform 0.3s ease;
        }

        .sidebar-header {
            padding: 1.5rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .sidebar-logo {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            text-decoration: none;
            color: white;
        }

        .sidebar-logo-icon {
            width: 40px;
            height: 40px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 1.2rem;
        }

        .sidebar-logo-text {
            font-size: 1.25rem;
            font-weight: 700;
        }

        /* User Profile no Sidebar */
        .sidebar-user {
            padding: 1.5rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .sidebar-user-info {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .sidebar-user-avatar {
            width: 48px;
            height: 48px;
            background: linear-gradient(135deg, #10b981, #059669);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
            font-weight: 600;
        }

        .sidebar-user-details {
            flex: 1;
        }

        .sidebar-user-name {
            font-weight: 600;
            font-size: 0.95rem;
            margin-bottom: 0.25rem;
        }

        .sidebar-user-role {
            font-size: 0.8rem;
            color: rgba(255, 255, 255, 0.7);
        }

        /* Menu do Sidebar */
        .sidebar-menu {
            padding: 1rem 0;
        }

        .sidebar-menu-section {
            margin-bottom: 1.5rem;
        }

        .sidebar-menu-title {
            padding: 0.5rem 1.5rem;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: rgba(255, 255, 255, 0.5);
        }

        .sidebar-menu-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem 1.5rem;
            color: rgba(255, 255, 255, 0.9);
            text-decoration: none;
            transition: all 0.2s;
            position: relative;
        }

        .sidebar-menu-item:hover {
            background: rgba(255, 255, 255, 0.1);
            color: white;
        }

        .sidebar-menu-item.active {
            background: rgba(255, 255, 255, 0.15);
            color: white;
            font-weight: 500;
        }

        .sidebar-menu-item.active::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 4px;
            background: var(--secondary-color);
        }

        .sidebar-menu-icon {
            font-size: 1.25rem;
            width: 24px;
            text-align: center;
        }

        .sidebar-menu-badge {
            margin-left: auto;
            padding: 0.125rem 0.5rem;
            background: var(--danger-color);
            border-radius: 12px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        /* Main Content */
        .main-content {
            flex: 1;
            margin-left: var(--sidebar-width);
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        /* Top Header */
        .top-header {
            background: white;
            border-bottom: 1px solid #e5e7eb;
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .top-header-left {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .mobile-menu-btn {
            display: none;
            background: none;
            border: none;
            font-size: 1.5rem;
            cursor: pointer;
            color: var(--dark);
        }

        .page-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--dark);
        }

        .top-header-right {
            display: flex;
            align-items: center;
            gap: 1.5rem;
        }

        .header-icon-btn {
            position: relative;
            background: none;
            border: none;
            font-size: 1.25rem;
            color: var(--gray);
            cursor: pointer;
            padding: 0.5rem;
            border-radius: 8px;
            transition: all 0.2s;
        }

        .header-icon-btn:hover {
            background: var(--light-gray);
            color: var(--dark);
        }

        .header-icon-badge {
            position: absolute;
            top: 0.25rem;
            right: 0.25rem;
            width: 8px;
            height: 8px;
            background: var(--danger-color);
            border-radius: 50%;
        }

        /* Content Area */
        .content-area {
            flex: 1;
            padding: 2rem;
        }

        /* Alerts */
        .alert {
            padding: 1rem 1.5rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .alert-success {
            background: #d1fae5;
            color: #065f46;
            border-left: 4px solid var(--secondary-color);
        }

        .alert-danger {
            background: #fee2e2;
            color: #991b1b;
            border-left: 4px solid var(--danger-color);
        }

        /* Botão */
        .btn {
            padding: 0.6rem 1.5rem;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s;
            border: none;
            cursor: pointer;
            display: inline-block;
        }

        .btn-primary {
            background: var(--primary-color);
            color: var(--white);
        }

        .btn-primary:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);
        }

        .btn-danger {
            background: var(--danger-color);
            color: var(--white);
        }

        /* Footer */
        .footer {
            background: white;
            border-top: 1px solid #e5e7eb;
            padding: 1.5rem 2rem;
            text-align: center;
            color: var(--gray);
            font-size: 0.9rem;
        }

        /* Mobile Responsivo */
        @media (max-width: 968px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.active {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
            }

            .mobile-menu-btn {
                display: block;
            }

            .content-area {
                padding: 1rem;
            }
        }

        /* Overlay Mobile */
        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 999;
        }

        .sidebar-overlay.active {
            display: block;
        }

        /* Scrollbar do Sidebar */
        .sidebar::-webkit-scrollbar {
            width: 6px;
        }

        .sidebar::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.1);
        }

        .sidebar::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.3);
            border-radius: 3px;
        }

        .sidebar::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 255, 255, 0.5);
        }
    </style>

    @yield('styles')
</head>
<body>
<div class="layout-container">
    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
        <!-- Logo -->
        <div class="sidebar-header">
            <a href="{{ route('dashboard') }}" class="sidebar-logo">
                <div class="sidebar-logo-icon">CC</div>
                <span class="sidebar-logo-text">Conecta Cidade</span>
            </a>
        </div>

        <!-- User Profile -->
        <div class="sidebar-user">
            <div class="sidebar-user-info">
                <div class="sidebar-user-avatar">
                    {{ strtoupper(substr(session('user_name'), 0, 1)) }}
                </div>
                <div class="sidebar-user-details">
                    <div class="sidebar-user-name">{{ session('user_name') }}</div>
                    <div class="sidebar-user-role">
                        {{ session('user_tipo') === 'admin' ? 'Administrador' : 'Cidadão' }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Menu -->
        <nav class="sidebar-menu">
            <!-- Principal -->
            <div class="sidebar-menu-section">
                <div class="sidebar-menu-title">Principal</div>
                <a href="{{ route('dashboard') }}" class="sidebar-menu-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <span class="sidebar-menu-icon">🏠</span>
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('home') }}" class="sidebar-menu-item">
                    <span class="sidebar-menu-icon">🌆</span>
                    <span>Página Inicial</span>
                </a>
            </div>

            <!-- Reportes -->
            <div class="sidebar-menu-section">
                <div class="sidebar-menu-title">Reportes</div>
                <a href="{{ route('reportes.create') }}" class="sidebar-menu-item {{ request()->routeIs('reportes.create') ? 'active' : '' }}">
                    <span class="sidebar-menu-icon">➕</span>
                    <span>Novo Reporte</span>
                </a>
                <a href="{{ route('reportes.meus') }}" class="sidebar-menu-item {{ request()->routeIs('reportes.meus') ? 'active' : '' }}">
                    <span class="sidebar-menu-icon">📋</span>
                    <span>Meus Reportes</span>
                </a>
                <a href="{{ route('reportes.index') }}" class="sidebar-menu-item {{ request()->routeIs('reportes.index') ? 'active' : '' }}">
                    <span class="sidebar-menu-icon">📍</span>
                    <span>Todos os Reportes</span>
                </a>
            </div>

            <!-- Propostas -->
            <div class="sidebar-menu-section">
                <div class="sidebar-menu-title">Propostas</div>
                <a href="{{ route('propostas.index') }}" class="sidebar-menu-item {{ request()->routeIs('propostas.index') ? 'active' : '' }}">
                    <span class="sidebar-menu-icon">🗳️</span>
                    <span>Ver Propostas</span>
                </a>
                <a href="{{ route('propostas.minhas-votacoes') }}" class="sidebar-menu-item {{ request()->routeIs('propostas.minhas-votacoes') ? 'active' : '' }}">
                    <span class="sidebar-menu-icon">✓</span>
                    <span>Minhas Votações</span>
                </a>
            </div>

            @if(session('user_tipo') === 'admin')
                <!-- Admin -->
                <div class="sidebar-menu-section">
                    <div class="sidebar-menu-title">Administração</div>
                    <a href="#" class="sidebar-menu-item">
                        <span class="sidebar-menu-icon">👥</span>
                        <span>Usuários</span>
                    </a>
                    <a href="#" class="sidebar-menu-item">
                        <span class="sidebar-menu-icon">📊</span>
                        <span>Relatórios</span>
                    </a>
                    <a href="#" class="sidebar-menu-item">
                        <span class="sidebar-menu-icon">⚙️</span>
                        <span>Configurações</span>
                    </a>
                </div>
            @endif

            <!-- Conta -->
            <div class="sidebar-menu-section">
                <div class="sidebar-menu-title">Conta</div>
                <a href="#" class="sidebar-menu-item">
                    <span class="sidebar-menu-icon">👤</span>
                    <span>Meu Perfil</span>
                </a>
                <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                    @csrf
                    <button type="submit" class="sidebar-menu-item" style="width: 100%; text-align: left; background: none; border: none; cursor: pointer; font-size: 1rem; font-family: inherit;">
                        <span class="sidebar-menu-icon">🚪</span>
                        <span>Sair</span>
                    </button>
                </form>
            </div>
        </nav>
    </aside>

    <!-- Overlay Mobile -->
    <div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Top Header -->
        <header class="top-header">
            <div class="top-header-left">
                <button class="mobile-menu-btn" onclick="toggleSidebar()">☰</button>
                <h1 class="page-title">@yield('page-title', 'Dashboard')</h1>
            </div>
            <div class="top-header-right">
                <button class="header-icon-btn" title="Notificações">
                    🔔
                    <span class="header-icon-badge"></span>
                </button>
                <button class="header-icon-btn" title="Mensagens">
                    💬
                </button>
            </div>
        </header>

        <!-- Content Area -->
        <main class="content-area">
            <!-- Alerts -->
            @if(session('success'))
                <div class="alert alert-success">
                    <span>✓</span>
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger">
                    <span>✕</span>
                    {{ session('error') }}
                </div>
            @endif

            @yield('content')
        </main>

        <!-- Footer -->
        <footer class="footer">
            <p>&copy; {{ date('Y') }} Conecta Cidade - Code Crafters. Todos os direitos reservados.</p>
        </footer>
    </div>
</div>

<!-- Scripts -->
<script>
    function toggleSidebar() {
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');

        sidebar.classList.toggle('active');
        overlay.classList.toggle('active');
    }

    // Fechar sidebar ao clicar em um link (mobile)
    document.querySelectorAll('.sidebar-menu-item').forEach(item => {
        item.addEventListener('click', function() {
            if (window.innerWidth <= 968) {
                toggleSidebar();
            }
        });
    });
</script>

@yield('scripts')
</body>
</html>
