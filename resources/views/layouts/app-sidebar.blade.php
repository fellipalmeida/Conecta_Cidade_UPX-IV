<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Conecta Cidade - Plataforma de participação cidadã em mobilidade urbana">
    <title>@yield('title', 'Conecta Cidade - Participação Cidadã')</title>
    <link rel="icon" href="https://www.svgrepo.com/download/478646/infinity-symbol.svg" type="image/svg+xml">

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
            background-color: rgba(244, 244, 244, 0.91);
        }

        .layout-container {
            display: flex;
            min-height: 100vh;
        }

        .sidebar {
            width: var(--sidebar-width);
            background: linear-gradient(180deg, #1e40af 0%, #1e3a8a 100%);
            color: white;
            position: fixed;
            height: 100%;
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

        .main-content {
            flex: 1;
            margin-left: var(--sidebar-width);
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .top-header {
            background: white;
            border-bottom: 1px solid #e5e7eb;
            padding: 11px 2rem;
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
            background-color: ;
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
        /* --- Estilos dos Modais (Novo) --- */
        .custom-modal-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 2000; /* Maior que o sidebar */
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .custom-modal-overlay.active {
            display: flex;
            opacity: 1;
        }

        .custom-modal {
            background: var(--white);
            padding: 2rem;
            border-radius: 16px;
            width: 90%;
            max-width: 500px;
            max-height: 85vh;
            overflow-y: auto;
            position: relative;
            transform: translateY(20px);
            transition: transform 0.3s ease;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }

        .custom-modal-overlay.active .custom-modal {
            transform: translateY(0);
        }

        .modal-close-btn {
            position: absolute;
            top: 1.5rem;
            right: 1.5rem;
            background: none;
            border: none;
            font-size: 1.5rem;
            color: var(--gray);
            cursor: pointer;
            padding: 5px;
            line-height: 1;
        }

        .modal-header {
            margin-bottom: 1.5rem;
        }

        .modal-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--dark);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        /* Estilos Específicos para Notificações */
        .notification-list {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .notification-item {
            padding: 1rem;
            background: var(--light-gray);
            border-radius: 12px;
            border-left: 4px solid var(--primary-color);
        }

        .notification-item.important {
            border-left-color: var(--danger-color);
            background: #fef2f2;
        }

        .notification-date {
            font-size: 0.8rem;
            color: var(--gray);
            margin-bottom: 0.25rem;
        }

        .notification-title {
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: var(--dark);
        }

        .notification-body {
            font-size: 0.9rem;
            color: #4b5563;
        }

        /* Estilos básicos de formulário para o modal de suporte */
        .modal-form-group {
            margin-bottom: 1rem;
        }

        .modal-form-label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: var(--dark);
        }

        .modal-form-control {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            font-family: inherit;
            transition: all 0.2s;
        }

        .modal-form-control:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }
        /* --- Dropdown de Notificações --- */
        .notification-dropdown {
            display: none;
            position: absolute;
            top: 60px; /* Ajuste conforme a altura do seu header */
            right: 80px; /* Ajuste para alinhar com o sino */
            width: 380px;
            background: var(--white);
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
            z-index: 1001;
            border: 1px solid var(--light-gray);
            overflow: hidden;
        }

        .notification-dropdown.active {
            display: block;
            animation: slideDown 0.2s ease-out;
        }

        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .dropdown-header {
            padding: 1rem 1.5rem;
            border-bottom: 1px solid var(--light-gray);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .dropdown-title {
            font-weight: 700;
            color: var(--dark);
            font-size: 1.1rem;
        }

        .mark-all-read {
            font-size: 0.85rem;
            color: var(--primary-color);
            text-decoration: none;
            cursor: pointer;
        }

        .mark-all-read:hover {
            text-decoration: underline;
        }

        .dropdown-body {
            max-height: 400px;
            overflow-y: auto;
        }

        .dropdown-notification-item {
            padding: 1rem 1.5rem;
            border-bottom: 1px solid var(--light-gray);
            transition: background 0.2s;
            cursor: pointer;
        }

        .dropdown-notification-item:hover {
            background: #f9fafb;
        }

        .dropdown-notification-item.unread {
            background: #f0f9ff; /* Azul bem claro para não lidas */
        }

        .dropdown-notification-item:last-child {
            border-bottom: none;
        }

        .noti-header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 0.4rem;
        }

        .noti-title {
            font-weight: 600;
            font-size: 0.95rem;
            color: var(--dark);
        }

        .noti-date {
            font-size: 0.75rem;
            color: var(--gray);
        }

        .noti-body {
            font-size: 0.85rem;
            color: #4b5563;
            line-height: 1.4;
        }

        .dropdown-footer {
            padding: 0.75rem;
            text-align: center;
            border-top: 1px solid var(--light-gray);
            background: #f9fafb;
        }

        .view-all-btn {
            font-size: 0.9rem;
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 500;
        }

        /* Ajuste para mobile */
        @media (max-width: 768px) {
            .notification-dropdown {
                width: 90%;
                right: 5%;
                left: 5%;
                top: 70px;
            }
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
                <div class="" style="position: relative; top: 4px"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-infinity" viewBox="0 0 16 16">
                        <path d="M5.68 5.792 7.345 7.75 5.681 9.708a2.75 2.75 0 1 1 0-3.916ZM8 6.978 6.416 5.113l-.014-.015a3.75 3.75 0 1 0 0 5.304l.014-.015L8 8.522l1.584 1.865.014.015a3.75 3.75 0 1 0 0-5.304l-.014.015zm.656.772 1.663-1.958a2.75 2.75 0 1 1 0 3.916z"/>
                    </svg>️</div>
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

        <nav class="sidebar-menu">
            <div class="sidebar-menu-section">
                <div class="sidebar-menu-title">Principal</div>
                <a href="{{ route('dashboard') }}" class="sidebar-menu-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <span class="sidebar-menu-icon">🏠</span>
                    <span>Dashboard</span>
                </a>

            </div>

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
{{--                <a href="{{ route('reportes.index') }}" class="sidebar-menu-item {{ request()->routeIs('reportes.index') ? 'active' : '' }}">--}}
{{--                    <span class="sidebar-menu-icon">📍</span>--}}
{{--                    <span>Todos os Reportes</span>--}}
{{--                </a>--}}
            </div>

            <!-- Propostas -->
            <div class="sidebar-menu-section">
                <div class="sidebar-menu-title">Propostas</div>

                <a href="{{ route('propostas.create') }}" class="sidebar-menu-item {{ request()->routeIs('propostas.create') ? 'active' : '' }}">
                    <span class="sidebar-menu-icon">➕</span>
                    <span>Criar Proposta</span>
                </a>
                <a href="{{ route('propostas.index') }}" class="sidebar-menu-item {{ request()->routeIs('propostas.index') ? 'active' : '' }}">
                    <span class="sidebar-menu-icon">🗳️</span>
                    <span>Ver Propostas</span>
                </a>
                <a href="{{ route('propostas.minhas-votacoes') }}" class="sidebar-menu-item {{ request()->routeIs('propostas.minhas-votacoes') ? 'active' : '' }}">
                    <span class="sidebar-menu-icon">📝</span>
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
                <a href="{{ route('profile.show') }}" class="sidebar-menu-item {{ request()->routeIs('profile.show') ? 'active' : '' }}">
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
        <header class="top-header" style=" padding: 19px 2rem;!important;">
            <div class="top-header-left">
                <button class="mobile-menu-btn" onclick="toggleSidebar()">☰</button>

            </div>
            <div class="top-header-right" style="position: relative;">
                <button id="notiBtn" class="header-icon-btn" title="Novidades" onclick="toggleDropdown('notificationDropdown')">
                    🔔
                    <span class="header-icon-badge"></span> </button>

                <button class="header-icon-btn" title="Fale com o Suporte" onclick="openModal('supportModal')">
                    💬
                </button>
            </div>
            <div id="notificationDropdown" class="notification-dropdown">
                <div class="dropdown-header">
                    <span class="dropdown-title">🔔 Notificações</span>
                    <span class="mark-all-read">Marcar todas como lidas</span>
                </div>
                <div class="dropdown-body">
                    <div class="dropdown-notification-item unread">
                        <div class="noti-header">
                            <span class="noti-title">Manutenção Programada</span>
                            <span class="noti-date">Hoje, 14:30</span>
                        </div>
                        <div class="noti-body">
                            O sistema passará por uma atualização neste sábado das 02h às 04h.
                        </div>
                    </div>
                    <div class="dropdown-notification-item">
                        <div class="noti-header">
                            <span class="noti-title">Nova Funcionalidade: Mapas</span>
                            <span class="noti-date">Ontem, 09:15</span>
                        </div>
                        <div class="noti-body">
                            Visualize problemas relatados diretamente no mapa da dashboard.
                        </div>
                    </div>
                    <div class="dropdown-notification-item">
                        <div class="noti-header">
                            <span class="noti-title">Bem-vindo!</span>
                            <span class="noti-date">01 Nov</span>
                        </div>
                        <div class="noti-body">
                            Explore as funcionalidades e ajude a melhorar nossa cidade.
                        </div>
                    </div>
                </div>
                <div class="dropdown-footer">
                    <a href="#" class="view-all-btn">Ver todas as notificações</a>
                </div>
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


<div class="custom-modal-overlay" id="supportModal">
    <div class="custom-modal">
        <button class="modal-close-btn" onclick="closeModal('supportModal')">&times;</button>
        <div class="modal-header">
            <h2 class="modal-title">💬 Fale com o Suporte</h2>
            <p style="color: var(--gray); font-size: 0.9rem; margin-top: 0.5rem">
                Tem alguma dúvida ou encontrou um problema? Envie uma mensagem para nossa equipe.
            </p>
        </div>
        <div class="modal-body">
            <form action="#" method="POST">
                @csrf
                <div class="modal-form-group">
                    <label class="modal-form-label">Assunto</label>
                    <select class="modal-form-control" name="assunto" required>
                        <option value="">Selecione um assunto...</option>
                        <option value="duvida">Dúvida sobre o sistema</option>
                        <option value="problema">Relatar um erro técnico</option>
                        <option value="sugestao">Sugestão de melhoria</option>
                        <option value="outro">Outro</option>
                    </select>
                </div>

                <div class="modal-form-group">
                    <label class="modal-form-label">Mensagem</label>
                    <textarea class="modal-form-control" name="mensagem" rows="5" placeholder="Descreva detalhadamente como podemos ajudar..." required></textarea>
                </div>

                <div style="text-align: right; margin-top: 1.5rem;">
                    <button type="button" class="btn" style="background: var(--light-gray); color: var(--dark); margin-right: 0.5rem;" onclick="closeModal('supportModal')">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Enviar Mensagem</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // --- FUNÇÕES PARA DROPDOWN E MODAIS ---

    function toggleDropdown(dropdownId) {
        const dropdown = document.getElementById(dropdownId);
        const isActive = dropdown.classList.contains('active');

        // Fecha outros dropdowns se houver
        closeAllDropdowns();

        if (!isActive) {
            dropdown.classList.add('active');

            // Opcional: Adiciona listener para fechar ao clicar fora
            document.addEventListener('click', closeDropdownOnClickOutside);
        } else {
            document.removeEventListener('click', closeDropdownOnClickOutside);
        }
    }

    function closeAllDropdowns() {
        document.querySelectorAll('.notification-dropdown.active').forEach(drop => {
            drop.classList.remove('active');
        });
    }

    function closeDropdownOnClickOutside(event) {
        const dropdown = document.getElementById('notificationDropdown');
        const notiBtn = document.getElementById('notiBtn');

        if (!dropdown.contains(event.target) && !notiBtn.contains(event.target)) {
            dropdown.classList.remove('active');
            document.removeEventListener('click', closeDropdownOnClickOutside);
        }
    }


    function toggleSidebar() {
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');
        sidebar.classList.toggle('active');
        overlay.classList.toggle('active');
    }

    // --- NOVAS FUNÇÕES PARA OS MODAIS ---
    function openModal(modalId) {
        const modal = document.getElementById(modalId);
        if (modal) {
            modal.classList.add('active');
            document.body.style.overflow = 'hidden'; // Evita rolagem da página de fundo
        }
    }

    function closeModal(modalId) {
        const modal = document.getElementById(modalId);
        if (modal) {
            modal.classList.remove('active');
            document.body.style.overflow = 'auto'; // Restaura rolagem
        }
    }

    // Fechar modal se clicar fora dele (no overlay escuro)
    document.querySelectorAll('.custom-modal-overlay').forEach(overlay => {
        overlay.addEventListener('click', function(e) {
            if (e.target === this) {
                this.classList.remove('active');
                document.body.style.overflow = 'auto';
            }
        });
    });
</script>
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
