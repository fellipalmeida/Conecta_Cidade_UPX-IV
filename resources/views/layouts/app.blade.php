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
        }

        body {
            font-family: 'Inter', sans-serif;
            line-height: 1.6;
            color: var(--dark);
            background-color: var(--white);
        }

        /* Header */
        .header {
            background: var(--white);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .navbar {
            max-width: 1200px;
            margin: 0 auto;
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary-color);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .logo-icon {
            width: 32px;
            height: 32px;
            background: var(--primary-color);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
        }

        .nav-links {
            display: flex;
            gap: 2rem;
            align-items: center;
            list-style: none;
        }

        .nav-links a {
            color: var(--dark);
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s;
        }

        .nav-links a:hover {
            color: white;
        }

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
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.17);
        }

        .btn-outline {
            background: transparent;
            color: var(--primary-color);
            border: 2px solid var(--primary-color);
        }

        .btn-outline:hover {
           background-color: #1D4ED8;
        }

        .btn-danger {
            background: var(--danger-color);
            color: var(--white);
        }

        .btn-danger:hover {
            background: #dc2626;
        }

        /* Main Content */
        .main-content {
            min-height: calc(100vh - 180px);
        }

        /* Footer */
        .footer {
            background: var(--dark);
            color: var(--white);
            padding: 3rem 2rem 1.5rem;
            margin-top: 4rem;
        }

        .footer-content {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
            margin-bottom: 2rem;
        }

        .footer-section h3 {
            color: var(--white);
            margin-bottom: 1rem;
        }

        .footer-section p,
        .footer-section a {
            color: #9ca3af;
            text-decoration: none;
            display: block;
            margin-bottom: 0.5rem;
        }

        .footer-section a:hover {
            color: var(--primary-color);
        }

        .footer-bottom {
            max-width: 1200px;
            margin: 0 auto;
            padding-top: 2rem;
            border-top: 1px solid #374151;
            text-align: center;
            color: #9ca3af;
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

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem;
        }

        /* Mobile Menu */
        .mobile-menu-btn {
            display: none;
            background: none;
            border: none;
            font-size: 1.5rem;
            color: var(--dark);
            cursor: pointer;
        }

        @media (max-width: 768px) {
            .nav-links {
                display: none;
                position: absolute;
                top: 100%;
                left: 0;
                right: 0;
                background: var(--white);
                flex-direction: column;
                padding: 1rem;
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            }

            .nav-links.active {
                display: flex;
            }

            .mobile-menu-btn {
                display: block;
            }

            .footer-content {
                grid-template-columns: 1fr;
            }
        }

        /* User Menu */
        .user-menu {
            position: relative;
        }

        .user-name {
            cursor: pointer;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            background: var(--light-gray);
            color: var(--dark);
            font-weight: 500;
        }

        .user-name:hover {
            background: #e5e7eb;
        }

        .dropdown-menu {
            position: absolute;
            top: 100%;
            right: 0;
            margin-top: 0.5rem;
            background: var(--white);
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            min-width: 200px;
            display: none;
            z-index: 1000;
        }

        .dropdown-menu.active {
            display: block;
        }

        .dropdown-item {
            padding: 0.75rem 1rem;
            display: block;
            color: var(--dark);
            text-decoration: none;
            transition: background 0.2s;
        }

        .dropdown-item:hover {
            background: var(--light-gray);
        }

        .dropdown-divider {
            height: 1px;
            background: var(--light-gray);
            margin: 0.5rem 0;
        }


    </style>

    @yield('styles')
</head>
<body>
<!-- Header -->
<header class="header">
    <nav class="navbar">
        <a href="{{ route('home') }}" class="logo">
            <div>♾️</div>
            Conecta Cidade
        </a>

        <button class="mobile-menu-btn" onclick="toggleMobileMenu()">
            ☰
        </button>

        <ul class="nav-links" id="navLinks">
            @if(session('user_id'))
                <!-- Links para usuários LOGADOS -->
                <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li><a href="{{ route('reportes.index') }}">Reportes</a></li>
                <li><a href="{{ route('propostas.index') }}">Propostas</a></li>

                @if(session('user_tipo') === 'admin')
                    <li><a href="#">Admin</a></li>
                @endif

                <li class="user-menu">
                        <span class="user-name" onclick="toggleUserMenu()">
                            {{ session('user_name') }}
                        </span>
                    <div class="dropdown-menu" id="userMenu">
                        <a href="#" class="dropdown-item">Meu Perfil</a>
                        <a href="#" class="dropdown-item">Meus Reportes</a>
                        <div class="dropdown-divider"></div>
                        <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                            @csrf
                            <button type="submit" class="dropdown-item" style="width: 100%; text-align: left; background: none; border: none; cursor: pointer; font-size: 1rem;">
                                Sair
                            </button>
                        </form>
                    </div>
                </li>
            @else
                <!-- Links para usuários NÃO logados -->
                <li><a href="{{ route('home') }}">Início</a></li>
                <li><a href="#sobre">Sobre</a></li>
                <li><a href="#como-funciona">Como Funciona</a></li>
                <li><a href="{{ route('login') }}" class="btn btn-outline ">Entrar</a></li>
                <li><a href="{{ route('register') }}" class="btn btn-primary" style="color: white;">Cadastrar</a></li>
            @endif
        </ul>
    </nav>
</header>

<!-- Main Content -->
<main class="main-content">
    <div class="container">
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
    </div>
</main>

<!-- Footer -->
<footer class="footer">
    <div class="footer-content">
        <div class="footer-section">
            <h3>Conecta Cidade</h3>
            <p>Plataforma de participação cidadã em mobilidade urbana. Juntos construímos uma cidade melhor.</p>
        </div>

        <div class="footer-section">
            <h3>Links Rápidos</h3>
            <a href="{{ route('home') }}">Início</a>
            <a href="#sobre">Sobre Nós</a>
            <a href="#como-funciona">Como Funciona</a>
        </div>

        <div class="footer-section">
            <h3>Contato</h3>
            <p>Email: contato@conectacidade.com</p>
            <p>Telefone: (15) 3000-0000</p>
            <p>Sorocaba - SP</p>
        </div>

        <div class="footer-section">
            <h3>ODS</h3>
            <p>Este projeto contribui com:</p>
            <p>• ODS 11 - Cidades Sustentáveis</p>
            <p>• ODS 17 - Parcerias</p>
        </div>
    </div>

    <div class="footer-bottom">
        <p>&copy; {{ date('Y') }} Conecta Cidade - Code Crafters. Todos os direitos reservados.</p>
    </div>
</footer>

<!-- Scripts -->
<script>
    function toggleMobileMenu() {
        const navLinks = document.getElementById('navLinks');
        navLinks.classList.toggle('active');
    }

    function toggleUserMenu() {
        const userMenu = document.getElementById('userMenu');
        userMenu.classList.toggle('active');
    }

    // Fechar menu ao clicar fora
    document.addEventListener('click', function(event) {
        const userMenu = document.getElementById('userMenu');
        const userName = document.querySelector('.user-name');

        if (userMenu && userName && !userMenu.contains(event.target) && !userName.contains(event.target)) {
            userMenu.classList.remove('active');
        }
    });
</script>

@yield('scripts')
</body>
</html>
