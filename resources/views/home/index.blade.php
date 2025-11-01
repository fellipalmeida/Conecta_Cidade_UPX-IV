@extends('layouts.app')

@section('title', 'Conecta Cidade - Plataforma de Participação Cidadã')

@section('styles')
    <style>
        /* Hero Section */
        .hero {
            background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%);
            color: white;
            padding: 4rem 2rem;
            text-align: center;
            border-radius: 16px;
            margin-bottom: 4rem;
        }

        .hero h1 {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            font-weight: 700;
        }

        .hero p {
            font-size: 1.25rem;
            margin-bottom: 2rem;
            opacity: 0.9;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }

        .hero-buttons {
            display: flex;
            gap: 1rem;
            justify-content: center;
            flex-wrap: wrap;
        }

        .btn-hero {
            padding: 1rem 2rem;
            font-size: 1.1rem;
            border-radius: 10px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s;
            display: inline-block;
        }

        .btn-hero-primary {
            background: white;
            color: #2563eb;
        }

        .btn-hero-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(255, 255, 255, 0.12);
        }

        .btn-hero-secondary {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            border: 2px solid white;
        }

        .btn-hero-secondary:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(255, 255, 255, 0.12);
        }

        /* Stats Section */
        .stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 2rem;
            margin: 3rem 0;
        }

        .stat-card {
            background: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%);
            padding: 2rem;
            border-radius: 12px;
            text-align: center;
        }

        .stat-number {
            font-size: 2.5rem;
            font-weight: 700;
            color: #2563eb;
            margin-bottom: 0.5rem;
        }

        .stat-label {
            color: #6b7280;
            font-weight: 500;
        }

        /* Features Section */
        .section {
            margin: 4rem 0;
        }

        .section-title {
            font-size: 2rem;
            font-weight: 700;
            text-align: center;
            margin-bottom: 1rem;
            color: #1f2937;
        }

        .section-subtitle {
            text-align: center;
            color: #6b7280;
            margin-bottom: 3rem;
            font-size: 1.1rem;
        }

        .features {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 2rem;
            margin-top: 3rem;
        }

        .feature-card {
            background: white;
            padding: 2rem;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(37, 99, 235, 0.15);
        }

        .feature-icon {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #2563eb, #1e40af);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
            color: white;
            margin-bottom: 1.5rem;
        }

        .feature-title {
            font-size: 1.3rem;
            font-weight: 600;
            margin-bottom: 0.75rem;
            color: #1f2937;
        }

        .feature-description {
            color: #6b7280;
            line-height: 1.7;
        }

        /* How It Works Section */
        .steps {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
            margin-top: 3rem;
        }

        .step-card {
            text-align: center;
            position: relative;
        }

        .step-number {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #10b981, #059669);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            font-weight: 700;
            margin: 0 auto 1.5rem;
        }

        .step-title {
            font-size: 1.2rem;
            font-weight: 600;
            margin-bottom: 0.75rem;
            color: #1f2937;
        }

        .step-description {
            color: #6b7280;
            line-height: 1.6;
        }

        /* CTA Section */
        .cta {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
            padding: 3rem 2rem;
            border-radius: 16px;
            text-align: center;
            margin: 4rem 0;
        }

        .cta h2 {
            font-size: 2rem;
            margin-bottom: 1rem;
        }

        .cta p {
            font-size: 1.1rem;
            margin-bottom: 2rem;
            opacity: 0.95;
        }

        .btn-cta {
            background: white;
            color: #10b981;
            padding: 1rem 2.5rem;
            border-radius: 10px;
            text-decoration: none;
            font-weight: 600;
            display: inline-block;
            transition: all 0.3s;
        }

        .btn-cta:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(255, 255, 255, 0.3);
        }

        @media (max-width: 768px) {
            .hero h1 {
                font-size: 2rem;
            }

            .hero p {
                font-size: 1rem;
            }

            .section-title {
                font-size: 1.5rem;
            }

            .stats {
                grid-template-columns: 1fr;
            }
        }
    </style>
@endsection

@section('content')
    <!-- Hero Section -->
    <section class="hero">
        <h1>🌆 Bem-vindo ao Conecta Cidade</h1>
        <p>Sua voz importa! Reporte problemas urbanos e participe das decisões sobre a mobilidade da sua cidade.</p>
        <div class="hero-buttons">
            @if(session('user_id'))
                <a href="#" class="btn-hero btn-hero-primary">Fazer um Reporte</a>
                <a href="#" class="btn-hero btn-hero-secondary">Ver Propostas</a>
            @else
                <a href="{{ route('register') }}" class="btn-hero btn-hero-primary">Cadastre-se Grátis</a>
                <a href="#sobre" class="btn-hero btn-hero-secondary">Saiba Mais</a>
            @endif
        </div>
    </section>

    <!-- Stats Section -->
    <div class="stats">
        <div class="stat-card">
            <div class="stat-number">1.234</div>
            <div class="stat-label">Reportes Realizados</div>
        </div>
        <div class="stat-card">
            <div class="stat-number">856</div>
            <div class="stat-label">Problemas Resolvidos</div>
        </div>
        <div class="stat-card">
            <div class="stat-number">2.5K</div>
            <div class="stat-label">Cidadãos Ativos</div>
        </div>
        <div class="stat-card">
            <div class="stat-number">42</div>
            <div class="stat-label">Propostas em Votação</div>
        </div>
    </div>

    <!-- About Section -->
    <section id="sobre" class="section">
        <h2 class="section-title">Sobre o Conecta Cidade</h2>
        <p class="section-subtitle">Fortalecendo a participação cidadã na gestão da mobilidade urbana</p>

        <div class="features">
            <div class="feature-card">
                <div class="feature-icon">📍</div>
                <h3 class="feature-title">Reporte Problemas</h3>
                <p class="feature-description">
                    Identifique e reporte problemas de mobilidade urbana como buracos, semáforos quebrados,
                    falta de sinalização e muito mais. Acompanhe o status da resolução em tempo real.
                </p>
            </div>

            <div class="feature-card">
                <div class="feature-icon">🗳️</div>
                <h3 class="feature-title">Vote em Propostas</h3>
                <p class="feature-description">
                    Participe ativamente das decisões municipais votando em propostas relacionadas à mobilidade.
                    Sua opinião importa na construção de uma cidade melhor.
                </p>
            </div>

            <div class="feature-card">
                <div class="feature-icon">🤝</div>
                <h3 class="feature-title">Conecte-se</h3>
                <p class="feature-description">
                    Crie um canal direto entre você e os gestores públicos. Contribua com sugestões,
                    comente em reportes e participe de discussões sobre melhorias urbanas.
                </p>
            </div>
        </div>
    </section>

    <!-- How It Works Section -->
    <section id="como-funciona" class="section">
        <h2 class="section-title">Como Funciona</h2>
        <p class="section-subtitle">É simples e rápido participar!</p>

        <div class="steps">
            <div class="step-card">
                <div class="step-number">1</div>
                <h3 class="step-title">Cadastre-se</h3>
                <p class="step-description">
                    Crie sua conta gratuita em menos de 2 minutos. Você só precisa de um email válido e CPF.
                </p>
            </div>

            <div class="step-card">
                <div class="step-number">2</div>
                <h3 class="step-title">Identifique o Problema</h3>
                <p class="step-description">
                    Encontrou um problema na sua cidade? Faça um reporte com descrição, localização e foto.
                </p>
            </div>

            <div class="step-card">
                <div class="step-number">3</div>
                <h3 class="step-title">Acompanhe</h3>
                <p class="step-description">
                    Receba um número de protocolo e acompanhe o status do seu reporte até a resolução.
                </p>
            </div>

            <div class="step-card">
                <div class="step-number">4</div>
                <h3 class="step-title">Participe das Decisões</h3>
                <p class="step-description">
                    Vote em propostas municipais e ajude a decidir o futuro da mobilidade urbana da sua cidade.
                </p>
            </div>
        </div>
    </section>

    <!-- ODS Section -->
    <section class="section">
        <h2 class="section-title">Contribuindo com os ODS</h2>
        <p class="section-subtitle">Alinhados aos Objetivos de Desenvolvimento Sustentável da ONU</p>

        <div class="features">
            <div class="feature-card">
                <div class="feature-icon">🏙️</div>
                <h3 class="feature-title">ODS 11 - Cidades Sustentáveis</h3>
                <p class="feature-description">
                    Promovemos o desenvolvimento urbano participativo através de um canal direto entre
                    cidadãos e poder público, permitindo identificação rápida de problemas e priorização
                    baseada na demanda real.
                </p>
            </div>

            <div class="feature-card">
                <div class="feature-icon">🤝</div>
                <h3 class="feature-title">ODS 17 - Parcerias</h3>
                <p class="feature-description">
                    Estabelecemos uma ponte tecnológica entre sociedade civil e administração pública,
                    fomentando colaboração para resolução de problemas urbanos e construção de cidades mais inteligentes.
                </p>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    @if(!session('user_id'))
        <section class="cta">
            <h2>Pronto para fazer a diferença?</h2>
            <p>Junte-se a milhares de cidadãos que já estão transformando sua cidade!</p>
            <a href="{{ route('register') }}" class="btn-cta">Começar Agora - É Grátis!</a>
        </section>
    @endif
@endsection
